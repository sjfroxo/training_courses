<?php

namespace Revalto\Seeder\Repositories\Interfaces;

interface SeederRepositoryInterface
{
    /**
     * @return array
     */
    public function getRan(): array;

    /**
     * @param array $fillable
     * @return bool|void
     */
    public function create(array $fillable);
}
