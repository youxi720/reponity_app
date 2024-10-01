<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 leading-tight">
            {{ __('Community') }}
        </h2>
    </x-slot>    

    <h3 class="ml-5 text-xl font-bold mb-4">{{ $community->title }} のチャット</h3>

    <!-- 全体を囲むコンテナ -->
    <div class="flex flex-col h-[64vh] border rounded-lg shadow-md">

        <!-- メッセージ表示エリア（固定の高さに設定） -->
        <div id="chat-window" class="flex-1 overflow-y-auto bg-gray-100 p-4 border-b h-[60vh]">
            @if($chats->isEmpty())
                <p class="text-gray-600 text-center">まだメッセージがありません</p>
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
                <button type="submit" class="ml-2 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600 transition duration-200">送信</button>
            </div>
        </form>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            var chatWindow = document.getElementById('chat-window');
            chatWindow.scrollTop = chatWindow.scrollHeight; // ページ読み込み時にスクロール位置を一番下に設定
            
            const userId = {{ auth()->id() }}; // ユーザーIDをJS変数に格納

            // Pusherを使ったリアルタイムメッセージの受信
            window.Echo.channel('community.{{ $community->id }}')
                .listen('Chatpost', (event) => {
                
                    // 新しいメッセージのHTMLを生成
                    const messageHtml = `
                        <div class="flex ${event.user_id === userId ? 'justify-end' : 'justify-start'} mb-4">
                            <div class="${event.user_id === userId ? 'bg-blue-500 text-white' : 'bg-gray-300 text-black'} p-3 rounded-lg max-w-md w-fit shadow-lg">
                                <strong>${event.user}</strong>
                                <p>${event.message}</p>
                                <span class="text-xs ${event.user_id === userId ? 'text-gray-200' : 'text-gray-600'}">${event.created_at}</span>
                            </div>
                        </div>
                    `;
                    
                    // 新しいメッセージをチャットウィンドウの最後に追加
                    chatWindow.insertAdjacentHTML('beforeend', messageHtml);
                    
                    // 新しいメッセージが来たらスクロールを最下部に設定
                    chatWindow.scrollTop = chatWindow.scrollHeight;
                });
        });
    </script>
</x-app-layout>