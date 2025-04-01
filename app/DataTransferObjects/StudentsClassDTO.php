<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class StudentsClassDTO implements ModelDTO
{
    /**
     * @param string $name
     * @param int $course_id
     * @param int $curator_id
     * @param array $student_ids
     */
    public function __construct(
        public readonly string $name,
        public readonly int $course_id,
        public readonly int $curator_id,
        public readonly array $student_ids,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'course_id' => $this->course_id,
            'curator_id' => $this->curator_id,
            'student_ids' => $this->student_ids,
        ];
    }
}
