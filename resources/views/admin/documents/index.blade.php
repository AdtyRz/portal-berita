@extends('admin.layouts.app')

@section('content')
@section('title', 'Documents')

    <x-admin.page-header title="Documents" description="Manage downloadable documents">
        <x-admin.button href="{{ route('admin.documents.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Document
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search documents..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="category" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Categories</option>
                    <option value="academic" @selected(request('category') === 'academic')>Academic</option>
                    <option value="administrative" @selected(request('category') === 'administrative')>Administrative</option>
                    <option value="regulation" @selected(request('category') === 'regulation')>Regulation</option>
                    <option value="form" @selected(request('category') === 'form')>Form</option>
                    <option value="other" @selected(request('category') === 'other')>Other</option>
                </select>
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>
                <div class="flex gap-2">
                    <a href="{{ route('admin.documents.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.documents.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-800">Create New </a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Document</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Category</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Size</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Downloads</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($documents as $document)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate max-w-xs">{{ $document->title }}</div>
                            <div class="text-xs text-neutral-500 font-mono">{{ strtoupper($document->file_type ?? 'PDF') }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge variant="neutral">{{ ucfirst($document->category) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600">{{ $document->file_size_formatted }}</td>
                <td class="px-6 py-4">
                    <div class="flex items-center gap-1 text-sm text-neutral-600">
                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                        </svg>
                        {{ number_format($document->download_count) }}
                    </div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $statusVariants = ['draft' => 'warning', 'published' => 'success', 'archived' => 'neutral'];
                    @endphp
                    <x-admin.badge :variant="$statusVariants[$document->status]">{{ ucfirst($document->status) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.documents.edit', $document) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.documents.destroy', $document) }}" onsubmit="return confirm('Delete this document?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><x-admin.empty-state>@section('title', 'No documents found')<x-slot name="action"><x-admin.button href="{{ route('admin.documents.create') }}">Create Document</x-admin.button></x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($documents->hasPages()) <div class="mt-6">{{ $documents->links() }}</div> @endif
@endsection