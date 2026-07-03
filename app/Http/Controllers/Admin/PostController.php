<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StorePostRequest;
use App\Http\Requests\Admin\UpdatePostRequest;
use App\Models\ActivityLog;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;

class PostController extends Controller
{
    public function index(Request $request)
    {
        $query = Post::with('category', 'author');

        if ($request->filled('search')) {
            $query->search($request->search);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        if ($request->filled('featured')) {
            $query->where('featured', $request->featured === 'yes');
        }

        $posts = $query->latest()->paginate(15)->withQueryString();
        $categories = Category::active()->ordered()->get();

        return view('admin.posts.index', compact('posts', 'categories'));
    }

    public function create()
    {
        $categories = Category::active()->ordered()->get();
        $tags = Tag::active()->get();

        return view('admin.posts.create', compact('categories', 'tags'));
    }

    public function store(StorePostRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        if ($data['status'] === 'published' && empty($data['publish_date'])) {
            $data['publish_date'] = now();
        }

        $post = Post::create($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        ActivityLog::log('created', $post, "Created post: {$post->title}");

        Cache::forget('home_data_v1');
        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.posts.index')->with('success', 'Post created successfully.');
    }

    public function edit(Post $post)
    {
        $categories = Category::active()->ordered()->get();
        $tags = Tag::active()->get();

        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    public function update(UpdatePostRequest $request, Post $post)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($post->thumbnail) {
                Storage::disk('public')->delete($post->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('posts', 'public');
        }

        if ($data['status'] === 'published' && empty($data['publish_date']) && $post->status !== 'published') {
            $data['publish_date'] = now();
        }

        $post->update($data);

        if ($request->has('tags')) {
            $post->tags()->sync($request->tags);
        }

        ActivityLog::log('updated', $post, "Updated post: {$post->title}");

        Cache::forget('home_data_v1');
        Cache::tags(['posts'])->flush();

        return redirect()->route('admin.posts.index')->with('success', 'Post updated successfully.');
    }

    public function destroy(Post $post)
    {
        $title = $post->title;

        if ($post->thumbnail) {
            Storage::disk('public')->delete($post->thumbnail);
        }

        $post->delete();
        ActivityLog::log('deleted', $post, "Deleted post: {$title}");

        return redirect()->route('admin.posts.index')->with('success', 'Post deleted successfully.');
    }
}
