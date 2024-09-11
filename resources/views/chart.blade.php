<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>reponity</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
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
            const chartsData = @json($data['data']);  // PHPから受け取った全データ

            Object.keys(chartsData).forEach((question) => {
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
                                backgroundColor: labels.map(() => randomColor()),  // 各選択肢にランダムな色を設定
                                borderColor: labels.map(() => randomColor(true)),  // 各選択肢にランダムな色を設定
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
                                }
                            }
                        }
                    });
                } else {
                    console.error('Canvas with ID ' + canvasId + ' not found.');
                }
            });

            function randomColor(dark = false) {
                const r = Math.floor(Math.random() * 256);
                const g = Math.floor(Math.random() * 256);
                const b = Math.floor(Math.random() * 256);
                return `rgba(${r}, ${g}, ${b}, ${dark ? '1' : '0.2'})`;
            }
        });
    </script>
</x-app-layout>
</body>
</html>
