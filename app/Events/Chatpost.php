<?php

namespace App\Events;

use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use App\Models\Chat;

class Chatpost implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;
    
    public $chat;
    
    /**
     * Create a new event instance.
     */
    public function __construct(Chat $chat)
    {
        $this->chat = $chat;
    }

    /**
     * Get the channels the event should broadcast on.
     *
     * @return array<int, \Illuminate\Broadcasting\Channel>
     */
    public function broadcastOn(): array
    {
        // コミュニティごとのチャネルにブロードキャストする
        return [
            new Channel('community.' . $this->chat->community_id),
        ];
    }

    /**
     * Get the data to broadcast.
     *
     * @return array
     */
    public function broadcastWith()
    {
        return [
            'user' => $this->chat->user->name,
            'message' => $this->chat->message,
            'created_at' => $this->chat->created_at->diffForHumans(),
            'user_id' => $this->chat->user_id,
        ];
    }
}
