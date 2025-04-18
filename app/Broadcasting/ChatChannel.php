<?php

namespace App\Broadcasting;

class ChatChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param $user
     * @param $chatId
     * @return bool
     */
    public function join($user, $chatId): bool
    {
        return $user->chats()->where('chats.id', $chatId)->exists();
    }
}
