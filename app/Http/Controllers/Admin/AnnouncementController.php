<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAnnouncementRequest;
use App\Http\Requests\Admin\UpdateAnnouncementRequest;
use App\Models\ActivityLog;
use App\Models\Announcement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AnnouncementController extends Controller
{
    public function index(Request $request)
    {
        $query = Announcement::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('priority')) {
            $query->where('priority', $request->priority);
        }

        $announcements = $query->latest()->paginate(15)->withQueryString();

        return view('admin.announcements.index', compact('announcements'));
    }

    public function create()
    {
        return view('admin.announcements.form');
    }

    public function store(StoreAnnouncementRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('announcements', 'public');
        }

        if ($data['status'] === 'published' && empty($data['publish_date'])) {
            $data['publish_date'] = now();
        }

        $announcement = Announcement::create($data);
        ActivityLog::log('created', $announcement, "Created announcement: {$announcement->title}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement created successfully.');
    }

    public function edit(Announcement $announcement)
    {
        return view('admin.announcements.form', compact('announcement'));
    }

    public function update(UpdateAnnouncementRequest $request, Announcement $announcement)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($announcement->thumbnail) {
                Storage::disk('public')->delete($announcement->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('announcements', 'public');
        }

        $announcement->update($data);
        ActivityLog::log('updated', $announcement, "Updated announcement: {$announcement->title}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement updated successfully.');
    }

    public function destroy(Announcement $announcement)
    {
        $title = $announcement->title;
        if ($announcement->thumbnail) {
            Storage::disk('public')->delete($announcement->thumbnail);
        }
        $announcement->delete();
        ActivityLog::log('deleted', $announcement, "Deleted announcement: {$title}");

        return redirect()->route('admin.announcements.index')->with('success', 'Announcement deleted successfully.');
    }
}
