<?php

use App\Http\Controllers\Admin\AchievementController;
use App\Http\Controllers\Admin\ActivityLogController;
use App\Http\Controllers\Admin\AgendaController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\BannerController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\CommentController;
use App\Http\Controllers\Admin\ContactController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\GalleryController;
use App\Http\Controllers\Admin\HeroSliderController;
use App\Http\Controllers\Admin\ManageAdminController;
use App\Http\Controllers\Admin\NotificationController;
use App\Http\Controllers\Admin\OrganizationController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\VideoController;
use App\Http\Controllers\Frontend\CategoryController as FrontendCategoryController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\PageController;
use App\Http\Controllers\Frontend\PostController as FrontendPostController;
use App\Http\Controllers\Frontend\SitemapController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Frontend Routes
|--------------------------------------------------------------------------
*/
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/news', [FrontendPostController::class, 'index'])->name('frontend.posts.index');
Route::get('/news/{slug}', [FrontendPostController::class, 'show'])->name('frontend.posts.show');
Route::post('/news/{slug}/comment', [FrontendPostController::class, 'storeComment'])->name('frontend.posts.comment');
Route::get('/category/{slug}', [FrontendCategoryController::class, 'show'])->name('frontend.categories.show');

Route::get('/about', [PageController::class, 'about'])->name('frontend.about');
Route::get('/organizations/{slug}', [PageController::class, 'organizationShow'])->name('frontend.organizations.show');
Route::get('/contact', [PageController::class, 'contact'])->name('frontend.contact');
Route::post('/contact', [PageController::class, 'storeContact'])->name('frontend.contact.store');

Route::get('/gallery', [PageController::class, 'gallery'])->name('frontend.gallery');
Route::get('/gallery/{slug}', [PageController::class, 'galleryShow'])->name('frontend.gallery.show');

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
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');

/*
|--------------------------------------------------------------------------
| Auth & Profile Routes
|--------------------------------------------------------------------------
*/
Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
});

// Redirect /dashboard to /admin/dashboard
Route::get('/dashboard', function () {
    return redirect()->route('admin.dashboard');
})->middleware(['auth'])->name('dashboard');

/*
|--------------------------------------------------------------------------
| Admin Routes
|--------------------------------------------------------------------------
*/
Route::middleware(['auth', 'verified', 'active', 'admin.permission'])->prefix('admin')->name('admin.')->group(function () {

    // 1. Dashboard
    Route::get('/dashboard', [DashboardController::class, 'index'])->name('dashboard');
    Route::post('/notifications/mark-read', [\App\Http\Controllers\Admin\NotificationController::class, 'markAsRead'])->name('notifications.mark-read');

    // 2. Content Management
    Route::resource('categories', CategoryController::class);
    Route::resource('tags', TagController::class);
    Route::resource('posts', PostController::class);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('agendas', AgendaController::class);
    Route::resource('achievements', AchievementController::class);

    // 3. Comments Management
    Route::get('comments', [CommentController::class, 'index'])->name('comments.index');
    Route::get('comments/{comment}', [CommentController::class, 'show'])->name('comments.show');
    Route::post('comments/{comment}/approve', [CommentController::class, 'approve'])->name('comments.approve');
    Route::delete('comments/{comment}', [CommentController::class, 'destroy'])->name('comments.destroy');

    // 4. Media Management
    Route::resource('galleries', GalleryController::class);
    Route::resource('videos', VideoController::class);
    Route::resource('documents', DocumentController::class);

    // 5. Website Management
    Route::resource('hero-sliders', HeroSliderController::class);
    Route::resource('banners', BannerController::class);
    Route::resource('organizations', OrganizationController::class);

    // Organization Galleries (Nested Routes)
    Route::get('organizations/{organization}/gallery', [OrganizationController::class, 'galleryIndex'])->name('organizations.gallery.index');
    Route::get('organizations/{organization}/gallery/create', [OrganizationController::class, 'galleryCreate'])->name('organizations.gallery.create');
    Route::post('organizations/{organization}/gallery', [OrganizationController::class, 'galleryStore'])->name('organizations.gallery.store');
    Route::get('organizations/{organization}/gallery/{gallery}/edit', [OrganizationController::class, 'galleryEdit'])->name('organizations.gallery.edit');
    Route::put('organizations/{organization}/gallery/{gallery}', [OrganizationController::class, 'galleryUpdate'])->name('organizations.gallery.update');
    Route::delete('organizations/{organization}/gallery/{gallery}', [OrganizationController::class, 'galleryDestroy'])->name('organizations.gallery.destroy');

    // 6. Contacts Management
    Route::get('contacts', [ContactController::class, 'index'])->name('contacts.index');
    Route::get('contacts/{contact}', [ContactController::class, 'show'])->name('contacts.show');
    Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

    // 7. Super Admin Only Routes (Poin 15)
    Route::middleware(['role:super-admin'])->group(function () {
        Route::resource('users', UserController::class);

        // Manage Admins & Permissions
        Route::get('manage-admins', [ManageAdminController::class, 'index'])->name('manage-admins.index');
        Route::get('manage-admins/create', [ManageAdminController::class, 'create'])->name('manage-admins.create');
        Route::post('manage-admins', [ManageAdminController::class, 'store'])->name('manage-admins.store');
        Route::get('manage-admins/{user}/edit', [ManageAdminController::class, 'edit'])->name('manage-admins.edit');
        Route::put('manage-admins/{user}', [ManageAdminController::class, 'update'])->name('manage-admins.update');
        Route::delete('manage-admins/{user}', [ManageAdminController::class, 'destroy'])->name('manage-admins.destroy');

        // Settings & Logs
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::put('settings', [SettingController::class, 'update'])->name('settings.update');
        Route::get('activity-logs', [ActivityLogController::class, 'index'])->name('activity-logs.index');
    });
});

/*
|--------------------------------------------------------------------------
| Debug Routes (Optional, bisa dihapus saat production)
|--------------------------------------------------------------------------
*/
Route::get('/debug-paths', function () {
    return response()->json([
        'admin_path' => resource_path('views/admin/components'),
        'admin_realpath' => realpath(resource_path('views/admin/components')),
        'admin_exists' => file_exists(resource_path('views/admin/components')),
        'admin_files' => file_exists(resource_path('views/admin/components')) ? scandir(resource_path('views/admin/components')) : 'NOT FOUND',
        'frontend_path' => resource_path('views/frontend'),
        'frontend_realpath' => realpath(resource_path('views/frontend')),
    ]);
})->middleware('auth');

// Route untuk ganti bahasa (Language Switcher)
Route::get('/lang/{locale}', function ($locale) {
    // Validasi agar hanya 'id' atau 'en' yang diterima
    if (in_array($locale, ['id', 'en'])) {
        session(['locale' => $locale]);
    }

    // Kembali ke halaman sebelumnya
    return redirect()->back();
})->name('lang.switch');

require __DIR__.'/auth.php';
