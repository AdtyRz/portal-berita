@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $schoolProfile = \App\Models\SchoolProfile::first();
        $siteName = $schoolProfile->name ?? 'School Portal';
        $siteTagline = $schoolProfile->tagline ?? 'Excellence in Education';
    @endphp

    <div class="bg-gradient-to-t from-stone-500 via-stone-400 to-stone-300 h-32 md:h-24"></div>
   {{-- Hero Slider Section --}}
@if(isset($heroSliders) && $heroSliders->count() > 0)
<section>
    <div class="swiper mySwiper h-[400px] md:h-[500px] lg:h-[600px]">
        <div class="swiper-wrapper">
            @foreach($heroSliders as $slider)
                <div class="swiper-slide relative">
                    <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                    <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                    <div class="absolute bottom-0 left-0 right-0 p-6 md:p-12 lg:p-16">
                        <div class="mx-auto max-w-7xl">
                            <div class="max-w-3xl">
                                <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full mb-3">FEATURED</span>
                                <h1 class="text-3xl md:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight" style="font-family: var(--font-heading);">
                                    {{ $slider->title }}
                                </h1>
                                @if($slider->description)
                                    <p class="text-sm md:text-base text-neutral-200 mb-4 line-clamp-2">
                                        {{ $slider->description }}
                                    </p>
                                @endif
                                @if($slider->button_text && $slider->button_url)
                                    <a href="{{ $slider->button_url }}" class="inline-flex items-center px-6 py-2.5 bg-white text-neutral-900 font-semibold rounded-lg hover:bg-neutral-100 transition-all shadow-lg">
                                        {{ $slider->button_text }}
                                        <svg class="ml-2 w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                        </svg>
                                    </a>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
        <div class="swiper-pagination"></div>
    </div>
</section>

@else
{{-- Fallback: Default Hero Section (jika tidak ada slider) --}}
<div class="bg-gradient-to-t from-neutral-950 via-neutral-000 to-white"></div>
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
                Welcome to <span class="text-transparent bg-clip-text bg-gradient-to-r from-blue-400 to-purple-400">{{ $siteName }}</span>
            </h1>
            <p class="text-xl text-neutral-300 max-w-2xl mx-auto mb-8">{{ $siteTagline }}</p>

            {{-- Quick Stats --}}
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6 max-w-4xl mx-auto mb-12">
                <div class="bg-white/10 backdrop-blur-sm rounded-2xl p-6 hover:bg-white/20 transition-all cursor-pointer" onclick="window.location='{{ route('frontend.posts.index') }}'">
                    <div class="text-3xl font-bold mb-1">{{ $latestPosts->count() }}+</div>
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
</section>
@endif

    {{-- 2. BREAKING NEWS (Merah) --}}
    @if(isset($breakingNews) && $breakingNews->count() > 0)
    <div class="bg-red-600 text-white py-2 relative z-10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-4">
                <span class="px-3 py-1 bg-white text-red-600 text-xs font-bold rounded uppercase tracking-wider shrink-0 animate-pulse">Breaking</span>
                <div class="flex-1 overflow-hidden">
                    <div class="flex gap-8 whitespace-nowrap animate-marquee">
                        @foreach($breakingNews as $news)
                            <a href="{{ route('frontend.posts.show', $news->slug) }}" class="text-sm font-medium hover:underline transition-colors">{{ $news->title }}</a>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- 3. GRADIENT TRANSITION --}}
    <div class="bg-gradient-to-b from-stone-500 via-stone-400 to-stone-100 relative">
        <div class="py-4">
            {{-- 4. PROGRAM PRIORITAS --}}
            <section>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-white" style="font-family: var(--font-heading);">Program Prioritas</h2>
                        <div class="flex-1 h-px bg-white/30"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
@foreach($latestAchievements->take(6) as $achievement)
    <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="group relative rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
        <div class="aspect-[4/3] overflow-hidden bg-neutral-800">
            @if($achievement->thumbnail)
                <img src="{{ asset('storage/' . $achievement->thumbnail) }}" 
                     alt="{{ $achievement->title }}" 
                     class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
            @else
                <div class="w-full h-full flex items-center justify-center text-neutral-500 text-xs">
                    No Image
                </div>
            @endif
        </div>
        <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
        <div class="absolute bottom-0 left-0 right-0 p-3">
            <h3 class="text-xs font-semibold text-white line-clamp-2">{{ $achievement->title }}</h3>
        </div>
    </a>
@endforeach
                    </div>
                </div>
            </section>

            {{-- 5. INFORMASI TERKINI --}}
            <section class="mt-16">
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-white" style="font-family: var(--font-heading);">Informasi Terkini</h2>
                        <div class="flex-1 h-px bg-white/30"></div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Main Post --}}
                        @if($featuredPosts->count() > 0)
                            @php $mainPost = $featuredPosts[0]; @endphp
                            <div class="lg:col-span-2">
                                <a href="{{ route('frontend.posts.show', $mainPost->slug) }}" class="group block rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1">
                                    <div class="aspect-[16/9] overflow-hidden">
                                        <img src="{{ $mainPost->thumbnail_url }}" alt="{{ $mainPost->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="p-5">
                                        <span class="inline-block px-2 py-1 bg-white text-black text-xs font-bold rounded mb-2">{{ $mainPost->category->name ?? 'Berita' }}</span>
                                        <h3 class="text-lg md:text-xl font-bold text-black mb-2 line-clamp-2 group-hover:text-blue-400 transition-colors">{{ $mainPost->title }}</h3>
                                        <p class="text-sm text-black line-clamp-2 mb-3">{{ $mainPost->excerpt }}</p>
                                        <div class="flex items-center gap-3 text-xs text-black">
                                            <span>{{ $mainPost->author->name }}</span>
                                            <span>•</span>
                                            <span>{{ $mainPost->publish_date?->format('d M Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </div>
                        @endif

                        {{-- Side Posts --}}
                        <div class="space-y-4">
                            @foreach($latestPosts->take(2) as $post)
                                <a href="{{ route('frontend.posts.show', $post->slug) }}" class="group flex gap-4 p-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0">
                                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold text-black mb-1 line-clamp-2 group-hover:text-blue-400 transition-colors">{{ $post->title }}</h4>
                                        <div class="text-xs text-neutral-700">{{ $post->publish_date?->format('d M Y') }}</div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- 6. ARTIKEL LAINNYA (Background Putih) --}}
    <section class="py-12 bg-stone-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-black" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Artikel Lainnya</h2>
                <div class="flex-1 h-px bg-neutral-200"></div>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex gap-2 mb-8 overflow-x-auto pb-2">
                <button class="px-4 py-2 bg-black text-white rounded-full text-sm font-medium whitespace-nowrap hover:black transition-colors">Semua</button>
                <button class="px-4 py-2 bg-neutral-100 text-neutral-700 rounded-full text-sm font-medium hover:bg-neutral-200 whitespace-nowrap transition-colors">Berita</button>
                <button class="px-4 py-2 bg-neutral-100 text-neutral-700 rounded-full text-sm font-medium hover:bg-neutral-200 whitespace-nowrap transition-colors">Pengumuman</button>
                <button class="px-4 py-2 bg-neutral-100 text-neutral-700 rounded-full text-sm font-medium hover:bg-neutral-200 whitespace-nowrap transition-colors">Agenda</button>
            </div>

            {{-- Grid Posts --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($latestPosts->skip(3)->take(8) as $post)
                    <article class="group bg-white rounded-xl overflow-hidden border border-neutral-200 shadow hover:shadow-xl transition-all hover:-translate-y-1">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4">
                            <span class="inline-block px-2 py-1 bg-blue-50 text-blue-600 text-xs font-semibold rounded mb-2">{{ $post->category->name ?? 'Berita' }}</span>
                            <h3 class="text-sm font-bold text-neutral-900 mb-2 line-clamp-2 group-hover:text-blue-600 transition-colors">{{ $post->title }}</h3>
                            <div class="flex items-center gap-2 text-xs text-neutral-500">
                                <span>{{ $post->publish_date?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

 {{-- 7. MEDIA SOSIAL --}}
<section class="py-12 bg-stone-100">
    @php
        // Ambil data dari SchoolProfile (sama seperti di footer)
        $schoolProfile = \App\Models\SchoolProfile::first();
        
        // Fungsi helper untuk mengubah URL penuh menjadi handle yang rapi (contoh: @sekolah)
        $getHandle = function($url, $default) {
            if (!$url) return $default;
            $url = trim($url, '/');
            $parts = explode('/', $url);
            $handle = end($parts);
            return (str_starts_with($handle, '@') ? '' : '@') . $handle;
        };

        // Ambil URL dari database
        $igUrl = $schoolProfile->instagram ?? '';
        $ttUrl = $schoolProfile->tiktok ?? '';
        $ytUrl = $schoolProfile->youtube ?? '';
        $twUrl = $schoolProfile->twitter ?? '';
        $fbUrl = $schoolProfile->facebook ?? '';

        // Format untuk tampilan teks
        $igHandle = $getHandle($igUrl, '@instagram');
        $ttHandle = $getHandle($ttUrl, '@tiktok');
        $ytHandle = $getHandle($ytUrl, 'YouTube Channel');
        $twHandle = $getHandle($twUrl, '@twitter');
        $fbHandle = $getHandle($fbUrl, 'Facebook Page');
    @endphp

    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
        {{-- Section Header --}}
        <div class="flex items-center gap-3 mb-8">
            <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Media Sosial</h2>
            <div class="flex-1 h-px bg-neutral-200"></div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-12 gap-6">
            {{-- Left Sidebar: Social Media List --}}
            <div class="lg:col-span-4">
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden">
                    {{-- Instagram Button --}}
                    <button type="button" onclick="switchSocialMedia('instagram')" 
                            class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-100 hover:bg-neutral-50"
                            data-platform="instagram"
                            data-url="{{ $igUrl ?: '#' }}">
                        <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                            <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-semibold text-neutral-900">Instagram</div>
                            <div class="text-sm text-neutral-500">{{ $igHandle }}</div>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- TikTok Button --}}
                    <button type="button" onclick="switchSocialMedia('tiktok')" 
                            class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-100 hover:bg-neutral-50"
                            data-platform="tiktok"
                            data-url="{{ $ttUrl ?: '#' }}">
                        <div class="w-12 h-12 rounded-full bg-neutral-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-semibold text-neutral-900">TikTok</div>
                            <div class="text-sm text-neutral-500">{{ $ttHandle }}</div>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- YouTube Button --}}
                    <button type="button" onclick="switchSocialMedia('youtube')" 
                            class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-100 hover:bg-neutral-50"
                            data-platform="youtube"
                            data-url="{{ $ytUrl ?: '#' }}">
                        <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-semibold text-neutral-900">YouTube</div>
                            <div class="text-sm text-neutral-500">{{ $ytHandle }}</div>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>

                    {{-- X (Twitter) Button --}}
                    <!-- <button type="button" onclick="switchSocialMedia('twitter')" 
                            class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-100 hover:bg-neutral-50"
                            data-platform="twitter"
                            data-url="{{ $twUrl ?: '#' }}">
                        <div class="w-12 h-12 rounded-full bg-neutral-100 flex items-center justify-center">
                            <svg class="w-6 h-6 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-semibold text-neutral-900">X</div>
                            <div class="text-sm text-neutral-500">{{ $twHandle }}</div>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button> -->

                    {{-- Facebook Button --}}
                    <button type="button" onclick="switchSocialMedia('facebook')" 
                            class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group hover:bg-neutral-50"
                            data-platform="facebook"
                            data-url="{{ $fbUrl ?: '#' }}">
                        <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                            <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/>
                            </svg>
                        </div>
                        <div class="flex-1 text-left">
                            <div class="font-semibold text-neutral-900">Facebook</div>
                            <div class="text-sm text-neutral-500">{{ $fbHandle }}</div>
                        </div>
                        <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Right Content: Dynamic Social Media Feed --}}
            <div class="lg:col-span-8">
                <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden p-6">
                    
                    {{-- Instagram Feed Container --}}
                    <div id="instagram-feed" class="social-feed-content">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                            <svg class="w-6 h-6 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/>
                            </svg>
                                Latest from Instagram
                            </h3>
                            <a href="{{ $igUrl ?: '#' }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Follow Us →</a>
                        </div>
                        <div class="w-full min-h-[400px] flex items-center justify-center bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200">
                            <div class="text-center p-8">
                                <p class="text-neutral-600 font-semibold mb-2">Instagram Feed Widget</p>
                                <p class="text-sm text-neutral-500">Paste kode embed dari LightWidget di sini</p>
                            </div>
                        </div>
                    </div>

                    {{-- TikTok Feed Container --}}
                    <div id="tiktok-feed" class="social-feed-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                                Latest from TikTok
                            </h3>
                            <a href="{{ $ttUrl ?: '#' }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Follow Us →</a>
                        </div>
                        <div class="w-full min-h-[400px] flex items-center justify-center bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200">
                            <div class="text-center p-8">
                                <p class="text-neutral-600 font-semibold">TikTok Feed Widget</p>
                                <p class="text-sm text-neutral-500">Paste kode embed TikTok di sini</p>
                            </div>
                        </div>
                    </div>

                    {{-- YouTube Feed Container --}}
<div id="youtube-feed" class="social-feed-content hidden">
    <div class="flex items-center justify-between mb-6">
        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/>
            </svg>
            Latest from YouTube
        </h3>
        <a href="{{ $ytUrl ?: '#' }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Subscribe →</a>
    </div>
    
    {{-- YouTube Video Embed - Placeholder sampai ada video --}}
    <div class="aspect-video rounded-xl overflow-hidden bg-neutral-900 shadow-lg flex items-center justify-center">
        <div class="text-center text-neutral-400 p-8">
            <svg class="w-16 h-16 mx-auto mb-4 opacity-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14.752 11.168l-3.197-2.132A1 1 0 0010 9.87v4.263a1 1 0 001.555.832l3.197-2.132a1 1 0 000-1.664z" />
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
            </svg>
            <p class="font-semibold mb-2">YouTube Channel: {{ str_replace('@', '', $ytHandle) }}</p>
            <p class="text-sm">Channel belum memiliki video publik atau URL perlu disesuaikan</p>
            <p class="text-xs mt-4 text-neutral-500">
                URL di database: {{ $ytUrl }}
            </p>
        </div>
    </div>
    
    {{-- Instruksi untuk admin --}}
    <div class="mt-4 p-4 bg-blue-50 border border-blue-200 rounded-lg">
        <p class="text-sm text-blue-800 font-medium mb-2">📹 Cara Menampilkan Video YouTube:</p>
        <ol class="text-xs text-blue-700 space-y-1 list-decimal list-inside">
            <li>Pastikan channel YouTube sudah memiliki video publik</li>
            <li>Atau paste video ID spesifik di sini untuk menampilkan video tertentu</li>
            <li>Contoh: Ganti iframe dengan video ID dari URL youtube.com/watch?v=<strong>VIDEO_ID</strong></li>
        </ol>
    </div>
</div>

                    {{-- Twitter Feed Container --}}
                    <!-- <div id="twitter-feed" class="social-feed-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24"><path d="M18.244 2.25h3.308l-7.227 8.26 8.502 11.24H16.17l-5.214-6.817L4.99 21.75H1.68l7.73-8.835L1.254 2.25H8.08l4.713 6.231zm-1.161 17.52h1.833L7.084 4.126H5.117z"/></svg>
                                Latest from X (Twitter)
                            </h3>
                            <a href="{{ $twUrl ?: '#' }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Follow Us →</a>
                        </div>
                        <div class="w-full min-h-[400px] flex items-center justify-center bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200">
                            <div class="text-center p-8">
                                <p class="text-neutral-600 font-semibold">Twitter Timeline Widget</p>
                                <p class="text-sm text-neutral-500">Paste kode embed Twitter di sini</p>
                            </div>
                        </div>
                    </div> -->

                    {{-- Facebook Feed Container --}}
                    <div id="facebook-feed" class="social-feed-content hidden">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2">
                                <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                Latest from Facebook
                            </h3>
                            <a href="{{ $fbUrl ?: '#' }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Like Page →</a>
                        </div>
                        <div class="w-full min-h-[400px] flex items-center justify-center bg-neutral-50 rounded-xl border-2 border-dashed border-neutral-200">
                            <div class="text-center p-8">
                                <p class="text-neutral-600 font-semibold">Facebook Page Plugin</p>
                                <p class="text-sm text-neutral-500">Paste kode embed Facebook di sini</p>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
        </div>
    </div>
</section>

    {{-- <div class="bg-gradient-to-t from-neutral-950 via-neutral-000 to-white py-16"></div> --}}
@endsection

@push('scripts')
<script>
    // 1. Fungsi untuk mengganti tampilan feed media sosial
    function switchSocialMedia(platform) {
        // Sembunyikan semua konten feed
        document.querySelectorAll('.social-feed-content').forEach(function(feed) {
            feed.classList.add('hidden');
        });
        
        // Hapus highlight dari semua tombol
        document.querySelectorAll('.socmed-btn').forEach(function(btn) {
            btn.classList.remove('bg-neutral-100');
        });
        
        // Tampilkan feed yang dipilih
        var selectedFeed = document.getElementById(platform + '-feed');
        if (selectedFeed) {
            selectedFeed.classList.remove('hidden');
        }
        
        // Tambahkan highlight ke tombol yang aktif
        var selectedBtn = document.querySelector('.socmed-btn[data-platform="' + platform + '"]');
        if (selectedBtn) {
            selectedBtn.classList.add('bg-neutral-100');
        }
    }

    // 2. Inisialisasi dengan Instagram sebagai default saat halaman dimuat
    document.addEventListener('DOMContentLoaded', function() {
        switchSocialMedia('instagram');
    });

    // 3. Marquee animation for breaking news
    const marqueeStyle = document.createElement('style');
    marqueeStyle.textContent = `
        @keyframes marquee {
            0% { transform: translateX(0); }
            100% { transform: translateX(-50%); }
        }
        .animate-marquee {
            animation: marquee 30s linear infinite;
        }
    `;
    document.head.appendChild(marqueeStyle);

    // 4. Swiper initialization (Hero Slider) dengan loop infinite
    var swiper = new Swiper(".mySwiper", {
        loop: true,
        autoplay: {
            delay: 5000,
            disableOnInteraction: false,
        },
        pagination: {
            el: ".swiper-pagination",
            clickable: true,
            dynamicBullets: true,
        },
        navigation: {
            nextEl: ".swiper-button-next",
            prevEl: ".swiper-button-prev",
        },
        effect: 'fade',
        fadeEffect: { crossFade: true },
        speed: 800,
    });
</script>