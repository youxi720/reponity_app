<body>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
<h1>Post create</h1>
<form action="/posts" method="POST">
    @csrf
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
        <textarea name="post[overview]" placeholder="どんな質問内容になっていますか"></textarea>
    </div>
    <div class="form_url">
        <h2>フォームリンク</h2>
        <input type="text" name="post[form_url]" placeholder="リンクを貼り付けてください"/>
    </div>
    <input type="submit" value="store"/> 
</form>
<div class="footer">
    <a href="/posts">戻る</a>
</div>
</x-app-layout>
</body>
