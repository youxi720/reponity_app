<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\UserVioRequest;
use Illuminate\Support\Facades\Auth;
use Cloudinary;
use App\Models\User;
use App\Models\Post;

class UserController extends Controller
{
    public function show(User $user)
    {
        // 渡された$userを使用する
        return view("user.user_profile")->with(['user_profile' => $user]);
    }

    public function edit(User $user)
    {
        return view("user.user_profile_edit")->with(["user_profile" => $user]);
    }

    public function update(UserVioRequest $request, User $user)
    {
        if ($request->file('image')) {
            // Cloudinaryに画像をアップロードし、URLを取得
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            // 画像URLをデータベースに保存
            $user->image_url = $image_url;
        }
    
        // 他のフィールドを更新
        $user->fill($request->only(['grade', 'faculty', 'hobby']))->save();
        return redirect()->route('show', ['user' => $user->id]);
    }

    public function countAnswers(Request $request, User $user)
    {
        $authUser = Auth::user();
        if ($authUser) {
            $authUser->increment('answers');
            return redirect()->route('thanks'); // サンクスページにリダイレクト
        }
        return response()->json(['success' => false], 403);
    }
    
    public function thankspage()
    {
        return view("posts.thanks");
    }
}
