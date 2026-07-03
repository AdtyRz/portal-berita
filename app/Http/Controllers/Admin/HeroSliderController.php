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
        if ($request->hasFile('image')) {
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }
        $slider = HeroSlider::create($data);
        ActivityLog::log('created', $slider, "Created hero slider: {$slider->title}");
        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider created.');
    }

    public function edit(HeroSlider $heroSlider)
    {
        return view('admin.hero-sliders.form', ['slider' => $heroSlider]);
    }

    public function update(UpdateHeroSliderRequest $request, HeroSlider $heroSlider)
    {
        $data = $request->validated();
        if ($request->hasFile('image')) {
            if ($heroSlider->image) Storage::disk('public')->delete($heroSlider->image);
            $data['image'] = $request->file('image')->store('hero-sliders', 'public');
        }
        $heroSlider->update($data);
        ActivityLog::log('updated', $heroSlider, "Updated hero slider: {$heroSlider->title}");
        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider updated.');
    }

    public function destroy(HeroSlider $heroSlider)
    {
        if ($heroSlider->image) Storage::disk('public')->delete($heroSlider->image);
        $heroSlider->delete();
        return redirect()->route('admin.hero-sliders.index')->with('success', 'Hero slider deleted.');
    }
}
