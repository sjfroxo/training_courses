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

class RepositoryMakeCommand extends AbstractMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:repository';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'create:repository';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string The path to the generated repository.
     */
    protected string $path = 'app/Repositories/';

    /**
     * @return void
     */
    public function createFile(): void
    {
        $file = new PhpFile();

        $namespace = $this->createNamespace($file);
        $class = $this->createClass($namespace);
        $method = $this->createMethod($class);

        if ($this->hasOption('model')) {
            $this->setModelInConstructor($method, $namespace);
        }

        if($this->hasOption('service') && $this->option('service') === true) {
            $this->call('create:service', [
                'name' => Str::replace('Repository', 'Service', $this->getNameInput()),
                '--repository' => $this->getNameInput() . 'Interface'
            ]);
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
            ->addNamespace('App\Repositories');

        if (null !== ($repository = config('servicerepository.repository'))) {
            $namespace->addUse($repository, 'Repository');
        }

        if($this->hasOption('interface') && $this->option('interface') === true) {
            $this->call('create:repository-interface', [
                'name' => $this->getNameInput() . 'Interface'
            ]);

            $namespace->addUse('App\\Repositories\\Interfaces\\' . $this->getNameInput() . 'Interface', 'RepositoryInterface');
        }

        return $namespace;
    }

    /**
     * @param PhpNamespace $namespace
     * @return ClassType
     */
    private function createClass(PhpNamespace $namespace): ClassType
    {
        $class = $namespace
            ->addClass($this->getNameInput())
            ->setExtends('Repository');

        if($this->hasOption('interface') && $this->option('interface') === true) {
            $class->setImplements(['RepositoryInterface']);
        }

        return $class;
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
    private function setModelInConstructor(Method $method, PhpNamespace $namespace): void
    {
        $modelName = empty($this->option('model'))
            ? Str::replace('Repository', '', $this->getNameInput())
            : $this->option('model');

        $namespace
            ->addUse('App\\Models\\' . $modelName);

        $method
            ->addParameter('model')
            ->setType($modelName);

        $method->setBody('parent::__construct($model);');

        $method
            ->setComment('@param ' . $modelName . ' $model')
            ->addComment('@return void');
    }

    /**
     * @return array
     */
    protected function getOptions(): array
    {
        return [
            ['model', 'm', InputOption::VALUE_OPTIONAL, 'The model name'],
            ['interface', 'i', InputOption::VALUE_NONE, 'Create a repository interface'],
            ['service', 's', InputOption::VALUE_NONE, 'Create a service']
        ];
    }
}
