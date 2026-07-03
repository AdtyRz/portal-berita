<x-admin.layouts.app>
    <x-slot name="title">Achievements</x-slot>

    <x-admin.page-header title="Achievements" description="Manage student and school achievements">
        <x-admin.button href="{{ route('admin.achievements.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Achievement
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search achievements..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="level" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Levels</option>
                    <option value="school" @selected(request('level') === 'school')>School</option>
                    <option value="district" @selected(request('level') === 'district')>District</option>
                    <option value="city" @selected(request('level') === 'city')>City</option>
                    <option value="province" @selected(request('level') === 'province')>Province</option>
                    <option value="national" @selected(request('level') === 'national')>National</option>
                    <option value="international" @selected(request('level') === 'international')>International</option>
                </select>
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="draft" @selected(request('status') === 'draft')>Draft</option>
                    <option value="published" @selected(request('status') === 'published')>Published</option>
                    <option value="archived" @selected(request('status') === 'archived')>Archived</option>
                </select>
                <div class="flex gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.achievements.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Achievement</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Level</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Rank</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Date</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($achievements as $achievement)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 rounded-lg bg-neutral-100 overflow-hidden shrink-0">
                            @if($achievement->thumbnail)
                                <img src="{{ $achievement->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5"><path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" /></svg>
                                </div>
                            @endif
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate max-w-xs">{{ $achievement->title }}</div>
                            @if($achievement->achiever_name)
                                <div class="text-xs text-neutral-500">{{ $achievement->achiever_name }}</div>
                            @endif
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    <x-admin.badge variant="info">{{ ucfirst($achievement->level) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4">
                    @if($achievement->rank)
                        <x-admin.badge variant="success">{{ $achievement->rank }}</x-admin.badge>
                    @else
                        <span class="text-sm text-neutral-400">-</span>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-neutral-500">{{ $achievement->achievement_date?->format('M d, Y') }}</td>
                <td class="px-6 py-4">
                    @php
                        $statusVariants = ['draft' => 'warning', 'published' => 'success', 'archived' => 'neutral'];
                    @endphp
                    <x-admin.badge :variant="$statusVariants[$achievement->status]">{{ ucfirst($achievement->status) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.achievements.edit', $achievement) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.achievements.destroy', $achievement) }}" onsubmit="return confirm('Delete this achievement?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="6"><x-admin.empty-state><x-slot name="title">No achievements found</x-slot><x-slot name="action"><x-admin.button href="{{ route('admin.achievements.create') }}">Create Achievement</x-admin.button></x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($achievements->hasPages()) <div class="mt-6">{{ $achievements->links() }}</div> @endif
</x-admin.layouts.app>
