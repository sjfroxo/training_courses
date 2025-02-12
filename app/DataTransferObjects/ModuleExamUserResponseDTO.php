<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ModuleExamUserResponseRequest;
use App\Services\ModuleExamQuestionService;

class ModuleExamUserResponseDTO implements ModelDTO
{
    /**
     * @param string $module_exam_question_id ,
     * @param string $user_id ,
     * @param string|null $module_exam_answer_id ,
     * @param string|null $text ,
     */
    public function __construct(
        public readonly string $module_exam_question_id,
        public readonly string $user_id,
        public readonly ?string $module_exam_answer_id,
        public readonly ?string $text,
        public readonly ?string $module_exam_id,
    )
    {
    }

    /**
     * @param ModuleExamUserResponseRequest $request
     * @param ModuleExamQuestionService $moduleExamQuestionService
     * @return array
     */
    public static function appRequest(ModuleExamUserResponseRequest $request, ModuleExamQuestionService $moduleExamQuestionService): array
    {
        $user_id = auth()->id();
        $dtos = [];

        foreach ($request->input('question_id') as $question_id) {
            $answer = $request->input('answer.' . $question_id) ?? null;
            $question = $moduleExamQuestionService->findById($question_id);

            switch ($question->questionType->id) {
                case 3:
                    if (is_numeric($answer)) {
                        $dtos[] = new self($question_id, $user_id, $answer, null, $question->module_exam_id);
                    }
                    break;
                case 2:
                    if (is_array($answer)) {
                        foreach ($answer as $answer_id) {
                            $dtos[] = new self($question_id, $user_id, $answer_id, null, $question->module_exam_id);
                        }
                    }
                    break;
                default:
                    $dtos[] = new self($question_id, $user_id, null, $answer, $question->module_exam_id);
                    break;
            }
        }

        return $dtos;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'module_exam_question_id' => $this->module_exam_question_id,
            'user_id' => $this->user_id,
            'module_exam_answer_id' => $this->module_exam_answer_id,
            'text' => $this->text,
            'module_exam_id' => $this->module_exam_id,
        ];
    }
}
