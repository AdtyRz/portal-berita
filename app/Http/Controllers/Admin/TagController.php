<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreTagRequest;
use App\Http\Requests\Admin\UpdateTagRequest;
use App\Models\ActivityLog;
use App\Models\Tag;
use Illuminate\Http\Request;

class TagController extends Controller
{
    public function index(Request $request)
    {
        $query = Tag::query();

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        $tags = $query->withCount('posts')->latest()->paginate(20)->withQueryString();

        return view('admin.tags.index', compact('tags'));
    }

    public function create()
    {
        return view('admin.tags.form');
    }

    public function store(StoreTagRequest $request)
    {
        $tag = Tag::create($request->validated());
        ActivityLog::log('created', $tag, "Created tag: {$tag->name}");

        return redirect()->route('admin.tags.index')->with('success', 'Tag created successfully.');
    }

    public function edit(Tag $tag)
    {
        return view('admin.tags.form', compact('tag'));
    }

    public function update(UpdateTagRequest $request, Tag $tag)
    {
        $tag->update($request->validated());
        ActivityLog::log('updated', $tag, "Updated tag: {$tag->name}");

        return redirect()->route('admin.tags.index')->with('success', 'Tag updated successfully.');
    }

    public function destroy(Tag $tag)
    {
        $name = $tag->name;
        $tag->delete();
        ActivityLog::log('deleted', $tag, "Deleted tag: {$name}");

        return redirect()->route('admin.tags.index')->with('success', 'Tag deleted successfully.');
    }
}
