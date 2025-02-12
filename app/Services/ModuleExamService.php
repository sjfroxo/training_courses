<?php

namespace App\Services;

use App\Repositories\Interfaces\ModuleExamRepositoryInterface;
use App\Repositories\ModuleExamRepository;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;

class ModuleExamService extends CoreService
{
	/**
	 * @param ModuleExamRepository $repository
	 */
	public function __construct(ModuleExamRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}

	/**
	 * @param string $id
	 *
	 * @return Model
	 */
	public function firstWithModule(string $id): Model
	{
        return $this->repository->firstWithModule($id);
	}

	public function getQuestions(Model $exam): Collection
	{
		return $exam->moduleExamQuestions()->get();
	}
}
