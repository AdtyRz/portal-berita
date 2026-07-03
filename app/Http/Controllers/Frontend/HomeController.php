<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Gallery;
use App\Models\HeroSlider;
use App\Models\Post;
use App\Models\Video;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class HomeController extends Controller
{
    public function index(): View
    {
        // Cache 1 jam (3600 detik)
        $data = Cache::remember('home_data_v1', 3600, function () {
            return [
                'heroSliders' => HeroSlider::active()->ordered()->get(),
                'breakingNews' => Post::published()->breakingNews()->latest()->take(5)->get(),
                'featuredPosts' => Post::published()->featured()->latest()->take(4)->get(),
                'latestPosts' => Post::published()->with('category', 'author')->latest()->take(8)->get(),
                'latestAnnouncements' => Announcement::active()->latest()->take(5)->get(),
                'upcomingAgendas' => Agenda::upcoming()->take(5)->get(),
                'latestAchievements' => Achievement::published()->latest()->take(4)->get(),
                'latestVideos' => Video::published()->latest()->take(4)->get(),
                'latestGalleries' => Gallery::published()->latest()->take(6)->get(),
            ];
        });

        return view('frontend.pages.home', $data);
    }
}