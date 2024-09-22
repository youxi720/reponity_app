<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Posts') }}
        </h2>
    </x-slot>

    <!-- 絞り込みフォーム -->
    <form method="GET" action="{{ route('post_index') }}" class="mb-6 flex items-center">
        <div class="mb-4 ml-4">
            <label for="target" class="block text-sm font-medium text-gray-700">ターゲットで絞り込み:</label>
            <select name="target_id" id="target" class="mt-1 block w-60 border-gray-300 rounded-md shadow-sm focus:border-blue-500 focus:ring focus:ring-blue-200 focus:ring-opacity-50">
                <option value="">全てのターゲット</option>
                @foreach ($targets as $target)
                    <option value="{{ $target->id }}" {{ request('target_id') == $target->id ? 'selected' : '' }}>
                        {{ $target->target }}
                    </option>
                @endforeach
            </select>
        </div>
        <button type="submit" class="mt-2 inline-flex items-center px-4 py-2 border border-transparent rounded-md font-semibold text-black hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
            絞り込み
        </button>
    </form>

    <!-- 投稿作成リンク -->
    <a href='/posts/create' class="ml-4 inline-flex items-center px-4 py-2 mb-4 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
        Create
    </a>

    <!-- 投稿一覧 -->
    <div class="space-y-4">
        @foreach ($posts as $post)
            <div class="p-4 border border-gray-300 rounded-lg shadow-sm bg-white">
                <p class="font-semibold">投稿者：<a href="/users/{{ $post->user->id }}" class="text-blue-600 hover:underline">{{ $post->user->name }}</a></p>
                <p class="text-gray-700">対象者：{{ $post->targets->pluck('target')->implode(', ') }}</p>
                <p class="text-gray-600">概要：{{ $post->overview }}</p>
                
                <!-- 回答するボタンといいねボタンを並列に配置 -->
                <div class="flex items-center mt-2">
                    <a href="/posts/{{ $post->id }}" class="inline-flex items-center px-3 py-1 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">回答する</a>
                    
                    <div class='like-btn ml-2'>
                        @if($post->is_liked_by_auth_user())
                            <form action="{{ route('unlike', ['post' => $post->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 bg-red-600 rounded-full px-4 py-4 text-white hover:bg-red-500 focus:outline-none focus:ring-2 focus:ring-red-500 focus:ring-offset-2">👍</button>
                            </form>
                        @else
                            <form action="{{ route('like', ['post' => $post->id]) }}" method="POST" style="display:inline;">
                                @csrf
                                <button type="submit" class="inline-flex items-center justify-center w-8 h-8 border-2 border-gray-400 rounded-full px-4 py-4 font-semibold text-black hover:bg-gray-400 hover:text-white focus:outline-none focus:ring-2 focus:ring-gray-500 focus:ring-offset-2">👍</button>
                            </form>
                        @endif
                    </div>
                </div>
            </div>
        @endforeach
    </div>

    <!-- ページネーション -->
    <div class='paginate mt-6'>
        {{ $posts->appends(request()->input())->links() }}
    </div>
</x-app-layout>
