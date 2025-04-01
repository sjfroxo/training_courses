<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class UserRoleDTO implements ModelDTO
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
            'title' => $this->title,
        ];
    }
}
