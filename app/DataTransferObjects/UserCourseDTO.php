<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\AuthRequest;
use App\Http\Requests\UserCourseRequest;

class UserCourseDTO implements ModelDTO
{
    /**
     * @param string $user_id
     * @param string $course_id
     * @param string $progress
     */
    public function __construct(
        public readonly string $user_id,
        public readonly string $course_id,
        public readonly string $progress,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'user_id' => $this->user_id,
            'course_id' => $this->course_id,
            'progress' => $this->progress,
        ];
    }
}
