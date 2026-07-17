<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationRequest;
use App\Http\Requests\Admin\UpdateOrganizationRequest;
use App\Models\ActivityLog;
use App\Models\Organization;
use App\Models\OrganizationGallery;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class OrganizationController extends Controller
{
    public function index()
    {
        $organizations = Organization::withCount('galleries')
            ->ordered()
            ->paginate(15);

        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.form');
    }

    public function store(StoreOrganizationRequest $request)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }

        $organization = Organization::create($data);

        // Handle multiple gallery uploads
        if ($request->hasFile('gallery_images')) {
            foreach ($request->file('gallery_images') as $index => $image) {
                $path = $image->store('organization-galleries', 'public');

                OrganizationGallery::create([
                    'organization_id' => $organization->id,
                    'title' => $request->input("gallery_titles.$index", 'Gallery ' . ($index + 1)),
                    'description' => $request->input("gallery_descriptions.$index"),
                    'image' => $path,
                    'event_type' => $request->input("gallery_types.$index"),
                    'event_date' => $request->input("gallery_dates.$index"),
                    'order' => $index,
                ]);
            }
        }

        ActivityLog::log('created', $organization, "Created organization: {$organization->name}");

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization created successfully.');
    }

    public function edit(Organization $organization)
    {
        $organization->load('galleries');
        return view('admin.organizations.form', compact('organization'));
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $data = $request->validated();

        if (empty($data['slug'])) {
            $data['slug'] = Str::slug($data['name']);
        }

        if ($request->hasFile('photo')) {
            if ($organization->photo) {
                Storage::disk('public')->delete($organization->photo);
            }
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }

        $organization->update($data);

        ActivityLog::log('updated', $organization, "Updated organization: {$organization->name}");

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization updated successfully.');
    }

    public function destroy(Organization $organization)
    {
        $name = $organization->name;

        // Delete organization photo
        if ($organization->photo) {
            Storage::disk('public')->delete($organization->photo);
        }

        // Delete all gallery images
        foreach ($organization->galleries as $gallery) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
        }

        $organization->galleries()->delete();
        $organization->delete();

        ActivityLog::log('deleted', $organization, "Deleted organization: {$name}");

        return redirect()
            ->route('admin.organizations.index')
            ->with('success', 'Organization deleted successfully.');
    }

    // ========== GALLERY MANAGEMENT ==========

    public function galleryIndex(Organization $organization)
    {
        $galleries = $organization->galleries()->ordered()->paginate(20);
        return view('admin.organizations.gallery.index', compact('organization', 'galleries'));
    }

    public function galleryCreate(Organization $organization)
    {
        return view('admin.organizations.gallery.form', compact('organization'));
    }

    public function galleryStore(Request $request, Organization $organization)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['required', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'event_type' => ['nullable', 'string', 'max:50'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['boolean'],
        ]);

        $validated['organization_id'] = $organization->id;
        $validated['image'] = $request->file('image')->store('organization-galleries', 'public');
        $validated['is_featured'] = $request->boolean('is_featured');

        OrganizationGallery::create($validated);

        return redirect()
            ->route('admin.organizations.gallery.index', $organization)
            ->with('success', 'Gallery item added successfully.');
    }

    public function galleryEdit(Organization $organization, OrganizationGallery $gallery)
    {
        return view('admin.organizations.gallery.form', compact('organization', 'gallery'));
    }

    public function galleryUpdate(Request $request, Organization $organization, OrganizationGallery $gallery)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string', 'max:1000'],
            'image' => ['nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'event_type' => ['nullable', 'string', 'max:50'],
            'event_date' => ['nullable', 'date'],
            'location' => ['nullable', 'string', 'max:255'],
            'is_featured' => ['boolean'],
        ]);

        if ($request->hasFile('image')) {
            if ($gallery->image) {
                Storage::disk('public')->delete($gallery->image);
            }
            $validated['image'] = $request->file('image')->store('organization-galleries', 'public');
        }

        $validated['is_featured'] = $request->boolean('is_featured');

        $gallery->update($validated);

        return redirect()
            ->route('admin.organizations.gallery.index', $organization)
            ->with('success', 'Gallery item updated successfully.');
    }

    public function galleryDestroy(Organization $organization, OrganizationGallery $gallery)
    {
        if ($gallery->image) {
            Storage::disk('public')->delete($gallery->image);
        }

        $gallery->delete();

        return redirect()
            ->route('admin.organizations.gallery.index', $organization)
            ->with('success', 'Gallery item deleted successfully.');
    }
}