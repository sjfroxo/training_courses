<?php

namespace Revalto\Seeder\Providers;

use Illuminate\Support\ServiceProvider;
use Revalto\Seeder\Commands\CreateSeederCommand;
use Revalto\Seeder\Repositories\Interfaces\SeederRepositoryInterface;
use Revalto\Seeder\Repositories\SeederRepository;

class SeederServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(): void
    {
        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../Migrations/2022_11_15_113237_create_seeder_table.php'
                    => database_path('migrations/' . now()->format('Y_m_d_His') . '_create_seeder_table.php')
            ], 'migrations');

            $this->commands([
                CreateSeederCommand::class
            ]);
        }
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->bind(SeederRepositoryInterface::class, SeederRepository::class);
    }
}
