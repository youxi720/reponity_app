<body>
    <x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>
    <h1>コミュニティ作成</h1>
    <form method="POST" action="{{ route('communities_store') }}">
    @csrf
    <div>
        <label for="title">コミュニティ名:</label>
        <input type="text" name="title" id="title">
    </div>
    <div>
        <label for="description">コミュニティ概要:</label>
        <textarea name="description" id="description"></textarea>
    </div>
    <button type="submit">作成する</button>
</form>
<div class="footer">
    <a href="/communities/index">戻る</a>
</div>
</x-app-layout>
</body>
