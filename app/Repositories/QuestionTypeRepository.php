<?php

namespace App\Repositories;

use App\Models\QuestionType;
use App\Repositories\Interfaces\QuestionTypeRepositoryInterface as RepositoryInterface;
use Revalto\ServiceRepository\Repository\AbstractRepository as Repository;

class QuestionTypeRepository extends CoreRepository implements RepositoryInterface
{
	/**
	 * @param QuestionType $model
	 * @return void
	 */
	public function __construct(QuestionType $model)
	{
		parent::__construct($model);
	}
}
