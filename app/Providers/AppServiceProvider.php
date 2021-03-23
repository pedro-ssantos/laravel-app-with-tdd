<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Observers\TravelObserver;
use App\Observers\TaskObserver;
use App\Travel;
use App\Task;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        Travel::observe(TravelObserver::class);
        Task::observe(TaskObserver::class);
    }
}
