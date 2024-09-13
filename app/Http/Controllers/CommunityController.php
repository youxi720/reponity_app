<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;


class CommunityController extends Controller
{
    public function index()
    {
        $communities = Community::withCount('members')->get();
        $user = Auth::user();
        
        // ユーザーが参加しているコミュニティの ID を取得
        $joinedCommunityIds = $user->communities()->pluck('community_id')->toArray();
        
        return view('communities.index', compact('communities', 'user', 'joinedCommunityIds'));
    }
    
    public function create()
    {
        return view('communities.create');
    }
    
    public function store(Request $request)
    {
            $community = Community::create([
            'title' => $request->title,
            'description' => $request->description,
            'creator_id' => Auth::id(),
        ]);

        // コミュニティ作成者をメンバーとして追加
        $community->members()->attach(Auth::id());

        return redirect()->route('communities_index');
    }

    // コミュニティ参加
    public function join(Request $request, Community $community)
    {
        $user = Auth::user();
        if (!$user->communities->contains($community->id)) {
            $user->communities()->attach($community->id); // コミュニティに参加
        }
    
        return redirect()->back()->with('success', 'コミュニティに参加しました');
    }

    // コミュニティ詳細表示
    public function show(Community $community)
    {
        // コミュニティのメンバーを取得
        $members = $community->members;

        // ログインユーザーの取得
        $user = Auth::user();

        return view('communities.show', compact('community', 'members', 'user'));
    }
    
    public function delete($id)
    {
        // $idを使用してコミュニティを取得
        $community = Community::findOrFail($id);
    
        // 作成者のみ削除を許可
        if (Auth::id() === $community->creator_id) {
            $community->delete();
    
            return redirect()->route('communities_index')->with('status', 'コミュニティを削除しました。');
        } else {
            return redirect()->route('communities_index')->with('error', '削除する権限がありません。');
        }
    }
}
