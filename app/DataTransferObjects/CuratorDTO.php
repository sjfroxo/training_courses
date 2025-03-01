<?php

namespace App\DataTransferObjects;

use App\Contracts\ModelDTO;

class CuratorDTO implements ModelDTO
{
    public function __construct(
        public readonly array $curator_id,
    ) {}

    public function toArray(): array
    {
        return [
            'curator_id' => $this->curator_id,
        ];
    }
}
