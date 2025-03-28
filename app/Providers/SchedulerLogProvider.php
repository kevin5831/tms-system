<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class SchedulerLogProvider extends ServiceProvider
{
    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        $this->app->bind('App\Facades\SchedulerLog');
    }

    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //
    }
}
