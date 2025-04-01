<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;
use App\Http\Requests\ChatRequest;

class ChatDTO implements ModelDTO
{
    /**
     * @param string $title
     */
    public function __construct(
        public readonly string $title,
    )
    {
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'name' => $this->title,
        ];
    }
}
