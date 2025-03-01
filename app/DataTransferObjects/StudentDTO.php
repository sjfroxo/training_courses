<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class StudentDTO implements ModelDTO
{
    public function __construct(
        public readonly array $student_ids,
    ) {}

    public function toArray(): array
    {
        return [
            'student_ids' => $this->student_ids,
        ];
    }
}
