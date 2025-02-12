<?php

namespace App\Repositories;

use App\Models\ModuleComment;
use App\Repositories\Interfaces\ModuleCommentRepositoryInterface;

class ModuleCommentRepository extends CoreRepository implements ModuleCommentRepositoryInterface
{
	/**
	 * @param ModuleComment $model
	 *
	 * @return void
	 */
	public function __construct(ModuleComment $model)
	{
		parent::__construct($model);
	}
}
