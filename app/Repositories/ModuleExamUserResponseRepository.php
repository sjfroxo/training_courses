<?php

namespace App\Repositories;

use App\Models\ModuleExamUserResponse;
use App\Repositories\Interfaces\ModuleExamUserResponseRepositoryInterface as RepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class ModuleExamUserResponseRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param ModuleExamUserResponse $model
	 *
	 * @return void
	 */
	public function __construct(ModuleExamUserResponse $model)
	{
		parent::__construct($model);
	}

    public function deleteUserResponses(int $moduleExamId, int $userId): void
    {
        ModuleExamUserResponse::query()
            ->where('module_exam_id', $moduleExamId)
            ->where('user_id', $userId)
            ->delete();
    }

    public function createResponse(array $data): ModuleExamUserResponse
    {
        return ModuleExamUserResponse::query()->create($data);
    }

    public function getUserResponses(int $moduleExamId, int $userId): Collection
    {
        return ModuleExamUserResponse::query()
            ->where('module_exam_id', $moduleExamId)
            ->where('user_id', $userId)
            ->get();
    }

}
