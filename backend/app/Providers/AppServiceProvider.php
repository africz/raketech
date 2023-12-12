<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Gateways\RestCountries;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(RestCountries::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
