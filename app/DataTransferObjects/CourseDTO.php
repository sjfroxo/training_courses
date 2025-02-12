<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\CourseRequest;

class CourseDTO implements ModelDTO
{
    /**
     * @param string $title
     * @param string $description
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
    )
    {
    }

    /**
     * @param CourseRequest $request
     * @return CourseDTO
     */
    public static function appRequest(CourseRequest $request): CourseDTO
    {
        return new CourseDTO(
            $request['title'],
            $request['description']
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
        ];
    }
}
