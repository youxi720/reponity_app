<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="p-4">
        <p class="text-gray-700"><strong>対象者：</strong>{{ $post->targets->pluck('target')->implode(', ') }}</p>
        <p class="text-gray-600"><strong>概要：</strong>{{ $post->overview }}</p>
    </div>

    <div class="gform mb-4 flex justify-center">
        <iframe id="googleForm" src="{{ $post->form_url }}" width="80%" height="480" frameborder="0" marginheight="0" marginwidth="0">読み込み中...</iframe> 
    </div>

    <div class="flex justify-center">
        <form action="{{ route('count-ans', ['user' => $user]) }}" method="POST">
            @csrf
            <button type="submit" class="inline-flex items-center px-4 py-2 bg-blue-600 border border-transparent rounded-md font-semibold text-white hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-blue-500 focus:ring-offset-2">
                回答が完了しました
            </button>
        </form>
    </div>
</x-app-layout>
