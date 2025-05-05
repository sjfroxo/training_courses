<?php

namespace App\Repositories;

use App\Enums\UserRoleEnum;
use App\Models\Course;
use App\Models\Task;
use App\Repositories\Interfaces\CourseRepositoryInterface;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class TaskRepository extends CoreRepository implements TaskRepositoryInterface
{
    /**
     * @param Task $model
     */
	public function __construct(Task $model)
	{
		parent::__construct($model);
	}
}
