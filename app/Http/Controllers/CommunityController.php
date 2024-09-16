<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use Illuminate\Support\Facades\Auth;


class CommunityController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $keyword = $request->input('keyword');
    
        // 参加済みコミュニティの取得
        $InCommunities = $user->communities()->withCount('members')->get();
    
        // 未参加のコミュニティをキーワードでフィルタリング
        $NotInCommunityIds = $user->communities->pluck('id')->toArray();
        $NotInCommunities = Community::whereNotIn('id', $NotInCommunityIds)
                                         ->where(function ($query) use ($keyword) {
                                             $query->where('title', 'like', '%' . $keyword . '%')
                                                   ->orWhere('description', 'like', '%' . $keyword . '%');
                                         })
                                         ->withCount('members')
                                         ->get();
    
        return view('communities.index', [
            'InCommunities' => $InCommunities,
            'NotInCommunities' => $NotInCommunities,
            'user' => $user
        ]);
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
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        $user = Auth::user(); // ログインユーザー情報を取得
    
        // 参加済みのコミュニティを取得
        $InCommunities = $user->communities;
    
        // ユーザーが参加していないコミュニティを取得し、キーワードでフィルタリング
        $NotInCommunities = Community::whereNotIn('id', $user->communities->pluck('id'))
                                    ->where(function ($query) use ($keyword) {
                                        $query->where('title', 'like', '%' . $keyword . '%')
                                              ->orWhere('description', 'like', '%' . $keyword . '%');
                                    })
                                    ->get();
    
        return view('communities.index', compact('InCommunities', 'NotInCommunities', 'user'));
    }
        public function leave(Community $community)
    {
        $user = Auth::user();
        
        // コミュニティ作成者以外が脱退する処理
        if ($user->id !== $community->creator_id) {
            $user->communities()->detach($community->id); // コミュニティから脱退
            return redirect()->back()->with('success', 'コミュニティを脱退しました');
        }
    
        return redirect()->back()->with('error', 'コミュニティ作成者は脱退できません');
    }
}