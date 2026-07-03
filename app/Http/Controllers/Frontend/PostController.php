<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(Request $request): View
    {
        $query = Post::published()
            ->with(['category', 'author', 'tags'])
            ->latest('publish_date');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('category')) {
            $query->whereHas('category', function ($q) use ($request) {
                $q->where('slug', $request->category);
            });
        }

        if ($request->filled('tag')) {
            $query->whereHas('tags', function ($q) use ($request) {
                $q->where('slug', $request->tag);
            });
        }

        $posts = $query->paginate(12)->withQueryString();

        return view('frontend.posts.index', compact('posts'));
    }

    public function show(string $slug): View
    {
        $post = Post::published()
            ->with(['category', 'author', 'tags', 'approvedComments.user'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Get related posts
        $relatedPosts = $post->relatedPosts(4);

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }
}