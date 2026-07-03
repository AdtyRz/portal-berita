<x-admin.layouts.app>
    <x-slot name="title">Tags</x-slot>

    <x-admin.page-header title="Tags" description="Manage content tags">
        <x-admin.button href="{{ route('admin.tags.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Tag
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="flex gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search tags..." class="flex-1 px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <x-admin.button type="submit">Filter</x-admin.button>
                <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Name</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Slug</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Posts</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($tags as $tag)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-2">
                        <span class="w-3 h-3 rounded-full" style="background-color: {{ $tag->color ?? '#6b7280' }}"></span>
                        <span class="text-sm font-semibold text-neutral-900">{{ $tag->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600 font-mono">{{ $tag->slug }}</td>
                <td class="px-6 py-4 text-sm font-medium text-neutral-900">{{ $tag->posts_count }}</td>
                <td class="px-6 py-4">
                    <x-admin.badge :variant="$tag->status ? 'success' : 'neutral'">{{ $tag->status ? 'Active' : 'Inactive' }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.tags.edit', $tag) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        <form method="POST" action="{{ route('admin.tags.destroy', $tag) }}" onsubmit="return confirm('Delete this tag?');">
                            @csrf @method('DELETE')
                            <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                            </button>
                        </form>
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5"><x-admin.empty-state><x-slot name="title">No tags found</x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($tags->hasPages()) <div class="mt-6">{{ $tags->links() }}</div> @endif
</x-admin.layouts.app>
