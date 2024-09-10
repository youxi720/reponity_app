<?php

namespace App\Http\Controllers;

use Google_Client;
use Google_Service_Sheets;
use Illuminate\Http\Request;
use App\Models\Post;

class GoogleSheetsController extends Controller
{
    public function showChart(Post $post)
    {
        $sheetId = $post->sheet;  // PostモデルからsheetIDを取得
        if ($sheetId){
            $data = $this->getSheetData($sheetId);
        
            // データが正しく取得できなかった場合のエラーハンドリング
            if (empty($data['data'])) {
                return redirect()->back()->withErrors(['error' => 'シートのデータが見つかりませんでした。']);
            }

            return view('chart', compact('data'));
            }
        else{
            return redirect('posts/my_posts');
        }
    }

    function getSheetData($spreadsheetId)
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(storage_path('credentials.json'));

        $service = new Google_Service_Sheets($client);
        $range = 'フォームの回答 1';  // シート全体
        
        $response = $service->spreadsheets_values->get($spreadsheetId, $range);
        $values = $response->getValues();
        // データが空かどうか確認
        if (empty($values) || count($values) < 2) {
            return ['data' => [], 'title' => '', 'total' => 0, 'invalid' => 0];
        }
    
        // 1列目はタイムスタンプなので、2列目以降の1行目をタイトルとして設定
        $title = isset($values[0][1]) ? $values[0][1] : 'タイトルが見つかりません';

        // 2列目以降の2行目以降のデータをカウント
        $result = [];
        for ($i = 2; $i < count($values); $i++) { // 3行目以降を処理
            $row = $values[$i];
            for ($j = 1; $j < count($row); $j++) { // 2列目以降を処理
                $option = $row[$j];
                if (isset($result[$option])) {
                    $result[$option]++;
                } else {
                    $result[$option] = 1;
                }
            }
        }

        return ['title' => $title, 'data' => $result];
    }
}
