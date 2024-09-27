<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Community;
use Cloudinary;
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
    
    public function store(Request $request, Community $community)
    {
        $input = $request->only(['title', 'description']);
        if ($request->file('image')) {
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            // 入力データに画像URLを追加
            $input['image_url'] = $image_url;
        }
        // 作成者IDを追加
        $input['creator_id'] = Auth::id();
        // データを保存
        $community = Community::create($input);
        
        // コミュニティ作成者をメンバーとして追加
        $community->members()->attach(Auth::id());
        return redirect()->route('communities_index')->with('success', 'コミュニティを作成しました。');
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
    
    public function edit(Community $community)
    {
        return view("communities.edit")->with(["community" => $community]);
    }
    
    public function update(Request $request, Community $community)
    {
        if ($request->file("image")) {
            $image_url = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
            $community->image_url = $image_url;
        }
        $community->fill($request->except('image'))->save();
        return redirect()->route("communities_show", ['community' => $community->id]);
    }

}