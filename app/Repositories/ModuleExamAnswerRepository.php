<?php

namespace App\Repositories;

use App\Models\ModuleExam;
use App\Models\ModuleExamAnswer;
use App\Repositories\Interfaces\ModuleExamAnswerRepositoryInterface;

class ModuleExamAnswerRepository extends CoreRepository implements ModuleExamAnswerRepositoryInterface
{
	/**
	 * @param ModuleExamAnswer $model
	 *
	 * @return void
	 */
	public function __construct(ModuleExamAnswer $model)
	{
		parent::__construct($model);
	}

	/**
	 * @param string $id
	 *
	 * @return ModuleExam
	 */
	public function findModuleExamByQuestionId(string $id): ModuleExam
	{
		return $this->getBuilder()->findOrFail($id)->moduleExam;
	}

	/**
	 * @param string $id
	 *
	 * @return ModuleExam
	 */
	public function findModuleExamByAnswerId(string $id): ModuleExam
	{
		return $this->getBuilder()->findOrFail($id)->moduleExamQuestion->moduleExam;
	}
}
