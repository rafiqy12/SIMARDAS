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
        // Register DNS1D facade for barcode generation
        if (!class_exists('DNS1D')) {
            class_alias('Milon\\Barcode\\Facades\\DNS1DFacade', 'DNS1D');
        }
    }
}
