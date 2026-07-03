<?php

use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Frontend\SitemapController;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [FrontendPostController::class, 'index'])->name('frontend.posts.index');
Route::get('/news/{slug}', [FrontendPostController::class, 'show'])->name('frontend.posts.show');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('frontend.categories.show');
Route::get('/about', [PageController::class, 'about'])->name('frontend.about');
Route::get('/contact', [PageController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('frontend.contact.store');
Route::get('/gallery', [PageController::class, 'gallery'])->name('frontend.gallery');

// New Routes
Route::get('/announcements', [PageController::class, 'announcements'])->name('frontend.announcements.index');
Route::get('/announcements/{slug}', [PageController::class, 'announcementShow'])->name('frontend.announcements.show');
Route::get('/agendas', [PageController::class, 'agendas'])->name('frontend.agendas.index');
Route::get('/agendas/{slug}', [PageController::class, 'agendaShow'])->name('frontend.agendas.show');
Route::get('/achievements', [PageController::class, 'achievements'])->name('frontend.achievements.index');
Route::get('/achievements/{slug}', [PageController::class, 'achievementShow'])->name('frontend.achievements.show');
Route::get('/videos', [PageController::class, 'videos'])->name('frontend.videos.index');
Route::get('/videos/{slug}', [PageController::class, 'videoShow'])->name('frontend.videos.show');
Route::get('/documents', [PageController::class, 'documents'])->name('frontend.documents.index');
Route::get('/documents/{document}/download', [PageController::class, 'documentDownload'])->name('frontend.documents.download');
Route::get('/search', [PageController::class, 'search'])->name('frontend.search');

/*
|--------------------------------------------------------------------------
| Auth Routes
|--------------------------------------------------------------------------
*/

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/

Route::middleware(['auth', 'verified', 'active'])->prefix('admin')->name('admin.')->group(function () {

    // Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');

    // Content
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('agendas', AgendaController::class);
    Route::resource('achievements', AchievementController::class);

    // Comments
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // Media
    Route::resource('galleries', GalleryController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('documents', DocumentController::class);

    // Website
    Route::resource('hero-sliders', HeroSliderController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('organizations', OrganizationController::class);

    // Contacts
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // Administration (Super Admin only)
    Route::middleware(['role:super-admin'])->group(function () {
        Route::resource('users', UserController::class);
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});

Route::get('/debug-paths', function() {
    return response()->json([
        'admin_path' => resource_path('views/admin/components'),
        'admin_realpath' => realpath(resource_path('views/admin/components')),
        'admin_exists' => file_exists(resource_path('views/admin/components')),
        'admin_files' => file_exists(resource_path('views/admin/components')) 
            ? scandir(resource_path('views/admin/components')) 
            : 'NOT FOUND',
        'frontend_path' => resource_path('views/frontend'),
        'frontend_realpath' => realpath(resource_path('views/frontend')),
    ]);
});

// Sitemap
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

// Redirect /dashboard to /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

require __DIR__.'/auth.php';
