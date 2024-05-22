<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Services\SurveyService;

class SurveyServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(SurveyService::class, function()
        {
            return new SurveyService;
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
