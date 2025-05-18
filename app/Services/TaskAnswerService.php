<?php

namespace App\Services;

use App\Repositories\Interfaces\TaskAnswerRepositoryInterface;
use Illuminate\Database\Eloquent\Collection;

class TaskAnswerService extends CoreService
{
    /**
     * @param TaskAnswerRepositoryInterface $repository
     */
	public function __construct(TaskAnswerRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}

    /**
     * @return Collection
     */
    public function getForCurator(): Collection
    {
        return $this->repository->getForCurator();
    }
}
