@extends('frontend.layouts.app')

@section('title', $organization->name)
@section('metaDescription', $organization->position ?? Str::limit(strip_tags($organization->description), 160))

@section('content')
<article class="py-12 bg-white">
    <div class="mx-auto max-w-5xl px-4 sm:px-6 lg:px-8">
        {{-- Breadcrumb --}}
        <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
            <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            <a href="{{ route('frontend.about') }}" class="hover:text-neutral-900">About</a>
            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
            <span class="text-neutral-900 truncate">{{ Str::limit($organization->name, 40) }}</span>
        </nav>

        {{-- Profile Card --}}
        <div class="mb-10 bg-white rounded-2xl border border-neutral-200 shadow-sm overflow-hidden">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-0">
                {{-- Photo Section --}}
                <div class="relative aspect-square md:aspect-auto bg-neutral-100 flex items-center justify-center overflow-hidden">
                    @if($organization->photo)
                        <img src="{{ $organization->photo_url }}" alt="{{ $organization->name }}" class="w-full h-full object-cover">
                    @else
                        <div class="w-40 h-40 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-600 text-6xl font-bold">
                            {{ strtoupper(substr($organization->name, 0, 1)) }}
                        </div>
                    @endif
                </div>

                {{-- Info Section --}}
                <div class="md:col-span-2 p-8 md:p-10 flex flex-col justify-center">
                    @if($organization->organization_type)
                        <span class="inline-block px-3 py-1 bg-neutral-100 text-neutral-700 text-xs font-semibold rounded-full uppercase tracking-wider mb-3 w-fit">
                            {{ ucfirst($organization->organization_type) }}
                        </span>
                    @endif
                    
                    <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-2" style="font-family: var(--font-heading);">
                        {{ $organization->name }}
                    </h1>
                    
                    @if($organization->position)
                        <p class="text-lg text-neutral-600 mb-6">{{ $organization->position }}</p>
                    @endif

                    {{-- Quick Stats --}}
                    <div class="grid grid-cols-3 gap-4 mb-6">
                        <div class="text-center p-3 bg-white border border-neutral-200 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900">{{ $organization->gallery_count }}</div>
                            <div class="text-xs text-neutral-500 mt-1">Activities</div>
                        </div>
                        <div class="text-center p-3 bg-white border border-neutral-200 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900">{{ $organization->featuredGalleries->count() }}</div>
                            <div class="text-xs text-neutral-500 mt-1">Featured</div>
                        </div>
                        <div class="text-center p-3 bg-white border border-neutral-200 rounded-xl">
                            <div class="text-2xl font-bold text-neutral-900">{{ $organization->getAvailableYears()->count() }}</div>
                            <div class="text-xs text-neutral-500 mt-1">Years</div>
                        </div>
                    </div>

                    {{-- Social Media Links --}}
                    @if($organization->facebook || $organization->instagram || $organization->twitter || $organization->linkedin)
                        <div class="flex items-center gap-3 mb-6">
                            <span class="text-sm text-neutral-500 mr-2">Connect:</span>
                            @if($organization->facebook)
                                <a href="{{ $organization->facebook }}" target="_blank" class="w-10 h-10 rounded-full bg-neutral-100 text-neutral-700 flex items-center justify-center hover:bg-neutral-900 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                                </a>
                            @endif
                            @if($organization->instagram)
                                <a href="{{ $organization->instagram }}" target="_blank" class="w-10 h-10 rounded-full bg-neutral-100 text-neutral-700 flex items-center justify-center hover:bg-neutral-900 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069zm0-2.163c-3.259 0-3.667.014-4.947.072-4.358.2-6.78 2.618-6.98 6.98-.059 1.281-.073 1.689-.073 4.948 0 3.259.014 3.668.072 4.948.2 4.358 2.618 6.78 6.98 6.98 1.281.058 1.689.072 4.948.072 3.259 0 3.668-.014 4.948-.072 4.354-.2 6.782-2.618 6.979-6.98.059-1.28.073-1.689.073-4.948 0-3.259-.014-3.667-.072-4.947-.196-4.354-2.617-6.78-6.979-6.98-1.281-.059-1.69-.073-4.949-.073zm0 5.838c-3.403 0-6.162 2.759-6.162 6.162s2.759 6.163 6.162 6.163 6.162-2.759 6.162-6.163c0-3.403-2.759-6.162-6.162-6.162zm0 10.162c-2.209 0-4-1.79-4-4 0-2.209 1.791-4 4-4s4 1.791 4 4c0 2.21-1.791 4-4 4zm6.406-11.845c-.796 0-1.441.645-1.441 1.44s.645 1.44 1.441 1.44c.795 0 1.439-.645 1.439-1.44s-.644-1.44-1.439-1.44z"/></svg>
                                </a>
                            @endif
                            @if($organization->twitter)
                                <a href="{{ $organization->twitter }}" target="_blank" class="w-10 h-10 rounded-full bg-neutral-100 text-neutral-700 flex items-center justify-center hover:bg-neutral-900 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.189 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                                </a>
                            @endif
                            @if($organization->linkedin)
                                <a href="{{ $organization->linkedin }}" target="_blank" class="w-10 h-10 rounded-full bg-neutral-100 text-neutral-700 flex items-center justify-center hover:bg-neutral-900 hover:text-white transition-all">
                                    <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 24 24"><path d="M20.447 20.452h-3.554v-5.569c0-1.328-.027-3.037-1.852-3.037-1.853 0-2.136 1.445-2.136 2.939v5.667H9.351V9h3.414v1.561h.046c.477-.9 1.637-1.85 3.37-1.85 3.601 0 4.267 2.37 4.267 5.455v6.286zM5.337 7.433a2.062 2.062 0 01-2.063-2.065 2.063 2.063 0 112.063 2.065zm1.782 13.019H3.555V9h3.564v11.452zM22.225 0H1.771C.792 0 0 .774 0 1.729v20.542C0 23.227.792 24 1.771 24h20.451C23.2 24 24 23.227 24 22.271V1.729C24 .774 23.2 0 22.222 0h.003z"/></svg>
                                </a>
                            @endif
                        </div>
                    @endif

                    @if($organization->description)
                        <div class="prose prose-neutral max-w-none text-neutral-700">
                            {!! nl2br(e($organization->description)) !!}
                        </div>
                    @endif
                </div>
            </div>
        </div>

        {{-- Vision & Mission Section --}}
        @if($organization->vision || $organization->mission)
            <section class="mb-12">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    @if($organization->vision)
                        <div class="bg-white rounded-2xl p-8 border border-neutral-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-neutral-900 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Vision</h2>
                            </div>
                            <p class="text-neutral-700 leading-relaxed">{!! nl2br(e($organization->vision)) !!}</p>
                        </div>
                    @endif

                    @if($organization->mission)
                        <div class="bg-white rounded-2xl p-8 border border-neutral-200">
                            <div class="flex items-center gap-3 mb-4">
                                <div class="w-10 h-10 rounded-xl bg-neutral-900 text-white flex items-center justify-center">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                                    </svg>
                                </div>
                                <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Mission</h2>
                            </div>
                            <p class="text-neutral-700 leading-relaxed">{!! nl2br(e($organization->mission)) !!}</p>
                        </div>
                    @endif
                </div>
            </section>
        @endif

        {{-- Achievements Section --}}
        @if($organization->achievements)
            <section class="mb-12">
                <div class="bg-white rounded-2xl p-8 border border-neutral-200">
                    <div class="flex items-center gap-3 mb-6">
                        <div class="w-10 h-10 rounded-xl bg-neutral-900 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Achievements</h2>
                    </div>
                    <div class="prose prose-neutral max-w-none text-neutral-700">
                        {!! nl2br(e($organization->achievements)) !!}
                    </div>
                </div>
            </section>
        @endif

        {{-- Gallery Section --}}
        @if($organization->galleries->count() > 0)
            <section class="mb-12">
                <div class="flex items-center justify-between mb-6">
                    <div>
                        <h2 class="text-2xl font-bold text-neutral-900" style="font-family: var(--font-heading);">Activity Gallery</h2>
                        <p class="text-sm text-neutral-500 mt-1">Documented activities and events</p>
                    </div>
                </div>

                {{-- Filter by Year --}}
                @if($organization->getAvailableYears()->count() > 1)
                    <div class="mb-6 flex flex-wrap gap-2">
                        <button type="button" class="gallery-filter-btn active px-4 py-2 text-sm font-medium bg-neutral-900 text-white rounded-lg" data-year="all">
                            All Years
                        </button>
                        @foreach($organization->getAvailableYears() as $year)
                            <button type="button" class="gallery-filter-btn px-4 py-2 text-sm font-medium bg-white text-neutral-700 border border-neutral-200 rounded-lg hover:bg-neutral-50" data-year="{{ $year }}">
                                {{ $year }}
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Filter by Type --}}
                @if($organization->getEventTypes()->count() > 1)
                    <div class="mb-6 flex flex-wrap gap-2">
                        <button type="button" class="type-filter-btn active px-4 py-2 text-sm font-medium bg-neutral-900 text-white rounded-lg" data-type="all">
                            All Types
                        </button>
                        @foreach($organization->getEventTypes() as $type)
                            <button type="button" class="type-filter-btn px-4 py-2 text-sm font-medium bg-white text-neutral-700 border border-neutral-200 rounded-lg hover:bg-neutral-50" data-type="{{ $type }}">
                                {{ ucfirst($type) }}
                            </button>
                        @endforeach
                    </div>
                @endif

                {{-- Gallery Grid --}}
                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4" id="gallery-grid">
                    @foreach($organization->galleries as $gallery)
                        <div class="gallery-item group bg-white rounded-2xl overflow-hidden border border-neutral-200 hover:shadow-lg transition-all cursor-pointer" 
                             data-year="{{ $gallery->event_date?->year }}" 
                             data-type="{{ $gallery->event_type }}"
                             onclick="openGalleryModal({{ $gallery->id }})">
                            <div class="aspect-video bg-neutral-100 relative overflow-hidden">
                                <img src="{{ $gallery->image_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @if($gallery->is_featured)
                                    <span class="absolute top-2 right-2 px-2 py-1 text-xs font-bold text-neutral-900 bg-white rounded shadow-sm">
                                        ★ Featured
                                    </span>
                                @endif
                                @if($gallery->event_type)
                                    <span class="absolute bottom-2 left-2 px-2 py-1 text-xs font-medium text-white bg-black/50 backdrop-blur rounded">
                                        {{ ucfirst($gallery->event_type) }}
                                    </span>
                                @endif
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                    <svg class="w-10 h-10 text-white opacity-0 group-hover:opacity-100 transition-opacity" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                    </svg>
                                </div>
                            </div>
                            <div class="p-4">
                                <h3 class="text-sm font-bold text-neutral-900 line-clamp-1 group-hover:text-neutral-600 transition-colors">{{ $gallery->title }}</h3>
                                @if($gallery->event_date)
                                    <p class="text-xs text-neutral-500 mt-1">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                            </svg>
                                            {{ $gallery->event_date->format('M d, Y') }}
                                        </span>
                                    </p>
                                @endif
                                @if($gallery->location)
                                    <p class="text-xs text-neutral-500 mt-0.5 truncate">
                                        <span class="inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            </svg>
                                            {{ $gallery->location }}
                                        </span>
                                    </p>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </section>
        @endif

        {{-- Back & Share --}}
        <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-6 border-t border-neutral-200">
            <a href="{{ route('frontend.about') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-700 hover:text-neutral-900">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                </svg>
                Back to Our Team
            </a>
            <div class="flex items-center gap-2">
                <span class="text-sm font-semibold text-neutral-900">Share:</span>
                <a href="https://wa.me/?text={{ urlencode($organization->name . ' - ' . url()->current()) }}" target="_blank" class="w-9 h-9 rounded-lg bg-neutral-100 text-neutral-700 flex items-center justify-center hover:bg-neutral-900 hover:text-white transition-colors">
                    <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 24 24"><path d="M17.472 14.382c-.297-.149-1.758-.867-2.03-.967-.273-.099-.471-.148-.67.15-.197.297-.767.966-.94 1.164-.173.199-.347.223-.644.075-.297-.15-1.255-.463-2.39-1.475-.883-.788-1.48-1.761-1.653-2.059-.173-.297-.018-.458.13-.606.134-.133.298-.347.446-.52.149-.174.198-.298.298-.497.099-.198.05-.371-.025-.52-.075-.149-.669-1.612-.916-2.207-.242-.579-.487-.5-.669-.51-.173-.008-.371-.01-.57-.01-.198 0-.52.074-.792.372-.272.297-1.04 1.016-1.04 2.479 0 1.462 1.065 2.875 1.213 3.074.149.198 2.096 3.2 5.077 4.487.709.306 1.262.489 1.694.625.712.227 1.36.195 1.871.118.571-.085 1.758-.719 2.006-1.413.248-.694.248-1.289.173-1.413-.074-.124-.272-.198-.57-.347m-5.421 7.403h-.004a9.87 9.87 0 01-5.031-1.378l-.361-.214-3.741.982.998-3.648-.235-.374a9.86 9.86 0 01-1.51-5.26c.001-5.45 4.436-9.884 9.888-9.884 2.64 0 5.122 1.03 6.988 2.898a9.825 9.825 0 012.893 6.994c-.003 5.45-4.437 9.884-9.885 9.884m8.413-18.297A11.815 11.815 0 0012.05 0C5.495 0 .16 5.335.157 11.892c0 2.096.547 4.142 1.588 5.945L.057 24l6.305-1.654a11.882 11.882 0 005.683 1.448h.005c6.554 0 11.89-5.335 11.893-11.893a11.821 11.821 0 00-3.48-8.413z"/></svg>
                </a>
            </div>
        </div>

        {{-- Other Members --}}
        @if($otherOrganizations->count() > 0)
            <section class="mt-16 pt-12 border-t border-neutral-200">
                <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Other Team Members</h2>
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
                    @foreach($otherOrganizations as $other)
                        <a href="{{ route('frontend.organizations.show', $other->slug) }}" class="group bg-white rounded-2xl border border-neutral-200 p-5 text-center hover:shadow-lg hover:-translate-y-1 transition-all">
                            <div class="w-20 h-20 rounded-full bg-neutral-100 mx-auto mb-3 overflow-hidden ring-2 ring-transparent group-hover:ring-neutral-300 transition-all">
                                @if($other->photo)
                                    <img src="{{ $other->photo_url }}" alt="{{ $other->name }}" class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-neutral-400 bg-neutral-200">
                                        <span class="text-2xl font-bold text-neutral-600">{{ strtoupper(substr($other->name, 0, 1)) }}</span>
                                    </div>
                                @endif
                            </div>
                            <h3 class="text-sm font-bold text-neutral-900 line-clamp-1 group-hover:text-neutral-600 transition-colors">{{ $other->name }}</h3>
                            @if($other->position)
                                <p class="text-xs text-neutral-500 line-clamp-1 mt-0.5">{{ $other->position }}</p>
                            @endif
                        </a>
                    @endforeach
                </div>
            </section>
        @endif
    </div>
</article>

{{-- Gallery Modal --}}
<div id="gallery-modal" class="fixed inset-0 z-50 hidden items-center justify-center bg-black/90 backdrop-blur-sm p-4">
    <button onclick="closeGalleryModal()" class="absolute top-4 right-4 w-10 h-10 rounded-full bg-white/10 text-white hover:bg-white/20 flex items-center justify-center">
        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
        </svg>
    </button>
    <div class="max-w-5xl w-full">
        <img id="modal-image" src="" alt="" class="w-full max-h-[80vh] object-contain rounded-lg">
        <div class="mt-4 text-center">
            <h3 id="modal-title" class="text-xl font-bold text-white"></h3>
            <p id="modal-description" class="text-neutral-300 mt-2"></p>
            <div class="flex items-center justify-center gap-4 mt-3 text-sm text-neutral-400">
                <span id="modal-date"></span>
                <span id="modal-location"></span>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
    // Data galleries untuk modal - sudah di-pass dari controller
    var galleriesData = @json($galleriesData);

    function openGalleryModal(id) {
        var gallery = galleriesData.find(function(g) { return g.id === id; });
        if (!gallery) return;

        document.getElementById('modal-image').src = gallery.image_url;
        document.getElementById('modal-title').textContent = gallery.title;
        document.getElementById('modal-description').textContent = gallery.description || '';
        document.getElementById('modal-date').textContent = gallery.event_date ? '📅 ' + gallery.event_date : '';
        document.getElementById('modal-location').textContent = gallery.location ? '📍 ' + gallery.location : '';
        
        var modal = document.getElementById('gallery-modal');
        modal.classList.remove('hidden');
        modal.classList.add('flex');
    }

    function closeGalleryModal() {
        var modal = document.getElementById('gallery-modal');
        modal.classList.add('hidden');
        modal.classList.remove('flex');
    }

    // Close on ESC
    document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape') closeGalleryModal();
    });

    // Close on backdrop click
    document.getElementById('gallery-modal').addEventListener('click', function(e) {
        if (e.target === this) closeGalleryModal();
    });

    // Filter by Year
    document.querySelectorAll('.gallery-filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.gallery-filter-btn').forEach(function(b) {
                b.classList.remove('active', 'bg-neutral-900', 'text-white');
                b.classList.add('bg-white', 'text-neutral-700', 'border', 'border-neutral-200');
            });
            this.classList.add('active', 'bg-neutral-900', 'text-white');
            this.classList.remove('bg-white', 'text-neutral-700', 'border', 'border-neutral-200');

            var year = this.dataset.year;
            document.querySelectorAll('.gallery-item').forEach(function(item) {
                if (year === 'all' || item.dataset.year === year) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });

    // Filter by Type
    document.querySelectorAll('.type-filter-btn').forEach(function(btn) {
        btn.addEventListener('click', function() {
            document.querySelectorAll('.type-filter-btn').forEach(function(b) {
                b.classList.remove('active', 'bg-neutral-900', 'text-white');
                b.classList.add('bg-white', 'text-neutral-700', 'border', 'border-neutral-200');
            });
            this.classList.add('active', 'bg-neutral-900', 'text-white');
            this.classList.remove('bg-white', 'text-neutral-700', 'border', 'border-neutral-200');

            var type = this.dataset.type;
            document.querySelectorAll('.gallery-item').forEach(function(item) {
                if (type === 'all' || item.dataset.type === type) {
                    item.style.display = '';
                } else {
                    item.style.display = 'none';
                }
            });
        });
    });
</script>
@endpush