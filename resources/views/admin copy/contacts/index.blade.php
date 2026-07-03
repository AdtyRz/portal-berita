<x-admin.layouts.app>
    <x-slot name="title">Contacts</x-slot>

    <x-admin.page-header title="Contact Messages" description="Manage incoming contact form submissions" />

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search by name, email, or subject..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="unread" @selected(request('status') === 'unread')>Unread</option>
                </select>
                <div class="flex gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.contacts.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <div class="space-y-3">
        @forelse($contacts as $contact)
            <x-admin.card class="hover:shadow-md transition-shadow {{ !$contact->is_read ? 'border-l-4 border-l-blue-500' : '' }}">
                <a href="{{ route('admin.contacts.show', $contact) }}" class="block p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-10 h-10 rounded-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center text-white text-sm font-bold shrink-0">
                                    {{ strtoupper(substr($contact->name, 0, 1)) }}
                                </div>
                                <div class="min-w-0">
                                    <div class="text-sm font-semibold text-neutral-900 truncate">{{ $contact->name }}</div>
                                    <div class="text-xs text-neutral-500 truncate">{{ $contact->email }}</div>
                                </div>
                                @if(!$contact->is_read)
                                    <x-admin.badge variant="info" size="xs">New</x-admin.badge>
                                @endif
                                @if($contact->is_replied)
                                    <x-admin.badge variant="success" size="xs">Replied</x-admin.badge>
                                @endif
                            </div>
                            @if($contact->subject)
                                <h4 class="text-base font-semibold text-neutral-900 mb-1">{{ $contact->subject }}</h4>
                            @endif
                            <p class="text-sm text-neutral-600 line-clamp-2">{{ $contact->message }}</p>
                            <div class="flex items-center gap-3 mt-3 text-xs text-neutral-500">
                                <span>{{ $contact->created_at->diffForHumans() }}</span>
                                @if($contact->phone)
                                    <span class="flex items-center gap-1">
                                        <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" /></svg>
                                        {{ $contact->phone }}
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>
                </a>
            </x-admin.card>
        @empty
            <x-admin.card>
                <x-admin.empty-state>
                    <x-slot name="title">No messages found</x-slot>
                    <x-slot name="description">Contact form submissions will appear here.</x-slot>
                </x-admin.empty-state>
            </x-admin.card>
        @endforelse
    </div>

    @if($contacts->hasPages()) <div class="mt-6">{{ $contacts->links() }}</div> @endif
</x-admin.layouts.app>
