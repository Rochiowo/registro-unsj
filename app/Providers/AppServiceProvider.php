<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Contracts\AnimalServiceInterface;
use App\Services\FileAnimalService;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Vinculamos la interfaz con la nueva implementación en JSON
        $this->app->bind(
            AnimalServiceInterface::class,
            FileAnimalService::class
        );
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}