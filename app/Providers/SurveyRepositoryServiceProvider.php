<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Repositories\SurveyRepository;

class SurveyRepositoryServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        app()->bind(SurveyRepository::class, function()
        {
            return new SurveyRepository;
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
