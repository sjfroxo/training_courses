<?php

namespace App\Repositories\Interfaces;

use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface UserRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @return Collection
     */
    public function getUsers(): Collection;

    /**
     * @param User $user
     * @return string
     */
    public function getUserRole(User $user): string;

    /**
     * @param int $studentsClassId
     * @return Model|null
     */
    public function getCuratorByStudentClassId(int $studentsClassId): ?Model;
}
