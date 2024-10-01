<body>
    <x-app-layout>
        <x-slot name="header">
            <h2 class="font-semibold text-xl text-gray-800 leading-tight">
                {{ __('Community') }}
            </h2>
        </x-slot>
        <div class="max-w-2xl mx-auto mt-6 bg-white p-6 rounded-lg shadow-md sm:max-w-full">
            <h1 class="text-2xl font-bold mb-6">コミュニティ作成</h1>
            <form action="{{ route('communities_update', ['community' => $community->id]) }}" method="POST" class="space-y-6" enctype="multipart/form-data">
                @csrf
                @method('PUT')
                
                <!-- コミュニティ名 -->
                <div>
                    <label for="title" class="block text-sm font-medium text-gray-700">コミュニティ名:</label>
                    <input type="text" name="title" value="{{ $community->title }}" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                    @error('title')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- コミュニティ概要 -->
                <div>
                    <label for="description" class="block text-sm font-medium text-gray-700">コミュニティ概要:</label>
                    <textarea name="description" rows="4" class="mt-1 block w-full px-3 py-2 border border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">{{ $community->description }}</textarea>
                    @error('description')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                
                <!-- 画像のアップロード -->
                <div class="image mb-4">
                    <label for="image" class="block text-sm font-medium text-gray-700">コミュニティ画像:</label>
                    <input type="file" name="image">
                    @error('image')
                        <p class="text-red-600 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
    
                <!-- 保存ボタン -->
                <div>
                    <button type="submit" class="inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-500 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                        保存
                    </button>
                </div>
            </form>
    
            <!-- 戻るリンク -->
            <div class="mt-5">
                <a href="{{ route('communities_index') }}" class="text-blue-600 hover:underline">戻る</a>
            </div>
        </div>
    </x-app-layout>
</body>
