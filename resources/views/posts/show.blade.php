<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('post') }}
        </h2>
    </x-slot>
<p>対象者：{{ $post->target }}</p>
<p>概要：{{ $post->overview }}</p>
<iframe src="{{ $post->form_url }}" width="640" height="480" frameborder="0" marginheight="0" marginwidth="0">読み込み中...</iframe> 
</x-app-layout>