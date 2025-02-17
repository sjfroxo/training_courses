<?php

namespace App\Services;

use App\DataTransferObjects\ModuleExamUserResponseDTO;
use App\Http\Requests\ExamUserResponseResultRequest;
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

    public function handleUserResponses(ExamUserResponseResultRequest $request, int $userId): void
    {
        $moduleExamId = $request->input('module_exam_id');
        $this->repository->deleteUserResponses($moduleExamId, $userId);

        $dtos = [];
        foreach ($request->input('question_id') as $questionId) {
            $answer = $request->input('answer')[$questionId] ?? null;

            if (is_array($answer)) {
                foreach ($answer as $moduleExamAnswerId) {
                    $dtos[] = new ModuleExamUserResponseDTO($questionId, $userId, $moduleExamAnswerId, '', $moduleExamId);
                }
            } elseif (is_numeric($answer)) {
                $dtos[] = new ModuleExamUserResponseDTO($questionId, $userId, (int) $answer, '', $moduleExamId);
            } elseif (is_string($answer)) {
                $dtos[] = new ModuleExamUserResponseDTO($questionId, $userId, null, $answer, $moduleExamId);
            }
        }

        foreach ($dtos as $dto) {
            $this->repository->createResponse($dto->toArray());
        }
    }

}
