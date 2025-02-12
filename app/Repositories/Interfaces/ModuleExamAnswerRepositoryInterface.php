<?php

namespace App\Repositories\Interfaces;

use App\Models\ModuleExam;
use Revalto\ServiceRepository\Repository\AbstractRepositoryInterface;

interface ModuleExamAnswerRepositoryInterface extends AbstractRepositoryInterface
{
	/**
	 * @param string $id
	 *
	 * @return ModuleExam
	 */
	public function findModuleExamByQuestionId(string $id): ModuleExam;

	/**
	 * @param string $id
	 *
	 * @return ModuleExam
	 */
	public function findModuleExamByAnswerId(string $id): ModuleExam;
}
