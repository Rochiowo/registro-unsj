<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\AnimalServiceInterface;
use App\Services\AnimalMockService;
use App\Services\SQLAnimalsService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //le dice a Laravel: "Cada vez que en la aplicación alguien pida el contrato 'AnimalServiceInterface',
        //entreégale el trabajador 'SQLAnimalsService'".|
        $this->app->singleton(
            AnimalServiceInterface::class,
            SQLAnimalsService::class
        );
    }

    public function boot(): void
    {
        //
    }
}