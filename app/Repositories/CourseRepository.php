<?php

namespace App\Repositories;

use App\Models\Course;
use App\Repositories\Interfaces\CourseRepositoryInterface;

class CourseRepository extends CoreRepository implements CourseRepositoryInterface
{
	/**
	 * @param Course $model
	 */
	public function __construct(Course $model)
	{
		parent::__construct($model);
	}
}
