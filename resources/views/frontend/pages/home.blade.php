@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Section dengan Breaking News Ticker --}}
    <section class="relative bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 text-white overflow-hidden">
        {{-- Animated Background --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-blue-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-24">
            <div class="text-center">
                <h1 class="text-5xl md:text-6xl font-bold mb-6 leading-tight" style="font-family: var(--font-heading);">
                    Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">School Portal</span>
                </h1>
                <p class="text-xl text-neutral-300 max-w-2xl mx-auto mb-8">Excellence in Education, Shaping Tomorrow's Leaders</p>
                
                {{-- Quick Stats --}}
                <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12">
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all cursor-pointer" onclick="window.location='{{ route('frontend.posts.index') }}'">
                        <div class="text-3xl font-bold mb-1" id="postsCount">{{ $latestPosts->count() }}+</div>
                        <div class="text-sm text-neutral-300">News Articles</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all cursor-pointer" onclick="window.location='{{ route('frontend.announcements.index') }}'">
                        <div class="text-3xl font-bold mb-1">{{ $latestAnnouncements->count() }}+</div>
                        <div class="text-sm text-neutral-300">Announcements</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all cursor-pointer" onclick="window.location='{{ route('frontend.agendas.index') }}'">
                        <div class="text-3xl font-bold mb-1">{{ $upcomingAgendas->count() }}+</div>
                        <div class="text-sm text-neutral-300">Upcoming Events</div>
                    </div>
                    <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all cursor-pointer" onclick="window.location='{{ route('frontend.achievements.index') }}'">
                        <div class="text-3xl font-bold mb-1">{{ $latestAchievements->count() }}+</div>
                        <div class="text-sm text-neutral-300">Achievements</div>
                    </div>
                </div>

                {{-- CTA Buttons --}}
                <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                    <a href="{{ route('frontend.posts.index') }}" class="px-8 py-4 bg-white text-neutral-900 font-semibold rounded-xl hover:bg-neutral-100 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-1">
                        Read Latest News
                    </a>
                    <a href="{{ route('frontend.about') }}" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                        Learn More
                    </a>
                </div>
            </div>
        </div>

        {{-- Breaking News Ticker --}}
        @if($breakingNews->count() > 0)
        <div class="bg-red-600 text-white py-2 overflow-hidden">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 flex items-center gap-4">
                <span class="px-3 py-1 bg-white text-red-600 text-xs font-bold rounded uppercase tracking-wider shrink-0 animate-pulse">Breaking</span>
                <div class="flex-1 overflow-hidden">
                    <div class="flex gap-8 whitespace-nowrap animate-marquee">
                        @foreach($breakingNews as $news)
                            <a href="{{ route('frontend.posts.show', $news->slug) }}" class="text-sm font-medium hover:underline">
                                {{ $news->title }}
                            </a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
        @endif
    </section>

    {{-- Featured Posts --}}
    @if($featuredPosts->count() > 0)
    <section class="py-20 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-end justify-between mb-12">
                <div>
                    <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Editor's Pick</span>
                    <h2 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2" style="font-family: var(--font-heading);">Featured Stories</h2>
                </div>
                <a href="{{ route('frontend.posts.index') }}" class="hidden md:inline-flex items-center gap-2 text-sm font-semibold text-neutral-700 hover:text-neutral-900">
                    View all
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
                {{-- Main Featured --}}
                @if($featuredPosts->count() >= 1)
                    @php $mainPost = $featuredPosts[0]; @endphp
                    <a href="{{ route('frontend.posts.show', $mainPost->slug) }}" class="lg:col-span-7 group relative block rounded-3xl overflow-hidden bg-neutral-200 aspect-[4/5] lg:aspect-auto lg:h-full hover:shadow-2xl transition-all">
                        <img src="{{ $mainPost->thumbnail_url }}" alt="{{ $mainPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-700">
                        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 via-neutral-900/40 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-8">
                            @if($mainPost->category)
                                <span class="inline-block px-2.5 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-semibold rounded mb-3">{{ $mainPost->category->name }}</span>
                            @endif
                            <h3 class="text-2xl md:text-3xl font-bold text-white mb-3 group-hover:text-neutral-200 transition-colors" style="font-family: var(--font-heading);">{{ $mainPost->title }}</h3>
                            <p class="text-neutral-300 text-sm line-clamp-2 mb-4">{{ $mainPost->excerpt }}</p>
                            <div class="flex items-center gap-3 text-xs text-neutral-400">
                                <span>{{ $mainPost->author->name }}</span>
                                <span>•</span>
                                <span>{{ $mainPost->publish_date?->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </a>
                @endif

                {{-- Side Featured --}}
                <div class="lg:col-span-5 space-y-6">
                    @foreach($featuredPosts->slice(1, 3) as $index => $post)
                        <a href="{{ route('frontend.posts.show', $post->slug) }}" class="group block bg-white rounded-2xl overflow-hidden hover:shadow-lg transition-all">
                            <div class="flex gap-4 p-4">
                                <div class="w-24 h-24 rounded-xl overflow-hidden bg-neutral-100 shrink-0">
                                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                </div>
                                <div class="flex-1 min-w-0">
                                    @if($post->category)
                                        <span class="text-xs font-semibold text-red-600 uppercase tracking-wider">{{ $post->category->name }}</span>
                                    @endif
                                    <h3 class="text-base font-bold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2 mt-1 mb-2">{{ $post->title }}</h3>
                                    <div class="text-xs text-neutral-500">{{ $post->publish_date?->format('M d, Y') }}</div>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Latest News + Sidebar --}}
    <section class="py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-12">
                {{-- Main: Latest News --}}
                <div class="lg:col-span-8">
                    <div class="flex items-end justify-between mb-8">
                        <div>
                            <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Latest Updates</span>
                            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mt-2" style="font-family: var(--font-heading);">Latest News</h2>
                        </div>
                        <a href="{{ route('frontend.posts.index') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-700 hover:text-neutral-900">
                            View all
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>

                    <div class="space-y-6">
                        @forelse($latestPosts->take(3) as $post)
                            <article class="group bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-lg transition-all">
                                <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                                    <div class="flex flex-col md:flex-row">
                                        <div class="md:w-64 md:h-48 shrink-0">
                                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-48 md:h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                        </div>
                                        <div class="p-6 flex-1">
                                            @if($post->category)
                                                <span class="text-xs font-bold text-red-600 uppercase tracking-wider">{{ $post->category->name }}</span>
                                            @endif
                                            <h3 class="text-xl font-bold text-neutral-900 group-hover:text-neutral-600 transition-colors mt-2 mb-3" style="font-family: var(--font-heading);">{{ $post->title }}</h3>
                                            <p class="text-sm text-neutral-600 line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                                            <div class="flex items-center gap-3 text-xs text-neutral-500">
                                                <span class="font-semibold text-neutral-700">{{ $post->author->name }}</span>
                                                <span>•</span>
                                                <span>{{ $post->publish_date?->format('M d, Y') }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </a>
                            </article>
                        @empty
                            <p class="text-neutral-500 text-center py-12">No posts yet.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Sidebar --}}
                <aside class="lg:col-span-4 space-y-8">
                    {{-- Announcements --}}
                    <div class="bg-gradient-to-br from-red-50 to-orange-50 rounded-2xl p-6 border border-red-100">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-10 h-10 rounded-lg bg-red-100 flex items-center justify-center text-red-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-neutral-900" style="font-family: var(--font-heading);">Announcements</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($latestAnnouncements->take(2) as $announcement)
                                <a href="{{ route('frontend.announcements.show', $announcement->slug) }}" class="block border-l-2 border-red-600 pl-4 hover:bg-white/50 rounded-r-lg p-2 transition-colors">
                                    @if($announcement->priority === 'urgent')
                                        <span class="text-[10px] font-bold text-red-600 uppercase tracking-wider">Urgent</span>
                                    @endif
                                    <h4 class="text-sm font-semibold text-neutral-900 line-clamp-2 mt-1">{{ $announcement->title }}</h4>
                                    <div class="text-xs text-neutral-500 mt-1">{{ $announcement->publish_date?->diffForHumans() }}</div>
                                </a>
                            @empty
                                <p class="text-sm text-neutral-500">No announcements.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('frontend.announcements.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-red-600 hover:text-red-700 mt-4">
                            View all
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>

                    {{-- Upcoming Events --}}
                    <div class="bg-gradient-to-br from-blue-50 to-cyan-50 rounded-2xl p-6 border border-blue-100">
                        <div class="flex items-center gap-2 mb-5">
                            <div class="w-10 h-10 rounded-lg bg-blue-100 flex items-center justify-center text-blue-600">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-bold text-neutral-900" style="font-family: var(--font-heading);">Upcoming Events</h3>
                        </div>
                        <div class="space-y-4">
                            @forelse($upcomingAgendas->take(2) as $agenda)
                                <a href="{{ route('frontend.agendas.show', $agenda->slug) }}" class="block hover:bg-white/50 rounded-lg p-2 transition-colors">
                                    <div class="flex gap-3">
                                        <div class="text-center shrink-0 w-12">
                                            <div class="text-[10px] font-bold text-neutral-500 uppercase">{{ $agenda->start_date->format('M') }}</div>
                                            <div class="text-xl font-bold text-neutral-900 leading-none mt-0.5">{{ $agenda->start_date->format('d') }}</div>
                                        </div>
                                        <div class="flex-1 min-w-0">
                                            <h4 class="text-sm font-semibold text-neutral-900 line-clamp-2">{{ $agenda->title }}</h4>
                                            @if($agenda->location)
                                                <div class="text-xs text-neutral-500 mt-1 flex items-center gap-1">
                                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                                    {{ $agenda->location }}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </a>
                            @empty
                                <p class="text-sm text-neutral-500">No upcoming events.</p>
                            @endforelse
                        </div>
                        <a href="{{ route('frontend.agendas.index') }}" class="inline-flex items-center gap-1 text-sm font-semibold text-blue-600 hover:text-blue-700 mt-4">
                            View all
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                        </a>
                    </div>
                </aside>
            </div>
        </div>
    </section>

    {{-- Achievements --}}
    @if($latestAchievements->count() > 0)
    <section class="py-20 bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 text-white relative overflow-hidden">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(255,255,255,0.1),transparent_50%)]"></div>
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12 max-w-2xl mx-auto">
                <span class="text-xs font-bold text-yellow-400 uppercase tracking-wider">Celebrating Excellence</span>
                <h2 class="text-4xl md:text-5xl font-bold mt-2 mb-4" style="font-family: var(--font-heading);">Our Achievements</h2>
                <p class="text-neutral-400">Outstanding accomplishments from our students and staff</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestAchievements->take(4) as $achievement)
                    <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="group bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-all hover:scale-105">
                        <div class="w-12 h-12 rounded-xl bg-yellow-400/20 flex items-center justify-center mb-4 group-hover:scale-110 transition-transform">
                            <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold mb-2 group-hover:text-yellow-400 transition-colors" style="font-family: var(--font-heading);">{{ $achievement->title }}</h3>
                        @if($achievement->achiever_name)
                            <p class="text-sm text-neutral-400 mb-3">{{ $achievement->achiever_name }}</p>
                        @endif
                        <div class="flex items-center gap-2 mt-4">
                            <span class="px-2 py-0.5 bg-white/10 rounded text-xs font-medium">{{ ucfirst($achievement->level) }}</span>
                            @if($achievement->rank)
                                <span class="px-2 py-0.5 bg-yellow-400/20 text-yellow-400 rounded text-xs font-semibold">{{ $achievement->rank }}</span>
                            @endif
                        </div>
                    </a>
                @endforeach
            </div>

            <div class="text-center mt-12">
                <a href="{{ route('frontend.achievements.index') }}" class="inline-flex items-center gap-2 px-6 py-3 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                    View All Achievements
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                </a>
            </div>
        </div>
    </section>
    @endif

    {{-- Quick Links Grid --}}
    <section class="py-20 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Explore</span>
                <h2 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2" style="font-family: var(--font-heading);">Quick Access</h2>
            </div>

            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                <a href="{{ route('frontend.posts.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-blue-100 flex items-center justify-center text-blue-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">News</div>
                </a>
                <a href="{{ route('frontend.announcements.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-red-100 flex items-center justify-center text-red-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">Announcements</div>
                </a>
                <a href="{{ route('frontend.agendas.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-purple-100 flex items-center justify-center text-purple-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">Agendas</div>
                </a>
                <a href="{{ route('frontend.videos.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-pink-100 flex items-center justify-center text-pink-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">Videos</div>
                </a>
                <a href="{{ route('frontend.documents.index') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-green-100 flex items-center justify-center text-green-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">Documents</div>
                </a>
                <a href="{{ route('frontend.gallery') }}" class="group bg-white rounded-2xl p-6 text-center hover:shadow-lg transition-all hover:-translate-y-1">
                    <div class="w-12 h-12 rounded-xl bg-yellow-100 flex items-center justify-center text-yellow-600 mx-auto mb-3 group-hover:scale-110 transition-transform">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" /></svg>
                    </div>
                    <div class="text-sm font-semibold text-neutral-900">Gallery</div>
                </a>
            </div>
        </div>
    </section>

    {{-- CTA Section --}}
    <section class="py-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-5xl font-bold mb-4" style="font-family: var(--font-heading);">Join Our Community</h2>
            <p class="text-lg text-blue-100 mb-8 max-w-2xl mx-auto">Be part of our journey towards excellence. Get the latest updates and news from our school.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('frontend.contact') }}" class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-neutral-100 transition-all shadow-xl hover:shadow-2xl transform hover:-translate-y-1">
                    Contact Us
                </a>
                <a href="{{ route('frontend.about') }}" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                    Learn More
                </a>
            </div>
        </div>
    </section>
@endsection

@push('scripts')
<script>
    // Marquee animation for breaking news
    const style = document.createElement('style');
    style.textContent = `
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    `;
    document.head.appendChild(style);
</script>
@endpush