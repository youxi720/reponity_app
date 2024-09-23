<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Post') }}
        </h2>
    </x-slot>

    <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
        <h1 class="text-2xl font-bold mb-4">投稿</h1>
        
        <form action="/posts" method="POST">
            @csrf
            <div class="target mb-4">
                <h2 class="text-lg font-semibold">対象者</h2>
                <div class="flex flex-wrap">
                    @foreach($allTargets as $target)
                        <label class="flex items-center w-full sm:w-1/2 md:w-1/3 p-2">
                            <input type="checkbox" name="post[target_ids][]" value="{{ $target->id }}"
                            {{ $post->targets->contains($target->id) ? 'checked' : '' }} class="mr-2">
                            {{ $target->target }}
                        </label>
                    @endforeach
                </div>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-2">概要</h2>
                <textarea name="post[overview]" placeholder="どんな質問内容になっていますか" 
                class="w-full border border-gray-300 rounded-md p-2" rows="4"></textarea>
            </div>

            <div class="mb-6">
                <h2 class="font-semibold text-lg mb-2">フォームリンク</h2>
                <input type="text" name="post[form_url]" placeholder="リンクを貼り付けてください" 
                class="w-full border border-gray-300 rounded-md p-2"/>
            </div>

            <input type="submit" value="保存" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200">
        </form>
        <a href="/posts" class="mt-4 inline-block text-blue-600 hover:underline">戻る</a>
    </div>
</x-app-layout>
