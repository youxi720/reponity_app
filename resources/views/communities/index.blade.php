<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community') }}
            </h2>
        </x-slot>
        
        <div class="mx-4">
            @if ($errors->any())
                <div class="mb-4">
                    <ul>
                        @foreach ($errors->all() as $error)
                            <li class="text-red-600">{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            
            <!-- 参加済みコミュニティ -->
            <h2 class="text-2xl font-bold mb-4">参加済みコミュニティ</h2>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-4">
                @foreach ($JoinCommunities as $community)
                    <div class="border p-4 rounded shadow bg-white">
                        <p class="font-bold">コミュニティ名：{{ $community->title }}</p>
                        <p>コミュニティ概要：{{ $community->description }}</p>
                        <p>メンバー数：{{ $community->members_count }}</p>
                        <p>作成者：{{ $community->creator->name }}</p>
                        <div class="flex mt-2">
                            <a href="{{ route('communities_show', $community->id) }}" class="text-blue-500 hover:underline">詳細</a>
                            <a href="{{ route('chats_index', $community->id) }}" class="ml-3 text-blue-500 hover:underline">チャット</a>
                        </div>

                        <!-- 退会ボタン（作成者以外の場合） -->
                        @if ($community->creator_id !== auth()->id())
                            <form action="{{ route('communities_leave', $community->id) }}" method="POST" class="mt-2">
                                @csrf
                                <button type="submit" class="bg-red-600 text-white px-4 py-2 rounded hover:bg-red-500">退会する</button>
                            </form>
                        @endif
                    </div>
                @endforeach
            </div>

            <!-- 検索結果（未参加コミュニティ） -->
            <h2 class="text-2xl font-bold mt-8 mb-2">コミュニティを探す</h2>
            <!-- 検索フォームとCreateボタンを横並びに -->
            <div class="flex items-center mb-3">
                <a href='/communities/create' class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-green-500 focus:ring-offset-2">
                    Create
                </a>
                <form action="{{ route('communities_index') }}" method="GET" class="flex ml-3 mt-5">
                    <input type="text" name="keyword" placeholder="キーワード検索" class="form-input border border-gray-300 rounded-md p-2" value="{{ request()->input('keyword') }}">
                    <button type="submit" class="whitespace-nowrap bg-blue-600 text-white px-4 py-2 rounded-md hover:bg-blue-500 ml-2">検索</button>
                </form>
            </div>

            @if ($NotJoinCommunities->isNotEmpty())
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-y-6 gap-x-4">
                    @foreach ($NotJoinCommunities as $community)
                        <div class="border p-3 rounded-lg shadow bg-white">
                            <p class="font-bold">コミュニティ名：{{ $community->title }}</p>
                            <p>コミュニティ概要：{{ $community->description }}</p>
                            <p>メンバー数：{{ $community->members_count }}</p>
                            <p>作成者：{{ $community->creator->name }}</p>
                            <div class="mt-2">
                                <a href="{{ route('communities_show', $community->id) }}" class="ml-1 text-blue-500 hover:underline">詳細</a>

                                <!-- 参加ボタン -->
                                <form action="{{ route('communities_join', $community->id) }}" method="POST" class="mt-2">
                                    @csrf
                                    <button type="submit" class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-500">参加する</button>
                                </form>
                            </div>
                        </div>
                    @endforeach
                </div>
            @else
                <p class="pb-4 text-red-500">該当するコミュニティはありません</p>
            @endif
        </div>
    </x-app-layout>
</body>
