<?php

namespace App\Observers;

use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class PostObserver
{
    public function created(Post $post): void
    {
        $this->clearCache();
    }

    public function updated(Post $post): void
    {
        $this->clearCache();
    }

    public function deleted(Post $post): void
    {
        $this->clearCache();
    }

    public function restored(Post $post): void
    {
        $this->clearCache();
    }

    public function forceDeleted(Post $post): void
    {
        $this->clearCache();
    }

    private function clearCache(): void
    {
        // Clear dashboard cache
        Cache::forget('dashboard_stats');
        
        // Clear frontend cache (jika ada)
        Cache::forget('home_data');
        Cache::forget('frontend_posts');
    }
}