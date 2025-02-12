<?php

namespace Revalto\ServiceRepository\Console\Commands;

use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Symfony\Component\Console\Input\InputOption;

class ServiceMakeCommand extends AbstractMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:service';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'create:service';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string The path to the generated repository.
     */
    protected string $path = 'app/Services/';

    /**
     * @return void
     */
    public function createFile(): void
    {
        $file = new PhpFile();

        $namespace = $this->createNamespace($file);
        $class = $this->createClass($namespace);
        $method = $this->createMethod($class);

        if($this->hasOption('repository') && $this->option('repository') !== null) {
            $this->setRepositoryInConstructor($method, $namespace);
        }

        $printer = new Printer();
        $printer->setTypeResolving(false);

        File::put(
            base_path($this->path . $this->getNameInput() . '.php'),
            "<?php" . PHP_EOL . PHP_EOL . $printer->printNamespace($namespace)
        );
    }

    /**
     * @param PhpFile $file
     * @return PhpNamespace
     */
    private function createNamespace(PhpFile $file): PhpNamespace
    {
        $namespace = $file
            ->addNamespace('App\Services');

        if (null !== ($repository = config('servicerepository.service'))) {
            $namespace->addUse($repository, 'Service');
        }

        return $namespace;
    }

    /**
     * @param PhpNamespace $namespace
     * @return ClassType
     */
    private function createClass(PhpNamespace $namespace): ClassType
    {
        return $namespace
            ->addClass($this->getNameInput())
            ->setExtends('Service');
    }

    /**
     * @param ClassType $class
     * @return Method
     */
    private function createMethod(ClassType $class): Method
    {
        return $class->addMethod('__construct')
            ->setPublic()
            ->addComment('@return void');
    }

    /**
     * @param Method $method
     * @param PhpNamespace $namespace
     * @return void
     */
    private function setRepositoryInConstructor(Method $method, PhpNamespace $namespace): void
    {
        $namespace
            ->addUse(
                Str::endsWith($this->option('repository'), 'Interface')
                    ? 'App\\Repositories\\Interfaces\\' . $this->option('repository')
                    : 'App\\Repositories\\' . $this->option('repository')
            );

        $method
            ->addParameter('repository')
            ->setType($this->option('repository'));

        $method->setBody('parent::__construct($repository);');

        $method
            ->setComment('@param ' . $this->option('repository') . ' $repository')
            ->addComment('@return void');
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['repository', 'r', InputOption::VALUE_REQUIRED, 'The repository name'],
        ];
    }
}
