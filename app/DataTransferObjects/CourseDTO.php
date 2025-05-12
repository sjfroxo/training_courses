<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\CourseRequest;

readonly class CourseDTO implements ModelDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string $image_url
     */
    public function __construct(
        public string $title,
        public string $description,
        public string $image_url
    ) {}

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'title' => $this->title,
            'description' => $this->description,
            'image_url' => $this->image_url
        ];
    }
}
