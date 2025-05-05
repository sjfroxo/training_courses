<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class TaskDTO implements ModelDTO
{
    public function __construct(
        public readonly string $name,
        public readonly string $desciption,
        public readonly string $deadline,
        public readonly int|null $courseId
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        $arr = [
            'name' => $this->name,
            'description' => $this->desciption,
            'deadline' => $this->deadline,
        ];

        if ($this->courseId) {
            $arr['course_id'] = $this->courseId;
        }

        return $arr;
    }
}
