<?php

namespace Revalto\ServiceRepository\Console\Commands;

use Illuminate\Console\GeneratorCommand;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Nette\PhpGenerator\ClassType;
use Nette\PhpGenerator\InterfaceType;
use Nette\PhpGenerator\Method;
use Nette\PhpGenerator\PhpFile;
use Nette\PhpGenerator\PhpNamespace;
use Nette\PhpGenerator\Printer;
use Revalto\ServiceRepository\Repository;
use Revalto\ServiceRepository\RepositoryInterface;
use Symfony\Component\Console\Input\InputOption;

class RepositoryInterfaceMakeCommand extends AbstractMakeCommand
{
    /**
     * The console command name.
     *
     * @var string
     */
    protected $name = 'create:repository-interface';

    /**
     * The name of the console command.
     *
     * This name is used to identify the command during lazy loading.
     *
     * @var string|null
     *
     * @deprecated
     */
    protected static $defaultName = 'create:repository-interface';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * @var string The path to the generated repository interface.
     */
    protected string $path = 'app/Repositories/Interfaces/';

    /**
     * @var array
     */
    protected array $excludeMethods = [
        '__construct',
        '__call',
        '__callStatic',
        '__get',
        '__set',
        '__isset',
        '__unset',
        '__sleep',
        '__wakeup',
        '__toString',
        '__invoke',
        '__set_state',
        '__clone',
        '__debugInfo',
        '__destruct',
    ];

    /**
     * @var array
     */
    protected array $useClass = [];

    /**
     * @var array
     */
    protected array $methods = [];

    /**
     * @return void
     * @throws \ReflectionException
     */
    public function createFile(): void
    {
        $file = new PhpFile();

        if($this->hasOption('repository') && $this->option('repository') !== null) {
            $this->getMethods($this->option('repository'));
        }

        $namespace = $this->createNamespace($file);
        $class = $this->createClass($namespace);

        if(!empty($this->methods)) {
            $this->createMethods($class);
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
            ->addNamespace('App\Repositories\Interfaces');

        if(null !== ($interface = config('servicerepository.repository_interface'))) {
            $namespace->addUse($interface);
        }

        foreach ($this->useClass as $useClass) {
            $namespace->addUse($useClass);
        }

        return $namespace;
    }

    /**
     * @param PhpNamespace $namespace
     * @return InterfaceType
     */
    private function createClass(PhpNamespace $namespace): InterfaceType
    {
        return $namespace
            ->addInterface($this->getNameInput())
            ->setExtends('AbstractRepositoryInterface');
    }

    /**
     * @param InterfaceType $interface
     * @return void
     */
    private function createMethods(InterfaceType &$interface)
    {
        foreach ($this->methods as $method) {
            $newMethod = $interface->addMethod($method['name'])
                ->setPublic()
                ->setReturnType($method['returnType']);

            foreach ($method['parameters'] as $parameter) {
                $newMethod->addComment(
                    !empty($parameter['type'])
                        ? '@param ' . $parameter['type'] . ' $' . $parameter['name']
                        : '@param $' . $parameter['name']
                );

                $newMethod->addParameter($parameter['name'])
                    ->setType($parameter['type']);
            }

            $newMethod->addComment('@return ' . ($method['returnType'] ?? 'mixed'));
        }
    }

    /**
     * @param string $className
     * @return void
     * @throws \ReflectionException
     */
    private function getMethods(string $className): void
    {
        $class = new \ReflectionClass($className);

        foreach ($class->getMethods() as $method) {
            if ($method->isPublic() && !$method->isStatic() && $method->class === $class->getName()
                && !in_array($method->getName(), $this->excludeMethods)) {
                $thisMethod = [
                    'name' => $method->getName(),
                    'parameters' => [],
                    'returnType' => null,
                ];

                if(null !== $method->getReturnType()) {
                    $className = Str::of($method->getReturnType())->classBasename();

                    if((string)$className === $method->getReturnType()->getName()) {
                        $thisMethod['returnType'] = $method->getReturnType()->getName();
                    } else {
                        $this->addInterfaceUseClass($method->getReturnType()->getName());

                        $thisMethod['returnType'] = $className;
                    }
                }

                foreach ($method->getParameters() as $parameter) {
                    $className = Str::of($parameter->getType())->classBasename();

                    $thisMethod['parameters'][] = [
                        'name' => $parameter->getName(),
                        'type' => (string)$className === $parameter->getType()
                            ? $parameter->getType()
                            : $className,
                    ];
                }

                $this->methods[] = $thisMethod;
            }
        }
    }

    /**
     * @param array $fillable
     * @return void
     */
    private function addInterfaceMethod(array $fillable): void
    {
        $this->methods[] = $fillable;
    }

    /**
     * @param string $class
     * @return void
     */
    private function addInterfaceUseClass(string $class): void
    {
        if(in_array($class, $this->useClass)) {
            return;
        }

        $this->useClass[] = $class;
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
