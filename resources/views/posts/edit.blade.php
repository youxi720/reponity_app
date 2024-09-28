<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <title>reponity</title>
    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css?family=Nunito:200,600" rel="stylesheet">
</head>
<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('post') }}
            </h2>
        </x-slot>
        
        <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md">
            <h1 class="text-2xl font-bold mb-4">編集画面</h1>
            <form action="/posts/{{ $post->id }}" method="POST">
                @csrf
                @method("PUT")
                
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
                    @error('post.target_ids')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="overview mb-6">
                    <h2 class="font-semibold text-lg mb-2">概要</h2>
                    <textarea name="post[overview]" required class="w-full border border-gray-300 rounded-md p-2" rows="4">{{ $post->overview }}</textarea>
                    @error('post.overview')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <div class="form_url mb-6">
                    <h2 class="font-semibold text-lg mb-2">フォームリンク</h2>
                    <input type="text" name="post[form_url]" value="{{ $post->form_url }}" required class="w-full border border-gray-300 rounded-md p-2"/>
                    @error('post.form_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <div class="sheet mb-6">
                    <h2 class="font-semibold text-lg mb-2">GoogleスプレッドシートのURL</h2>
                    <input type="text" name="post[spreadsheet_url]" value="{{ old('post.spreadsheet_url', $post->spreadsheet_url) }}" class="w-full border border-gray-300 rounded-md p-2" />
                    @error('post.spreadsheet_url')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <input type="submit" value="保存" class="bg-blue-600 text-white py-2 px-4 rounded-md hover:bg-blue-700 transition duration-200 text-center">
            </form>
            <a href="/posts/my_posts" class="mt-4 inline-block text-blue-600 hover:underline">戻る</a>
        </div>


    </x-app-layout>
</body>
</html>
