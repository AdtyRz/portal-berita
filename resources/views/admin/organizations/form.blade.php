@extends('admin.layouts.app')

@section('title', isset($organization) ? 'Edit Organization' : 'Create Organization')

@section('content')
    <x-admin.page-header 
        title="{{ isset($organization) ? 'Edit' : 'Create' }} Organization" 
        description="{{ isset($organization) ? 'Update organization profile' : 'Add new organization member' }}" 
    />

    <form method="POST" 
          action="{{ isset($organization) ? route('admin.organizations.update', $organization) : route('admin.organizations.store') }}" 
          enctype="multipart/form-data" 
          class="space-y-6">
        @csrf
        @if(isset($organization)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                {{-- Basic Info --}}
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">Basic Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.input label="Name" name="name" :value="old('name', $organization->name ?? '')" required />
                            <x-admin.input label="Slug" name="slug" :value="old('slug', $organization->slug ?? '')" help="Leave empty to auto-generate" />
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.input label="Position/Role" name="position" :value="old('position', $organization->position ?? '')" placeholder="e.g. President, Secretary" />
                            <x-admin.select 
                                label="Organization Type" 
                                name="organization_type" 
                                :options="['' => 'Select Type', 'student' => 'Student', 'teacher' => 'Teacher', 'staff' => 'Staff', 'alumni' => 'Alumni']" 
                                :value="old('organization_type', $organization->organization_type ?? '')" 
                            />
                        </div>

                        <x-admin.textarea 
                            label="Short Description" 
                            name="description" 
                            :value="old('description', $organization->description ?? '')" 
                            rows="3" 
                            help="Brief description shown in listings" 
                        />
                    </div>
                </x-admin.card>

                {{-- Vision, Mission, Achievements --}}
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">Vision, Mission & Achievements</h3>
                        
                        <x-admin.textarea 
                            label="Vision" 
                            name="vision" 
                            :value="old('vision', $organization->vision ?? '')" 
                            rows="3" 
                            placeholder="Organization's vision..." 
                        />

                        <x-admin.textarea 
                            label="Mission" 
                            name="mission" 
                            :value="old('mission', $organization->mission ?? '')" 
                            rows="4" 
                            placeholder="Organization's mission..." 
                        />

                        <x-admin.textarea 
                            label="Achievements" 
                            name="achievements" 
                            :value="old('achievements', $organization->achievements ?? '')" 
                            rows="4" 
                            help="List achievements separated by new lines" 
                            placeholder="- Achievement 1&#10;- Achievement 2&#10;- Achievement 3" 
                        />
                    </div>
                </x-admin.card>

                {{-- Contact Info --}}
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">Contact Information</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.input label="Email" name="contact_email" type="email" :value="old('contact_email', $organization->contact_email ?? '')" />
                            <x-admin.input label="Phone" name="contact_phone" :value="old('contact_phone', $organization->contact_phone ?? '')" />
                        </div>
                    </div>
                </x-admin.card>

                {{-- Social Media --}}
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">Social Media</h3>
                        
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.input label="Facebook URL" name="facebook" :value="old('facebook', $organization->facebook ?? '')" placeholder="https://facebook.com/..." />
                            <x-admin.input label="Instagram URL" name="instagram" :value="old('instagram', $organization->instagram ?? '')" placeholder="https://instagram.com/..." />
                            <x-admin.input label="Twitter URL" name="twitter" :value="old('twitter', $organization->twitter ?? '')" placeholder="https://twitter.com/..." />
                            <x-admin.input label="LinkedIn URL" name="linkedin" :value="old('linkedin', $organization->linkedin ?? '')" placeholder="https://linkedin.com/in/..." />
                        </div>
                    </div>
                </x-admin.card>

                {{-- Quick Gallery Upload (Create Only) --}}
                @if(!isset($organization))
                    <x-admin.card>
                        <div class="p-6 space-y-6">
                            <div class="flex items-center justify-between">
                                <h3 class="text-base font-semibold text-neutral-900">Quick Gallery Upload</h3>
                                <span class="text-xs text-neutral-500">Optional - Add later via gallery management</span>
                            </div>
                            
                            <div id="gallery-items" class="space-y-4">
                                <div class="gallery-item p-4 border border-neutral-200 rounded-lg">
                                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                        <div>
                                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Image</label>
                                            <input type="file" name="gallery_images[]" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-neutral-100 file:text-neutral-700">
                                        </div>
                                        <div>
                                            <x-admin.input label="Title" name="gallery_titles[]" />
                                        </div>
                                        <div>
                                            <x-admin.select 
                                                label="Event Type" 
                                                name="gallery_types[]" 
                                                :options="['' => 'Select', 'lomba' => 'Lomba', 'kegiatan' => 'Kegiatan', 'rapat' => 'Rapat', 'pelatihan' => 'Pelatihan', 'lainnya' => 'Lainnya']" 
                                            />
                                        </div>
                                        <div>
                                            <x-admin.input label="Event Date" name="gallery_dates[]" type="date" />
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <button type="button" id="add-gallery-btn" class="inline-flex items-center gap-2 px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                                </svg>
                                Add More Gallery Item
                            </button>
                        </div>
                    </x-admin.card>
                @endif
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                {{-- Publish --}}
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        
                        <x-admin.select 
                            label="Status" 
                            name="status" 
                            :options="['1' => 'Active', '0' => 'Inactive']" 
                            :value="old('status', $organization->status ?? '1')" 
                            required 
                        />
                        
                        <x-admin.input 
                            label="Display Order" 
                            name="order" 
                            type="number" 
                            :value="old('order', $organization->order ?? 0)" 
                            min="0"
                            help="Lower number = shown first"
                        />
                    </div>
                </x-admin.card>

                {{-- Photo --}}
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Profile Photo</h3>
                        
                        @if(isset($organization) && $organization->photo)
                            <div class="mb-3">
                                <img src="{{ $organization->photo_url }}" alt="" class="w-full h-48 object-cover rounded-lg">
                            </div>
                        @endif
                        
                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Recommended: Square image, max 5MB</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        {{-- Submit Buttons --}}
        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($organization) ? 'Update' : 'Create' }} Organization</x-admin.button>
        </div>
    </form>

    @if(!isset($organization))
        @push('scripts')
        <script>
            document.getElementById('add-gallery-btn').addEventListener('click', function() {
                const container = document.getElementById('gallery-items');
                const newItem = document.createElement('div');
                newItem.className = 'gallery-item p-4 border border-neutral-200 rounded-lg relative';
                newItem.innerHTML = `
                    <button type="button" class="remove-gallery-btn absolute top-2 right-2 p-1 text-red-500 hover:bg-red-50 rounded">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                        </svg>
                    </button>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Image</label>
                            <input type="file" name="gallery_images[]" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-neutral-100 file:text-neutral-700">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Title</label>
                            <input type="text" name="gallery_titles[]" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm">
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Event Type</label>
                            <select name="gallery_types[]" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm">
                                <option value="">Select</option>
                                <option value="lomba">Lomba</option>
                                <option value="kegiatan">Kegiatan</option>
                                <option value="rapat">Rapat</option>
                                <option value="pelatihan">Pelatihan</option>
                                <option value="lainnya">Lainnya</option>
                            </select>
                        </div>
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Event Date</label>
                            <input type="date" name="gallery_dates[]" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm">
                        </div>
                    </div>
                `;
                container.appendChild(newItem);
                
                newItem.querySelector('.remove-gallery-btn').addEventListener('click', function() {
                    newItem.remove();
                });
            });
        </script>
        @endpush
    @endif
@endsection