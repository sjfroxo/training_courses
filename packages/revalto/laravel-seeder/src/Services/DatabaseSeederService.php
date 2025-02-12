<?php

namespace Revalto\Seeder\Services;

use Exception;
use Illuminate\Contracts\Filesystem\FileNotFoundException;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Collection;
use Revalto\Seeder\Repositories\Interfaces\SeederRepositoryInterface;

class DatabaseSeederService
{
    /**
     * @param Filesystem $files
     * @param SeederRepositoryInterface $repository
     */
    public function __construct(
        protected Filesystem                $files,
        protected SeederRepositoryInterface $repository
    ) {}

    /**
     * @return void
     * @throws FileNotFoundException
     */
    public function run(): void
    {
        $files = $this->getSeederFiles();

        $this->requireFiles($seeder = $this->pendingSeeders(
            $files, $this->repository->getRan()
        ));

        foreach ($seeder as $class) {
            try {
                $seed = $this->files->getRequire($class);

                if (is_object($seed)) {
                    $seed->run();

                    $this->repository->create([
                        'title' => $this->files->name($class)
                    ]);
                }
            } catch (Exception $e) {
                dd($e);
            }
        }
    }

    /**
     * @return array
     */
    protected function getSeederFiles(): array
    {
        return collect($this->files->glob(
            database_path('seeders/CustomSeeder/*.php')
        ))
            ->filter()
            ->values()
            ->keyBy(fn($path) => $this->files->name($path))
            ->all();
    }

    /**
     * Get the migration files that have not yet run.
     *
     * @param array $files
     * @param array $ran
     * @return array
     */
    protected function pendingSeeders(array $files, array $ran): array
    {
        return Collection::make($files)
            ->reject(fn ($file) => in_array($this->files->name($file), $ran))
            ->values()
            ->all();
    }

    /**
     * Require in all the migration files in a given path.
     *
     * @param array $files
     * @return void
     * @throws FileNotFoundException
     */
    protected function requireFiles(array $files)
    {
        foreach ($files as $file) {
            $this->files->requireOnce($file);
        }

    }
}
