<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SchoolProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SettingController extends Controller
{
    public function index()
    {
        $profile = SchoolProfile::getCurrent();
        return view('admin.settings.index', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'short_name' => ['nullable', 'string', 'max:50'],
            'tagline' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:2000'],
            'vision' => ['nullable', 'string', 'max:2000'],
            'mission' => ['nullable', 'string', 'max:5000'],
            'address' => ['nullable', 'string', 'max:500'],
            'phone' => ['nullable', 'string', 'max:50'],
            'email' => ['nullable', 'email', 'max:255'],
            'website' => ['nullable', 'url', 'max:255'],
            'founded_year' => ['nullable', 'integer', 'min:1900', 'max:' . date('Y')],
            'accreditation' => ['nullable', 'string', 'max:50'],
            'principal_name' => ['nullable', 'string', 'max:255'],
            'facebook' => ['nullable', 'url', 'max:255'],
            'instagram' => ['nullable', 'url', 'max:255'],
            'twitter' => ['nullable', 'url', 'max:255'],
            'youtube' => ['nullable', 'url', 'max:255'],
            'linkedin' => ['nullable', 'url', 'max:255'],
            'tiktok' => ['nullable', 'url', 'max:255'],
            'logo' => ['nullable', 'image', 'max:2048'],
            'favicon' => ['nullable', 'image', 'max:1024'],
            'cover_image' => ['nullable', 'image', 'max:5120'],
        ]);

        $profile = SchoolProfile::getCurrent();

        // Handle file uploads
        if ($request->hasFile('logo')) {
            if ($profile->logo) Storage::disk('public')->delete($profile->logo);
            $validated['logo'] = $request->file('logo')->store('school', 'public');
        }

        if ($request->hasFile('favicon')) {
            if ($profile->favicon) Storage::disk('public')->delete($profile->favicon);
            $validated['favicon'] = $request->file('favicon')->store('school', 'public');
        }

        if ($request->hasFile('cover_image')) {
            if ($profile->cover_image) Storage::disk('public')->delete($profile->cover_image);
            $validated['cover_image'] = $request->file('cover_image')->store('school', 'public');
        }

        // Handle mission (simpan sebagai text, pisah per baris)
        if (isset($validated['mission'])) {
            // Keep as string with newlines
            $validated['mission'] = $validated['mission'];
        }

        $profile->update($validated);

        // Clear cache
        SchoolProfile::clearCache();
        \Illuminate\Support\Facades\Cache::forget('home_data_v1');

        return redirect()->back()->with('success', 'School profile updated successfully.');
    }
}