<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
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
        $input = $request['post'];
        $input += ['user_id' => $request->user()->id];
        $post->fill($input)->save();
        return redirect('/posts');
    }
    
    public function post_show(Post $post)
    {
        return view('posts.show')->with(['post' => $post]);
    }
}
