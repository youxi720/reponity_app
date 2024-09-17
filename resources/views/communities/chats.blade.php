<x-app-layout>
    <h2 class="text-xl font-bold mb-4">{{ $community->title }} のチャット</h2>

    <!-- 全体を囲むコンテナ -->
    <div class="flex flex-col h-[80vh] border rounded-lg">

        <!-- メッセージ表示エリア（固定の高さに設定） -->
        <div id="chat-window" class="flex-1 overflow-y-auto bg-gray-100 p-4 border-b h-[60vh]">
            @if($chats->isEmpty())
                <p class="text-gray-600">まだメッセージがありません</p>
            @else
                @foreach($chats->reverse() as $chat)  <!-- メッセージを逆順に表示 -->
                    @if($chat->user->id === auth()->id())
                        <!-- 自分のメッセージ -->
                        <div class="flex justify-end mb-4">
                            <div class="bg-blue-500 text-white p-3 rounded-lg max-w-md w-fit shadow-lg">
                                <strong>{{ $chat->user->name }}</strong>
                                <p>{{ $chat->message }}</p>
                                <span class="text-xs text-gray-200">{{ $chat->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @else
                        <!-- 他のユーザーのメッセージ -->
                        <div class="flex justify-start mb-4">
                            <div class="bg-gray-300 text-black p-3 rounded-lg max-w-md w-fit shadow-lg">
                                <strong>{{ $chat->user->name }}</strong>
                                <p>{{ $chat->message }}</p>
                                <span class="text-xs text-gray-600">{{ $chat->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                    @endif
                @endforeach
            @endif
        </div>

        <!-- メッセージ入力フォーム -->
        <form action="{{ route('chats_store', $community->id) }}" method="POST" class="p-4 bg-white border-t">
            @csrf
            <div class="flex items-center">
                <textarea name="message" rows="2" class="w-full p-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500" placeholder="メッセージを入力" required></textarea>
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg">送信</button>
            </div>
        </form>

    </div>

    <!-- ページ読み込み時にスクロールを一番下にするためのJavaScript -->
    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var chatWindow = document.getElementById('chat-window');
            chatWindow.scrollTop = chatWindow.scrollHeight; // スクロール位置を一番下に設定
        });
    </script>
</x-app-layout>
