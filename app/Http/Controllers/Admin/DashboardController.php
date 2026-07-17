<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Achievement;
use App\Models\Agenda;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Organization;
use App\Models\Post;
use Illuminate\Support\Facades\Cache;

class DashboardController extends Controller
{
public function index()
{
    // Cache hanya 60 detik (1 menit) - lebih realtime
    $stats = Cache::remember('dashboard_stats', 30, function () {
        return [
            'total_posts' => Post::count(),
            'total_views' => (int) Post::sum('total_views'),
            'pending_comments' => Comment::where('is_approved', false)->count(),
            'total_comments' => Comment::count(),
            'unread_contacts' => Contact::where('is_read', false)->count(),
            'total_announcements' => Announcement::count(),
            'total_agendas' => Agenda::count(),
            'total_achievements' => Achievement::count(),
            'total_organizations' => Organization::count(),
        ];
    });

    // Recent posts (tidak pakai cache, selalu fresh)
    $recentPosts = Post::with(['category', 'author'])
        ->latest()
        ->take(5)
        ->get();

    // Recent comments (tidak pakai cache, selalu fresh)
    $recentComments = Comment::with('post')
        ->latest()
        ->take(5)
        ->get()
        ->map(fn($comment) => [
            'id' => $comment->id,
            'author_name' => $comment->user?->name ?? $comment->name ?? 'Anonymous',
            'content' => $comment->content,
            'post_title' => $comment->post?->title ?? 'Unknown Post',
            'is_approved' => $comment->is_approved,
            'created_at' => $comment->created_at,
        ]);

    return view('admin.dashboard', compact('stats', 'recentPosts', 'recentComments'));
}
}