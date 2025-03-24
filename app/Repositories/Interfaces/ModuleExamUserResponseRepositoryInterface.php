<?php

namespace App\Repositories\Interfaces;

use App\Models\ModuleExamUserResponse;
use Illuminate\Database\Eloquent\Collection;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ModuleExamUserResponseRepositoryInterface extends AbstractRepositoryInterface
{
    /**
     * @param int $moduleExamId
     * @param int $userId
     * @return void
     */
    public function deleteUserResponses(int $moduleExamId, int $userId): void;

    /**
     * @param array $data
     * @return ModuleExamUserResponse
     */
    public function createResponse(array $data): ModuleExamUserResponse;

    /**
     * @param int $moduleExamId
     * @param int $userId
     * @return Collection
     */
    public function getUserResponses(int $moduleExamId, int $userId): Collection;
}
