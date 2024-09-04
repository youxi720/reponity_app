<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
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

    public function update(Request $request, User $user)
    {
        // fillメソッドで更新する
        $user->fill($request->all())->save();
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
    
    public function thankspage(Request $request)
    {
        return view("posts.thanks");
    }
}
