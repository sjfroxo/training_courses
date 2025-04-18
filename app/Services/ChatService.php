<?php

namespace App\Services;

use App\Models\Chat;
use App\Repositories\ChatRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Pagination\LengthAwarePaginator;

class ChatService extends CoreService
{
    public function __construct(ChatRepository $repository)
    {
        parent::__construct($repository);
    }

    public function getChats(int $userId): Collection
    {
        return $this->repository->getChats($userId);
    }

    public function chatDetails(string $slug): array
    {
        return $this->repository->getChatDetails($this->repository->findBySlug($slug));
    }

    public function getMessages(string $slug, ?string $lastMessId): LengthAwarePaginator
    {
        return $this->repository->getMessages($this->repository->findBySlug($slug), $lastMessId);
    }

    public function getExistingChat(int $user1Id, int $user2Id): ?Chat
    {
        return $this->repository->getExistingChat($user1Id, $user2Id);
    }
}
