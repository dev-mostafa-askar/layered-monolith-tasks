<?php

namespace App\Providers;

use App\Models\Task;
use App\Models\User;
use App\Repositories\Task\Eloquent\EloquentTaskRepository;
use App\Repositories\Task\TaskRepository;
use App\Repositories\User\Eloquent\EloquentUserRepository;
use App\Repositories\User\UserRepository;
use Illuminate\Support\ServiceProvider;

class RepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->singleton(TaskRepository::class, function () {
            return new EloquentTaskRepository(new Task());
        });

        $this->app->singleton(UserRepository::class, function () {
            return new EloquentUserRepository(new User());
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}