<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Post;
use App\Models\Comment;
use Illuminate\Http\Request;
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
            ->with(['category', 'author', 'tags', 'approvedComments'])
            ->where('slug', $slug)
            ->firstOrFail();

        // Increment views
        $post->incrementViews();

        // Related posts
        $relatedPosts = $post->relatedPosts(4);

        return view('frontend.posts.show', compact('post', 'relatedPosts'));
    }

        public function storeComment(Request $request, string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(), // Tetap disimpan untuk tracking internal admin
            // FIX: Jika nama kosong atau hanya spasi, paksa jadi 'Anonymous'
            'name' => !empty(trim($validated['name'] ?? '')) ? trim($validated['name']) : 'Anonymous',
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_approved' => false, // Wajib false agar divalidasi admin dulu
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        return back()->with('success', 'Komentar Anda telah dikirim dan akan ditampilkan setelah disetujui oleh admin.');
    }
}
