<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index(Request $request)
    {
        $query = Gallery::with('author')->withCount('items');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $galleries = $query->latest()->paginate(15)->withQueryString();

        return view('admin.galleries.index', compact('galleries'));
    }

    public function create()
    {
        return view('admin.galleries.form');
    }

    public function store(StoreGalleryRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        $gallery = Gallery::create($data);

        // Handle multiple images
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery-items', 'public');
                GalleryItem::create([
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'order' => $index,
                ]);
            }
        }

        ActivityLog::log('created', $gallery, "Created gallery: {$gallery->title}");

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery created successfully.');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('items');
        return view('admin.galleries.form', compact('gallery'));
    }

    public function update(UpdateGalleryRequest $request, Gallery $gallery)
    {
        $data = $request->validated();

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        $gallery->update($data);

        // Handle new images
        if ($request->hasFile('images')) {
            $currentCount = $gallery->items()->count();
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery-items', 'public');
                GalleryItem::create([
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'order' => $currentCount + $index,
                ]);
            }
        }

        // Handle deleted items
        if ($request->has('delete_items')) {
            foreach ($request->delete_items as $itemId) {
                $item = GalleryItem::find($itemId);
                if ($item) {
                    Storage::disk('public')->delete($item->image);
                    $item->delete();
                }
            }
        }

        ActivityLog::log('updated', $gallery, "Updated gallery: {$gallery->title}");

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery updated successfully.');
    }

    public function destroy(Gallery $gallery)
    {
        $title = $gallery->title;

        // Delete cover image
        if ($gallery->cover_image) {
            Storage::disk('public')->delete($gallery->cover_image);
        }

        // Delete all items
        foreach ($gallery->items as $item) {
            Storage::disk('public')->delete($item->image);
            $item->delete();
        }

        $gallery->delete();
        ActivityLog::log('deleted', $gallery, "Deleted gallery: {$title}");

        return redirect()->route('admin.galleries.index')->with('success', 'Gallery deleted successfully.');
    }
}
