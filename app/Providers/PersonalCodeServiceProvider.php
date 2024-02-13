<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\PersonalCodeService;
use Illuminate\Contracts\Foundation\Application;

class PersonalCodeServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->singleton(PersonalCodeService::class, function ($code) {
            return new PersonalCodeService($code);
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
