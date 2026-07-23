<?php

namespace App\Providers;

use App\Repositories\EvaluationRepository;
use App\Repositories\FeedbackRepository;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->singleton(EvaluationRepository::class);
        $this->app->singleton(FeedbackRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
