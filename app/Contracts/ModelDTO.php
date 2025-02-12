<?php

namespace App\Contracts;

interface ModelDTO
{
    /**
     * @return array<string, mixed>
     */
    public function toArray(): array;
}
