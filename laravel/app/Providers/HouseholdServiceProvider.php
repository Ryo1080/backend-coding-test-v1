<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Packages\Domain\Household\HouseholdRepositoryInterface;
use Packages\Infrastructure\HouseholdRepository;

class HouseholdServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(
            HouseholdRepositoryInterface::class,
            HouseholdRepository::class
        );
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
