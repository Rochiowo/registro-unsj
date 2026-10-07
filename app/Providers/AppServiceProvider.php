<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SpeciesServiceInterface;
use App\Services\SQLSpeciesService;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //le dice a Laravel: "Cada vez que en la aplicación alguien pida el contrato 'SpeciesServiceInterface',
        //entreégale el trabajador 'SQLSpeciesService'".|
        $this->app->bind(
            SpeciesServiceInterface::class,
            SQLSpeciesService::class
        );
    }

    public function boot(): void
    {
        //
    }
}