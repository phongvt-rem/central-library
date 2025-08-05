<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\Interface\BookRepositoryInterface;
use App\Repositories\Eloquent\BookRepository;
use App\Repositories\Interface\AuthorRepositoryInterface;
use App\Repositories\Eloquent\AuthorRepository;
use App\Repositories\Interface\CategoryRepositoryInterface;
use App\Repositories\Eloquent\CategoryRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(BookRepositoryInterface::class, BookRepository::class);
        $this->app->bind(AuthorRepositoryInterface::class, AuthorRepository::class);
        $this->app->bind(CategoryRepositoryInterface::class, CategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
