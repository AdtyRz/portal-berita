@extends('admin.layouts.app')

@section('title', isset($gallery) ? 'Edit Gallery' : 'Add Gallery')

@section('content')
    <x-admin.page-header 
        title="{{ isset($gallery) ? 'Edit' : 'Add' }} Gallery Item" 
        description="Organization: {{ $organization->name }}" 
    />

    <form method="POST" 
          action="{{ isset($gallery) ? route('admin.organizations.gallery.update', [$organization, $gallery]) : route('admin.organizations.gallery.store', $organization) }}" 
          enctype="multipart/form-data" 
          class="space-y-6">
        @csrf
        @if(isset($gallery)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $gallery->title ?? '')" required placeholder="e.g. Lomba Cerdas Cermat 2026" />
                        
                        <x-admin.textarea label="Description" name="description" :value="old('description', $gallery->description ?? '')" rows="3" placeholder="Brief description of the event..." />
                        
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">
                                Image <span class="text-red-500">*</span>
                            </label>
                            @if(isset($gallery) && $gallery->image)
                                <div class="mb-3">
                                    <img src="{{ $gallery->image_url }}" alt="" class="w-full h-48 object-cover rounded-lg">
                                </div>
                            @endif
                            <input type="file" name="image" accept="image/*" @if(!isset($gallery)) required @endif class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                            <p class="mt-1 text-xs text-neutral-500">Recommended: Landscape, max 5MB</p>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Event Details</h3>
                        
                        <x-admin.select 
                            label="Event Type" 
                            name="event_type" 
                            :options="['' => 'Select Type', 'lomba' => 'Lomba', 'kegiatan' => 'Kegiatan', 'rapat' => 'Rapat', 'pelatihan' => 'Pelatihan', 'sosial' => 'Bakti Sosial', 'lainnya' => 'Lainnya']" 
                            :value="old('event_type', $gallery->event_type ?? '')" 
                        />
                        
                        <x-admin.input 
                            label="Event Date" 
                            name="event_date" 
                            type="date" 
                            :value="old('event_date', isset($gallery) && $gallery->event_date ? $gallery->event_date->format('Y-m-d') : '')" 
                        />
                        
                        <x-admin.input 
                            label="Location" 
                            name="location" 
                            :value="old('location', $gallery->location ?? '')" 
                            placeholder="e.g. Aula Sekolah" 
                        />
                        
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_featured" value="0">
                            <input type="checkbox" name="is_featured" value="1" id="is_featured" @checked(old('is_featured', $gallery->is_featured ?? false)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="is_featured" class="text-sm text-neutral-700">Featured (shown first)</label>
                        </div>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.organizations.gallery.index', $organization) }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($gallery) ? 'Update' : 'Add' }} Photo</x-admin.button>
        </div>
    </form>
@endsection