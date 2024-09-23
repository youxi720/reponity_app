<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community') }}
            </h2>
        </x-slot>
        
        <div class="mt-6 max-w-4xl mx-auto p-6 bg-white rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">{{ $community->title }}</h1>
            <p class="text-gray-600 mb-6">概要：{{ $community->description }}</p>
            
            <h2 class="text-xl font-semibold mb-2">メンバー</h2>
            <ul class="list-disc list-inside mb-6">
                @if ($community->members->isNotEmpty())
                    @foreach($community->members as $member)
                        <li class="mb-2">
                            <a href="/users/{{ $member->id }}" class="text-blue-500 hover:underline">{{ $member->name }}</a>
                        </li>
                    @endforeach
                @else
                    <li>メンバーがまだいません</li>
                @endif
            </ul>
            
            <a href="{{ route('chats_index', $community->id) }}" class="bg-blue-500 text-white px-4 py-2 rounded hover:bg-blue-800">チャット</a>
            
            @if ($community->creator_id === $user->id)
                <form action="{{ route('communities_delete', $community->id) }}" method="POST" class="mt-4">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="bg-red-500 text-white px-4 py-2 rounded hover:bg-red-600" onclick="return confirm('削除すると復元できません。\n本当に削除しますか？')">コミュニティを削除</button>
                </form>
            @endif
            
            <div class="mt-8">
                <a href="/communities/index" class="text-blue-500 hover:underline">戻る</a>
            </div>
        </div>
    </x-app-layout>
</body>
