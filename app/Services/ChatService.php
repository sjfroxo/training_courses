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
        return $this->repository->getChatDetails($this->repository->findBySlug($slug));
    }

    public function getMessages(string $slug, string $lastMessId): LengthAwarePaginator
    {
        return $this->repository->getMessages($this->repository->findBySlug($slug), $lastMessId);
    }
}
