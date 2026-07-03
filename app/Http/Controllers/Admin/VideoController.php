<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreVideoRequest;
use App\Http\Requests\Admin\UpdateVideoRequest;
use App\Models\ActivityLog;
use App\Models\Video;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class VideoController extends Controller
{
    public function index(Request $request)
    {
        $query = Video::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $videos = $query->latest()->paginate(15)->withQueryString();

        return view('admin.videos.index', compact('videos'));
    }

    public function create()
    {
        return view('admin.videos.form');
    }

    public function store(StoreVideoRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        if ($request->hasFile('video_file')) {
            $data['video_file'] = $request->file('video_file')->store('videos/files', 'public');
        }

        $video = Video::create($data);
        ActivityLog::log('created', $video, "Created video: {$video->title}");

        return redirect()->route('admin.videos.index')->with('success', 'Video created successfully.');
    }

    public function edit(Video $video)
    {
        return view('admin.videos.form', compact('video'));
    }

    public function update(UpdateVideoRequest $request, Video $video)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($video->thumbnail) {
                Storage::disk('public')->delete($video->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('videos', 'public');
        }

        if ($request->hasFile('video_file')) {
            if ($video->video_file) {
                Storage::disk('public')->delete($video->video_file);
            }
            $data['video_file'] = $request->file('video_file')->store('videos/files', 'public');
        }

        $video->update($data);
        ActivityLog::log('updated', $video, "Updated video: {$video->title}");

        return redirect()->route('admin.videos.index')->with('success', 'Video updated successfully.');
    }

    public function destroy(Video $video)
    {
        $title = $video->title;
        if ($video->thumbnail) {
            Storage::disk('public')->delete($video->thumbnail);
        }
        if ($video->video_file) {
            Storage::disk('public')->delete($video->video_file);
        }
        $video->delete();
        ActivityLog::log('deleted', $video, "Deleted video: {$title}");

        return redirect()->route('admin.videos.index')->with('success', 'Video deleted successfully.');
    }
}
