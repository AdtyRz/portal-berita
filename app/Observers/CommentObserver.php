<?php

namespace App\Observers;

use App\Models\Comment;
use Illuminate\Support\Facades\Cache;

class CommentObserver
{
    public function created(Comment $comment): void
    {
        Cache::forget('dashboard_stats');
    }

    public function updated(Comment $comment): void
    {
        Cache::forget('dashboard_stats');
    }

    public function deleted(Comment $comment): void
    {
        Cache::forget('dashboard_stats');
    }
}