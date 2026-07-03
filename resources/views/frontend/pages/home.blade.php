@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    {{-- Hero Slider --}}
    @if($heroSliders->count() > 0)
        <section class="relative bg-neutral-900">
            <div class="relative h-[500px] overflow-hidden">
                @foreach($heroSliders as $index => $slider)
                    <div class="absolute inset-0 transition-opacity duration-500 {{ $index === 0 ? 'opacity-100' : 'opacity-0' }}" data-slide="{{ $index }}">
                        <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                        <div class="absolute inset-0 flex items-end">
                            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 pb-16 w-full">
                                <div class="max-w-2xl">
                                    <h1 class="text-4xl md:text-5xl font-bold text-white mb-4" style="font-family: var(--font-heading);">{{ $slider->title }}</h1>
                                    @if($slider->description)
                                        <p class="text-lg text-neutral-200 mb-6">{{ $slider->description }}</p>
                                    @endif
                                    @if($slider->link)
                                        <a href="{{ $slider->link }}" class="inline-flex items-center gap-2 px-6 py-3 text-sm font-semibold text-white bg-white/10 backdrop-blur-sm border border-white/20 rounded-lg hover:bg-white/20 transition-all">
                                            {{ $slider->button_text ?? 'Learn More' }}
                                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" />
                                            </svg>
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
    @endif

    {{-- Breaking News --}}
    @if($breakingNews->count() > 0)
        <section class="bg-red-600 text-white py-3">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <span class="px-3 py-1 bg-white text-red-600 text-xs font-bold rounded uppercase tracking-wider">Breaking</span>
                    <div class="flex-1 overflow-hidden">
                        <div class="flex items-center gap-6">
                            @foreach($breakingNews as $news)
                                <a href="{{ route('frontend.posts.show', $news->slug) }}" class="text-sm font-medium hover:underline whitespace-nowrap">
                                    {{ $news->title }}
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- Featured Posts --}}
    @if($featuredPosts->count() > 0)
        <section class="py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Featured Stories</h2>
                    <a href="{{ route('frontend.posts.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($featuredPosts as $post)
                        <article class="group">
                            <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                                <div class="aspect-[4/3] rounded-2xl overflow-hidden bg-neutral-100 mb-4">
                                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                </div>
                                @if($post->category)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-neutral-700 bg-neutral-100 rounded mb-2">{{ $post->category->name }}</span>
                                @endif
                                <h3 class="text-lg font-semibold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2 mb-2">{{ $post->title }}</h3>
                                <p class="text-sm text-neutral-500 line-clamp-2">{{ $post->excerpt }}</p>
                            </a>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Latest Posts --}}
    <section class="py-16 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Latest News</h2>
                <a href="{{ route('frontend.posts.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($latestPosts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden group hover:shadow-lg transition-shadow">
                        <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                            <div class="aspect-[16/9] overflow-hidden bg-neutral-100">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-6">
                                @if($post->category)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-neutral-700 bg-neutral-100 rounded mb-3">{{ $post->category->name }}</span>
                                @endif
                                <h3 class="text-xl font-semibold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2 mb-2">{{ $post->title }}</h3>
                                <p class="text-sm text-neutral-500 line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                                <div class="flex items-center gap-3 text-xs text-neutral-400">
                                    <span>{{ $post->author->name }}</span>
                                    <span>•</span>
                                    <span>{{ $post->publish_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    {{-- Announcements & Agendas --}}
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                {{-- Announcements --}}
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Announcements</h2>
                    <div class="space-y-4">
                        @forelse($latestAnnouncements as $announcement)
                            <article class="bg-white border border-neutral-200 rounded-xl p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-start gap-4">
                                    <div class="w-12 h-12 rounded-lg bg-red-50 flex items-center justify-center text-red-600 shrink-0">
                                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-neutral-900 mb-1">{{ $announcement->title }}</h3>
                                        <p class="text-sm text-neutral-500 line-clamp-2">{{ $announcement->excerpt }}</p>
                                        <div class="flex items-center gap-2 mt-2">
                                            <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium {{ $announcement->priority === 'urgent' ? 'bg-red-100 text-red-800' : 'bg-neutral-100 text-neutral-800' }}">
                                                {{ ucfirst($announcement->priority) }}
                                            </span>
                                            <span class="text-xs text-neutral-400">{{ $announcement->publish_date->diffForHumans() }}</span>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-neutral-500">No announcements at this time.</p>
                        @endforelse
                    </div>
                </div>

                {{-- Agendas --}}
                <div>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Upcoming Events</h2>
                    <div class="space-y-4">
                        @forelse($upcomingAgendas as $agenda)
                            <article class="bg-white border border-neutral-200 rounded-xl p-5 hover:shadow-md transition-shadow">
                                <div class="flex items-start gap-4">
                                    <div class="text-center shrink-0">
                                        <div class="text-xs font-semibold text-neutral-500 uppercase">{{ $agenda->start_date->format('M') }}</div>
                                        <div class="text-2xl font-bold text-neutral-900">{{ $agenda->start_date->format('d') }}</div>
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h3 class="text-base font-semibold text-neutral-900 mb-1">{{ $agenda->title }}</h3>
                                        @if($agenda->location)
                                            <p class="text-sm text-neutral-500 flex items-center gap-1">
                                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                    <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                                </svg>
                                                {{ $agenda->location }}
                                            </p>
                                        @endif
                                        <div class="text-xs text-neutral-400 mt-2">
                                            {{ $agenda->start_date->format('H:i') }}
                                            @if($agenda->end_date)
                                                - {{ $agenda->end_date->format('H:i') }}
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @empty
                            <p class="text-sm text-neutral-500">No upcoming events.</p>
                        @endforelse
                    </div>
                </div>
            </div>
        </div>
    </section>

    {{-- Achievements --}}
    @if($latestAchievements->count() > 0)
        <section class="py-16 bg-gradient-to-br from-neutral-900 to-neutral-800 text-white">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="text-center mb-12">
                    <h2 class="text-3xl font-bold mb-4" style="font-family: var(--font-heading);">Our Achievements</h2>
                    <p class="text-neutral-400 max-w-2xl mx-auto">Celebrating excellence and outstanding accomplishments of our students</p>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                    @foreach($latestAchievements as $achievement)
                        <article class="bg-white/5 backdrop-blur-sm border border-white/10 rounded-2xl p-6 hover:bg-white/10 transition-colors">
                            <div class="w-12 h-12 rounded-xl bg-yellow-500/20 flex items-center justify-center mb-4">
                                <svg class="w-6 h-6 text-yellow-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                                </svg>
                            </div>
                            <h3 class="text-lg font-semibold mb-2">{{ $achievement->title }}</h3>
                            @if($achievement->achiever_name)
                                <p class="text-sm text-neutral-400 mb-2">{{ $achievement->achiever_name }}</p>
                            @endif
                            <div class="flex items-center gap-2 mt-4">
                                <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-blue-500/20 text-blue-300">{{ ucfirst($achievement->level) }}</span>
                                @if($achievement->rank)
                                    <span class="inline-flex items-center px-2 py-0.5 rounded text-xs font-medium bg-emerald-500/20 text-emerald-300">{{ $achievement->rank }}</span>
                                @endif
                            </div>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    {{-- Gallery Preview --}}
    @if($latestGalleries->count() > 0)
        <section class="py-16">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center justify-between mb-8">
                    <h2 class="text-3xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Gallery</h2>
                    <a href="{{ route('frontend.gallery') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
                </div>
                <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                    @foreach($latestGalleries as $gallery)
                        <a href="{{ route('frontend.gallery') }}" class="group aspect-square rounded-2xl overflow-hidden bg-neutral-100">
                            <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </a>
                    @endforeach
                </div>
            </div>
        </section>
    @endif
@endsection
