<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reponity</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <style>
        .chart-container {
            width: 300px !important;
            height: 300px !important;
            margin-bottom: 30px;
        }
        .total-count {
            font-size: 16px;
            margin-bottom: 10px;
        }
    </style>
</head>
<body>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Myposts') }}
        </h2>
    </x-slot>

    @foreach ($data['data'] as $index => $chartData)
        <div class="chart-container">
            <div class="total-count" id="total_{{ $index }}"></div>
            <canvas id="chart_{{ $index }}"></canvas>
        </div>
    @endforeach

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const chartsData = @json($data['data']);  // PHPから全データ取得

            // パステルカラーの透明度があるカラースケール
            const pastelColorScale = [
                'rgba(255, 99, 132, 0.6)',  // ピンク
                'rgba(54, 162, 235, 0.6)',  // 水色
                'rgba(255, 206, 86, 0.6)',  // パステルイエロー
                'rgba(75, 192, 192, 0.6)',  // パステルターコイズ
                'rgba(153, 102, 255, 0.6)', // ラベンダー
                'rgba(255, 159, 64, 0.6)',  // パステルオレンジ
                'rgba(255, 205, 86, 0.6)',  // 淡いゴールド
                'rgba(201, 203, 207, 0.6)', // パステルグレー
                'rgba(169, 223, 191, 0.6)', // パステルグリーン
                'rgba(241, 148, 138, 0.6)'  // パステルレッド
            ];

            Object.keys(chartsData).forEach((question, questionIndex) => {
                const canvasId = 'chart_' + question;  // 質問名ベースのID
                const totalId = 'total_' + question;  // 回答総数用のID
                const canvasElement = document.getElementById(canvasId);  // キャンバス要素を取得
                const totalElement = document.getElementById(totalId);  // 回答総数用の要素を取得

                if (canvasElement && totalElement) {  // 要素が存在する場合のみ処理を実行
                    const ctx = canvasElement.getContext('2d');

                    const data = chartsData[question];
                    const labels = Object.keys(data);
                    const values = Object.values(data);
                    const total = values.reduce((sum, value) => sum + value, 0); // 総数の計算

                    // 総数を HTML に表示
                    totalElement.textContent = `回答総数: ${total}`;

                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: labels.map((_, index) => pastelColorScale[index % pastelColorScale.length]),  // 10色のパステルカラーを繰り返し使用
                                borderColor: labels.map(() => '#ffffff'),  // 白の境界線
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: question,  // 質問名をタイトルに表示
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    },
                                    font: {
                                        size: 14
                                    }
                                },
                                legend: {
                                    position: 'top'
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            const value = tooltipItem.raw;
                                            const percentage = (value / total * 100).toFixed(2);
                                            return `${value}件 (${percentage}%)`;  // 値とパーセンテージを両方表示
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#000',
                                    formatter: (value, ctx) => {
                                        const percentage = (value / total * 100).toFixed(2);
                                        return `${value} (${percentage}%)`;  // 値とパーセンテージを両方表示
                                    },
                                    anchor: 'center',  // ラベルを円の内側に表示
                                    align: 'center',   // ラベルの配置を中心に
                                    font: {
                                        size: 12  // フォントサイズを少し大きめに調整
                                    },
                                    clip: false  // ラベルが円の外側にクリッピングされないように
                                }
                            }
                        },
                        plugins: [ChartDataLabels]  // DataLabelsプラグインを使用
                    });
                } else {
                    console.error('Canvas with ID ' + canvasId + ' not found.');
                }
            });
        });
    </script>
</x-app-layout>
</body>
</html>
