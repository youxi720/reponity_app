<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community') }}
            </h2>
        </x-slot>
        
        <h1>{{ $community->title }}</h1>
        <p>概要：{{ $community->description }}</p>
        
        <h2>メンバー</h2>
        <ul>
            @if ($community->members->isNotEmpty())
                @foreach($community->members as $member)
                    <li><a href="/users/{{ $member->id }}">{{ $member->name }}</a></li>
                @endforeach
            @else
                <li>メンバーがまだいません</li>
            @endif
        </ul>
        
        @if ($community->creator_id === $user->id)
            <br>
            <form action="{{ route('communities_delete', $community->id) }}" method="POST">
                @csrf
                @method('DELETE')
                <button type="submit" onclick="return confirm('削除すると復元できません。\n本当に削除しますか？')">コミュニティを削除する</button> <!-- 作成者のみ削除ボタン -->
            </form>
        @endif
        
        <div class="footer">
            <a href="/communities/index">戻る</a>
        </div>
    </x-app-layout>
</body>
