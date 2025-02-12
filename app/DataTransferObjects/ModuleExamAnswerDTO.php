<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ModuleExamAnswerRequest;

class ModuleExamAnswerDTO implements ModelDTO
{
    /**
     * @param string $value
     * @param string $module_exam_question_id
     * @param string $module_exam_user_response_id
     * @param string $is_correct
     * @param string $module_exam_id
     */
    public function __construct(
        public readonly string $value,
        public readonly string $module_exam_question_id,
        public readonly string $module_exam_user_response_id,
        public readonly string $is_correct,
        public readonly string $module_exam_id,
    )
    {
    }

    /**
     * @param ModuleExamAnswerRequest $request
     * @return ModuleExamAnswerDTO
     */
    public static function appRequest(ModuleExamAnswerRequest $request): ModuleExamAnswerDTO
    {
        return new ModuleExamAnswerDTO(
            $request['value'],
            $request['module_exam_question_id'],
            $request['module_exam_user_response_id'],
            $request['is_correct'],
            $request['module_exam_id'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'module_exam_question_id' => $this->module_exam_question_id,
            'module_exam_user_response_id' => $this->module_exam_user_response_id,
            'is_correct' => $this->is_correct,
            'module_exam_id' => $this->module_exam_id,
        ];
    }
}
