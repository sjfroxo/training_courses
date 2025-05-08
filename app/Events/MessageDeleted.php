<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;

class MessageDeleted implements ShouldBroadcastNow
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public int $messageId;
    public int $chatId;

    /**
     * @param  int  $messageId
     * @param  int  $chatId
     */
    public function __construct(int $messageId, int $chatId)
    {
        $this->messageId = $messageId;
        $this->chatId    = $chatId;

        Log::info('MessageDelete: ', [
            'message_id' => $this->messageId,
            'chat_id'    => $this->chatId,
        ]);
    }

    public function broadcastOn(): PrivateChannel
    {
        return new PrivateChannel('chat.' . $this->chatId);
    }

    public function broadcastAs(): string
    {
        return 'MessageDeleted';
    }

    public function broadcastWith(): array
    {
        return [
            'messageId' => $this->messageId,
            'chatId'    => $this->chatId,
        ];
    }
}
