<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\View\View;

class UserController extends Controller
{
    public function show (User $user)
    {
        $user = Auth::user();
        return view("user.user_profile")->with(['user_profile' => $user]);
    }
    
    public function edit (User $user)
    {
        return view("user.user_profile_edit")->with(["user_profile" => $user]);
    }
    
    public function update(Request $request, User $user)
    {
        $user->fill($request->all())->save();
        $user->save();

        return redirect()->route('show', ['user' => $user->id]);
    }
}
