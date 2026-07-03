<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
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

    public function approve(Comment $comment)
    {
        $comment->update(['is_approved' => true]);

        // Update post comment count
        $comment->post->update([
            'total_comments' => $comment->post->approvedComments()->count()
        ]);

        ActivityLog::log('approved', $comment, "Approved comment on: {$comment->post->title}");

        return back()->with('success', 'Comment approved successfully.');
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
}
