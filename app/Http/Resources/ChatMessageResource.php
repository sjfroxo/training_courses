<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ChatMessageResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'message' => $this->message,
            'type' => $this->type,
            'media_url' => $this->media_url,
            'reply_message_id' => $this->reply_message_id,
            'replied_to_message' => $this->repliedToMessage ? [
                'id' => $this->repliedToMessage->id,
                'message' => $this->repliedToMessage->message,
                'type' => $this->repliedToMessage->type,
            ] : null,
            'created_at' => $this->created_at->toISOString(),
        ];
    }
}
