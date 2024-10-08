<?php

namespace App\Http\Controllers;

use App\Services\CiniiApiClient;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;

class ArticleController extends Controller
{
    protected $ciniiClient;

    public function __construct(CiniiApiClient $ciniiClient)
    {
        $this->ciniiClient = $ciniiClient;
    }

    public function search(Request $request)
    {
        $query = $request->input('query');
    
        // APIからデータを取得
        $response = $this->ciniiClient->searchArticles($query);
        
        // APIのレスポンスから、必要な情報を抽出
        $articles = $response['items'] ?? []; // ここで実際に論文情報が含まれるキーを確認
        
        // ページネーションのためのコレクションに変換
        $perPage = 5; // 1ページあたりのアイテム数
        $currentPage = LengthAwarePaginator::resolveCurrentPage();
        $items = collect($articles)->slice(($currentPage - 1) * $perPage, $perPage)->all();
        $paginatedArticles = new LengthAwarePaginator($items, count($articles), $perPage, $currentPage);
    
        // ページネーション用のURLを設定
        $paginatedArticles->setPath($request->url());
        return view('articles.index', compact('paginatedArticles'));
    }

    
    public function index()
    {
        return view('articles.index');
    }
}
