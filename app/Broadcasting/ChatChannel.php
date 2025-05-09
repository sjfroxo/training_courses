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
        \Log::info('Channel auth attempt', [
            'user_id' => $user ? $user->id : null,
            'chat_id' => $chatId,
        ]);
        $hasAccess = $user && $user->chats()->where('chats.id', $chatId)->exists();
        \Log::info('Channel auth result', ['has_access' => $hasAccess]);
        return $hasAccess;
    }
}
