<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\CategoryRequest;

class CategoryDTO implements ModelDTO
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
