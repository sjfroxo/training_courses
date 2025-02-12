<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\ModuleComment;
use App\Models\ModuleExamUserResponse;
use App\Policies\CoursePolicy;
use App\Policies\ModuleCommentPolicy;
use App\Policies\ModuleExamUserResponsePolicy;
use Illuminate\Support\ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{


    protected $policies = [
        Course::class => CoursePolicy::class,
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
