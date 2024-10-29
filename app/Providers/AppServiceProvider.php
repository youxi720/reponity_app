<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Pagination\Paginator;
use App\Http\Clients\CiniiApiClient;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        Paginator::useBootstrap();
        $this->app->singleton(CiniiApiClient::class, function ($app) {
            return new CiniiApiClient();
        });
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        if (app()->environment('production')) {
            \URL::forceScheme('https');
            $this->app['request']->server->set('HTTPS', 'on');
        }
    }
}