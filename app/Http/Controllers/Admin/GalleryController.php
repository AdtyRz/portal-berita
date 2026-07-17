<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreGalleryRequest;
use App\Http\Requests\Admin\UpdateGalleryRequest;
use App\Models\ActivityLog;
use App\Models\Gallery;
use App\Models\GalleryItem;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;
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
        $data['display_mode'] = $request->input('display_mode', 'grid');

        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        if ($data['status'] === 'published' && empty($data['publish_date'] ?? null)) {
            $data['publish_date'] = now();
        }

        $gallery = Gallery::create($data);

        // Handle multiple images upload
        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery-items', 'public');

                $itemData = [
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'order' => $index,
                ];

                // Tambah title & caption jika mode detailed
                if ($data['display_mode'] === 'detailed' && $request->has("captions.{$index}")) {
                    $itemData['title'] = $request->input("captions.{$index}.title");
                    $itemData['caption'] = $request->input("captions.{$index}.caption");
                }

                GalleryItem::create($itemData);
            }
        }

        // Set cover image otomatis jika kosong
        if (! $gallery->cover_image && $gallery->items->count() > 0) {
            $gallery->update(['cover_image' => $gallery->items->first()->image]);
        }

        Cache::forget('home_data_v1');

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
        $data['display_mode'] = $request->input('display_mode', $gallery->display_mode);

        if ($request->hasFile('cover_image')) {
            if ($gallery->cover_image) {
                Storage::disk('public')->delete($gallery->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('galleries', 'public');
        }

        $gallery->update($data);

        // Delete selected items
        if ($request->has('delete_items')) {
            foreach ($request->delete_items as $itemId) {
                $item = GalleryItem::find($itemId);
                if ($item && $item->gallery_id === $gallery->id) {
                    Storage::disk('public')->delete($item->image);
                    $item->delete();
                }
            }
        }

        // Add new images
        if ($request->hasFile('images')) {
            $currentMaxOrder = $gallery->items()->max('order') ?? 0;
            foreach ($request->file('images') as $index => $image) {
                $path = $image->store('gallery-items', 'public');

                $itemData = [
                    'gallery_id' => $gallery->id,
                    'image' => $path,
                    'order' => $currentMaxOrder + $index + 1,
                ];

                if ($data['display_mode'] === 'detailed' && $request->has("captions.{$index}")) {
                    $itemData['title'] = $request->input("captions.{$index}.title");
                    $itemData['caption'] = $request->input("captions.{$index}.caption");
                }

                GalleryItem::create($itemData);
            }
        }

        Cache::forget('home_data_v1');

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
