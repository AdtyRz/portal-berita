@php
    // Ambil data SchoolProfile realtime
    $schoolProfile = \App\Models\SchoolProfile::first();
    $siteName = $schoolProfile->name ?? 'School Portal';
    $siteShortName = $schoolProfile->short_name ?? 'SP';
    $siteTagline = $schoolProfile->tagline ?? 'Excellence in Education';
@endphp

<header id="mainHeader"
    class="fixed top-0 left-0 right-0 z-50 px-4 sm:px-4 lg:px-4 py-4 transition-all duration-300 ease-in-out"
    x-data="{ mobileOpen: false, scrolled: false }">
    <div class="mx-auto max-w-8xl">
        <div class="bg-white/40 backdrop-blur-xl border border-white/30 rounded-2xl shadow-lg shadow-neutral-900/5">

            {{-- DESKTOP: Logo + Navigation --}}
            <div class="hidden md:flex items-center justify-between h-16 px-6">
                {{-- Logo --}}
                <a href="{{ route('home') }}" class="flex items-center gap-3">
                    <div
                        class="w-9 h-9 rounded-xl bg-gradient-to-br from-neutral-900 to-neutral-700 flex items-center justify-center shadow-sm">
                        <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <div>
                        <div class="font-bold text-neutral-900 text-sm tracking-tight"
                            style="font-family: var(--font-heading);">{{ $siteName }}</div>
                        <div class="text-[10px] text-neutral-500 font-medium tracking-wider uppercase">{{ $siteTagline }}</div>
                    </div>
                </a>

                {{-- Desktop Navigation --}}
                <nav class="hidden md:flex items-center gap-2">
                    <a href="{{ route('home') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('home') ? 'bg-white/50 text-neutral-900' : '' }}">Home</a>
                    <a href="{{ route('frontend.posts.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.posts.*') ? 'bg-white/50 text-neutral-900' : '' }}">News</a>
                    <a href="{{ route('frontend.announcements.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.announcements.*') ? 'bg-white/50 text-neutral-900' : '' }}">Announcements</a>
                    <a href="{{ route('frontend.agendas.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.agendas.*') ? 'bg-white/50 text-neutral-900' : '' }}">Agendas</a>
                    <a href="{{ route('frontend.achievements.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.achievements.*') ? 'bg-white/50 text-neutral-900' : '' }}">Achievements</a>
                    <a href="{{ route('frontend.videos.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.videos.*') ? 'bg-white/50 text-neutral-900' : '' }}">Videos</a>
                    <a href="{{ route('frontend.documents.index') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.documents.*') ? 'bg-white/50 text-neutral-900' : '' }}">Documents</a>
                    <!-- <a href="{{ route('frontend.gallery') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.gallery') ? 'bg-white/50 text-neutral-900' : '' }}">Gallery</a> -->
                    <a href="{{ route('frontend.about') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.about') ? 'bg-white/50 text-neutral-900' : '' }}">About</a>
                    <a href="{{ route('frontend.contact') }}"
                        class="px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.contact') ? 'bg-white/50 text-neutral-900' : '' }}">Contact</a>
                </nav>
            </div>

            {{-- MOBILE: Logo + Search + Scrollable Navigation --}}
            <div class="md:hidden px-4 py-3">
                {{-- Row 1: Logo + Search --}}
                <div class="flex items-center gap-3 mb-3">
                    {{-- Logo + Nama App --}}
                    <a href="{{ route('home') }}" class="flex items-center gap-2.5 shrink-0">
                        <div
                            class="w-9 h-9 rounded-xl bg-gradient-to-br from-neutral-900 to-neutral-700 flex items-center justify-center shadow-sm">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-neutral-900 text-sm tracking-tight leading-tight truncate"
                                style="font-family: var(--font-heading);">{{ $siteName }}</div>
                            <div class="text-[10px] text-neutral-500 font-medium truncate">{{ $siteTagline }}</div>
                        </div>
                    </a>

                    {{-- Search Bar --}}
                    <form action="{{ route('frontend.posts.index') }}" method="GET" class="flex-1">
                        <div class="relative">
                            <input type="text" name="search" placeholder="Search..."
                                class="w-full pl-9 pr-3 py-2 bg-neutral-100/80 rounded-full text-sm text-neutral-900 outline-none border border-transparent focus:border-neutral-300/50 focus:bg-white/90 transition-all placeholder:text-neutral-500">
                        </div>
                    </form>
                </div>

                {{-- Row 2: Horizontal Scrollable Navigation --}}
                <nav class="flex gap-2 overflow-x-auto pb-1" style="scrollbar-width: none; -ms-overflow-style: none;">
                    <a href="{{ route('home') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('home') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6" />
                        </svg>
                        Home
                    </a>
                    <a href="{{ route('frontend.posts.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.posts.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        News
                    </a>
                    <a href="{{ route('frontend.announcements.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.announcements.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                        Announcements
                    </a>
                    <a href="{{ route('frontend.agendas.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.agendas.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Agendas
                    </a>
                    <a href="{{ route('frontend.achievements.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.achievements.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                        </svg>
                        Achievements
                    </a>
                    <a href="{{ route('frontend.videos.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.videos.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                        </svg>
                        Videos
                    </a>
                    <a href="{{ route('frontend.documents.index') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.documents.*') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                        </svg>
                        Documents
                    </a>
                    <!-- <a href="{{ route('frontend.gallery') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.gallery') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        Gallery
                    </a> -->
                    <a href="{{ route('frontend.about') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.about') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        About
                    </a>
                    <a href="{{ route('frontend.contact') }}"
                        class="shrink-0 inline-flex items-center gap-1.5 px-4 py-2 text-sm font-medium text-neutral-700 hover:text-neutral-900 hover:bg-white/50 rounded-lg transition-all {{ request()->routeIs('frontend.contact') ? 'bg-white/50 text-neutral-900' : '' }}">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                            stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        Contact
                    </a>
                </nav>
            </div>
        </div>
    </div>
</header>

{{-- Spacer untuk fixed header --}}
<div class="h-32 md:h-24"></div>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const header = document.getElementById('mainHeader');
        let lastScroll = 0;
        let ticking = false;

        function updateHeader() {
            const currentScroll = window.pageYOffset;
            const windowHeight = window.innerHeight;
            const documentHeight = document.documentElement.scrollHeight;
            const scrollPercentage = (currentScroll + windowHeight) / documentHeight;

            if (scrollPercentage > 0.96) {
                header.style.opacity = '0';
                header.style.transform = 'translateY(-100%)';
                header.style.pointerEvents = 'none';
            } else if (currentScroll > lastScroll && currentScroll > 100) {
                header.style.opacity = '0';
                header.style.transform = 'translateY(-100%)';
                header.style.pointerEvents = 'none';
            } else {
                header.style.opacity = '1';
                header.style.transform = 'translateY(0)';
                header.style.pointerEvents = 'auto';
            }

            lastScroll = currentScroll;
            ticking = false;
        }

        window.addEventListener('scroll', function() {
            if (!ticking) {
                window.requestAnimationFrame(updateHeader);
                ticking = true;
            }
        }, {
            passive: true
        });
    });
</script>