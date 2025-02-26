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
     * @param int $user_role_id
     */
    public function __construct(
        public readonly string $name,
        public readonly int $course_id,
        public readonly int $curator_id,
        public readonly array $student_ids,
        public readonly int $user_role_id,
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
            'user_role_id' => $this->user_role_id,
        ];
    }
}
