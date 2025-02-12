<?php

namespace Revalto\ServiceRepository\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\File;

class InitCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'service-repository:init';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        $modelsPath = app_path('Models');
        $modelFiles = File::allFiles($modelsPath);

        foreach ($modelFiles as $modelFile) {
            try {
                $this->call('create:repository', [
                    'name' => $modelFile->getFilenameWithoutExtension() . 'Repository',
                    '--interface' => null,
                    '--model' => null,
                    '--service' => null,
                ]);
            } catch (\Exception $e) {
                $this->error($e->getMessage());
            }
        }

        return self::SUCCESS;
    }
}
