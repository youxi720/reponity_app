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
        $sheetName = $post->sheet_name ?? 'フォームの回答 1';  // Postモデルからシート名を取得、なければデフォルト名

        if ($sheetId) {
            try {
                $data = $this->getSheetData($sheetId, $sheetName);

                // データが正しく取得できなかった場合のエラーハンドリング
                if (empty($data['data'])) {
                    return redirect()->back()->withErrors(['error' => 'シートのデータが見つかりませんでした。']);
                }

                return view('chart', compact('data'));
            } catch (\Exception $e) {
                // 例外が発生した場合のエラーハンドリング
                return redirect()->back()->withErrors(['error' => 'シートデータの取得中にエラーが発生しました。']);
            }
        } else {
            return redirect('posts/my_posts')->withErrors(['error' => 'シートIDが読み込めませんでした。']);
        }
    }

    function getSheetData($spreadsheetId, $sheetName)
    {
        $client = new Google_Client();
        $client->setApplicationName('Google Sheets API');
        $client->setScopes(Google_Service_Sheets::SPREADSHEETS_READONLY);
        $client->setAuthConfig(storage_path('credentials.json'));

        $service = new Google_Service_Sheets($client);
        $range = $sheetName;  // シート名を動的に使用

        try {
            $response = $service->spreadsheets_values->get($spreadsheetId, $range);
            $values = $response->getValues();

            // データが空かどうか確認
            if (empty($values) || count($values) < 2) {
                return ['data' => [], 'title' => ''];
            }

            // 各列ごとのデータを処理
            $result = [];
            $titles = $values[0];  // 1行目はタイトル
            for ($j = 1; $j < count($titles); $j++) { // 2列目以降のタイトルを取得
                $question = $titles[$j];
                $result[$question] = [];

                // 2行目以降のデータをカウント
                for ($i = 1; $i < count($values); $i++) { // 2行目以降を処理
                    $option = $values[$i][$j] ?? '';  // 列ごとのデータ
                    if ($option !== '') {
                        if (isset($result[$question][$option])) {
                            $result[$question][$option]++;
                        } else {
                            $result[$question][$option] = 1;
                        }
                    }
                }
            }
            return ['data' => $result];

        } catch (\Exception $e) {
            // APIエラーやその他の例外が発生した場合
            throw new \Exception('シートデータの取得中にエラーが発生しました。');
        }
    }
}
