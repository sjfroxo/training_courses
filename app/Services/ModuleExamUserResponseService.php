<?php

namespace App\Services;

use App\Repositories\ModuleExamUserResponseRepository;

class ModuleExamUserResponseService extends CoreService
{
	/**
	 * @param ModuleExamUserResponseRepository $repository
	 *
	 * @return void
	 */
	public function __construct(ModuleExamUserResponseRepository $repository)
	{
		parent::__construct($repository);
	}

    public function processUserResponses(int $moduleExamId, int $userId, array $dtos): void
    {
        $this->repository->deleteUserResponses($moduleExamId, $userId);

        foreach ($dtos as $dto) {
            $this->repository->createResponse([
                'module_exam_question_id' => $dto->module_exam_question_id,
                'user_id' => $dto->user_id,
                'text' => $dto->text,
                'module_exam_answer_id' => $dto->module_exam_answer_id,
                'module_exam_id' => $dto->module_exam_id,
            ]);
        }
    }
}
