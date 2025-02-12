<?php

namespace Revalto\ServiceRepository\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Str;

abstract class AbstractMakeCommand extends GeneratorCommand
{
    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle(): int
    {
        if ($this->alreadyExists($this->getNameInput())) {
            $this->error($this->getNameInput() . ' already exists!');

            return false;
        }

        if (!$this->files->exists($this->laravel->basePath($this->path))) {
            $this->makeDirectory($this->getPath($this->getNameInput()));
        }

        $this->createFile();

        $this->info($this->getNameInput() . ' created successfully.');

        return self::SUCCESS;
    }

    /**
     * @return void
     */
    abstract public function createFile(): void;

    /**
     * Get the destination class path.
     *
     * @param string $name
     * @return string
     */
    protected function getPath($name): string
    {
        $name = str_replace('\\', '/', Str::replaceFirst($this->rootNamespace(), '', $name));

        if (is_dir($this->laravel->basePath($this->path))) {
            return $this->laravel->basePath($this->path . $name . '.php');
        }

        return $this->laravel->basePath($this->path . $name . '.php');
    }

    /**
     * @return string|void
     */
    protected function getStub()
    {
        // TODO: Implement getStub() method.
    }
}
