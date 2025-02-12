<?php

namespace Revalto\ServiceRepository\Providers;

use Illuminate\Support\ServiceProvider;
use Revalto\ServiceRepository\Console\Commands\InitCommand;
use Revalto\ServiceRepository\Console\Commands\RepositoryInterfaceMakeCommand;
use Revalto\ServiceRepository\Console\Commands\RepositoryMakeCommand;
use Revalto\ServiceRepository\Console\Commands\ServiceMakeCommand;

class ServiceRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->mergeConfigFrom(
            __DIR__ . '/../../config/servicerepository.php', 'servicerepository'
        );

        $this->publishes([
            __DIR__ . '/../../config/servicerepository.php' => config_path('servicerepository.php')
        ]);

        $this->registerCommand();
    }

    /**
     * @return void
     */
    private function registerCommand(): void
    {
        if ($this->app->runningInConsole()) {
            $this->commands([
                RepositoryMakeCommand::class,
                RepositoryInterfaceMakeCommand::class,
                ServiceMakeCommand::class,
                InitCommand::class
            ]);
        }
    }
}
