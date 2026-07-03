<header class="sticky top-0 z-30 bg-white/80 backdrop-blur-xl border-b border-neutral-200/80">
    <div class="flex items-center justify-between h-16 px-6">
        {{-- Left: Mobile menu toggle --}}
        <div class="flex items-center gap-3">
            <button type="button" class="lg:hidden p-2 rounded-lg text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 transition-colors"
                    x-data @click="$dispatch('toggle-sidebar')">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>

            {{-- Search --}}
            <div class="hidden md:flex items-center gap-2 px-3 py-1.5 rounded-lg bg-neutral-100/80 border border-transparent focus-within:border-neutral-300 focus-within:bg-white transition-all w-72">
                <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                </svg>
                <input type="text" placeholder="Search..." class="bg-transparent border-0 outline-none text-sm text-neutral-900 placeholder:text-neutral-400 w-full">
                <kbd class="hidden lg:inline-flex items-center px-1.5 py-0.5 text-[10px] font-mono text-neutral-400 bg-white rounded border border-neutral-200">⌘K</kbd>
            </div>
        </div>

        {{-- Right: Actions --}}
        <div class="flex items-center gap-2">
            {{-- Visit Site --}}
            <a href="{{ url('/') }}" target="_blank" class="hidden sm:inline-flex items-center gap-2 px-3 py-1.5 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-neutral-100 rounded-lg transition-colors">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" />
                </svg>
                Visit Site
            </a>

            {{-- Notifications --}}
            <button type="button" class="relative p-2 rounded-lg text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 transition-colors">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9" />
                </svg>
                <span class="absolute top-1.5 right-1.5 w-2 h-2 bg-red-500 rounded-full"></span>
            </button>

            {{-- Theme Toggle --}}
            <button type="button" class="p-2 rounded-lg text-neutral-500 hover:text-neutral-900 hover:bg-neutral-100 transition-colors"
                    x-data="{ dark: false }"
                    x-init="dark = localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)"
                    @click="dark = !dark; localStorage.theme = dark ? 'dark' : 'light'; document.documentElement.classList.toggle('dark', dark)">
                <svg x-show="!dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M20.354 15.354A9 9 0 018.646 3.646 9.003 9.003 0 0012 21a9.003 9.003 0 008.354-5.646z" />
                </svg>
                <svg x-show="dark" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 3v1m0 16v1m9-9h-1M4 12H3m15.364 6.364l-.707-.707M6.343 6.343l-.707-.707m12.728 0l-.707.707M6.343 17.657l-.707.707M16 12a4 4 0 11-8 0 4 4 0 018 0z" />
                </svg>
            </button>
        </div>
    </div>
</header>
