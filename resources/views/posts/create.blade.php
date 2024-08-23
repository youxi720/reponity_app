<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('post') }}
        </h2>
    </x-slot>
<body>
<h1>Post create</h1>
<form action="/posts" method="POST">
    @csrf
    <div class="target">
        <h2>対象者</h2>
        <input type="text" name="post[target]" placeholder="対象者"/>
    </div>
    <div class="overview">
        <h2>概要</h2>
        <textarea name="post[overview]" placeholder="どんな質問内容になっていますか"></textarea>
    </div>
    <div class="form_url">
        <h2>フォームリンク</h2>
        <input type="text" name="post[form_url]" placeholder"リンクを貼り付けてください"/>
    </div>
    <input type="submit" value="store"/> 
</form>
<div class="footer">
    <a href="/posts">戻る</a>
</div>
</body>
</x-app-layout>