@extends('admin.layouts.app')

@section('content')
@section('title', 'Galleries')

    <x-admin.page-header title="Galleries" description="Manage photo galleries">
        <x-admin.button href="{{ route('admin.galleries.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Gallery
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search galleries..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>
                <div class="flex gap-2">
                    <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.galleries.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-800">Create New </a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($galleries as $gallery)
            <x-admin.card class="overflow-hidden group hover:shadow-md transition-shadow">
                <div class="aspect-video bg-neutral-100 overflow-hidden">
                    @if($gallery->cover_image)
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-neutral-400">
                            <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-base font-semibold text-neutral-900 line-clamp-1">{{ $gallery->title }}</h3>
                        @php
                            $statusVariants = ['draft' => 'warning', 'published' => 'success', 'archived' => 'neutral'];
                        @endphp
                        <x-admin.badge :variant="$statusVariants[$gallery->status]" size="xs">{{ ucfirst($gallery->status) }}</x-admin.badge>
                    </div>
                    @if($gallery->description)
                        <p class="text-sm text-neutral-500 line-clamp-2 mb-3">{{ $gallery->description }}</p>
                    @endif
                    <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                        <div class="flex items-center gap-1.5 text-xs text-neutral-500">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            {{ $gallery->items_count ?? 0 }} photos
                        </div>
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.galleries.edit', $gallery) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.galleries.destroy', $gallery) }}" onsubmit="return confirm('Delete this gallery?');">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </x-admin.card>
        @empty
            <div class="col-span-full">
                <x-admin.card>
                    <x-admin.empty-state>
                        @section('title', 'No galleries found')
                        <x-slot name="description">Create your first gallery to showcase photos.</x-slot>
                        <x-slot name="action">
                            <x-admin.button href="{{ route('admin.galleries.create') }}">Create Gallery</x-admin.button>
                        </x-slot>
                    </x-admin.empty-state>
                </x-admin.card>
            </div>
        @endforelse
    </div>

    @if($galleries->hasPages()) <div class="mt-6">{{ $galleries->links() }}</div> @endif
@endsection