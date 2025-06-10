<?php

namespace App\Services;

use App\Repositories\ModuleRepository;
use Illuminate\Database\Eloquent\Model;

class ModuleService extends CoreService
{
	/**
	 * @param ModuleRepository $repository
	 *
	 * @return void
	 */
	public function __construct(ModuleRepository $repository)
	{
		parent::__construct($repository);
	}

    public function firstWithModule(string $id): Model
    {
        return $this->repository->firstWithModule($id);
    }

    public function findCourses()
    {
        return $this->repository->findCourses();
    }
}
