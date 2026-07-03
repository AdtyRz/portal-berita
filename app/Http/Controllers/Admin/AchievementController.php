<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreAchievementRequest;
use App\Http\Requests\Admin\UpdateAchievementRequest;
use App\Models\Achievement;
use App\Models\ActivityLog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AchievementController extends Controller
{
    public function index(Request $request)
    {
        $query = Achievement::with('author');

        if ($request->filled('search')) {
            $query->where('title', 'like', "%{$request->search}%");
        }

        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $achievements = $query->latest('achievement_date')->paginate(15)->withQueryString();

        return view('admin.achievements.index', compact('achievements'));
    }

    public function create()
    {
        return view('admin.achievements.form');
    }

    public function store(StoreAchievementRequest $request)
    {
        $data = $request->validated();
        $data['user_id'] = auth()->id();

        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('achievements', 'public');
        }

        $achievement = Achievement::create($data);
        ActivityLog::log('created', $achievement, "Created achievement: {$achievement->title}");

        return redirect()->route('admin.achievements.index')->with('success', 'Achievement created successfully.');
    }

    public function edit(Achievement $achievement)
    {
        return view('admin.achievements.form', compact('achievement'));
    }

    public function update(UpdateAchievementRequest $request, Achievement $achievement)
    {
        $data = $request->validated();

        if ($request->hasFile('thumbnail')) {
            if ($achievement->thumbnail) {
                Storage::disk('public')->delete($achievement->thumbnail);
            }
            $data['thumbnail'] = $request->file('thumbnail')->store('achievements', 'public');
        }

        $achievement->update($data);
        ActivityLog::log('updated', $achievement, "Updated achievement: {$achievement->title}");

        return redirect()->route('admin.achievements.index')->with('success', 'Achievement updated successfully.');
    }

    public function destroy(Achievement $achievement)
    {
        $title = $achievement->title;
        if ($achievement->thumbnail) {
            Storage::disk('public')->delete($achievement->thumbnail);
        }
        $achievement->delete();
        ActivityLog::log('deleted', $achievement, "Deleted achievement: {$title}");

        return redirect()->route('admin.achievements.index')->with('success', 'Achievement deleted successfully.');
    }
}
