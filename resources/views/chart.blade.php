<!DOCTYPE html>
<html lang="ja">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>円グラフの表示</title>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        #myChart {
            width: 300px !important; /* グラフの幅を調整 */
            height: 300px !important; /* グラフの高さを調整 */
        }
    </style>
</head>
<body>
    <p id="total"></p>
    <canvas id="myChart"></canvas>
    <script>
        document.addEventListener('DOMContentLoaded', (event) => {
            const ctx = document.getElementById('myChart').getContext('2d');

            // PHP から受け取ったデータを JSON で読み込む
            const data = {!! json_encode($data['data']) !!};
            const title = {!! json_encode($data['title']) !!};

            // データとラベルの処理
            const labels = Object.keys(data);
            const values = Object.values(data);
            const total = values.reduce((sum, value) => sum + value, 0); // 総数の計算

            // 総数を HTML に表示
            document.getElementById('total').textContent = `回答総数: ${total}`;

            new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: [
                            'rgba(75, 192, 192, 0.2)',
                            'rgba(54, 162, 235, 0.2)',
                            'rgba(255, 206, 86, 0.2)',
                            'rgba(153, 102, 255, 0.2)',
                            'rgba(255, 159, 64, 0.2)'
                        ],
                        borderColor: [
                            'rgba(75, 192, 192, 1)',
                            'rgba(54, 162, 235, 1)',
                            'rgba(255, 206, 86, 1)',
                            'rgba(153, 102, 255, 1)',
                            'rgba(255, 159, 64, 1)'
                        ],
                        borderWidth: 1
                    }]
                },
                options: {
                    responsive: false, // この設定で canvas サイズに従うように
                    plugins: {
                        title: {
                            display: true,
                            text: title, // タイトルとしてグラフタイトルを表示
                            padding: {
                                top: 10,
                                bottom: 30
                            },
                            font: {
                                size: 14 // タイトルのフォントサイズを調整
                            }
                        },
                        legend: {
                            position: 'top' // 凡例の位置を調整
                        }
                    }
                }
            });
        });
    </script>
</body>
</html>
