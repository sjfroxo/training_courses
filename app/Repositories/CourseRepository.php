<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class CourseRepository extends CoreRepository implements CourseRepositoryInterface
{
	/**
	 * @param Course $model
	 */
	public function __construct(Course $model)
	{
		parent::__construct($model);
	}

    /**
     * @param int $courseId
     * @return Course
     */
    public function getUsers(int $courseId): Course
    {
        return $this->model->query()
            ->where('id', '=', $courseId)
            ->with('users')
            ->whereHas('users', fn ($query) => $query->where('user_role_id', '=', UserRoleEnum::USER->value))
            ->first();
    }
}
