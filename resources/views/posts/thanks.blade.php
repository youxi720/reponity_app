<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md text-center">
        <p class="text-lg mb-4">回答ありがとうございました。</p>
        <a href="/posts" class="text-blue-600 hover:underline">ホームへ戻る</a>
    </div>
</x-app-layout>
