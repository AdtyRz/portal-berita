<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Contact;
use App\Models\Document;
use App\Models\Gallery;
use App\Models\Organization;
use App\Models\Post;
use App\Models\Setting;
use App\Models\SocialMedia;
use App\Models\Video;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PageController extends Controller
{
    public function about(): View
    {
        // Ambil data dari Settings model
        $settings = Setting::pluck('value', 'key')->toArray();

        $organizations = Organization::active()->ordered()->get();

        // Ambil social media
        $socials = SocialMedia::where('status', 1)->get();

        $organizations = Organization::active()->ordered()->get();

        return view('frontend.pages.about', compact('organizations', 'settings', 'socials'));

    }

    public function organizationShow(string $slug): View
    {
        $organization = Organization::where('slug', $slug)
            ->where('status', 1)
            ->firstOrFail();

        // Ambil organization lain untuk "More Members"
        $otherOrganizations = Organization::where('status', 1)
            ->where('id', '!=', $organization->id)
            ->ordered()
            ->take(4)
            ->get();

        // Prepare galleries data untuk JavaScript (hindari error @json)
        $galleriesData = $organization->galleries->map(function ($g) {
            return [
                'id' => $g->id,
                'title' => $g->title,
                'description' => $g->description,
                'image_url' => $g->image_url,
                'event_date' => $g->event_date ? $g->event_date->format('M d, Y') : null,
                'event_type' => $g->event_type,
                'location' => $g->location,
            ];
        })->values();

        return view('frontend.pages.organization-show', compact(
            'organization',
            'otherOrganizations',
            'galleriesData'
        ));
    }

    public function contact(): View
    {
        return view('frontend.pages.contact');
    }

    public function storeContact(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['nullable', 'string', 'max:20'],
            'subject' => ['nullable', 'string', 'max:255'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        $validated['ip_address'] = $request->ip();

        Contact::create($validated);

        return back()->with('success', 'Thank you! Your message has been sent successfully.');
    }

    public function gallery(): View
    {
        $galleries = Gallery::published()->withCount('items')->latest()->paginate(12);

        return view('frontend.pages.gallery', compact('galleries'));
    }

    // Announcements
    public function announcements(Request $request): View
    {
        $query = Announcement::published();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $announcements = $query->latest('publish_date')->paginate(12)->withQueryString();

        return view('frontend.pages.announcements', compact('announcements'));
    }

    public function announcementShow(string $slug): View
    {
        $announcement = Announcement::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $announcement->increment('total_views');

        return view('frontend.pages.announcement-show', compact('announcement'));
    }

    // Agendas
    public function agendas(Request $request): View
    {
        $query = Agenda::published();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $agendas = $query->orderBy('start_date', 'desc')->paginate(12)->withQueryString();

        return view('frontend.pages.agendas', compact('agendas'));
    }

    public function agendaShow(string $slug): View
    {
        $agenda = Agenda::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $agenda->increment('total_views');

        return view('frontend.pages.agenda-show', compact('agenda'));
    }

    // Achievements
    public function achievements(Request $request): View
    {
        $query = Achievement::published();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        $achievements = $query->latest('achievement_date')->paginate(12)->withQueryString();

        return view('frontend.pages.achievements', compact('achievements'));
    }

    public function achievementShow(string $slug): View
    {
        $achievement = Achievement::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $achievement->increment('total_views');

        return view('frontend.pages.achievement-show', compact('achievement'));
    }

    // Videos
    public function videos(Request $request): View
    {
        $query = Video::published();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        $videos = $query->latest()->paginate(12)->withQueryString();

        return view('frontend.pages.videos', compact('videos'));
    }

    public function videoShow(string $slug): View
    {
        $video = Video::published()
            ->where('slug', $slug)
            ->firstOrFail();

        $video->increment('total_views');

        return view('frontend.pages.video-show', compact('video'));
    }

    // Documents
    public function documents(Request $request): View
    {
        $query = Document::published();

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('category')) {
            $query->where('category', $request->category);
        }

        $documents = $query->latest()->paginate(12)->withQueryString();

        return view('frontend.pages.documents', compact('documents'));
    }

    public function documentDownload(Document $document)
    {
        $document->incrementDownloads();

        return response()->download(storage_path('app/public/'.$document->file));
    }

    // Search
    public function search(Request $request): View
    {
        $query = $request->get('q', '');
        $results = collect();

        if (strlen($query) >= 2) {
            $posts = Post::published()->search($query)->latest()->take(5)->get();
            $announcements = Announcement::published()->where('title', 'like', "%{$query}%")->latest()->take(3)->get();
            $agendas = Agenda::published()->where('title', 'like', "%{$query}%")->latest()->take(3)->get();
            $achievements = Achievement::published()->where('title', 'like', "%{$query}%")->latest()->take(3)->get();

            $results = collect([
                'posts' => $posts,
                'announcements' => $announcements,
                'agendas' => $agendas,
                'achievements' => $achievements,
            ]);
        }

        return view('frontend.pages.search', compact('query', 'results'));
    }

    // Gallery Show
    public function galleryShow(string $slug): View
    {
        $gallery = Gallery::published()
            ->with('items')
            ->where('slug', $slug)
            ->firstOrFail();

        $gallery->increment('total_views');

        // Ambil gallery lain untuk "More Galleries"
        $otherGalleries = Gallery::published()
            ->where('id', '!=', $gallery->id)
            ->withCount('items')
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.pages.gallery-show', compact('gallery', 'otherGalleries'));
    }
}
