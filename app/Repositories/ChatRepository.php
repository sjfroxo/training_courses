<?php

namespace App\Repositories;

use App\Models\Chat;
use App\Repositories\Interfaces\ChatRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class ChatRepository extends CoreRepository implements ChatRepositoryInterface
{
    public function __construct(
        Chat $model,
        protected UserRepositoryInterface $userRepository
    ) {
        parent::__construct($model);
    }

    public function getChats(int $userId): Collection
    {
        return Chat::query()->whereHas('users', function ($query) use ($userId) {
            $query->where('users.id', $userId);
        })->with(['chatMessages' => function ($query) {
            $query->latest()->limit(1);
        }])->get();
    }

    public function getChatDetails(Chat $chat): array
    {
        $messages = $chat->chatMessages()
            ->with('repliedToMessage', 'user')
            ->latest()
            ->take(30)
            ->get()
            ->sortBy('created_at')
            ->values();

        $media = $this->getMedia($chat);

        return [
            'chat'          => $chat,
            'messages'      => $messages,
            'voiceMessages' => $media['voice'],
            'videoMessages' => $media['video'],
        ];
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

    /**
     * @throws Exception
     */
    public function loadMedia(string $id, UploadedFile $file): string
    {
        $path = 'public/messages/' . $id;
        Storage::makeDirectory($path);
        $fileName = $file->getClientOriginalName();
        $file->storeAs($path, $fileName);

        if (!Storage::exists($path . '/' . $fileName)) {
            Log::error('Failed to save media file in loadMedia for message ID: ' . $id);
            throw new Exception('Failed to save media file in loadMedia');
        }

        return Storage::url($path . '/' . $fileName);
    }

    public function getFilesByExtension($id, $extension): string
    {
        $allFiles = Storage::files("public/messages/" . $id . "/");
        $filteredFiles = array_filter($allFiles, fn($file) => pathinfo($file, PATHINFO_EXTENSION) === $extension);
        return Storage::url($filteredFiles[array_key_first($filteredFiles)] ?? '');
    }

    public function getExistingChat(int $user1Id, int $user2Id): ?Chat
    {
        return Chat::query()->whereHas('users', function ($query) use ($user1Id) {
            $query->where('users.id', $user1Id);
        })
            ->whereHas('users', function ($query) use ($user2Id) {
                $query->where('users.id', $user2Id);
            })
            ->where(function ($query) {
                $query->whereHas('users', function ($q) {
                    $q->select('chat_id')
                        ->groupBy('chat_id')
                        ->havingRaw('COUNT(users.id) = 2');
                });
            })
            ->first();
    }

    public function findBySlug(string $slug): ?Chat
    {
        return Chat::query()->where('slug', $slug)->firstOrFail();
    }
}
