<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reponity</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chartjs-plugin-datalabels@2"></script>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Myposts') }}
        </h2>
    </x-slot>

    <div class="flex flex-col items-center mt-8">
        @foreach ($data['data'] as $index => $chartData)
            <div class="w-full max-w-md mb-8">
                <div class="text-center total-count" id="total_{{ $index }}"></div>
                <div class="flex justify-center">
                    <canvas id="chart_{{ $index }}" class="w-3/4 h-80"></canvas> <!-- 円グラフ用キャンバス -->
                    <canvas id="bar_chart_{{ $index }}" class="w-3/4 h-80 mt-4"></canvas> <!-- 縦棒グラフ用キャンバス -->
                </div>
            </div>
        @endforeach
    </div>

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
                const canvasId = 'chart_' + question;  // 円グラフのキャンバスID
                const barCanvasId = 'bar_chart_' + question;  // 縦棒グラフのキャンバスID
                const totalId = 'total_' + question;  // 回答総数用のID
                const canvasElement = document.getElementById(canvasId);  // 円グラフ用キャンバス要素を取得
                const barCanvasElement = document.getElementById(barCanvasId);  // 縦棒グラフ用キャンバス要素を取得
                const totalElement = document.getElementById(totalId);  // 回答総数用の要素を取得

                if (canvasElement && barCanvasElement && totalElement) {  // 要素が存在する場合のみ処理を実行
                    const ctx = canvasElement.getContext('2d');
                    const barCtx = barCanvasElement.getContext('2d');

                    const data = chartsData[question];
                    const labels = Object.keys(data);
                    const values = Object.values(data);
                    const total = values.reduce((sum, value) => sum + value, 0); // 総数の計算

                    // 総数を HTML に表示
                    totalElement.textContent = `回答総数: ${total}`;

                    // 円グラフの描画
                    new Chart(ctx, {
                        type: 'pie',
                        data: {
                            labels: labels,
                            datasets: [{
                                data: values,
                                backgroundColor: labels.map((_, index) => pastelColorScale[index % pastelColorScale.length]),
                                borderColor: labels.map(() => '#ffffff'),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: question,
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
                                            return `${value}件 (${percentage}%)`;
                                        }
                                    }
                                },
                                datalabels: {
                                    color: '#000',
                                    formatter: (value, ctx) => {
                                        const percentage = (value / total * 100).toFixed(2);
                                        return `${value} (${percentage}%)`;
                                    },
                                    anchor: 'center',
                                    align: 'center',
                                    font: {
                                        size: 12
                                    },
                                    clip: false
                                }
                            }
                        },
                        plugins: [ChartDataLabels]
                    });

                    // 縦棒グラフの描画
                    new Chart(barCtx, {
                        type: 'bar',
                        data: {
                            labels: labels,
                            datasets: [{
                                label: '回答数',
                                data: values,
                                backgroundColor: labels.map((_, index) => pastelColorScale[index % pastelColorScale.length]),
                                borderColor: labels.map(() => '#ffffff'),
                                borderWidth: 1
                            }]
                        },
                        options: {
                            responsive: false,
                            plugins: {
                                title: {
                                    display: true,
                                    text: question,
                                    padding: {
                                        top: 10,
                                        bottom: 30
                                    },
                                    font: {
                                        size: 14
                                    }
                                },
                                legend: {
                                    display: false
                                },
                                tooltip: {
                                    callbacks: {
                                        label: function(tooltipItem) {
                                            return `${tooltipItem.raw}件`;  // 値のみ表示
                                        }
                                    }
                                }
                            }
                        }
                    });
                } else {
                    console.error('Canvas with ID ' + canvasId + ' or ' + barCanvasId + ' not found.');
                }
            });
        });
    </script>
</x-app-layout>
</body>
</html>
