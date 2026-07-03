<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StoreOrganizationRequest;
use App\Http\Requests\Admin\UpdateOrganizationRequest;
use App\Models\Organization;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class OrganizationController extends Controller
{
    public function index(Request $request)
    {
        $query = Organization::query();
        if ($request->filled('type')) {
            $query->where('organization_type', $request->type);
        }
        $organizations = $query->ordered()->paginate(15)->withQueryString();
        return view('admin.organizations.index', compact('organizations'));
    }

    public function create()
    {
        return view('admin.organizations.form');
    }

    public function store(StoreOrganizationRequest $request)
    {
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }
        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }
        Organization::create($data);
        return redirect()->route('admin.organizations.index')->with('success', 'Organization created.');
    }

    public function edit(Organization $organization)
    {
        return view('admin.organizations.form', compact('organization'));
    }

    public function update(UpdateOrganizationRequest $request, Organization $organization)
    {
        $data = $request->validated();
        if ($request->hasFile('logo')) {
            if ($organization->logo) Storage::disk('public')->delete($organization->logo);
            $data['logo'] = $request->file('logo')->store('organizations', 'public');
        }
        if ($request->hasFile('photo')) {
            if ($organization->photo) Storage::disk('public')->delete($organization->photo);
            $data['photo'] = $request->file('photo')->store('organizations', 'public');
        }
        $organization->update($data);
        return redirect()->route('admin.organizations.index')->with('success', 'Organization updated.');
    }

    public function destroy(Organization $organization)
    {
        if ($organization->logo) Storage::disk('public')->delete($organization->logo);
        if ($organization->photo) Storage::disk('public')->delete($organization->photo);
        $organization->delete();
        return redirect()->route('admin.organizations.index')->with('success', 'Organization deleted.');
    }
}
