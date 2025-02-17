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
