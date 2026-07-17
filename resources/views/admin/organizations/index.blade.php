@extends('admin.layouts.app')

@section('title', 'Organizations')

@section('content')
    <x-admin.page-header title="Organizations" description="Manage organization members">
        <x-slot name="action">
            <x-admin.button href="{{ route('admin.organizations.create') }}">
                <svg class="w-4 h-4 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                </svg>
                New Organization
            </x-admin.button>
        </x-slot>
    </x-admin.page-header>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Member</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Position</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Type</th>
            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-600 uppercase">Gallery</th>
            <th class="px-6 py-3 text-center text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($organizations as $org)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-full bg-neutral-100 overflow-hidden shrink-0">
                            @if($org->photo)
                                <img src="{{ $org->photo_url }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400 font-bold">
                                    {{ strtoupper(substr($org->name, 0, 1)) }}
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate">{{ $org->name }}</div>
                            <div class="text-xs text-neutral-500 truncate">{{ $org->slug }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600">{{ $org->position ?? '-' }}</td>
                <td class="px-6 py-4">
                    @if($org->organization_type)
                        <x-admin.badge variant="neutral">{{ ucfirst($org->organization_type) }}</x-admin.badge>
                    @else
                        <span class="text-xs text-neutral-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-center">
                    <a href="{{ route('admin.organizations.gallery.index', $org) }}" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium text-neutral-700 bg-neutral-100 rounded hover:bg-neutral-200">
                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $org->galleries_count }}
                    </a>
                </td>
                <td class="px-6 py-4 text-center">
                    <x-admin.badge :variant="$org->status ? 'success' : 'neutral'">
                        {{ $org->status ? 'Active' : 'Inactive' }}
                    </x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.organizations.gallery.index', $org) }}" 
                           class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100"
                           title="Manage Gallery">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </a>
                        <a href="{{ route('admin.organizations.edit', $org) }}" 
                           class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.organizations.destroy', $org) }}" onsubmit="return confirm('Delete this organization?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                                </svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr>
                <td colspan="6">
                    <x-admin.empty-state>
                        <x-slot name="title">No organizations yet</x-slot>
                        <x-slot name="action">
                            <x-admin.button href="{{ route('admin.organizations.create') }}">Create Organization</x-admin.button>
                        </x-slot>
                    </x-admin.empty-state>
                </td>
            </tr>
        @endforelse
    </x-admin.table>

    @if($organizations->hasPages())
        <div class="mt-6">{{ $organizations->links() }}</div>
    @endif
@endsection