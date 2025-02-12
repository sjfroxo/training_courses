<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install
Создаем в корне проекта папку packages/revalto и закидываем туда laravel-service-repository
Добавляем в composer.json
```
"repositories": {
    "laravel-service-repository": {
        "type": "path",
        "url": "packages/revalto/laravel-service-repository",
        "options": {
            "symlink": true
        }
    },
},
"require": {
    ...
    "revalto/laravel-service-repository": "@dev"
},
```
Потом вызываем
```
composer update
```

## Make
Для создания Repository
```
php artisan create:repository ExampleRepository -m Example -i
```

Где -m - Название модели<br>
Где -i - Создание интерфеса для репозитория

Для создания Service
```
php artisan create:service ExampleService -r ExampleRepositoryInterface
```
Где -r - Подставляется интерфес репозитория или класс репозитория

Для создания Builder
```
php artisan create:builder ExampleBuilder
```

## Change Builder in Repository
Для того, чтобы изменить конструктор запросов в репозитории, нужно его указать в своем Repository:
```
/**
 * @return string
 */
public function getBuilderClass(): string
{
    return ExampleBuilder::class;
}
```

## Examples
Service:
```
<?php

namespace App\Services;

use App\Repositories\Interfaces\UserRepositoryInterface;
use Revalto\ServiceRepository\Service;

class UserService extends Service
{
	/**
	 * @param UserRepositoryInterface $repository
	 * @return void
	 */
	public function __construct(UserRepositoryInterface $repository)
	{
		parent::__construct($repository);
	}
}
```

Repository:
```
<?php

namespace App\Repositories;

use App\Builders\UserBuilder;
use App\Models\User;
use App\Repositories\Interfaces\UserRepositoryInterface as RepositoryInterface;
use Revalto\ServiceRepository\Repository;

class UserRepository extends Repository implements RepositoryInterface
{
	/**
	 * @param User $model
	 * @return void
	 */
	public function __construct(User $model)
	{
		parent::__construct($model);
	}

    /**
     * @return string
     */
    public function getBuilderClass(): string
    {
        return UserBuilder::class;
    }
}
```

Builder:
```
<?php

namespace App\Builders;

use Revalto\ServiceRepository\Builder;

class UserBuilder extends Builder
{
    /**
     * @param string $email
     * @return \Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Query\Builder
     */
    public function email(string $email)
    {
        return $this->getQuery()
            ->where('email', '=', $email);
    }
}
```

Controller:
```
<?php

namespace App\Http\Controllers;

use App\Services\UserService;

class TestController extends Controller
{
    /**
     * @param UserService $userService
     */
    public function __construct(
        protected UserService $userService
    ) {}

    /**
     * @return void
     */
    public function index()
    {
        $response = $this->userService
            ->firstByEmail('erunte@example.com');

        dd($response);
    }
}
```

## Functions
Как вызывать функции с Builder
```
$service->firstByName(...);
$service->getByName(...);
$service->paginateByName(...);
$service->pluckByName(...);
$service->countByName(...);
$service->existsByName(...);
```

Без вызова функций с Builder:
```
$service->first(...);
$service->get(...);
$service->paginate(...);
$service->pluck(...);
$service->count(...);
$service->exists(...);
```

Создание:
```
$service->create([...]);
```

Обновление:
```
$service->update($id, [...]);
```

Так же можно создавать свои функции в Repository и Service.
