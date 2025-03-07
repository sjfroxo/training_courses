<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ModuleRequest;

class ModuleDTO implements ModelDTO
{
    /**
     * @param string $course_id
     * @param string $title
     * @param string $content
     */
    public function __construct(
        public readonly string $title,
        public readonly string $course_id,
        public readonly string $content,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'course_id' => $this->course_id,
            'content' => $this->content,
        ];
    }
}
