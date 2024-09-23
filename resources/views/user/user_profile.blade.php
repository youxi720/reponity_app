<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>reponity</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4">プロフィール情報</h3>
        <p class="mb-2"><span class="font-semibold">名前：</span>{{ $user_profile->name }}</p>
        @if ($user_profile->grade)
            <p class="mb-2"><span class="font-semibold">学年：</span>学部 {{ $user_profile->grade }} 年生</p>
        @else
            <p class="mb-2"><span class="font-semibold">学年：</span>未設定</p>
        @endif
        <p class="mb-2"><span class="font-semibold">学部：</span>{{ $user_profile->faculty }}</p>
        <p class="mb-2"><span class="font-semibold">趣味：</span>{{ $user_profile->hobby }}</p>
        <p class="mb-2"><span class="font-semibold">回答数：</span>{{ $user_profile->answers }}</p>
        @if ($user_profile->id === Auth::id())
            <a href="/users/{{ $user_profile->id }}/edit" class="text-red-600 hover:underline">編集</a>
        @endif
    </div>
</x-app-layout>
</body>
</html>
