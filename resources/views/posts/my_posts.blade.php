<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('myposts') }}
        </h2>
    </x-slot>
    <body>
    <a href='/posts/create'>create</a>
    @foreach ($posts as $post)
    <p>対象者：{{ $post->target }}</p>
    <p>概要：{{ $post->overview }}</p>
    <div class="edit">
        <a href="/posts/{{ $post->id }}/edit">edit</a>
    </div>
    <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post">
        @csrf
        @method('DELETE')
        <button type="button" onclick="deletePost({{ $post->id }})">delete</button>
    </form>
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