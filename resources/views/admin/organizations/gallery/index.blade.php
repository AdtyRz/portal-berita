@extends('admin.layouts.app')

@section('title', 'Gallery - ' . $organization->name)

@section('content')
    <x-admin.page-header title="Gallery: {{ $organization->name }}" description="Manage organization activities and events">
        <x-slot name="action">
            <div class="flex items-center gap-2">
                <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">
                    ← Back
                </a>
                <x-admin.button href="{{ route('admin.organizations.gallery.create', $organization) }}">
                    <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                    </svg>
                    Add Photo
                </x-admin.button>
            </div>
        </x-slot>
    </x-admin.page-header>

    {{-- Stats --}}
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-6">
        <x-admin.stat-card label="Total Photos" :value="$organization->galleries->count()" color="primary" />
        <x-admin.stat-card label="Featured" :value="$organization->featuredGalleries->count()" color="warning" />
        <x-admin.stat-card label="This Year" :value="$organization->galleries()->whereYear('event_date', now()->year)->count()" color="success" />
    </div>

    {{-- Gallery Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-4">
        @forelse($galleries as $gallery)
            <div class="bg-white border border-neutral-200 rounded-xl overflow-hidden hover:shadow-lg transition-shadow">
                <div class="aspect-video bg-neutral-100 relative overflow-hidden">
                    <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                    @if($gallery->is_featured)
                        <span class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-amber-700 bg-amber-100 rounded">
                            ★ Featured
                        </span>
                    @endif
                    @if($gallery->event_type)
                        <span class="absolute bottom-2 left-2 px-2 py-1 text-xs font-medium text-white bg-black/50 backdrop-blur rounded">
                            {{ ucfirst($gallery->event_type) }}
                        </span>
                    @endif
                </div>
                <div class="p-4">
                    <h3 class="text-sm font-semibold text-neutral-900 truncate">{{ $gallery->title }}</h3>
                    @if($gallery->event_date)
                        <p class="text-xs text-neutral-500 mt-1">{{ $gallery->event_date->format('M d, Y') }}</p>
                    @endif
                    @if($gallery->location)
                        <p class="text-xs text-neutral-500 mt-0.5 truncate">{{ $gallery->location }}</p>
                    @endif
                    
                    <div class="flex items-center gap-2 mt-3 pt-3 border-t border-neutral-100">
                        <a href="{{ route('admin.organizations.gallery.edit', [$organization, $gallery]) }}" 
                           class="flex-1 inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-neutral-700 bg-neutral-100 rounded hover:bg-neutral-200">
                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                            Edit
                        </a>
                        <form method="POST" action="{{ route('admin.organizations.gallery.destroy', [$organization, $gallery]) }}" 
                              onsubmit="return confirm('Delete this photo?');" class="flex-1">
                            @csrf @method('DELETE')
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-1 px-3 py-1.5 text-xs font-medium text-red-700 bg-red-50 rounded hover:bg-red-100">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                                Delete
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-span-full">
                <x-admin.empty-state>
                    <x-slot name="title">No gallery items yet</x-slot>
                    <x-slot name="description">Start adding photos of organization activities</x-slot>
                    <x-slot name="action">
                        <x-admin.button href="{{ route('admin.organizations.gallery.create', $organization) }}">Add First Photo</x-admin.button>
                    </x-slot>
                </x-admin.empty-state>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages())
        <div class="mt-6">{{ $galleries->links() }}</div>
    @endif
@endsection