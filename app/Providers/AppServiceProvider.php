<?php

namespace App\Providers;

use Braintree\Gateway;
use Illuminate\Pagination\Paginator;
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
        Paginator::useBootstrap();

        $this->app->singleton(Gateway::class, function ($app) {
            return new Gateway(
                [
                    'environment' => 'sandbox',
                    'merchantId' => 'ns4dzw8n78kg4yfx',
                    'publicKey' => '64zjd5f576395np2',
                    'privateKey' => '966abc0e823f87731bedc65211d65307'
                ]
            );
        });
    }
}
