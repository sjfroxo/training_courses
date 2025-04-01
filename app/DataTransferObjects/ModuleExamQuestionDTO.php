<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ModuleExamQuestionRequest;

class ModuleExamQuestionDTO implements ModelDTO
{
    /**
     * @param string $text
     * @param string $module_exam_id
     * @param string $question_type_id
     */
    public function __construct(
        public readonly string $text,
        public readonly string $module_exam_id,
        public readonly string $question_type_id,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'text' => $this->text,
            'module_exam_id' => $this->module_exam_id,
            'question_type_id' => $this->question_type_id,
        ];
    }
}
