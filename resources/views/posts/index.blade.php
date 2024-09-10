<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <!-- 絞り込みフォーム -->
    <form method="GET" action="{{ route('post_index') }}">
        <div class="mb-4">
            <label for="target">ターゲットで絞り込み:</label>
            <select name="target_id" id="target">
                <option value="">全てのターゲット</option>
                @foreach ($targets as $target)
                    <option value="{{ $target->id }}" {{ request('target_id') == $target->id ? 'selected' : '' }}>
                        {{ $target->target }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="btn btn-primary">絞り込み</button>
    </form>

    <!-- 投稿作成リンク -->
    <a href='/posts/create' class="btn btn-primary">Create</a>

    <!-- 投稿一覧 -->
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

    <!-- ページネーション -->
    <div class='paginate'>
        {{ $posts->appends(request()->input())->links() }}
    </div>
</x-app-layout>
