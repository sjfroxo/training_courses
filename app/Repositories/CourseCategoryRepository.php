<?php

namespace App\Repositories;

use App\Models\CourseCategory;
use App\Repositories\Interfaces\CourseCategoryRepositoryInterface;

class CourseCategoryRepository extends CoreRepository implements CourseCategoryRepositoryInterface
{
	/**
	 * @param CourseCategory $model
	 *
	 * @return void
	 */
	public function __construct(CourseCategory $model)
	{
		parent::__construct($model);
	}
}
