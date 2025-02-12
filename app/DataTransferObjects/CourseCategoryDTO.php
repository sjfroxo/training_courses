<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\CategoryRequest;
use App\Http\Requests\CourseCategoryRequest;

class CourseCategoryDTO implements ModelDTO
{
    /**
     * @param string $category_id
     * @param string $course_id
     */
    public function __construct(
        public readonly string $category_id,
        public readonly string $course_id,
    )
    {
    }

    /**
     * @param CategoryRequest $request
     * @return CourseCategoryDTO
     */
    public static function appRequest(CourseCategoryRequest $request): CourseCategoryDTO
    {
        return new CourseCategoryDTO(
            $request['category_id'],
            $request['course_id'],
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'category_id' => $this->category_id,
            'course_id' => $this->course_id,
        ];
    }
}
