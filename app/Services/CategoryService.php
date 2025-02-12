<?php

namespace App\Services;

use App\Repositories\CategoryRepository;

class CategoryService extends CoreService
{
	/**
	 * @param CategoryRepository $repository
	 */
	public function __construct(CategoryRepository $repository)
	{
		parent::__construct($repository);
	}
}
