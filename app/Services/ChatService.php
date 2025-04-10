<?php

namespace App\Services;

use App\Repositories\ChatRepository;
use Illuminate\Pagination\LengthAwarePaginator;

class ChatService extends CoreService
{
    public function __construct(ChatRepository $repository)
    {
        parent::__construct($repository);
    }

    public function chatDetails(string $slug): array
    {
        $chat = $this->repository->findBySlug($slug);
        return $this->repository->getChatDetails($chat);
    }

    public function getMessages(string $slug, string $lastMessId): LengthAwarePaginator
    {
        $chat = $this->repository->findBySlug($slug);
        return $this->repository->getMessages($chat, $lastMessId);
    }
}
