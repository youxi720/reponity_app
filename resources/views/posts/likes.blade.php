<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Favorites') }}
        </h2>
    </x-slot>

    <div class="p-6 space-y-6">
        @if ($posts->isNotEmpty())
            @foreach ($posts as $post)
                <div class="p-4 border border-gray-300 rounded-lg shadow-sm bg-white">
                    <p class="font-semibold text-gray-800">投稿者：<span class="text-blue-600">{{ $post->user->name }}</span></p>
                    <p class="text-gray-700"><strong>対象者：</strong>{{ $post->targets->pluck('target')->implode(', ') }}</p>
                    <p class="text-gray-600"><strong>概要：</strong>{{ $post->overview }}</p>

                    <div class="flex items-center mt-2">
                        <a href="/posts/{{ $post->id }}" class="inline-flex items-center px-4 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                            回答する
                        </a>
                        <form action="{{ route('unlike', ['post' => $post->id]) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="like-btn liked ml-4 inline-flex items-center justify-center w-10 h-10 bg-red-600 rounded-full text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">
                                👍
                            </button>
                        </form>
                    </div>
                </div>
            @endforeach
        @else
            <p class="text-center text-gray-600 mt-20 mb-20">まだお気に入り登録がされていません。</p>
        @endif

        <!-- ページネーション -->
        <div class="paginate mt-6 flex justify-center">
            <ul class="inline-flex items-center space-x-1">
                {{ $posts->appends(request()->input())->links('pagination::tailwind') }}
            </ul>
        </div>
    </div>

    <script>
        document.querySelectorAll('.like-btn').forEach(likeBtn => {
            likeBtn.addEventListener('click', async (e) => {
                e.preventDefault(); // ページのリロードを防ぐ
                const form = e.target.closest('form');
                const url = form.action; // フォームのアクションURLを取得

                try {
                    const res = await fetch(url, {
                        method: 'DELETE', // DELETEメソッドを使用
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content') // CSRFトークンを追加
                        }
                    });

                    if (res.ok) {
                        // 成功時の処理。ページを再読み込みなどでUIを更新する
                        location.reload();
                    } else {
                        throw new Error('いいね処理に失敗しました');
                    }
                } catch (error) {
                    alert(error.message);
                }
            });
        });
    </script>
</x-app-layout>
