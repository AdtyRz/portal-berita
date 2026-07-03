@extends('admin.layouts.app')

@section('content')
@section('title', 'Banners')

    <x-admin.page-header title="Banners" description="Manage promotional banners">
        <x-admin.button href="{{ route('admin.banners.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Banner
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Banner</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Position</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Order</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($banners as $banner)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-16 h-10 rounded-lg bg-neutral-100 overflow-hidden shrink-0">
                            <img src="{{ asset('storage/' . $banner->image) }}" alt="" class="w-full h-full object-cover">
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate max-w-xs">{{ $banner->title }}</div>
                            @if($banner->link)
                                <div class="text-xs text-neutral-500 truncate max-w-xs">{{ $banner->link }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $positionVariants = ['header' => 'info', 'sidebar' => 'warning', 'footer' => 'neutral', 'popup' => 'danger'];
                    @endphp
                    <x-admin.badge :variant="$positionVariants[$banner->position]">{{ ucfirst($banner->position) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600 font-mono">{{ $banner->order }}</td>
                <td class="px-6 py-4">
                    @if($banner->status)
                        <x-admin.badge variant="success">Active</x-admin.badge>
                    @else
                        <x-admin.badge variant="neutral">Inactive</x-admin.badge>
                    @endif
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.banners.edit', $banner) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.banners.destroy', $banner) }}" onsubmit="return confirm('Delete this banner?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5"><x-admin.empty-state>@section('title', 'No banners found')<x-slot name="action"><x-admin.button href="{{ route('admin.banners.create') }}">Create Banner</x-admin.button></x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($banners->hasPages()) <div class="mt-6">{{ $banners->links() }}</div> @endif
@endsection