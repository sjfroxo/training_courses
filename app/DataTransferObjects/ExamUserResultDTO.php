<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class ExamUserResultDTO implements ModelDTO
{
    /**
     * @param string $user_id
     * @param string $module_exam_id
     * @param string $mark
     */
    public function __construct(
        public readonly string $user_id,
        public readonly string $module_exam_id,
        public readonly string $mark,
    ) {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'module_exam_id' => $this->module_exam_id,
            'mark' => $this->mark,
        ];
    }
}
