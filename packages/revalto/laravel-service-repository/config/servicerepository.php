<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Abstract Repository Class
    |--------------------------------------------------------------------------
    |
    | This value is an abstract repository class. It is used when creating
    | a new repository to specify from which class it will inherit.
    |
    */

    'repository' => \Revalto\ServiceRepository\Repository\AbstractRepository::class,

    /*
    |--------------------------------------------------------------------------
    | Abstract Repository Interface Class
    |--------------------------------------------------------------------------
    |
    | This value is an abstract repository interface class. It is used when
    | creating a new repository interface to specify which interface it will inherit from.
    |
    */

    'repository_interface' => \Revalto\ServiceRepository\Repository\AbstractRepositoryInterface::class,

    /*
    |--------------------------------------------------------------------------
    | Abstract Service Class
    |--------------------------------------------------------------------------
    |
    | This value is an abstract service class. It is used when creating
    | a new service to specify which class it will inherit from.
    |
    */

    'service' => \Revalto\ServiceRepository\Service\AbstractService::class,

    /*
    |--------------------------------------------------------------------------
    | Aliases
    |--------------------------------------------------------------------------
    |
    | This value is an alias. An alias is used when creating classes
    |
    */

    'aliases' => [
        'repository' => 'Repository',
        'repository_interface' => 'RepositoryInterface',
        'service' => 'Service',
    ]
];
