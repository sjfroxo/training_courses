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
        public readonly string $course_id,
        public readonly string $title,
        public readonly string $content,
    )
    {
    }

    /**
     * @param ModuleRequest $request
     * @return ModuleDTO
     */
    public static function appRequest(ModuleRequest $request): ModuleDTO
    {
        return new ModuleDTO(
            $request['course_id'],
            $request['title'],
            $request['content'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'course_id' => $this->course_id,
            'title' => $this->title,
            'content' => $this->content,
        ];
    }
}
