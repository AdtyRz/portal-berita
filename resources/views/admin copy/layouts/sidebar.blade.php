<aside class="hidden lg:flex lg:flex-col lg:fixed lg:inset-y-0 lg:w-72 bg-white border-r border-neutral-200/80">
    {{-- Logo --}}
    <div class="flex items-center h-16 px-6 border-b border-neutral-200/80">
        <a href="{{ route('dashboard') }}" class="flex items-center gap-3">
            <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-neutral-900 to-neutral-700 flex items-center justify-center">
                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
            </div>
            <div>
                <div class="font-heading font-bold text-neutral-900 text-base" style="font-family: var(--font-heading);">School Portal</div>
                <div class="text-xs text-neutral-500">Administration</div>
            </div>
        </a>
    </div>

    {{-- Navigation --}}
    <nav class="flex-1 overflow-y-auto px-4 py-6">
        <div class="space-y-6">
            {{-- Main --}}
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Main</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="route('dashboard')"
                        :active="request()->routeIs('dashboard')"
                        icon="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"
                    >
                        Dashboard
                    </x-admin.sidebar-item>
                </ul>
            </div>

            {{-- Content --}}
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Content</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.posts.*')"
                        icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                    >
                        Posts
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.announcements.*')"
                        icon="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                    >
                        Announcements
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.agendas.*')"
                        icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                    >
                        Agendas
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.achievements.*')"
                        icon="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                    >
                        Achievements
                    </x-admin.sidebar-item>
                </ul>
            </div>

            {{-- Media --}}
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Media</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.galleries.*')"
                        icon="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    >
                        Galleries
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.videos.*')"
                        icon="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"
                    >
                        Videos
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.documents.*')"
                        icon="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"
                    >
                        Documents
                    </x-admin.sidebar-item>
                </ul>
            </div>

            {{-- Website --}}
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Website</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.categories.*')"
                        icon="M7 7h.01M7 3h5c.512 0 1.024.195 1.414.586l7 7a2 2 0 010 2.828l-7 7a2 2 0 01-2.828 0l-7-7A1.994 1.994 0 013 12V7a4 4 0 014-4z"
                    >
                        Categories
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.tags.*')"
                        icon="M7 20l4-16m2 16l4-16M6 9h14M4 15h14"
                    >
                        Tags
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.hero-sliders.*')"
                        icon="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"
                    >
                        Hero Sliders
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.organizations.*')"
                        icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                    >
                        Organizations
                    </x-admin.sidebar-item>
                </ul>
            </div>

            {{-- Interaction --}}
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Interaction</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.comments.*')"
                        icon="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.57 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                    >
                        Comments
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.contacts.*')"
                        icon="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                    >
                        Contacts
                    </x-admin.sidebar-item>
                </ul>
            </div>

            {{-- Administration --}}
            @role('super-admin')
            <div>
                <div class="px-3 mb-2 text-xs font-semibold text-neutral-400 uppercase tracking-wider">Administration</div>
                <ul class="space-y-1">
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.users.*')"
                        icon="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"
                    >
                        Users
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.roles.*')"
                        icon="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"
                    >
                        Roles & Permissions
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.settings.*')"
                        icon="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z M15 12a3 3 0 11-6 0 3 3 0 016 0z"
                    >
                        Settings
                    </x-admin.sidebar-item>
                    <x-admin.sidebar-item
                        :href="'#'"
                        :active="request()->routeIs('admin.activity-logs.*')"
                        icon="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01"
                    >
                        Activity Logs
                    </x-admin.sidebar-item>
                </ul>
            </div>
            @endrole
        </div>
    </nav>

    {{-- User Profile --}}
    <div class="border-t border-neutral-200/80 p-4">
        <div class="flex items-center gap-3 p-2 rounded-xl hover:bg-neutral-50 transition-colors">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-neutral-800 to-neutral-600 flex items-center justify-center text-white font-semibold text-sm">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-semibold text-neutral-900 truncate">{{ auth()->user()->name }}</div>
                <div class="text-xs text-neutral-500 truncate">{{ auth()->user()->email }}</div>
            </div>
            <form method="POST" action="{{ route('logout') }}" class="shrink-0">
                @csrf
                <button type="submit" class="p-1.5 rounded-lg text-neutral-400 hover:text-neutral-900 hover:bg-neutral-100 transition-colors" title="Logout">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                    </svg>
                </button>
            </form>
        </div>
    </div>
</aside>
