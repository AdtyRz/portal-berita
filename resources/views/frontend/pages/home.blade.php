@extends('frontend.layouts.app')

@section('title', 'Home')

@section('content')
    @php
        $schoolProfile = \App\Models\SchoolProfile::first();
        $siteName = $schoolProfile->name ?? 'School Portal';
        $siteTagline = $schoolProfile->tagline ?? 'Excellence in Education';
    @endphp

{{-- Hero Section - Split Layout Modern --}}
@if (isset($heroSliders) && $heroSliders->count() > 0)
    <section class="relative pt-24 md:pt-32">
        <div class="swiper mySwiper h-[350px] md:h-[500px] lg:h-[600px]">
            <div class="swiper-wrapper">
                @foreach ($heroSliders as $slider)
                    <div class="swiper-slide relative">
                        <img src="{{ $slider->image_url }}" alt="{{ $slider->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/90 via-black/50 to-transparent"></div>
                        <div class="absolute bottom-0 left-0 right-0 p-4 md:p-12 lg:p-16">
                            <div class="mx-auto max-w-7xl">
                                <div class="max-w-3xl">
                                    <span class="inline-block px-3 py-1 bg-white/20 backdrop-blur-sm text-white text-xs font-bold rounded-full mb-3">FEATURED</span>
                                    <h1 class="text-2xl md:text-4xl lg:text-5xl font-bold text-white mb-3 leading-tight" style="font-family: var(--font-heading);">
                                        {{ $slider->title }}
                                    </h1>
                                    @if ($slider->description)
                                        <p class="text-sm md:text-base text-neutral-200 mb-4 line-clamp-2">
                                            {{ $slider->description }}
                                        </p>
                                    @endif
                                    @if ($slider->button_text && $slider->button_url)
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
    {{-- Fallback: Default Hero Section - Split Layout --}}
    <section class="relative bg-stone-100 pt-28 md:pt-32 pb-16 md:pb-24 overflow-hidden">
        
        {{-- Background Pattern - Subtle Geometric --}}
        <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml,%3Csvg width=\'60\' height=\'60\' viewBox=\'0 0 60 60\' xmlns=\'http://www.w3.org/2000/svg\'%3E%3Cg fill=\'none\' fill-rule=\'evenodd\'%3E%3Cg fill=\'%23000000\' fill-opacity=\'1\'%3E%3Cpath d=\'M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z\'/%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        
        {{-- Decorative Gradient Blobs --}}
        <div class="absolute top-0 right-0 w-96 h-96 bg-amber-200/30 rounded-full blur-3xl -translate-y-1/2 translate-x-1/2"></div>
        <div class="absolute bottom-0 left-0 w-96 h-96 bg-orange-200/30 rounded-full blur-3xl translate-y-1/2 -translate-x-1/2"></div>

        {{-- Content Container --}}
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 items-center">
                
                {{-- Left Side: Text Content --}}
                <div class="text-center lg:text-left order-2 lg:order-1">
                    {{-- Welcome Badge --}}
                    <div class="inline-flex items-center gap-2 px-4 py-2 bg-amber-100 border border-amber-200 rounded-full mb-6">
                        <span class="w-2 h-2 bg-amber-600 rounded-full animate-pulse"></span>
                        <span class="text-xs md:text-sm font-semibold text-amber-900">Portal Resmi Sekolah</span>
                    </div>

                    {{-- Main Title --}}
                    <h1 class="text-4xl md:text-5xl lg:text-6xl font-bold text-stone-900 mb-4 leading-tight" style="font-family: var(--font-heading);">
                        Selamat Datang di
                        <span class="block text-transparent bg-clip-text bg-gradient-to-r from-amber-700 to-orange-700 mt-2">
                            {{ $siteName }}
                        </span>
                    </h1>

                    {{-- Tagline --}}
                    <p class="text-base md:text-lg text-stone-600 mb-8 max-w-xl mx-auto lg:mx-0 leading-relaxed">
                        {{ $siteTagline }}
                    </p>

                    {{-- Quick Stats - Horizontal --}}
                    <div class="flex flex-wrap items-center justify-center lg:justify-start gap-6 mb-8">
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-amber-700">{{ $latestPosts->count() }}+</div>
                            <div class="text-xs text-stone-600 font-medium">Berita</div>
                        </div>
                        <div class="w-px h-10 bg-stone-300"></div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-blue-700">{{ $latestAnnouncements->count() }}+</div>
                            <div class="text-xs text-stone-600 font-medium">Pengumuman</div>
                        </div>
                        <div class="w-px h-10 bg-stone-300"></div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-green-700">{{ $upcomingAgendas->count() }}+</div>
                            <div class="text-xs text-stone-600 font-medium">Agenda</div>
                        </div>
                        <div class="w-px h-10 bg-stone-300"></div>
                        <div class="text-center">
                            <div class="text-2xl md:text-3xl font-bold text-purple-700">{{ $latestAchievements->count() }}+</div>
                            <div class="text-xs text-stone-600 font-medium">Prestasi</div>
                        </div>
                    </div>

                    {{-- CTA Buttons --}}
                    <div class="flex flex-col sm:flex-row items-center justify-center lg:justify-start gap-4">
                        <a href="{{ route('frontend.posts.index') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-gradient-to-r from-amber-700 to-orange-700 text-white font-bold rounded-full hover:from-amber-800 hover:to-orange-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5 text-base">
                            Baca Berita Terbaru
                        </a>
                        <a href="{{ route('frontend.about') }}"
                            class="w-full sm:w-auto px-8 py-4 bg-white text-stone-900 font-bold rounded-full border-2 border-stone-300 hover:border-stone-400 hover:bg-stone-50 transition-all shadow-md hover:shadow-lg text-base">
                            Tentang Sekolah
                        </a>
                    </div>
                </div>

                {{-- Right Side: School Logo Circle --}}
                <div class="flex justify-center lg:justify-end order-1 lg:order-2">
                    <div class="relative">
                        {{-- Outer Decorative Ring --}}
                        <div class="absolute inset-0 rounded-full bg-gradient-to-br from-amber-200 to-orange-200 scale-110 blur-2xl opacity-60"></div>
                        
                        {{-- Main Circle Container --}}
                        <div class="relative w-72 h-72 md:w-96 md:h-96 lg:w-[420px] lg:h-[420px] rounded-full bg-gradient-to-br from-amber-100 to-orange-100 p-4 md:p-6 shadow-2xl border-4 border-white">
                            {{-- Inner Circle with Logo --}}
                            <div class="w-full h-full rounded-full bg-white shadow-inner flex items-center justify-center overflow-hidden p-8 md:p-12">
                                @if($schoolProfile->logo)
                                    <img src="{{ $schoolProfile->logo_url }}" 
                                         alt="{{ $siteName }}" 
                                         class="w-full h-full object-contain drop-shadow-lg">
                                @else
                                    <div class="text-center">
                                        <svg class="w-20 h-20 md:w-28 md:h-28 text-amber-700 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                                        </svg>
                                        <p class="text-stone-500 text-sm font-medium">{{ $siteName }}</p>
                                    </div>
                                @endif
                            </div>
                        </div>

                        {{-- Floating Accent Dots --}}
                        <div class="absolute top-8 -left-4 w-4 h-4 bg-amber-600 rounded-full shadow-lg"></div>
                        <div class="absolute bottom-12 -right-4 w-6 h-6 bg-orange-600 rounded-full shadow-lg"></div>
                        <div class="absolute top-1/2 -right-8 w-3 h-3 bg-blue-600 rounded-full shadow-lg"></div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endif

    {{-- 2. BREAKING NEWS (Merah) --}}
    @if (isset($breakingNews) && $breakingNews->count() > 0)
        <div class="bg-red-600 text-white py-2 relative z-10">
            <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                <div class="flex items-center gap-4">
                    <span
                        class="px-3 py-1 bg-white text-red-600 text-xs font-bold rounded uppercase tracking-wider shrink-0 animate-pulse">Breaking</span>
                    <div class="flex-1 overflow-hidden">
                        <div class="flex gap-8 whitespace-nowrap animate-marquee">
                            @foreach ($breakingNews as $news)
                                <a href="{{ route('frontend.posts.show', $news->slug) }}"
                                    class="text-sm font-medium hover:underline transition-colors">{{ $news->title }}</a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif

    {{-- 3. GRADIENT TRANSITION --}}
    <div class="bg-gradient-to-b from-stone-900 via-stone-400 to-stone-200 relative">
        <div class="h-32 md:h-8"></div>
        <div class="py-4">
            {{-- 4. PROGRAM PRIORITAS --}}
            <section>
                <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
                    <div class="flex items-center gap-3 mb-8">
                        <svg class="w-6 h-6 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-white" style="font-family: var(--font-heading);">Program
                            Prioritas</h2>
                        <div class="flex-1 h-px bg-white/30"></div>
                    </div>
                    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4">
                        @foreach ($latestAchievements->take(6) as $achievement)
                            <a href="{{ route('frontend.achievements.show', $achievement->slug) }}"
                                class="group relative rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                                <div class="aspect-[4/3] overflow-hidden bg-neutral-800">
                                    @if ($achievement->thumbnail)
                                        <img src="{{ asset('storage/' . $achievement->thumbnail) }}"
                                            alt="{{ $achievement->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div
                                            class="w-full h-full flex items-center justify-center text-neutral-500 text-xs">
                                            No Image
                                        </div>
                                    @endif
                                </div>
                                <div class="absolute inset-0 bg-gradient-to-t from-black/90 to-transparent"></div>
                                <div class="absolute bottom-0 left-0 right-0 p-3">
                                    <h3 class="text-xs font-semibold text-white line-clamp-2">{{ $achievement->title }}
                                    </h3>
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
                        <svg class="w-6 h-6 text-stone-50" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                        </svg>
                        <h2 class="text-2xl font-bold text-stone-50" style="font-family: var(--font-heading);">Informasi
                            Terkini</h2>
                        <div class="flex-1 h-px bg-white/30"></div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
                        {{-- Main Post --}}
                        @if ($featuredPosts->count() > 0)
                            @php $mainPost = $featuredPosts[0]; @endphp
                            <div class="lg:col-span-2">
                                <a href="{{ route('frontend.posts.show', $mainPost->slug) }}"
                                    class="group block rounded-xl overflow-hidden bg-white/10 backdrop-blur-sm border border-white/20 shadow-lg hover:shadow-2xl transition-all hover:-translate-y-1">
                                    <div class="aspect-[16/9] overflow-hidden">
                                        <img src="{{ $mainPost->thumbnail_url }}" alt="{{ $mainPost->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="p-5">
                                        <span
                                            class="inline-block px-2 py-1 bg-white text-black text-xs font-bold rounded mb-2">{{ $mainPost->category->name ?? 'Berita' }}</span>
                                        <h3
                                            class="text-lg md:text-xl font-bold text-black mb-2 line-clamp-2 group-hover:text-blue-400 transition-colors">
                                            {{ $mainPost->title }}</h3>
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
                            @foreach ($latestPosts->take(2) as $post)
                                <a href="{{ route('frontend.posts.show', $post->slug) }}"
                                    class="group flex gap-4 p-3 rounded-xl bg-white/10 backdrop-blur-sm border border-white/20 hover:bg-white/20 transition-all">
                                    <div class="w-24 h-24 rounded-lg overflow-hidden shrink-0">
                                        <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <h4
                                            class="text-sm font-semibold text-black mb-1 line-clamp-2 group-hover:text-blue-400 transition-colors">
                                            {{ $post->title }}</h4>
                                        <div class="text-xs text-neutral-700">{{ $post->publish_date?->format('d M Y') }}
                                        </div>
                                    </div>
                                </a>
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </div>

    {{-- 6. KATEGORI BERITA --}}
    <section class="py-12 bg-stone-200" x-data="{ activeCategory: 'all' }" x-cloak>
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex items-center gap-3 mb-8">
                <svg class="w-6 h-6 text-stone-800" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                </svg>
                <h2 class="text-2xl font-bold text-stone-800" style="font-family: var(--font-heading);">Kategori Berita
                </h2>
                <div class="flex-1 h-px bg-stone-300"></div>
            </div>

            @php
                // Ambil kategori yang aktif dari database
                // Jika controller sudah mengirim variabel $categories, gunakan itu.
                // Jika tidak, fallback ke query langsung agar tetap aman.
                $availableCategories = $categories ?? \App\Models\Category::where('status', 1)->orderBy('order')->get();
            @endphp

            {{-- Filter Tabs (Dinamis) --}}
            <div class="flex gap-2 mb-8 overflow-x-auto pb-2 no-scrollbar"
                style="scrollbar-width: none; -ms-overflow-style: none;">
                {{-- Tombol "Semua" (Selalu Ada) --}}
                <button @click="activeCategory = 'all'"
                    :class="activeCategory === 'all' ? 'bg-stone-800 text-stone-50 shadow-md' :
                        'bg-white text-stone-700 hover:bg-stone-200 border border-stone-200'"
                    class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-200">
                    Semua
                </button>

                {{-- Tombol Kategori Dinamis --}}
                @foreach ($availableCategories as $category)
                    <button @click="activeCategory = '{{ $category->id }}'"
                        :class="activeCategory === '{{ $category->id }}' ? 'bg-stone-800 text-stone-50 shadow-md' :
                            'bg-white text-stone-700 hover:bg-stone-200 border border-stone-200'"
                        class="px-5 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all duration-200">
                        {{ $category->name }}
                    </button>
                @endforeach
            </div>

            {{-- Grid Posts dengan Filter Alpine.js --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach ($latestPosts as $post)
                    <article {{-- Logika Filter: Tampilkan jika 'all' ATAU category_id cocok --}}
                        x-show="activeCategory === 'all' || activeCategory == {{ $post->category_id }}"
                        x-transition:enter="transition ease-out duration-300"
                        x-transition:enter-start="opacity-0 scale-95" x-transition:enter-end="opacity-100 scale-100"
                        class="group bg-stone-50 rounded-xl overflow-hidden border border-stone-200 shadow-sm hover:shadow-lg hover:border-amber-700/30 transition-all hover:-translate-y-1">
                        <div class="aspect-[4/3] overflow-hidden">
                            <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}"
                                class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                        </div>
                        <div class="p-4">
                            @if ($post->category)
                                <span
                                    class="inline-block px-2 py-1 bg-amber-100 text-amber-900 text-xs font-semibold rounded mb-2">
                                    {{ $post->category->name }}
                                </span>
                            @endif
                            <h3
                                class="text-sm font-bold text-stone-800 mb-2 line-clamp-2 group-hover:text-amber-800 transition-colors">
                                {{ $post->title }}
                            </h3>
                            <div class="flex items-center gap-2 text-xs text-stone-500">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                </svg>
                                <span>{{ $post->publish_date?->format('d M Y') }}</span>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            {{-- Pesan Jika Tidak Ada Post di Kategori Terpilih (Opsional, untuk UX yang lebih baik) --}}
            <div x-show="false" class="hidden text-center py-12 text-stone-500">
                <!-- Alpine akan menangani ini secara otomatis, tapi jika semua post di-hide, grid akan kosong. -->
            </div>
        </div>
    </section>

       {{-- 7. MEDIA SOSIAL --}}
    <section class="py-12 bg-stone-200">
        @php
            $schoolProfile = \App\Models\SchoolProfile::first();

            $getHandle = function ($url, $default) {
                if (!$url) {
                    return $default;
                }
                $url = trim($url, '/');
                $parts = explode('/', $url);
                $handle = end($parts);
                return (str_starts_with($handle, '@') ? '' : '@') . $handle;
            };

            $igUrl = $schoolProfile->instagram ?? '';
            $ttUrl = $schoolProfile->tiktok ?? '';
            $ytUrl = $schoolProfile->youtube ?? '';
            $fbUrl = $schoolProfile->facebook ?? '';

            $igHandle = $getHandle($igUrl, '@instagram');
            $ttHandle = $getHandle($ttUrl, '@tiktok');
            $ytHandle = $getHandle($ytUrl, 'YouTube Channel');
            $fbHandle = $getHandle($fbUrl, 'Facebook Page');

            $hasIg = !empty($schoolProfile->instagram_embed_1) || !empty($schoolProfile->instagram_embed_2);
            $hasTt = !empty($schoolProfile->tiktok_embed_1) || !empty($schoolProfile->tiktok_embed_2);
            $hasYt = !empty($schoolProfile->youtube_embed_1) || !empty($schoolProfile->youtube_embed_2);
            $hasFb = !empty($schoolProfile->facebook_embed_1) || !empty($schoolProfile->facebook_embed_2);
        @endphp

        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Section Header --}}
            <div class="flex items-center gap-3 mb-8">
                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Media Sosial</h2>
                <div class="flex-1 h-px bg-black"></div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-8">
                {{-- Left Sidebar: Social Media List --}}
                <div class="lg:col-span-4">
                    <div class="bg-stone-100 rounded-2xl border border-neutral-200 overflow-hidden shadow-sm">
                        @if ($hasIg)
                            <button type="button" onclick="switchSocialMedia('instagram')"
                                class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-200 hover:bg-neutral-50"
                                data-platform="instagram">
                                <div class="w-12 h-12 rounded-full bg-gradient-to-br from-purple-600 to-pink-600 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-white" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-semibold text-neutral-900">Instagram</div>
                                    <div class="text-sm text-neutral-500">{{ $igHandle }}</div>
                                </div>
                                <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif

                        @if ($hasTt)
                            <button type="button" onclick="switchSocialMedia('tiktok')"
                                class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-200 hover:bg-neutral-50"
                                data-platform="tiktok">
                                <div class="w-12 h-12 rounded-full bg-neutral-100 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-neutral-900" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-semibold text-neutral-900">TikTok</div>
                                    <div class="text-sm text-neutral-500">{{ $ttHandle }}</div>
                                </div>
                                <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif

                        @if ($hasYt)
                            <button type="button" onclick="switchSocialMedia('youtube')"
                                class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group border-b border-neutral-200 hover:bg-neutral-50"
                                data-platform="youtube">
                                <div class="w-12 h-12 rounded-full bg-red-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-red-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-semibold text-neutral-900">YouTube</div>
                                    <div class="text-sm text-neutral-500">{{ $ytHandle }}</div>
                                </div>
                                <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif

                        @if ($hasFb)
                            <button type="button" onclick="switchSocialMedia('facebook')"
                                class="socmed-btn w-full flex items-center gap-4 p-4 transition-all group hover:bg-neutral-50"
                                data-platform="facebook">
                                <div class="w-12 h-12 rounded-full bg-blue-50 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-blue-600" fill="currentColor" viewBox="0 0 24 24">
                                        <path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" />
                                    </svg>
                                </div>
                                <div class="flex-1 text-left">
                                    <div class="font-semibold text-neutral-900">Facebook</div>
                                    <div class="text-sm text-neutral-500">{{ $fbHandle }}</div>
                                </div>
                                <svg class="w-5 h-5 text-neutral-400 group-hover:text-neutral-600 transition-colors" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7" />
                                </svg>
                            </button>
                        @endif
                    </div>
                </div>

                {{-- Right Content: Dynamic Social Media Feed --}}
                <div class="lg:col-span-8">
                    <div class="bg-white rounded-2xl border border-neutral-200 overflow-hidden shadow-sm flex flex-col h-[700px]">
                        
                        {{-- Header dengan Navigation Buttons --}}
                        <div class="p-6 border-b border-neutral-200 bg-white shrink-0">
                            @if ($hasIg)
                                <div id="instagram-header" class="social-header">
                                    <div class="flex items-center justify-between gap-4">
                                        @if (!empty($schoolProfile->instagram_embed_1) && !empty($schoolProfile->instagram_embed_2))
                                            <button onclick="navigateEmbed('instagram', 'prev')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0" aria-label="Previous">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/>
                                                </svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif

                                        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 flex-1 text-center justify-center">
                                            <svg class="w-5 h-5 text-pink-600" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z" />
                                            </svg>
                                            Latest from Instagram
                                        </h3>

                                        @if (!empty($schoolProfile->instagram_embed_1) && !empty($schoolProfile->instagram_embed_2))
                                            <button onclick="navigateEmbed('instagram', 'next')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0" aria-label="Next">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                                                </svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                    </div>
                                    @if ($igUrl)
                                        <div class="mt-3 text-center">
                                            <a href="{{ $igUrl }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Follow Us →</a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if ($hasTt)
                                <div id="tiktok-header" class="social-header hidden">
                                    <div class="flex items-center justify-between gap-4">
                                        @if (!empty($schoolProfile->tiktok_embed_1) && !empty($schoolProfile->tiktok_embed_2))
                                            <button onclick="navigateEmbed('tiktok', 'prev')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 flex-1 text-center justify-center">
                                            <svg class="w-5 h-5 text-neutral-900" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1-.1z" /></svg>
                                            Latest from TikTok
                                        </h3>
                                        @if (!empty($schoolProfile->tiktok_embed_1) && !empty($schoolProfile->tiktok_embed_2))
                                            <button onclick="navigateEmbed('tiktok', 'next')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                    </div>
                                    @if ($ttUrl)
                                        <div class="mt-3 text-center">
                                            <a href="{{ $ttUrl }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Follow Us →</a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if ($hasYt)
                                <div id="youtube-header" class="social-header hidden">
                                    <div class="flex items-center justify-between gap-4">
                                        @if (!empty($schoolProfile->youtube_embed_1) && !empty($schoolProfile->youtube_embed_2))
                                            <button onclick="navigateEmbed('youtube', 'prev')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 flex-1 text-center justify-center">
                                            <svg class="w-5 h-5 text-red-600" fill="currentColor" viewBox="0 0 24 24"><path d="M23.498 6.186a3.016 3.016 0 0 0-2.122-2.136C19.505 3.545 12 3.545 12 3.545s-7.505 0-9.377.505A3.017 3.017 0 0 0 .502 6.186C0 8.07 0 12 0 12s0 3.93.502 5.814a3.016 3.016 0 0 0 2.122 2.136c1.871.505 9.376.505 9.376.505s7.505 0 9.377-.505a3.015 3.015 0 0 0 2.122-2.136C24 15.93 24 12 24 12s0-3.93-.502-5.814zM9.545 15.568V8.432L15.818 12l-6.273 3.568z" /></svg>
                                            Latest from YouTube
                                        </h3>
                                        @if (!empty($schoolProfile->youtube_embed_1) && !empty($schoolProfile->youtube_embed_2))
                                            <button onclick="navigateEmbed('youtube', 'next')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                    </div>
                                    @if ($ytUrl)
                                        <div class="mt-3 text-center">
                                            <a href="{{ $ytUrl }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Subscribe →</a>
                                        </div>
                                    @endif
                                </div>
                            @endif

                            @if ($hasFb)
                                <div id="facebook-header" class="social-header hidden">
                                    <div class="flex items-center justify-between gap-4">
                                        @if (!empty($schoolProfile->facebook_embed_1) && !empty($schoolProfile->facebook_embed_2))
                                            <button onclick="navigateEmbed('facebook', 'prev')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                        <h3 class="text-lg font-bold text-neutral-900 flex items-center gap-2 flex-1 text-center justify-center">
                                            <svg class="w-5 h-5 text-blue-600" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z" /></svg>
                                            Latest from Facebook
                                        </h3>
                                        @if (!empty($schoolProfile->facebook_embed_1) && !empty($schoolProfile->facebook_embed_2))
                                            <button onclick="navigateEmbed('facebook', 'next')" class="w-10 h-10 rounded-full border border-neutral-300 hover:bg-neutral-100 flex items-center justify-center transition-colors shrink-0">
                                                <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                                            </button>
                                        @else
                                            <div class="w-10"></div>
                                        @endif
                                    </div>
                                    @if ($fbUrl)
                                        <div class="mt-3 text-center">
                                            <a href="{{ $fbUrl }}" target="_blank" class="text-sm text-blue-600 hover:underline font-medium">Like Page →</a>
                                        </div>
                                    @endif
                                </div>
                            @endif
                        </div>

                        {{-- Content Area dengan Scroll --}}
                        <div class="flex-1 overflow-y-auto p-6 bg-neutral-50 custom-scrollbar">
                            
                            {{-- Instagram Feed --}}
                            @if ($hasIg)
                                <div id="instagram-feed" class="social-feed-content">
                                    <div class="flex justify-center">
                                        @if (!empty($schoolProfile->instagram_embed_1))
                                            <div id="instagram-embed-1" class="embed-wrapper-single w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->instagram_embed_1 !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($schoolProfile->instagram_embed_2))
                                            <div id="instagram-embed-2" class="embed-wrapper-single hidden w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->instagram_embed_2 !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- TikTok Feed --}}
                            @if ($hasTt)
                                <div id="tiktok-feed" class="social-feed-content hidden">
                                    <div class="flex justify-center">
                                        @if (!empty($schoolProfile->tiktok_embed_1))
                                            <div id="tiktok-embed-1" class="embed-wrapper-single w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->tiktok_embed_1 !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($schoolProfile->tiktok_embed_2))
                                            <div id="tiktok-embed-2" class="embed-wrapper-single hidden w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->tiktok_embed_2 !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- YouTube Feed --}}
                            @if ($hasYt)
                                <div id="youtube-feed" class="social-feed-content hidden">
                                    <div class="flex justify-center">
                                        @if (!empty($schoolProfile->youtube_embed_1))
                                            <div id="youtube-embed-1" class="embed-wrapper-single w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->youtube_embed_1 !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($schoolProfile->youtube_embed_2))
                                            <div id="youtube-embed-2" class="embed-wrapper-single hidden w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->youtube_embed_2 !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                            {{-- Facebook Feed --}}
                            @if ($hasFb)
                                <div id="facebook-feed" class="social-feed-content hidden">
                                    <div class="flex justify-center">
                                        @if (!empty($schoolProfile->facebook_embed_1))
                                            <div id="facebook-embed-1" class="embed-wrapper-single w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->facebook_embed_1 !!}
                                                </div>
                                            </div>
                                        @endif
                                        @if (!empty($schoolProfile->facebook_embed_2))
                                            <div id="facebook-embed-2" class="embed-wrapper-single hidden w-full max-w-[350px]">
                                                <div class="bg-white rounded-xl p-4 shadow-sm border border-neutral-200 flex justify-center">
                                                    {!! $schoolProfile->facebook_embed_2 !!}
                                                </div>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            @endif

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @endsection

@push('scripts')
<script>
    // Fungsi untuk switch platform
    function switchSocialMedia(platform) {
        // Hide all feeds and headers
        document.querySelectorAll('.social-feed-content').forEach(el => el.classList.add('hidden'));
        document.querySelectorAll('.social-header').forEach(el => el.classList.add('hidden'));
        
        // Remove active class from buttons
        document.querySelectorAll('.socmed-btn').forEach(btn => btn.classList.remove('bg-neutral-100'));
        
        // Show selected
        const feed = document.getElementById(platform + '-feed');
        const header = document.getElementById(platform + '-header');
        
        if (feed) feed.classList.remove('hidden');
        if (header) header.classList.remove('hidden');
        
        // Add active class to button
        const btn = document.querySelector('.socmed-btn[data-platform="' + platform + '"]');
        if (btn) btn.classList.add('bg-neutral-100');
    }

    // Fungsi untuk navigasi antar embed dalam platform yang sama
    function navigateEmbed(platform, direction) {
        const embed1 = document.getElementById(platform + '-embed-1');
        const embed2 = document.getElementById(platform + '-embed-2');
        
        if (!embed1 && !embed2) return;
        
        if (direction === 'next') {
            // Pindah dari embed 1 ke embed 2
            if (embed1 && !embed1.classList.contains('hidden')) {
                if (embed2) {
                    embed1.classList.add('hidden');
                    embed2.classList.remove('hidden');
                }
            }
        } else {
            // Pindah dari embed 2 ke embed 1
            if (embed2 && !embed2.classList.contains('hidden')) {
                if (embed1) {
                    embed2.classList.add('hidden');
                    embed1.classList.remove('hidden');
                }
            }
        }
    }

    // Inisialisasi dengan platform pertama yang tersedia
    document.addEventListener('DOMContentLoaded', function() {
        const firstPlatform = document.querySelector('.socmed-btn');
        if (firstPlatform) {
            const platform = firstPlatform.getAttribute('data-platform');
            switchSocialMedia(platform);
        }

        // Marquee animation & Custom Scrollbar
        const style = document.createElement('style');
        style.textContent = `
            @keyframes marquee {
                0% { transform: translateX(0); }
                100% { transform: translateX(-50%); }
            }
            .animate-marquee {
                animation: marquee 30s linear infinite;
            }
            .custom-scrollbar::-webkit-scrollbar {
                width: 8px;
            }
            .custom-scrollbar::-webkit-scrollbar-track {
                background: #f1f1f1;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb {
                background: #888;
                border-radius: 4px;
            }
            .custom-scrollbar::-webkit-scrollbar-thumb:hover {
                background: #555;
            }
        `;
        document.head.appendChild(style);

        // Swiper initialization
        if (typeof Swiper !== 'undefined') {
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
        }
    });
</script>
@endpush