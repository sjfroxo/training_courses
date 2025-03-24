<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param string $userId
     * @return Collection
     */
    public function getChats(string $userId): Collection;

    /**
     * @param Collection $chats
     * @return Collection
     */
    public function getLastMessages(Collection $chats): Collection;

    /**
     * @param User $user
     * @return string
     */
    public function getUserRole(User $user): string;
}
