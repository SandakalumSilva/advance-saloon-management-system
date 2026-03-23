<?php

namespace App\Providers;

use App\Interfaces\CategoryInterface;
use App\Interfaces\ProductCategoryInterface;
use App\Interfaces\ServiceCategoryInterface;
use Illuminate\Support\ServiceProvider;

use App\Models\User;
use App\Observers\UserObserver;

use App\Interfaces\UserInterface;
use App\Repositories\CategoryRepository;
use App\Repositories\ProductCategoryRepository;
use App\Repositories\ServiceCategoryRepository;
use App\Repositories\UserRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        User::observe(UserObserver::class);
        $this->app->bind(UserInterface::class, UserRepository::class);
        $this->app->bind(CategoryInterface::class, CategoryRepository::class);
        $this->app->bind(ServiceCategoryInterface::class, ServiceCategoryRepository::class);
        $this->app->bind(ProductCategoryInterface::class,ProductCategoryRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
