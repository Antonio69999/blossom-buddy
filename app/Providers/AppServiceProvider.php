<?php

namespace App\Providers;

use App\Interfaces\PlantInterface;
use App\Interfaces\PlantRepositoryInterface;
use App\Repositories\PlantRepository;
use App\Interfaces\UserRepositoryInterface;
use App\Repositories\UserRepository;
use App\Interfaces\UserPlantRepositoryInterface;
use App\Repositories\UserPlantRepository;
use App\Interfaces\UserPlantInterface;
use App\Services\UserPlantService;
use App\Services\PlantService;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(PlantRepositoryInterface::class, PlantRepository::class);
        $this->app->bind(UserPlantRepositoryInterface::class, UserPlantRepository::class);
        $this->app->bind(UserPlantInterface::class, UserPlantService::class);
        $this->app->bind(PlantInterface::class, PlantService::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
