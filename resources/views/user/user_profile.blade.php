<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>reponity</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>

    <div>
        <p>名前：{{ $user_profile->name }}</p>
        @if ($user_profile->grade)
            <p>学年：学部 {{ $user_profile->grade }} 年生</p>
        @else
            <p>学年：</p>
        @endif
        <p>学部：{{ $user_profile->faculty }}</p>
        <p>趣味：{{ $user_profile->hobby }}</p>
        <p>回答数：{{ $user_profile->answers }}</p>
        @if ($user_profile->id === Auth::id())
            <a href="/users/{{ $user_profile->id }}/edit" class="text-red-600">edit</a>
        @endif
    </div>
</x-app-layout>
</html>
