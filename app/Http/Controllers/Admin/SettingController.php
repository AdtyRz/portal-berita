<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Setting;
use App\Models\SocialMedia;
use Illuminate\Http\Request;

class SettingController extends Controller
{
    public function index()
    {
        $general = Setting::getGroup('general');
        $seo = Setting::getGroup('seo');
        $socials = SocialMedia::ordered()->get();

        return view('admin.settings.index', compact('general', 'seo', 'socials'));
    }

    public function update(Request $request)
    {
        $request->validate([
            'site_name' => ['required', 'string', 'max:255'],
            'site_description' => ['nullable', 'string', 'max:500'],
            'site_email' => ['nullable', 'email', 'max:255'],
            'site_phone' => ['nullable', 'string', 'max:50'],
            'site_address' => ['nullable', 'string', 'max:500'],
            'meta_title' => ['nullable', 'string', 'max:255'],
            'meta_description' => ['nullable', 'string', 'max:500'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
        ]);

        // General settings
        Setting::set('site_name', $request->site_name, 'text', 'general');
        Setting::set('site_description', $request->site_description, 'text', 'general');
        Setting::set('site_email', $request->site_email, 'text', 'general');
        Setting::set('site_phone', $request->site_phone, 'text', 'general');
        Setting::set('site_address', $request->site_address, 'text', 'general');

        // SEO settings
        Setting::set('meta_title', $request->meta_title, 'text', 'seo');
        Setting::set('meta_description', $request->meta_description, 'text', 'seo');
        Setting::set('meta_keywords', $request->meta_keywords, 'text', 'seo');

        // Social media
        if ($request->has('socials')) {
            SocialMedia::query()->delete();
            foreach ($request->socials as $index => $social) {
                if (!empty($social['url'])) {
                    SocialMedia::create([
                        'platform' => $social['platform'],
                        'url' => $social['url'],
                        'order' => $index,
                        'status' => true,
                    ]);
                }
            }
        }

        return back()->with('success', 'Settings updated successfully.');
    }
}
