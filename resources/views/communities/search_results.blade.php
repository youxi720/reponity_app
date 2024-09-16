<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community') }}
        </h2>
    </x-slot>
    <h2>未参加コミュニティ検索結果</h2>
    <div class="container mx-auto">
        @if ($communities->isEmpty())
            <p>検索結果はありません。</p>
        @else
            @foreach ($communities as $community)
                <p>コミュニティ名：{{ $community->title }}</p>
                <p>コミュニティ概要：{{ $community->description }}</p>
                <p>メンバー数：{{ $community->members_count }}</p>
                <p>作成者：{{ $community->creator->name }}</p>
                <a href="{{ route('communities_show', $community->id) }}">詳細</a>
                <div class="blank"><br></div>
            @endforeach
        @endif
    </div>
</x-app-layout>