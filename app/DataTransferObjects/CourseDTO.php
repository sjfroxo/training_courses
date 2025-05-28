<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\CourseRequest;

class CourseDTO implements ModelDTO
{
    /**
     * @param string $title
     * @param string $description
     * @param string|null $image_url
     */
    public function __construct(
        public readonly string $title,
        public readonly string $description,
        public readonly ?string $image_url = null,
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
