<?php

namespace App\Services;

use App\Repositories\QuestionTypeRepository;

class QuestionTypeService extends CoreService
{
	/**
	 * @param QuestionTypeRepository $repository
	 */
	public function __construct(QuestionTypeRepository $repository)
	{
		parent::__construct($repository);
	}
}
