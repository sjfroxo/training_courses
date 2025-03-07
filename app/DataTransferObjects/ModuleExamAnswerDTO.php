<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class ModuleExamAnswerDTO implements ModelDTO
{
    /**
     * @param string $value
     * @param string $module_exam_question_id
     * @param string $is_correct
     * @param string $module_exam_id
     */
    public function __construct(
        public readonly string $value,
        public readonly string $module_exam_question_id,
        public readonly string $is_correct,
        public readonly string $module_exam_id,
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'value' => $this->value,
            'module_exam_question_id' => $this->module_exam_question_id,
            'is_correct' => $this->is_correct,
            'module_exam_id' => $this->module_exam_id,
        ];
    }
}
