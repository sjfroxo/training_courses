<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Storage;

class ChatRepository extends CoreRepository implements ChatRepositoryInterface
{
    public function __construct(Chat $model)
    {
        parent::__construct($model);
    }

    public function getChatDetails(Chat $chat): array
    {
        $messages = $this->getMessages($chat);
        $media = $this->getMedia($chat);

        return [
            'chat' => $chat,
            'messages' => $messages,
            'voiceMessages' => $media['voice'],
            'videoMessages' => $media['video'],
        ];
    }

    public function getMessages(Chat $chat, ?string $lastMessId = null): LengthAwarePaginator
    {
        return $chat->chatMessages()
            ->with('repliedToMessage') // Добавляем связь для ответных сообщений
            ->when($lastMessId, fn($query) => $query->where('id', '<', $lastMessId))
            ->orderBy('created_at', 'desc')
            ->paginate(10);
    }

    public function getMedia(Chat $chat): array
    {
        return [
            'voice' => $this->getMediaFiles($chat, 'voice'),
            'video' => $this->getMediaFiles($chat, 'video'),
        ];
    }

    public function getMediaFiles(Chat $chat, string $type): array
    {
        return $chat->chatMessages()
            ->where('type', $type)
            ->get()
            ->filter(function ($message) {
                return Storage::exists("public/messages/" . $message->id);
            })
            ->mapWithKeys(function ($message) {
                return [$message->id => $this->getFilesByExtension($message->id, $message->type === 'voice' ? 'webm' : 'mkv')];
            })
            ->toArray();
    }

    public function getFilesByExtension($id, $extension): string
    {
        $allFiles = Storage::files("public/messages/" . $id . "/");
        $filteredFiles = array_filter($allFiles, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === $extension);
        return Storage::url($filteredFiles[array_key_first($filteredFiles)] ?? '');
    }
}
