<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;
use App\Models\Likepost;

class PostController extends Controller
{
    public function post_index(Post $post)
    {
        return view('posts.index')->with(['posts' => $post->getPaginateByLimit()]);
    }
    
    public function post_create()
    {
        return view('posts.create');
    }
    
    public function post_store(Request $request, Post $post)
    {
        $input = $request->input('post');
        
        // チェックボックスで選択されたtargetが配列であることを確認
        if (isset($input['target']) && is_array($input['target'])) 
    {   // 配列をカンマ区切りの文字列に変換して保存
        $input['target'] = implode(',', $input['target']);
    }
    
        $input['user_id'] = $request->user()->id;
        $post->fill($input)->save();
        return redirect('/posts');
    }
    
    public function post_show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }
    
    public function my_posts(Post $post)
    {
        $posts = Post::where('user_id', Auth::id())->paginate(5);
        return view('posts.my_posts')->with(['posts' => $posts]);
    }
    
    public function post_edit(Post $post)
    {
        return view('posts.edit')->with(['post' => $post]);
    }
    
    public function post_update(Request $request, Post $post)
    {
        $input_post = $request->input('post');
    
        if (isset($input_post['target']) && is_array($input_post['target'])) 
        {
            $input_post['target'] = implode(',', $input_post['target']);
        };
    
        $input_post['user_id'] = $request->user()->id; 
        $post->fill($input_post)->save();
        return redirect('/posts/my_posts');
    }
    
    public function delete(Post $post)
    {
        $post->delete();
        return redirect("/posts/my_posts");
    }
    
    public function like(Request $request, Post $post)
    {
        $user = Auth::user();
    
        if ($user) 
        {
            $user_id = Auth::id();
        
            $existingLike = Likepost::where('post_id', $post->id)
                ->where('user_id', $user_id)->first();
        
            if (!$existingLike)
            {
                $likepost = new Likepost();  
                $likepost->post_id = $post->id;
                $likepost->user_id = $user_id;
                $likepost->save();
            }
        }
        return redirect("/posts");
    }

    public function unlike(Request $request, Post $post)
    {
        $user = Auth::user();
    
        if ($user) 
        {
            $user_id = Auth::id();
        
            $existingLike = Likepost::where('post_id', $post->id)
                ->where('user_id', $user_id)->first();
        
            if ($existingLike)
            {
                $existingLike->delete();  
            }
        }
        return redirect("/posts");
    }
    
    public function likeshow(Request $request, Post $post)
    {
        $user_id = Auth::id(); // 現在のユーザーのIDを取得
    
        // ユーザーがいいねした投稿を取得
        // likeposts というリレーションが存在する Post モデルのレコードだけを取得
        $posts = Post::whereHas('likeposts', function($query) use ($user_id) {
            $query->where('user_id', $user_id);
        })->paginate(5);
    
        return view('posts.likes')->with(['posts' => $posts]);
    }

}
