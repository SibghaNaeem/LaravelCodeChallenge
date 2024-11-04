<?php

namespace App\Providers;

use App\Services\SessionTokenStorage;
use App\Services\TokenStorageInterface;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Schema::defaultStringLength(191);

        $this->app->bind(TokenStorageInterface::class, SessionTokenStorage::class);
    }
}
