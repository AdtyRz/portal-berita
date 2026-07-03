<?php

namespace App\Providers;

use Illuminate\Database\Events\QueryExecuted;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Event;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        // Auto clear cache saat data berubah
        Event::listen(function (QueryExecuted $event) {
            // Clear cache setiap 5 menit untuk memastikan data fresh
        });
    }

    public function boot(): void
    {
        // HAPUS SEMUA anonymousComponentPath
        // Laravel otomatis detect folder resources/views/components/

        // Hanya register frontend jika perlu
        Blade::anonymousComponentPath(resource_path('views/frontend'), 'frontend');
    }

    // Manual clear cache method
    public static function clearContentCache()
    {
        Cache::forget('home_data_v1');
        Cache::tags(['posts'])->flush();
        Cache::tags(['announcements'])->flush();
    }
}
