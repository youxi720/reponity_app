<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Community;
use App\Models\Chat;
use App\Events\Chatpost;

class ChatController extends Controller
{
    public function index(Community $community)
    {
        $chats = $community->chats()->with('user')->latest()->get();
        return view('communities.chats', compact('chats', 'community'));
    }
    
    public function store(Request $request, Community $community)
    {
        $chat = Chat::create([
            'user_id' => auth()->id(),
            'community_id' => $community->id,
            'message' => $request->message,
        ]);
        
        broadcast(new Chatpost($chat));
        
        return redirect()->back();
    }
}
