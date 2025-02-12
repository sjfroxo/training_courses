<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Revalto\Seeder\Services\DatabaseSeederService;


class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        app(DatabaseSeederService::class)->run();
    }
}
