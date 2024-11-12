<?php

namespace App\Providers;

use App\Service\CoinGeckoService;
use Illuminate\Support\ServiceProvider;
use Laravel\Passport\Passport;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->app->singleton(CoinGeckoService::class, function ($app) {
            return new CoinGeckoService();
        });
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Passport::enablePasswordGrant();
    }
}
