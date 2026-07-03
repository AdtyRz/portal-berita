<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Post;
use App\Models\Video;
use Illuminate\View\View;

class SitemapController extends Controller
{
    public function index(): View
    {
        $posts = Post::published()->latest('publish_date')->get();
        $announcements = Announcement::published()->latest('publish_date')->get();
        $agendas = Agenda::published()->orderBy('start_date', 'desc')->get();
        $achievements = Achievement::published()->latest('achievement_date')->get();
        $galleries = Gallery::published()->latest()->get();
        $videos = Video::published()->latest()->get();
        $documents = Document::published()->latest()->get();

        return view('sitemap', compact(
            'posts', 'announcements', 'agendas', 'achievements', 
            'galleries', 'videos', 'documents'
        ));
    }
}