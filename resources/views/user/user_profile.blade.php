<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Profile') }}
        </h2>
    </x-slot>
<body>
    <p>名前：{{ $user_profile->name }}</p>
    <p>学年：{{ $user_profile->grade }}</p>
    <p>学部：{{ $user_profile->faculty }}</p>
    <p>趣味：{{ $user_profile->hobby }}</p>
    <p>回答数：{{ $user_profile->answers }}</p>
    <a href="/users/{{ $user_profile->id }}/edit" class="text-red-600 ">edit</a>
</body>
</x-app-layout>