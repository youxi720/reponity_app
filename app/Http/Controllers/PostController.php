<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\PostRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Target;
use App\Models\Likepost;

class PostController extends Controller
{
public function post_index(Request $request)
{
    $query = Post::query();

    // 絞り込み処理
    if ($request->has('target_id') && $request->target_id) {
        $query->whereHas('targets', function($q) use ($request) {
            $q->where('target_id', $request->target_id);
        });
    }

    // 投稿とターゲットデータを取得
    $posts = $query->orderBy('updated_at', 'DESC')->paginate(5); // ページネーションを5件で実行
    $targets = Target::all(); // ターゲット一覧を取得

    return view('posts.index', compact('posts', 'targets'));
}

    
    // 投稿作成フォーム表示
    public function post_create(Post $post)
    {
        $allTargets = Target::all(); // すべてのターゲットを取得
        return view('posts.create', compact('post', 'allTargets'));
    }
    
    // 投稿の保存
    public function post_store(PostRequest $request)
    {
        $input = $request->input('post');
        $input['user_id'] = $request->user()->id;
        
        $targetIds = $input['target_ids'] ?? []; // 選択されたターゲットIDの配列
        
        $post = Post::create($input); // 投稿を作成
        $post->targets()->sync($targetIds); // ターゲットを関連付け

        return redirect('/posts');
    }
    
    // 投稿の詳細表示
    public function post_show(Post $post)
    {
        $user = Auth::user();
        return view('posts.show', compact('post', 'user'));
    }
    
    // 自分の投稿一覧
    public function my_posts()
    {
        $posts = Post::where('user_id', Auth::id())->orderBy('updated_at', 'DESC')->paginate(5);
        return view('posts.my_posts', compact('posts'));
    }
    
    // 投稿編集フォーム表示
    public function post_edit(Post $post)
    {
        $allTargets = Target::all(); // すべてのターゲットを取得
        
        if (!empty($post->sheet)) {
        $post->spreadsheet_url = "https://docs.google.com/spreadsheets/d/{$post->sheet}/edit";
        } else {
            $post->spreadsheet_url = null; // URLがない場合はnullをセット
        }
        
        return view('posts.edit', compact('post', 'allTargets'));
    }
    
    // 投稿の更新
    public function post_update(PostRequest $request, Post $post)
    {
        $input = $request->input('post');
        $spreadsheetUrl = $request->input('post.spreadsheet_url');
    
        // スプレッドシートのURLが空の場合はnullに設定
        if (empty($spreadsheetUrl)) {
            $input['sheet'] = null; // ここでnullに設定
        } else {
            $sheetId = $this->getSpreadsheetId($spreadsheetUrl);
            if ($sheetId) {
                $input['sheet'] = $sheetId;
            }
        }
    
        $targetIds = $input['target_ids'] ?? [];
        
        $post->update($input);
        $post->targets()->sync($targetIds);
    
        return redirect('/posts/my_posts');
    }

    // スプレッドシートIDの抽出
    private function getSpreadsheetId($url)
    {
        $spreadsheetPattern = '/\/d\/([a-zA-Z0-9_-]+)/';
        if (preg_match($spreadsheetPattern, $url, $matches)) {
            return $matches[1];
        }
        return null;
    }
    
    // 投稿の削除
    public function delete(Post $post)
    {
        $post->delete();
        return redirect("/posts/my_posts");
    }

    // 「いいね」を追加
    public function like(Request $request, Post $post)
    {
        $user = Auth::user();
    
        if ($user && !$user->likedPosts()->where('post_id', $post->id)->exists()) {
            $user->likedPosts()->attach($post->id);
        }

        return redirect("/posts");
    }

    // 「いいね」を削除
    public function unlike(Request $request, Post $post)
    {
        $user = Auth::user();
    
        if ($user && $user->likedPosts()->where('post_id', $post->id)->exists()) {
            $user->likedPosts()->detach($post->id);
        }

        return redirect("/posts");
    }
    
    // ユーザーが「いいね」した投稿を表示
    public function likeshow()
    {
        $user_id = Auth::id();
        $posts = Post::whereHas('likes', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->orderBy('updated_at', 'DESC')->paginate(5);

        return view('posts.likes', compact('posts'));
    }
}