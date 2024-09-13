<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('post') }}
            </h2>
        </x-slot>
        <a href='/communities/create' class="btn btn-primary">Create</a>
        <div class="blank">
            <br>
        </div>
        
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li class="text-red-600 ">{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        
        @foreach ($communities as $community)
        <p>コミュニティ名：{{ $community->title }}</p>
        <p>コミュニティ概要：{{ $community->description }}</p>
        <p>メンバー数：{{ $community->members_count }}</p>
        <p>作成者：{{ $community->creator->name }}</p>

        @if ($user->communities->contains($community->id))
            <a href="{{ route('communities_show', $community->id) }}">詳細</a> <!-- 参加済みの場合、詳細リンク -->
        @else
            <a href="{{ route('communities_show', $community->id) }}">詳細</a> <!-- 未参加でも詳細を見る -->
            <form action="{{ route('communities_join', $community->id) }}" method="POST">
                @csrf
                <button type="submit">参加する</button> <!-- 未参加の場合、参加ボタン -->
            </form>
        @endif
        
        <div class="blank">
            <br>
        </div>
        @endforeach
    </x-app-layout>
</body>
