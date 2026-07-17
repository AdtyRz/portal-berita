@extends('admin.layouts.app')

@section('content')
@section('title', 'Categories')

    <x-admin.page-header
        title="Categories"
        description="Manage your content categories"
    >
        <x-admin.button href="{{ route('admin.categories.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
            </svg>
            New Category
        </x-admin.button>
    </x-admin.page-header>

    {{-- Filters --}}
    <x-admin.card class="mb-6">
        <form method="GET" action="{{ route('admin.categories.index') }}" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <input type="text" name="search" value="{{ request('search') }}"
                           placeholder="Search categories..."
                           class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                </div>
                <div>
                    <select name="status" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                        <option value="">All Status</option>
                        <option value="active" @selected(request('status') === 'active')>Active</option>
                        <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                    </select>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('admin.categories.index') }}" class="inline-flex items-center justify-center px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">
                        Reset
                    </a>
                    <x-admin.button type="submit" variant="primary">Filter</x-admin.button>
                    <a href="{{ route('admin.categories.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-800">Create New </a>
                </div>
            </div>
        </form>
    </x-admin.card>

    {{-- Table --}}
    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Name</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Slug</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Posts</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Status</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase tracking-wider">Order</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase tracking-wider">Actions</th>
        </x-slot>

        @forelse($categories as $category)
            <tr class="hover:bg-neutral-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        @if($category->icon)
                            <div class="w-10 h-10 rounded-lg flex items-center justify-center text-white text-sm font-semibold" style="background-color: {{ $category->color ?? '#6b7280' }}">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                        @else
                            <div class="w-10 h-10 rounded-lg bg-neutral-100 flex items-center justify-center text-neutral-600 text-sm font-semibold">
                                {{ substr($category->name, 0, 1) }}
                            </div>
                        @endif
                        <div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $category->name }}</div>
                            @if($category->description)
                                <div class="text-xs text-neutral-500 mt-0.5">{{ Str::limit($category->description, 50) }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600 font-mono">{{ $category->slug }}</td>
                <td class="px-6 py-4">
                    <span class="text-sm font-medium text-neutral-900">{{ $category->posts_count ?? $category->posts()->count() }}</span>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge :variant="$category->status ? 'success' : 'neutral'">
                        {{ $category->status ? 'Active' : 'Inactive' }}
                    </x-admin.badge>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600">{{ $category->order }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.categories.edit', $category) }}"
                           class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100 transition-colors"
                           title="Edit">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" />
                            </svg>
                        </a>
                        <form method="POST" action="{{ route('admin.categories.destroy', $category) }}"
                              onsubmit="return confirm('Are you sure you want to delete this category?');"
                              class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit"
                                    class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50 transition-colors"
                                    title="Delete">
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
                        @section('title', 'No categories found')
                        <x-slot name="description">Get started by creating your first category.</x-slot>
                        <x-slot name="action">
                            <x-admin.button href="{{ route('admin.categories.create') }}">Create Category</x-admin.button>
                        </x-slot>
                    </x-admin.empty-state>
                </td>
            </tr>
        @endforelse
    </x-admin.table>

    {{-- Pagination --}}
    @if($categories->hasPages())
        <div class="mt-6">
            {{ $categories->links() }}
        </div>
    @endif
@endsection