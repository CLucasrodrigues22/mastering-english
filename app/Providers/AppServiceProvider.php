<?php

namespace App\Providers;

use App\Repositories\Auth\AuthEloquentORM;
use App\Repositories\Auth\AuthRepositoryInterface;
use App\Repositories\Listing\ListingEloquentORM;
use App\Repositories\Listing\ListingRepositoryInterface;
use App\Repositories\Profile\ProfileEloquentORM;
use App\Repositories\Profile\ProfileRepositoryInterface;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(AuthRepositoryInterface::class, AuthEloquentORM::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileEloquentORM::class);
        $this->app->bind(ListingRepositoryInterface::class, ListingEloquentORM::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
