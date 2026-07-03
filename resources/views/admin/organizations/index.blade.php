@extends('admin.layouts.app')

@section('content')
@section('title', 'Organizations')

    <x-admin.page-header title="Organizations" description="Manage school organizations and staff">
        <x-admin.button href="{{ route('admin.organizations.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Organization
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="type" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Types</option>
                    <option value="structural" @selected(request('type') === 'structural')>Structural</option>
                    <option value="student" @selected(request('type') === 'student')>Student</option>
                    <option value="extracurricular" @selected(request('type') === 'extracurricular')>Extracurricular</option>
                </select>
                <div class="flex gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($organizations as $org)
            <x-admin.card class="p-6 text-center hover:shadow-md transition-shadow">
                <div class="w-20 h-20 rounded-full bg-neutral-100 mx-auto mb-4 overflow-hidden">
                    @if($org->photo)
                        <img src="{{ asset('storage/' . $org->photo) }}" alt="{{ $org->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-full h-full flex items-center justify-center text-neutral-400">
                            <svg class="w-8 h-8" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                            </svg>
                        </div>
                    @endif
                </div>
                <h3 class="text-base font-semibold text-neutral-900 mb-1">{{ $org->name }}</h3>
                @if($org->position)
                    <p class="text-sm text-neutral-500 mb-3">{{ $org->position }}</p>
                @endif
                @php
                    $typeVariants = ['structural' => 'info', 'student' => 'success', 'extracurricular' => 'warning'];
                @endphp
                <x-admin.badge :variant="$typeVariants[$org->organization_type]" size="sm">{{ ucfirst($org->organization_type) }}</x-admin.badge>

                <div class="flex items-center justify-center gap-2 mt-4 pt-4 border-t border-neutral-100">
                    <a href="{{ route('admin.organizations.edit', $org) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                    </a>
                    <form method="POST" action="{{ route('admin.organizations.destroy', $org) }}" onsubmit="return confirm('Delete?');">
                        @csrf @method('DELETE')
                        <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                        </button>
                    </form>
                </div>
            </x-admin.card>
        @empty
            <div class="col-span-full">
                <x-admin.card>
                    <x-admin.empty-state>
                        @section('title', 'No organizations found')
                        <x-slot name="action">
                            <x-admin.button href="{{ route('admin.organizations.create') }}">Create Organization</x-admin.button>
                        </x-slot>
                    </x-admin.empty-state>
                </x-admin.card>
            </div>
        @endforelse
    </div>

    @if($organizations->hasPages()) <div class="mt-6">{{ $organizations->links() }}</div> @endif
@endsection