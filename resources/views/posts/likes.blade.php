<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('likes') }}
        </h2>
    </x-slot>
    <body>
    @foreach ($posts as $post)
        <p>投稿者：{{ $post->user->name }}</p>
        <p>対象者：{{ $post->targets->pluck('target')->implode(', ') }}</p>
        <p>概要：{{ $post->overview }}</p>
        <a href="/posts/{{ $post->id }}">回答する</a>
        <div class='like-btn'>
            <form action="{{ route('unlike', ['post' => $post->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-success btn-sm">👍</button>
            </form>
        </div>
        <div class="blank">
            <br>
        </div>
    @endforeach

    <div class='paginate'>
        {{ $posts->links() }}
    </div>
    </body>
    <script>
    function deletePost(id){
        "use strict"
        if (confirm("削除すると復元できません。\n本当に削除しますか？")){
            document.getElementById(`form_${id}`).submit();
        }
    }
    </script>
</x-app-layout>