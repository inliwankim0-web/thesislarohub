<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SAWService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(SAWService::class, fn() => new SAWService());
    }

    public function boot(): void
    {
        //
    }
}
