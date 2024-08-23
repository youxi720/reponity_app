<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('post') }}
        </h2>
    </x-slot>
<a href='/posts/create'>create</a>

@foreach ($posts as $post)
<p>対象者：{{ $post->target }}</p>
<p>概要：{{ $post->overview }}</p>
<a href="/posts/{{ $post->id }}">回答する</a>
@endforeach

<div class='paginate'>
    {{ $posts->links() }}
</div>

</x-app-layout>