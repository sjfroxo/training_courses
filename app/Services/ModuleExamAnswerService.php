<?php

namespace App\Services;

use App\Repositories\ModuleExamAnswerRepository;

class ModuleExamAnswerService extends CoreService
{
	/**
	 * @param ModuleExamAnswerRepository $repository
	 */
	public function __construct(ModuleExamAnswerRepository $repository)
	{
		parent::__construct($repository);
	}
}
