@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $schoolProfile = \App\Models\SchoolProfile::first();
        $siteName = $schoolProfile->name ?? 'School Portal';
        $siteTagline = $schoolProfile->tagline ?? 'Excellence in Education';
    @endphp
    

    {{-- 1. HERO SLIDER --}}
    @if(isset($heroSliders) && $heroSliders->count() > 0)
    <section class="relative bg-gradient-to-b from-neutral-1000 via-neutral-800 to-black">
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

    {{-- 3. GRADIENT TRANSITION (Hitam -> Putih) --}}
    <div class="bg-gradient-to-b from-black via-neutral-900 to-white relative">
        <div class="py-12">
            {{-- 4. PROGRAM PRIORITAS --}}
            <section>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-white" style="font-family: var(--font-heading);">Program Prioritas</h2>
                        <div class="flex-1 h-px bg-white/30"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach($latestAchievements->take(6) as $achievement)
                            <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="group relative rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                                <div class="aspect-[4/3] overflow-hidden">
                                    <img src="{{ $achievement->image_url ?? 'https://via.placeholder.com/400x300' }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
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
                        <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
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
                                        <span class="inline-block px-2 py-1 bg-blue-600 text-white text-xs font-bold rounded mb-2">{{ $mainPost->category->name ?? 'Berita' }}</span>
                                        <h3 class="text-lg md:text-xl font-bold text-white mb-2 line-clamp-2 group-hover:text-blue-400 transition-colors">{{ $mainPost->title }}</h3>
                                        <p class="text-sm text-neutral-300 line-clamp-2 mb-3">{{ $mainPost->excerpt }}</p>
                                        <div class="flex items-center gap-3 text-xs text-neutral-400">
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
                                        <h4 class="text-sm font-semibold text-white mb-1 line-clamp-2 group-hover:text-blue-400 transition-colors">{{ $post->title }}</h4>
                                        <div class="text-xs text-neutral-400">{{ $post->publish_date?->format('d M Y') }}</div>
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
    <section class="py-12 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Artikel Lainnya</h2>
                <div class="flex-1 h-px bg-neutral-200"></div>
            </div>

            {{-- Filter Tabs --}}
            <div class="flex gap-2 mb-8 overflow-x-auto pb-2">
                <button class="px-4 py-2 bg-blue-600 text-white rounded-full text-sm font-medium whitespace-nowrap hover:bg-blue-700 transition-colors">Semua</button>
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

    {{-- 7. MEDIA SOSIAL (Background Putih) --}}
    <section class="py-12 bg-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Media Sosial</h2>
                <div class="flex-1 h-px bg-neutral-200"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-4 gap-6">
                {{-- Sidebar Social Media List --}}
                <div class="lg:col-span-1 space-y-2">
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg bg-gradient-to-r from-purple-600 to-pink-600 text-white shadow-lg hover:shadow-xl transition-all hover:-translate-y-0.5">
                        <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                        <div class="flex-1">
                            <div class="text-sm font-semibold">Instagram</div>
                            <div class="text-xs opacity-80">@schoolportal</div>
                        </div>
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 transition-all">
                        <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z"/></svg>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-neutral-900">TikTok</div>
                            <div class="text-xs text-neutral-500">@schoolportal</div>
                        </div>
                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                    <a href="#" class="flex items-center gap-3 p-3 rounded-lg hover:bg-neutral-100 transition-all">
                        <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z"/></svg>
                        <div class="flex-1">
                            <div class="text-sm font-semibold text-neutral-900">YouTube</div>
                            <div class="text-xs text-neutral-500">School Portal</div>
                        </div>
                        <svg class="w-4 h-4 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>

                {{-- Social Media Content --}}
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
                        @foreach($latestGalleries->take(6) as $gallery)
                            <div class="aspect-square rounded-xl overflow-hidden bg-neutral-100 shadow-md hover:shadow-xl transition-all hover:-translate-y-1">
                                <img src="{{ $gallery->thumbnail_url ?? 'https://via.placeholder.com/300' }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </section>
    <div class="bg-gradient-to-t from-neutral-950 via-neutral-000 to-white py-16"></div>
@endsection

@push('scripts')
<script>
    // Marquee animation
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

    // Swiper initialization dengan loop infinite
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
@endpush