<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('post') }}
        </h2>
    </x-slot>
    <body>
    <a href='/posts/create'>create</a>
    @foreach ($posts as $post)
    <p>対象者：{{ $post->target }}</p>
    <p>概要：{{ $post->overview }}</p>
    <a href="/posts/{{ $post->id }}">回答する</a>
    <div class='like-btn'>
        @if($post->is_liked_by_auth_user())
            <form action="{{ route('unlike', ['post' => $post->id]) }}" method="POST" style="display:inline;">
                @csrf
                @method('DELETE')
                <button type="submit" class="btn btn-success btn-sm">👍</button>
            </form>
        @else
            <form action="{{ route('like', ['post' => $post->id]) }}" method="POST" style="display:inline;">
                @csrf
                <button type="submit" class="btn btn-secondary btn-sm">いいね</button>
            </form>
        @endif
    </div>
        @endforeach

    <div class='paginate'>
        {{ $posts->links() }}
    </div>
    </body>
</x-app-layout>