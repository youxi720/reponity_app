<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
    <head>
        <meta charset="utf-8">
        <title>reponity</title>
        <!-- Fonts -->
        <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
    </head>
    <body>
        <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('post') }}
            </h2>
        </x-slot>
        <h1 class="title">編集画面</h1>
        <div class="content">
            <form action="/posts/{{ $post->id }}" method="POST">
                @csrf
                @method("PUT")
                <div class="target">
                    <h2>対象者</h2>
                    <div>
                        @foreach($allTargets as $target)
                            <label>
                                <input type="checkbox" name="post[target_ids][]" value="{{ $target->id }}"
                                    {{ $post->targets->contains($target->id) ? 'checked' : '' }}>
                                {{ $target->target }}
                            </label><br>
                        @endforeach
                    </div>
                </div>
                <div class="overview">
                    <h2>概要</h2>
                    <textarea name="post[overview]" required>{{ $post->overview }}</textarea>
                </div>
                <div class="form_url">
                    <h2>フォームリンク</h2>
                    <input type="text" name="post[form_url]" value="{{ $post->form_url }}" required/>
                </div>
                <div class="sheet">
                    <h2>GoogleスプレッドシートのURL</h2>
                    <input type="text" name="spreadsheet_url" value="{{ $post->sheet }}" />
                </div>
                <input type="submit" value="保存"> 
            </form>
        </div>
        <div class="footer">
            <a href="/posts/my_posts">戻る</a>
        </div>
        </x-app-layout>
    </body>
</html>
