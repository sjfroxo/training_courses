<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use Illuminate\Http\UploadedFile;

class ChatMessageDTO implements ModelDTO
{
    /**
     * @param string $chat_id
     * @param string $user_id
     * @param string $type
     * @param string|null $reply_message_id
     * @param string $message
     * @param UploadedFile|null $media_file
     */
    public function __construct(
        public readonly string $chat_id,
        public readonly string $user_id,
        public readonly string $type,
        public readonly ?string $reply_message_id,
        public readonly ?string $message,
        public readonly ?UploadedFile $media_file = null,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'type' => $this->type,
            'reply_message_id' => $this->reply_message_id,
            'message' => $this->message,
            'media_file' => $this->media_file,
        ];
    }
}
