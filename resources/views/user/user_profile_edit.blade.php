<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>reponity</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body class="bg-gray-100">
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 mb-6 bg-white p-6 rounded-lg shadow-md">
        <h3 class="text-lg font-bold mb-4">プロフィール編集</h3>
        <form action="/users/{{ $user_profile->id }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method("PUT")

            <div class="mb-4">
                <h4 class="font-semibold mb-2">学年</h4>
                <div class="flex space-x-4">
                    <label class="inline-flex items-center">
                        <input type="radio" id="grade1" name="grade" value="1" {{ $user_profile->grade == 1 ? 'checked' : '' }} class="form-radio">
                        <span class="ml-2">学部1年生</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="grade2" name="grade" value="2" {{ $user_profile->grade == 2 ? 'checked' : '' }} class="form-radio">
                        <span class="ml-2">学部2年生</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="grade3" name="grade" value="3" {{ $user_profile->grade == 3 ? 'checked' : '' }} class="form-radio">
                        <span class="ml-2">学部3年生</span>
                    </label>
                    <label class="inline-flex items-center">
                        <input type="radio" id="grade4" name="grade" value="4" {{ $user_profile->grade == 4 ? 'checked' : '' }} class="form-radio">
                        <span class="ml-2">学部4年生</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <h4 class="font-semibold mb-2">学部</h4>
                <input type='text' name='faculty' value="{{ $user_profile->faculty }}" class="form-input mt-1 block w-full" placeholder="例: 経済学部">
            </div>

            <div class="mb-4">
                <h4 class="font-semibold mb-2">趣味</h4>
                <input type='text' name='hobby' value="{{ $user_profile->hobby }}" class="form-input mt-1 block w-full" placeholder="例: サッカー">
            </div>
            
            <div class="image">
                <input type="file" name="image">
            </div>

            <button type="submit" class="mt-4 bg-blue-600 text-white font-bold py-2 px-4 rounded hover:bg-blue-500 transition duration-150">保存</button>
        </form>

        <a href="/users/{{ $user_profile->id }}" class="mt-4 inline-block text-blue-600 hover:underline">戻る</a>
    </div>
</x-app-layout>
</body>
</html>
