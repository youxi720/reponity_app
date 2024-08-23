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
                {{ __('index') }}
            </h2>
        </x-slot>

        <body>
            <div class="content">
                <form action="/users/{{ $user_profile->id }}" method="POST">
                    @csrf
                    @method("PUT")
                    <div class='content__grade'>
                        <h2>学年</h2>
                        <input type="radio" id="grade1" name="grade" value="1" {{ $user_profile->grade == 1 ? 'checked' : '' }}><label for="grade1">学部1年生</label>
                        <input type="radio" id="grade2" name="grade" value="2" {{ $user_profile->grade == 2 ? 'checked' : '' }}><label for="grade2">学部2年生</label>
                        <input type="radio" id="grade3" name="grade" value="3" {{ $user_profile->grade == 3 ? 'checked' : '' }}><label for="grade3">学部3年生</label>
                        <input type="radio" id="grade4" name="grade" value="4" {{ $user_profile->grade == 4 ? 'checked' : '' }}><label for="grade4">学部4年生</label>
                    </div>
                    <div class='content__faculty'>
                        <h2>学部</h2>
                        <input type='text' name='faculty' value="{{ $user_profile->faculty }}">
                    </div>
                    <div class='content__hobby'>
                        <h2>趣味</h2>
                        <input type='text' name='hobby' value="{{ $user_profile->hobby }}">
                    </div>
                    <input type="submit" value="保存">
                </form>
            </div>
            <a href="/users/{{ $user_profile->id }}">戻る</a>
        </body>
    </x-app-layout>
</html>