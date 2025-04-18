<?php

namespace App\Events;

use App\Models\ChatMessage;
use Illuminate\Broadcasting\Channel;
use Illuminate\Broadcasting\InteractsWithSockets;
use Illuminate\Broadcasting\PrivateChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcast;
use Illuminate\Foundation\Events\Dispatchable;
use Illuminate\Queue\SerializesModels;
use Log;

class MessageSent implements ShouldBroadcast
{
    use Dispatchable, InteractsWithSockets, SerializesModels;

    public ChatMessage $message;

    public function __construct(ChatMessage $message)
    {
        Log::info('MessageSent: Получен объект сообщения', [
            'message_id' => $message->id,
            'chat_id' => $message->chat_id,
            'reply_message_id' => $message->reply_message_id,
        ]);
        $this->message = $message->load('repliedToMessage');
        Log::info('MessageSent: Отношение repliedToMessage загружено', [
            'replied_to_message_id' => $this->message->repliedToMessage ? $this->message->repliedToMessage->id : null,
        ]);
    }

    public function broadcastOn(): Channel
    {
        return new Channel('chat.1');
//        return new PrivateChannel('chat.' . $this->message->chat_id);
    }

    public function broadcastAs(): string
    {
        return 'MessageSent';
    }

    public function broadcastWith(): array
    {
        return [
            'id' => $this->message->id,
            'chat_id' => $this->message->chat_id,
            'user_id' => $this->message->user_id,
            'message' => $this->message->message,
            'type' => $this->message->type,
            'media_url' => $this->message->media_url,
            'reply_message_id' => $this->message->reply_message_id,
            'replied_to_message' => $this->message->repliedToMessage ? [
                'id' => $this->message->repliedToMessage->id,
                'message' => $this->message->repliedToMessage->message,
                'type' => $this->message->repliedToMessage->type,
            ] : null,
            'created_at' => $this->message->created_at->toISOString(),
        ];
    }
}
