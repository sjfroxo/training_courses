<?php

namespace App\Repositories;

use App\Models\ModuleExamQuestion;
use App\Repositories\Interfaces\ModuleExamQuestionRepositoryInterface as RepositoryInterface;

class ModuleExamQuestionRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param ModuleExamQuestion $model
	 */
	public function __construct(ModuleExamQuestion $model)
	{
		parent::__construct($model);
	}
}
