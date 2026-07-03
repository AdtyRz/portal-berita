<?php

namespace App\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register frontend anonymous components
        // Path: resources/views/frontend/
        // Usage: <x-frontend.layouts.app> → resources/views/frontend/layouts/app.blade.php
        Blade::anonymousComponentPath(resource_path('views/frontend'), 'frontend');
    }
}