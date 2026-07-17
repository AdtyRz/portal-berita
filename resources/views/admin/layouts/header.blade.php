<header class="sticky top-0 z-30 bg-white/80 dark:bg-neutral-900/80 backdrop-blur-xl border-b border-neutral-200 dark:border-neutral-800 transition-colors duration-300">
    <div class="flex items-center justify-between h-16 px-6">
        {{-- Left: Mobile menu toggle + Page Title --}}
        <div class="flex items-center gap-4">
            {{-- Mobile menu toggle --}}
            <button type="button" class="lg:hidden p-2 rounded-lg text-neutral-500 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors" x-data @click="$dispatch('toggle-sidebar')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Page Title Section --}}
            <div class="hidden sm:block">
                <h1 class="text-xl font-bold text-black-600 dark:text-white-400" style="font-family: var(--font-heading);">
                    @yield('title','Dashboard')
                </h1>
                <p class="text-xs text-neutral-500 dark:text-neutral-400">
                    @yield('page-subtitle', 'Welcome back, ' . auth()->user()->name)
                </p>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-4">
            {{-- Visit Site --}}
            <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-neutral-700 dark:text-neutral-300 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Visit Site
            </a>

            {{-- 1. NOTIFICATION DROPDOWN --}}
            <div class="relative" x-data="{
                open: false,
                notifications: {{ Js::from($headerNotifications ?? []) }},
                unreadCount: {{ Js::from($unreadNotificationCount ?? 0) }},
                async markAsRead() {
                    if (this.unreadCount > 0) {
                        await fetch('{{ route('admin.notifications.mark-read') }}', {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                'Accept': 'application/json'
                            }
                        });
                        this.unreadCount = 0;
                        this.notifications.forEach(n => n.is_read = true);
                    }
                }
            }">
                <button @click="open = !open; if(open) markAsRead()" 
                    class="relative p-2 text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                    <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                    </svg>
                    <span x-show="unreadCount > 0" x-transition
                        class="absolute top-1.5 right-1.5 min-w-[18px] h-[18px] flex items-center justify-center text-[10px] font-bold text-white bg-red-500 rounded-full border-2 border-white dark:border-neutral-900"
                        x-text="unreadCount > 9 ? '9+' : unreadCount"></span>
                </button>

                {{-- Dropdown Panel --}}
                <div x-show="open" @click.away="open = false" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-80 bg-white dark:bg-neutral-900 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-800 z-50 overflow-hidden">

                    <div class="p-4 border-b border-neutral-100 dark:border-neutral-800 flex items-center justify-between">
                        <h3 class="text-sm font-semibold text-neutral-900 dark:text-white">Notifications</h3>
                        <span class="text-xs text-neutral-500 bg-neutral-100 dark:bg-neutral-800 px-2 py-0.5 rounded-full" x-text="unreadCount + ' New'"></span>
                    </div>

                    <div class="max-h-96 overflow-y-auto">
                        <template x-if="notifications.length === 0">
                            <div class="p-8 text-center text-sm text-neutral-500">No new notifications</div>
                        </template>

                        <template x-for="notif in notifications" :key="notif.id">
                            <a :href="notif.url" class="block p-4 hover:bg-neutral-50 dark:hover:bg-neutral-800 transition-colors border-b border-neutral-50 dark:border-neutral-800" :class="{ 'bg-blue-50/50 dark:bg-blue-900/10': !notif.is_read }">
                                <div class="flex gap-3">
                                    <div class="w-8 h-8 rounded-full flex items-center justify-center shrink-0"
                                         :class="notif.type === 'comment' ? 'bg-blue-100 text-blue-600' : 'bg-green-100 text-green-600'">
                                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path x-show="notif.type === 'comment'" stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                                            <path x-show="notif.type === 'message'" stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div>
                                        <p class="text-sm font-medium text-neutral-900 dark:text-white" x-text="notif.title"></p>
                                        <p class="text-xs text-neutral-500 mt-1" x-text="notif.message"></p>
                                        <p class="text-xs text-neutral-400 mt-1" x-text="notif.time"></p>
                                    </div>
                                </div>
                            </a>
                        </template>
                    </div>
                </div>
            </div>

            {{-- 2. DARK MODE TOGGLE --}}
            <button x-data="{
                darkMode: localStorage.getItem('color-theme') === 'dark' || (!('color-theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches),
                toggle() {
                    this.darkMode = !this.darkMode;
                    if (this.darkMode) {
                        document.documentElement.classList.add('dark');
                        localStorage.setItem('color-theme', 'dark');
                    } else {
                        document.documentElement.classList.remove('dark');
                        localStorage.setItem('color-theme', 'light');
                    }
                }
            }" x-init="$watch('darkMode', val => val ? document.documentElement.classList.add('dark') : document.documentElement.classList.remove('dark')); if(darkMode) document.documentElement.classList.add('dark');"
            @click="toggle()"
            class="p-2 text-neutral-500 dark:text-neutral-400 hover:text-neutral-900 dark:hover:text-white hover:bg-neutral-100 dark:hover:bg-neutral-800 rounded-lg transition-colors">
                <svg x-show="darkMode" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M10 2a1 1 0 011 1v1a1 1 0 11-2 0V3a1 1 0 011-1zm4 8a4 4 0 11-8 0 4 4 0 018 0zm-.464 4.95l.707.707a1 1 0 001.414-1.414l-.707-.707a1 1 0 00-1.414 1.414zm2.12-10.607a1 1 0 010 1.414l-.706.707a1 1 0 11-1.414-1.414l.707-.707a1 1 0 011.414 0zM17 11a1 1 0 100-2h-1a1 1 0 100 2h1zm-7 4a1 1 0 011 1v1a1 1 0 11-2 0v-1a1 1 0 011-1zM5.05 6.464A1 1 0 106.465 5.05l-.708-.707a1 1 0 00-1.414 1.414l.707.707zm1.414 8.486l-.707.707a1 1 0 01-1.414-1.414l.707-.707a1 1 0 011.414 1.414zM4 11a1 1 0 100-2H3a1 1 0 000 2h1z" fill-rule="evenodd" clip-rule="evenodd"></path>
                </svg>
                <svg x-show="!darkMode" class="w-6 h-6" fill="currentColor" viewBox="0 0 20 20">
                    <path d="M17.293 13.293A8 8 0 016.707 2.707a8.001 8.001 0 1010.586 10.586z"></path>
                </svg>
            </button>

            {{-- 3. PROFILE DROPDOWN --}}
            <div class="relative" x-data="{ open: false }">
                <button @click="open = !open" class="flex items-center gap-2 p-1 rounded-lg hover:bg-neutral-100 dark:hover:bg-neutral-800 transition-colors">
                    <div class="w-8 h-8 rounded-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center text-white text-xs font-bold">
                        {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
                    </div>
                    <svg class="w-4 h-4 text-neutral-500" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7" />
                    </svg>
                </button>

                <div x-show="open" @click.away="open = false" x-cloak
                    x-transition:enter="transition ease-out duration-200"
                    x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                    x-transition:leave="transition ease-in duration-150"
                    x-transition:leave-start="opacity-100 scale-100" x-transition:leave-end="opacity-0 scale-95"
                    class="absolute right-0 mt-2 w-48 bg-white dark:bg-neutral-900 rounded-xl shadow-xl border border-neutral-200 dark:border-neutral-800 z-50 py-1">
                    <a href="{{ route('profile.edit') }}" class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">Profile</a>
                    
                    <div class="border-t border-neutral-100 dark:border-neutral-800 my-1"></div>
                    <a href="{{ route('lang.switch', 'id') }}" class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">🇮🇩 Indonesia</a>
                    <a href="{{ route('lang.switch', 'en') }}" class="block px-4 py-2 text-sm text-neutral-700 dark:text-neutral-300 hover:bg-neutral-50 dark:hover:bg-neutral-800">🇬🇧 English</a>

                    <div class="border-t border-neutral-100 dark:border-neutral-800 my-1"></div>
                    <form method="POST" action="{{ route('logout') }}">
                        @csrf
                        <button type="submit" class="w-full text-left px-4 py-2 text-sm text-red-600 hover:bg-red-50 dark:hover:bg-red-900/20">
                            Log Out
                        </button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</header>