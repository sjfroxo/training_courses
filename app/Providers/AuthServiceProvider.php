<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\ModuleExamUserResponse;
use App\Models\StudentsClass;
use App\Policies\CoursePolicy;
use App\Policies\ModuleExamUserResponsePolicy;
use App\Policies\StudentsClassPolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{


    protected array $policies = [
        Course::class => CoursePolicy::class,
        StudentsClass::class => StudentsClassPolicy::class,
        ModuleExamUserResponse::class => ModuleExamUserResponsePolicy::class
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {

    }
}
