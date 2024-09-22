<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('My Posts') }}
        </h2>
    </x-slot>

    {{-- エラーメッセージの表示 --}}
    @if ($errors->any())
        <div class="mb-4">
            <ul class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative" role="alert">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <a href='/posts/create' class="mt-3 ml-4 inline-flex items-center px-4 py-2 mb-4 bg-blue-600 text-white rounded-md hover:bg-blue-500">
        Create
    </a>

    @foreach ($posts as $post)
        <div class="p-4 border border-gray-300 rounded-lg shadow-sm bg-white mb-4">
            <p class="font-semibold">対象者：{{ $post->targets->pluck('target')->implode(', ') }}</p>
            <p class="text-gray-700">概要：{{ $post->overview }}</p>
            
            <div class="mt-2">
                <a href="/posts/{{ $post->id }}/edit" class="inline-flex items-center px-3 py-1 mt-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">edit</a>
                <a href="/chart/{{ $post->id }}" class="inline-flex items-center px-3 py-1 mt-2 bg-blue-500 border border-transparent rounded-md font-semibold text-white hover:bg-blue-400 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">check</a>
                
                <form action="/posts/{{ $post->id }}" id="form_{{ $post->id }}" method="post" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="button" onclick="deletePost({{ $post->id }})" class="inline-flex items-center px-3 py-1 bg-red-600 text-white rounded-md hover:bg-red-500">delete</button>
                </form>
            </div>
        </div>
    @endforeach

    <div class='paginate mt-6'>
        {{ $posts->links() }}
    </div>

    <script>
        function deletePost(id) {
            "use strict";
            if (confirm("削除すると復元できません。\n本当に削除しますか？")) {
                document.getElementById(`form_${id}`).submit();
            }
        }
    </script>
</x-app-layout>
