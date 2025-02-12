<?php

namespace App\Traits;

use App\Repositories\ModuleRepository;
use App\Services\CoreService;

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

//    public function firstWithModule(string $id): Model
//    {
//        return $this->repository->firstWithModule($id);
//    }
}
