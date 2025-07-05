<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        // Register layout aliases
        $this->app['view']->addNamespace('layouts', resource_path('views/layouts'));

        // Register component aliases
        \Illuminate\Support\Facades\Blade::component('layouts.sidebar', 'sidebar-layout');
    }
}
