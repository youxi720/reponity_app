<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <a href='/posts/create' class="btn btn-primary">Create</a>

    @foreach ($posts as $post)
        <div class="post">
            <p>対象者：{{ $post->targets->pluck('target')->implode(', ') }}</p>
            <p>概要：{{ $post->overview }}</p>
            <a href="/posts/{{ $post->id }}" class="btn btn-info">回答する</a>
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
        </div>
    @endforeach

    <div class='paginate'>
        {{ $posts->links() }}
    </div>
</x-app-layout>
