<?php

namespace App\Providers;

use App\Http\Controllers\Admin\NotificationController;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use App\Models\SchoolProfile;
use App\Observers\CommentObserver;
use App\Observers\ContactObserver;
use App\Observers\PostObserver;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        //
    }

    public function boot(): void
    {
        // Register admin components
        Blade::anonymousComponentPath(resource_path('views/components/admin'), 'admin');

        // Register frontend components
        Blade::anonymousComponentPath(resource_path('views/frontend'), 'frontend');

        // Register observers
        Post::observe(PostObserver::class);
        Comment::observe(CommentObserver::class);
        Contact::observe(ContactObserver::class);

        // Fix string length for MySQL (optional)
        Schema::defaultStringLength(191);

        View::composer('*', function ($view) {
            $view->with('schoolProfile', SchoolProfile::getCurrent());
        });

        View::composer('admin.layouts.app', function ($view) {
            if (auth()->check()) {
                $notifController = new NotificationController;
                $data = $notifController->getHeaderData();
                $view->with('headerNotifications', $data['notifications']);
                $view->with('unreadNotificationCount', $data['unreadCount']);
            }
        });
    }
}
