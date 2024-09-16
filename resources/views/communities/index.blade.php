<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('コミュニティ一覧') }}
            </h2>
        </x-slot>

        <a href='/communities/create' class="btn btn-primary">Create</a>
        <div class="blank"><br></div>

        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- 参加済みコミュニティ -->
        <h2>・参加済みコミュニティ</h2>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach ($InCommunities as $community)
                <div class="border p-4 rounded shadow">
                    <p class="font-bold">コミュニティ名：{{ $community->title }}</p>
                    <p>コミュニティ概要：{{ $community->description }}</p>
                    <p>メンバー数：{{ $community->members_count }}</p>
                    <p>作成者：{{ $community->creator->name }}</p>
                    <a href="{{ route('communities_show', $community->id) }}" class="text-blue-500">詳細</a>
                    
                    <!-- 退会ボタン（作成者以外の場合） -->
                    @if ($community->creator_id !== auth()->id())
                        <form action="{{ route('communities_leave', $community->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-danger text-red-600">退会する</button>
                        </form>
                    @endif
                </div>
            @endforeach
        </div>

        <!-- 検索結果（未参加コミュニティ） -->
        <h2>・コミュニティを探す</h2>
        <!-- 検索フォーム -->
        <form action="{{ route('communities_index') }}" method="GET" class="mb-6">
            <input type="text" name="keyword" placeholder="キーワードでコミュニティを検索" class="form-input" value="{{ request()->input('keyword') }}">
            <button type="submit" class="btn btn-primary">検索</button>
        </form>
        
        @if ($NotInCommunities->isNotEmpty())
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach ($NotInCommunities as $community)
                    <div class="border p-4 rounded shadow">
                        <p class="font-bold">コミュニティ名：{{ $community->title }}</p>
                        <p>コミュニティ概要：{{ $community->description }}</p>
                        <p>メンバー数：{{ $community->members_count }}</p>
                        <p>作成者：{{ $community->creator->name }}</p>
                        <a href="{{ route('communities_show', $community->id) }}" class="text-blue-500">詳細</a>
                        <form action="{{ route('communities_join', $community->id) }}" method="POST" class="mt-2">
                            @csrf
                            <button type="submit" class="btn btn-primary">参加する</button>
                        </form>
                    </div>
                @endforeach
            </div>
        @else
            <p>該当するコミュニティはありません</p>
        @endif
    </x-app-layout>
</body>
