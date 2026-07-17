@extends('admin.layouts.app')

@section('content')
@section('title', 'Announcements')

    <x-admin.page-header title="Announcements" description="Manage school announcements">
        <x-admin.button href="{{ route('admin.announcements.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Announcement
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search announcements..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>
                <select name="priority" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Priority</option>
                    <option value="low" @selected(request('priority') === 'low')>Low</option>
                    <option value="medium" @selected(request('priority') === 'medium')>Medium</option>
                    <option value="high" @selected(request('priority') === 'high')>High</option>
                    <option value="urgent" @selected(request('priority') === 'urgent')>Urgent</option>
                </select>
                <div class="flex gap-2">
                    <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.announcements.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-800">Create New </a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Announcement</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Priority</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Date</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($announcements as $announcement)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-neutral-100 overflow-hidden shrink-0">
                            @if($announcement->thumbnail)
                                <img src="{{ $announcement->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate max-w-xs">{{ $announcement->title }}</div>
                            <div class="text-xs text-neutral-500">by {{ $announcement->author->name }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @php
                        $priorityVariants = ['low' => 'neutral', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
                    @endphp
                    <x-admin.badge :variant="$priorityVariants[$announcement->priority]">{{ ucfirst($announcement->priority) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    @php
                        $statusVariants = ['draft' => 'warning', 'published' => 'success', 'archived' => 'neutral'];
                    @endphp
                    <x-admin.badge :variant="$statusVariants[$announcement->status]">{{ ucfirst($announcement->status) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-500">{{ $announcement->publish_date?->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.announcements.edit', $announcement) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.announcements.destroy', $announcement) }}" onsubmit="return confirm('Delete this announcement?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5"><x-admin.empty-state>@section('title', 'No announcements found')<x-slot name="action"><x-admin.button href="{{ route('admin.announcements.create') }}">Create Announcement</x-admin.button></x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($announcements->hasPages()) <div class="mt-6">{{ $announcements->links() }}</div> @endif
@endsection