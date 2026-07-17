<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreHeroSliderRequest;
use App\Http\Requests\Admin\UpdateHeroSliderRequest;
use App\Models\ActivityLog;
use App\Models\HeroSlider;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class HeroSliderController extends Controller
{
    public function index()
    {
        $sliders = HeroSlider::ordered()->paginate(15);
        return view('admin.hero-sliders.index', compact('sliders'));
    }

    public function create()
    {
        return view('admin.hero-sliders.form');
    }

    public function store(StoreHeroSliderRequest $request)
    {
        $data = $request->validated();
        
        // FIX: Auto-generate order jika tidak ada
        if (!isset($data['order']) || is_null($data['order']) || empty($data['order'])) {
            $data['order'] = (HeroSlider::max('order') ?? 0) + 1;
        }
        
        // Handle image upload
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }
        
        $slider = HeroSlider::create($data);
        
        // Activity log
        ActivityLog::log('created', $slider, "Created hero slider: {$slider->title}");
        
        return redirect()
            ->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider created successfully.');
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.form', ['slider' => $heroSlider]);
    }

    public function update(UpdateHeroSliderRequest $request, HeroSlider $heroSlider)
    {
        $data = $request->validated();
        
        // FIX: Auto-generate order jika tidak ada
        if (!isset($data['order']) || is_null($data['order']) || empty($data['order'])) {
            $data['order'] = $heroSlider->order;
        }
        
        if ($request->hasFile('image')) {
            if ($heroSlider->image) {
                Storage::disk('public')->delete($heroSlider->image);
            }
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }
        
        $heroSlider->update($data);
        ActivityLog::log('updated', $heroSlider, "Updated hero slider: {$heroSlider->title}");
        
        return redirect()
            ->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider updated.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) {
            Storage::disk('public')->delete($heroSlider->image);
        }
        $heroSlider->delete();
        ActivityLog::log('deleted', $heroSlider, "Deleted hero slider: {$heroSlider->title}");
        
        return redirect()
            ->route('admin.hero-sliders.index')
            ->with('success', 'Hero slider deleted.');
    }
}