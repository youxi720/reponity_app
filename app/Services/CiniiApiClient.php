<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class CiniiApiClient
{
    protected $baseUrl = 'https://ci.nii.ac.jp/opensearch/';
    protected $appId;
    
    public function __construct()
    {
        $this->appId = config('services.cinii.api_id');
    }
    
    /**
     * 論文を検索する
     *
     * @param string $query 検索クエリ
     * @param array $parameters 追加のパラメータ
     * @return array
     * @throws \Exception
     */
     
    public function searchArticles(string $query, array $parameters = []): array
    {
        // APIにGETリクエストを送信
        $response = Http::get($this->baseUrl . 'search', array_merge([
            'q' => $query,
            'format' => 'json',  // JSON形式でのレスポンスを指定
            'app_id' => $this->appId  // アプリケーションIDをリクエストに追加
        ], $parameters));

        // レスポンスが正常かどうかチェック
        if ($response->successful()) {
            return $response->json();
        }

        // エラーが発生した場合は例外を投げる
        throw new \Exception("API request failed with status: " . $response->status());
    }
}