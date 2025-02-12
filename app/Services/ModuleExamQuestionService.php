<?php

namespace App\Services;

use App\Repositories\Interfaces\ModuleExamQuestionRepositoryInterface;
use App\Repositories\ModuleExamQuestionRepository;

class ModuleExamQuestionService extends CoreService
{
	/**
	 * @param ModuleExamQuestionRepository $repository
	 */
	public function __construct(ModuleExamQuestionRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}
}
