<?php

namespace App\Repositories;

use App\Models\Category;
use App\Repositories\Interfaces\CategoryRepositoryInterface;

class CategoryRepository extends CoreRepository implements CategoryRepositoryInterface
{
	/**
	 * @param Category $model
	 */
	public function __construct(Category $model)
	{
		parent::__construct($model);
	}
}
