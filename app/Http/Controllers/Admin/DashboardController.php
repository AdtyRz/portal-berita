<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Announcement;
use App\Models\Comment;
use App\Models\Contact;
use App\Models\Post;
use App\Models\User;
use App\Models\Visitor;
use Illuminate\Http\Request;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $stats = [
            'total_posts' => Post::count(),
            'published_posts' => Post::published()->count(),
            'total_views' => Post::sum('total_views'),
            'total_comments' => Comment::count(),
            'pending_comments' => Comment::pending()->count(),
            'total_users' => User::count(),
            'visitors_today' => Visitor::today()->count(),
            'unread_contacts' => Contact::unread()->count(),
            'announcements' => Announcement::published()->count(),
        ];

        $recentPosts = Post::with('category', 'author')
            ->latest()
            ->take(5)
            ->get();

        $recentComments = Comment::with('post', 'user')
            ->latest()
            ->take(5)
            ->get();

        $recentContacts = Contact::unread()
            ->latest()
            ->take(5)
            ->get();

        return view('dashboard', compact('stats', 'recentPosts', 'recentComments', 'recentContacts'));
    }
}
