<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class StudentsClassDTO implements ModelDTO
{
    /**
     * @param string $name
     * @param string $course_id
     * @param string $user_id
     */
    public function __construct(
        public readonly string $name,
        public readonly string $course_id,
        public readonly string $user_id,
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'course_id' => $this->course_id,
            'user_id' => $this->user_id,
        ];
    }
}
