<?php

namespace App\Services;

use App\DataTransferObjects\ExamUserResultDTO;
use App\Repositories\ExamUserResultRepository;

class ExamUserResultService extends CoreService
{
	/**
	 * @param ExamUserResultRepository $repository
	 */
	public function __construct(ExamUserResultRepository $repository)
	{
		parent::__construct($repository);
	}

    public function createResult(ExamUserResultDTO $dto)
    {
        return $this->repository->create($dto->toArray());

    }

    /**
     * @param $moduleExamId
     * @return array
     */
    public function calculateResults($moduleExamId): array
    {
        return $this->repository->calculateResults($moduleExamId);
    }

}
