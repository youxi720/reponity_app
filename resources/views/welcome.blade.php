<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>

    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body class="antialiased bg-gray-100">

    <!-- Hero Section -->
    <div class="h-screen bg-cover bg-center flex items-center justify-center" style="background-image: url({{ asset('images/book_background.jpg') }});">
        <div class="text-center text-white bg-black bg-opacity-50 p-8 rounded-lg">
            <h1 class="text-6xl font-bold">reponity</h1>
            <p class="text-xl mt-4">Report × Community<br>アンケート調査をする人で集まりましょう</p>
            <div class="mt-6 space-x-4">
                @if (auth()->check())
                    <a href="{{ route('post_index') }}" class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-600 transition">ホームへ</a>
                @else
                    <a href="{{ route('login') }}" class="bg-blue-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-blue-600 transition">Login</a>
                    <a href="{{ route('register') }}" class="bg-gray-500 text-white px-6 py-3 rounded-full text-lg font-semibold hover:bg-gray-600 transition">Signup</a>
                @endif
            </div>
        </div>
    </div>

    <!-- Content Section -->
    <div class="container mx-auto py-12">
        <h2 class="text-3xl font-bold text-center mb-8">私たちのサービス</h2>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105">
                <i class="fas fa-users text-6xl mb-4 text-blue-500"></i>
                <h3 class="text-2xl font-bold">Connect</h3>
                <p class="mt-2 text-gray-600">学生と繋がる</p>
            </div>
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105">
                <i class="fas fa-brain text-6xl mb-4 text-blue-500"></i>
                <h3 class="text-2xl font-bold">Survey</h3>
                <p class="mt-2 text-gray-600">アンケート調査の募集</p>
            </div>
            <div class="flex flex-col items-center bg-white rounded-lg shadow-lg p-6 transition-transform transform hover:scale-105">
                <i class="fas fa-comments text-6xl mb-4 text-blue-500"></i>
                <h3 class="text-2xl font-bold">Communicate</h3>
                <p class="mt-2 text-gray-600">コミュニティで会話</p>
            </div>
        </div>
    </div>

</body>
</html>
