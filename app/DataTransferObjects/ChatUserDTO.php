<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ChatUserRequest;

class ChatUserDTO implements ModelDTO
{
    /**
     * @param string $chat_id
     * @param string $user_id
     * @param string $user_role
     */
    public function __construct(
        public readonly string $chat_id,
        public readonly string $user_id,
        public readonly string $user_role,
    )
    {
    }

    /**
     * @param ChatUserRequest $request
     * @return ChatUserDTO
     */
    public static function appRequest(ChatUserRequest $request): ChatUserDTO
    {
        return new ChatUserDTO(
            $request['chat_id'],
            $request['user_id'],
            $request['user_role'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'chat_id' => $this->chat_id,
            'user_id' => $this->user_id,
            'user_role' => $this->user_role,
        ];
    }
}
