<?php

namespace App\Providers;

use App\Models\Course;
use App\Models\User;
use App\Repositories\Interfaces\ModuleExamQuestionRepositoryInterface;
use App\Repositories\Interfaces\ModuleExamRepositoryInterface;
use App\Repositories\Interfaces\UserRepositoryInterface;
use App\Repositories\ModuleExamQuestionRepository;
use App\Repositories\ModuleExamRepository;
use App\Repositories\UserRepository;
use App\Services\ModuleExamQuestionService;
use App\Services\UserService;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Auth\Notifications\VerifyEmail;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Pagination\Paginator;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * @var array|string[]
     */
    public array $bindings = [
        ModuleExamRepositoryInterface::class => ModuleExamRepository::class,
        UserRepositoryInterface::class => UserRepository::class,
        ModuleExamQuestionRepositoryInterface::class => ModuleExamQuestionRepository::class
    ];

    /**
     * Register any application services.
     */
    public function register(): void
    {
        foreach ($this->bindings as $key => $value) {
            $this->app->bind($key, $value);
        }

        $this->app->bind(UserService::class, function ($app){
            return new UserService($app->make(UserRepositoryInterface::class));
        });

        $this->app->bind(ModuleExamQuestionService::class, function ($app) {
            return new ModuleExamQuestionService($app->make(ModuleExamQuestionRepositoryInterface::class));
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Paginator::useBootstrapFive();
        View::composer('layouts.navigation', function ($view) { $view->with('courses', Course::all()); });

        VerifyEmail::toMailUsing(function (object $notifiable, string $url) {
            return (new MailMessage)
                ->subject('Подтверждение электронной почты.')
                ->view('auth.email', ['url' => $url]);
        });

        ResetPassword::createUrlUsing(function (User $user, string $token) {
            return url(route('password.reset', ['token' => $token], false));
        });
    }
}
