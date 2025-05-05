<?php

namespace App\Services;

use App\Models\Course;
use App\Repositories\CourseRepository;
use App\Repositories\Interfaces\TaskRepositoryInterface;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Collection;

class TaskService extends CoreService
{
    /**
     * @param TaskRepositoryInterface $repository
     *
     */
	public function __construct(TaskRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}
}
