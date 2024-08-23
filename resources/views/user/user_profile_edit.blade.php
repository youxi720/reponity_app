<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('index') }}
        </h2>
    </x-slot>
<body>
<div class="content">
    <form action="/users/{{ $user_profile->id }}" method="POST">
        @csrf
        @method("PUT")
        <div class='content__grade'>
            <h2>学年</h2>
            <input type='text' name='grade' value="{{ $user_profile->grade }}">
        </div>
        <div class='content__faculty'>
            <h2>学部</h2>
            <input type='text' name='faculty' value="{{ $user_profile->faculty }}">
        </div>
        <div class='content__hobby'>
            <h2>趣味</h2>
            <input type='text' name='hobby' value="{{ $user_profile->hobby }}">
        </div>
        <input type="submit" value="保存">
    </form>
</div>
<a href="/users/{{ $user_profile->id }}">戻る</a>
</body>
</x-app-layout>