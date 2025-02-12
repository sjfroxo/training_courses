<?php

namespace App\Services;

use App\Repositories\CourseCategoryRepository;

class CourseCategoryService extends CoreService
{
	/**
	 * @param CourseCategoryRepository $repository
	 */
	public function __construct(CourseCategoryRepository $repository)
	{
		parent::__construct($repository);
	}
}
