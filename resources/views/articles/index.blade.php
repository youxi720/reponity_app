<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Search') }}
        </h2>
    </x-slot>
    
    <div class="flex justify-center mt-6">
        <form action="{{ route('articles_search') }}" method="GET" class="flex items-center w-full max-w-3xl">
            <input type="text" name="query" placeholder="論文検索" class="border rounded-md px-4 py-2 w-full shadow-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
            <button type="submit" class="ml-2 px-6 py-2 bg-blue-500 text-white rounded-md hover:bg-blue-600 transition duration-150">
                <span class="whitespace-nowrap">検索</span>
            </button>
        </form>
    </div>
    
    @if ($errors->any())
        <div class="bg-red-500 text-white p-2 rounded mt-4 mx-10">
            <ul>
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif
    
    <div class="mt-4 mx-10">
        @if(isset($paginatedArticles) && count($paginatedArticles) > 0)
            @foreach ($paginatedArticles as $article)
                <div class="mb-4 border border-gray-300 rounded-lg shadow-sm bg-white p-4">
                    <a href="{{ $article['@id'] }}" target="_blank" rel="noopener noreferrer" class="text-blue-500 hover:underline">
                        {{ htmlspecialchars($article['title']) }} <!-- タイトルをエスケープ -->
                    </a>
                    <p class="text-gray-600">
                    著者：
                    @if (isset($article['dc:creator']) && is_array($article['dc:creator']))
                        {{ implode(', ', array_map('htmlspecialchars', $article['dc:creator'])) }} <!-- 著者全員をカンマ区切りで表示 -->
                    @else
                        Unknown Author
                    @endif
                    </p>
                </div>
            @endforeach
        @else
            <p class="text-center text-gray-600">No articles found.</p>
        @endif
    </div>
    
    <!-- ページネーション -->
    @isset($paginatedArticles)
        @if($paginatedArticles->total() > 0)
            <div class="paginate mt-6 flex justify-center">
                <ul class="inline-flex items-center space-x-1">
                    {{ $paginatedArticles->appends(request()->input())->links('pagination::tailwind') }}
                </ul>
            </div>
        @endif
    @endisset
    
</x-app-layout>
