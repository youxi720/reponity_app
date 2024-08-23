<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use App\Models\Post;

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
}
