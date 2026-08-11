<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use Illuminate\Support\Facades\Blade;

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
        // Register Blade component aliases for master layouts
        Blade::component('layouts.app', 'app-layout');
        Blade::component('layouts.admin', 'admin-layout');
        Blade::component('layouts.hrd', 'hrd-layout');
    }
}
