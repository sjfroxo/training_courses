<p align="center"><a href="https://laravel.com" target="_blank"><img src="https://raw.githubusercontent.com/laravel/art/master/logo-lockup/5%20SVG/2%20CMYK/1%20Full%20Color/laravel-logolockup-cmyk-red.svg" width="400" alt="Laravel Logo"></a></p>

<p align="center">
<a href="https://travis-ci.org/laravel/framework"><img src="https://travis-ci.org/laravel/framework.svg" alt="Build Status"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/dt/laravel/framework" alt="Total Downloads"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/v/laravel/framework" alt="Latest Stable Version"></a>
<a href="https://packagist.org/packages/laravel/framework"><img src="https://img.shields.io/packagist/l/laravel/framework" alt="License"></a>
</p>

## Install
Создаем в корне проекта папку packages/revalto и закидываем туда laravel-seeder
Добавляем в composer.json
```
"repositories": {
    "laravel-service-repository": {
        "type": "path",
        "url": "packages/revalto/laravel-seeder",
        "options": {
            "symlink": true
        }
    },
},
"require": {
    ...
    "revalto/laravel-seeder": "@dev"
},
```
Потом вызываем
```
composer update
```

## Make
Для создания Seeder
```
php artisan create:seeder TestSeeder
```

## Usage
Для запуска Seeder
```
php artisan db:seed
```
