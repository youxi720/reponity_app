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
            {{ __('post') }}
        </h2>
    </x-slot>
    <body>
        <h1 class="title">編集画面</h1>
        <div class="content">
            <form action="/posts/{{ $post->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="target">
                    <h2>対象者</h2>
                    <input type="checkbox" id="target1" name="post[target][]" value="学部1年生">
                    <label for="target1">学部1年生</label>
                    <input type="checkbox" id="target2" name="post[target][]" value="学部2年生">
                    <label for="target2">学部2年生</label>
                    <input type="checkbox" id="target3" name="post[target][]" value="学部3年生">
                    <label for="target3">学部3年生</label>
                    <input type="checkbox" id="target4" name="post[target][]" value="学部4年生">
                    <label for="target4">学部4年生</label>
                </div>
                <div class="overview">
                    <h2>概要</h2>
                    <textarea name="post[overview]">{{ $post->overview }}</textarea>
                </div>
                <div class="form_url">
                    <h2>フォームリンク</h2>
                    <input type="text" name="post[form_url]" value="{{ $post->form_url }}"/>
                </div>
                <input type="submit" value="保存"> 
            </form>
        </div>
        <div class="footer">
            <a href="/posts/my_posts">戻る</a>
        </div>
    </body>
    </x-app-layout>
</html>
