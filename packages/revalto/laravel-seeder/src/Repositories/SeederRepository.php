<?php

namespace Revalto\Seeder\Repositories;

use Illuminate\Support\Facades\DB;
use Revalto\Seeder\Repositories\Interfaces\SeederRepositoryInterface;

class SeederRepository implements SeederRepositoryInterface
{
    /**
     * @return array
     */
    public function getRan(): array
    {
        return DB::table('seeders')
            ->orderBy('created_at')
            ->pluck('title')
            ->all();
    }

    /**
     * @param array $fillable
     * @return bool|void
     */
    public function create(array $fillable)
    {
        return DB::table('seeders')
            ->insert($fillable);
    }
}
