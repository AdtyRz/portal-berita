<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Events\NewCommentReceived;
use App\Models\ActivityLog;
use App\Models\Comment;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function index(Request $request)
    {
        $query = Comment::with('post', 'user');

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('content', 'like', "%{$request->search}%")
                  ->orWhere('name', 'like', "%{$request->search}%")
                  ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        if ($request->filled('status')) {
            if ($request->status === 'approved') {
                $query->approved();
            } elseif ($request->status === 'pending') {
                $query->pending();
            }
        }

        $comments = $query->latest()->paginate(20)->withQueryString();

        return view('admin.comments.index', compact('comments'));
    }

public function show(Comment $comment)
{
    $comment->load('post.author');
    return view('admin.comments.show', compact('comment'));
}

public function approve(Comment $comment)
{
    $comment->update(['is_approved' => true]);
    
    // Clear cache
    \Illuminate\Support\Facades\Cache::forget('dashboard_stats');
    
    return redirect()->back()->with('success', 'Comment approved successfully.');
}

    public function destroy(Comment $comment)
    {
        $post = $comment->post;
        $comment->delete();

        // Update post comment count
        $post->update([
            'total_comments' => $post->approvedComments()->count()
        ]);

        ActivityLog::log('deleted', $comment, "Deleted comment");

        return back()->with('success', 'Comment deleted successfully.');
    }
    public function storeComment(Request $request, string $slug)
    {
        $post = Post::published()->where('slug', $slug)->firstOrFail();

        $validated = $request->validate([
            'name' => ['nullable', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255'],
            'content' => ['required', 'string', 'max:2000'],
            'parent_id' => ['nullable', 'integer', 'exists:comments,id'],
        ]);

        // 2. Simpan komentar ke variabel $comment
        $comment = Comment::create([
            'post_id' => $post->id,
            'user_id' => auth()->id(),
            'name' => $validated['name'] ?? (auth()->user()?->name ?? 'Anonymous'),
            'email' => $validated['email'] ?? (auth()->user()?->email ?? null),
            'content' => $validated['content'],
            'parent_id' => $validated['parent_id'] ?? null,
            'is_approved' => false,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
        ]);

        event(new NewCommentReceived($comment));

        return back()->with('success', 'Komentar Anda telah dikirim dan akan ditampilkan setelah disetujui oleh admin.');
    }
}