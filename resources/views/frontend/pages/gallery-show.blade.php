@extends('frontend.layouts.app')

@section('title', $gallery->meta_title ?? $gallery->title)
@section('metaDescription', $gallery->meta_description ?? Str::limit($gallery->description, 160))

@section('content')
    <article class="py-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            {{-- Breadcrumb --}}
            <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('frontend.gallery') }}" class="hover:text-neutral-900">Gallery</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <span class="text-neutral-900 truncate">{{ Str::limit($gallery->title, 40) }}</span>
            </nav>

            {{-- Header dengan Decorative Border --}}
            <header class="mb-8 max-w-4xl relative">
                <div class="absolute -left-4 top-0 bottom-0 w-1 bg-gradient-to-b from-purple-500 via-pink-500 to-orange-500 rounded-full"></div>
                
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4 leading-tight pl-4" style="font-family: var(--font-heading);">
                    {{ $gallery->title }}
                </h1>
                
                @if($gallery->description)
                    <p class="text-lg text-neutral-600 mb-6 leading-relaxed pl-4">{{ $gallery->description }}</p>
                @endif

                <div class="flex flex-wrap items-center gap-4 text-sm text-neutral-500 pb-6 border-b border-neutral-200 pl-4">
                    <div class="flex items-center gap-1.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        <span>{{ $gallery->items->count() }} photos</span>
                    </div>
                    <span>•</span>
                    <span>{{ $gallery->created_at->format('F d, Y') }}</span>
                    <span>•</span>
                    <span>{{ number_format($gallery->total_views ?? 0) }} views</span>
                    <span>•</span>
                    <div class="flex items-center gap-1.5 px-2 py-0.5 bg-neutral-100 rounded-full">
                        @if($gallery->display_mode === 'detailed')
                            <svg class="w-3 h-3 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                            </svg>
                            <span class="text-xs text-neutral-700 font-medium">Detailed</span>
                        @else
                            <svg class="w-3 h-3 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                            </svg>
                            <span class="text-xs text-neutral-700 font-medium">Grid</span>
                        @endif
                    </div>
                </div>
            </header>

            {{-- Cover Image dengan Gradient Border --}}
            @if($gallery->cover_image)
                <div class="relative mb-10 group">
                    <div class="absolute -inset-1 bg-gradient-to-r from-purple-500 via-pink-500 to-orange-500 rounded-2xl blur opacity-30 group-hover:opacity-50 transition-opacity"></div>
                    <div class="relative aspect-[16/7] rounded-2xl overflow-hidden bg-neutral-100 shadow-xl">
                        <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover">
                    </div>
                </div>
            @endif

            {{-- Gallery Grid --}}
            @if($gallery->items->count() > 0)
                <div class="{{ $gallery->display_mode === 'detailed' ? 'grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6' : 'grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-3' }} mb-12">
                    @foreach($gallery->items as $index => $item)
                        @if($gallery->display_mode === 'detailed')
                            {{-- Detailed Mode: Card dengan Caption --}}
                            <div class="group cursor-pointer gallery-item" 
                                 data-index="{{ $index }}"
                                 data-src="{{ asset('storage/' . $item->image) }}"
                                 data-title="{{ $item->title ?? '' }}"
                                 data-caption="{{ $item->caption ?? '' }}">
                                <div class="relative aspect-square rounded-2xl overflow-hidden bg-neutral-100 ring-2 ring-neutral-200 group-hover:ring-purple-400 transition-all duration-300 shadow-sm group-hover:shadow-xl group-hover:-translate-y-1">
                                    <img src="{{ asset('storage/' . $item->image) }}" 
                                         alt="{{ $item->title ?? $gallery->title }}" 
                                         class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                         loading="lazy">
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-black/20 to-transparent opacity-0 group-hover:opacity-100 transition-opacity flex items-end p-4">
                                        <div class="text-white">
                                            @if($item->title)
                                                <h3 class="font-bold text-base mb-1">{{ $item->title }}</h3>
                                            @endif
                                            @if($item->caption)
                                                <p class="text-xs opacity-90 line-clamp-2">{{ $item->caption }}</p>
                                            @endif
                                        </div>
                                    </div>

                                    <div class="absolute top-3 right-3 w-9 h-9 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity shadow-lg">
                                        <svg class="w-4 h-4 text-neutral-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </div>
                                @if($item->title || $item->caption)
                                    <div class="mt-3 px-1">
                                        @if($item->title)
                                            <h3 class="text-sm font-semibold text-neutral-900 line-clamp-1">{{ $item->title }}</h3>
                                        @endif
                                        @if($item->caption)
                                            <p class="text-xs text-neutral-500 line-clamp-2 mt-0.5">{{ $item->caption }}</p>
                                        @endif
                                    </div>
                                @endif
                            </div>
                        @else
                            {{-- Grid Mode: Clean tanpa Caption --}}
                            <div class="group relative aspect-square rounded-xl overflow-hidden bg-neutral-100 cursor-pointer gallery-item ring-2 ring-transparent hover:ring-purple-400 transition-all duration-300 shadow-sm hover:shadow-lg"
                                 data-index="{{ $index }}"
                                 data-src="{{ asset('storage/' . $item->image) }}"
                                 data-title="{{ $item->title ?? '' }}"
                                 data-caption="{{ $item->caption ?? '' }}">
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $gallery->title }}" 
                                     class="w-full h-full object-cover group-hover:scale-110 transition-transform duration-500"
                                     loading="lazy">
                                
                                <div class="absolute inset-0 bg-black/0 group-hover:bg-black/30 transition-colors flex items-center justify-center">
                                    <div class="w-11 h-11 rounded-full bg-white/90 backdrop-blur-sm flex items-center justify-center opacity-0 group-hover:opacity-100 scale-75 group-hover:scale-100 transition-all shadow-lg">
                                        <svg class="w-5 h-5 text-neutral-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0zM10 7v3m0 0v3m0-3h3m-3 0H7" />
                                        </svg>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endforeach
                </div>

                {{-- Hint untuk Zoom --}}
                <div class="text-center mb-8">
                    <p class="text-sm text-neutral-500 inline-flex items-center gap-2 bg-neutral-50 px-4 py-2 rounded-full">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        Klik foto untuk membuka. <span class="hidden sm:inline">Gunakan <kbd class="px-1.5 py-0.5 bg-white border rounded text-xs">Ctrl</kbd> + scroll untuk zoom</span>
                    </p>
                </div>
            @else
                <div class="text-center py-16 bg-neutral-50 rounded-2xl">
                    <svg class="w-16 h-16 text-neutral-300 mx-auto mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    <p class="text-neutral-500">No photos in this gallery yet.</p>
                </div>
            @endif

            {{-- Back & Share --}}
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-8 border-t border-neutral-200">
                <a href="{{ route('frontend.gallery') }}" class="inline-flex items-center gap-2 text-sm font-semibold text-neutral-700 hover:text-neutral-900">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                    </svg>
                    Back to Gallery
                </a>
            </div>
        </div>
    </article>

    {{-- LIGHTBOX MODAL dengan Zoom + Pinch --}}
    <div id="lightbox" class="fixed inset-0 z-[9999] bg-black/95 backdrop-blur-sm hidden items-center justify-center" style="display: none;">
        {{-- Close Button --}}
        <button id="lightboxClose" class="absolute top-4 right-4 z-10 w-11 h-11 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
            </svg>
        </button>

        {{-- Counter --}}
        <div class="absolute top-4 left-4 z-10 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-sm font-medium">
            <span id="lightboxCounter">1 / 1</span>
        </div>

        {{-- Prev Button --}}
        <button id="lightboxPrev" class="absolute left-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7" />
            </svg>
        </button>

        {{-- Next Button --}}
        <button id="lightboxNext" class="absolute right-4 top-1/2 -translate-y-1/2 z-10 w-12 h-12 rounded-full bg-white/10 hover:bg-white/20 flex items-center justify-center text-white transition-colors">
            <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </button>

        {{-- Image Container dengan Zoom --}}
        <div id="lightboxContainer" class="relative max-w-[90vw] max-h-[85vh] flex items-center justify-center overflow-hidden">
            <img id="lightboxImage" src="" alt="" class="max-w-full max-h-[85vh] object-contain transition-transform duration-200 cursor-zoom-in select-none" draggable="false" style="transform-origin: center center;">
        </div>

        {{-- Caption --}}
        <div id="lightboxCaption" class="absolute bottom-6 left-1/2 -translate-x-1/2 z-10 max-w-2xl text-center text-white px-6 py-3 bg-black/50 backdrop-blur-md rounded-2xl hidden">
            <h3 id="lightboxTitle" class="font-bold text-lg mb-1"></h3>
            <p id="lightboxDesc" class="text-sm text-neutral-200"></p>
        </div>

        {{-- Zoom Indicator --}}
        <div id="zoomIndicator" class="absolute bottom-6 right-6 z-10 px-3 py-1.5 bg-white/10 backdrop-blur-sm rounded-full text-white text-xs font-medium hidden">
            <span id="zoomLevel">100%</span>
        </div>
    </div>

    @push('scripts')
    <script>
    (function() {
        const lightbox = document.getElementById('lightbox');
        const lightboxImage = document.getElementById('lightboxImage');
        const lightboxClose = document.getElementById('lightboxClose');
        const lightboxPrev = document.getElementById('lightboxPrev');
        const lightboxNext = document.getElementById('lightboxNext');
        const lightboxCounter = document.getElementById('lightboxCounter');
        const lightboxCaption = document.getElementById('lightboxCaption');
        const lightboxTitle = document.getElementById('lightboxTitle');
        const lightboxDesc = document.getElementById('lightboxDesc');
        const zoomIndicator = document.getElementById('zoomIndicator');
        const zoomLevel = document.getElementById('zoomLevel');
        
        const items = Array.from(document.querySelectorAll('.gallery-item'));
        let currentIndex = 0;
        let scale = 1;
        let posX = 0, posY = 0;
        let isDragging = false;
        let startX, startY;
        let initialDistance = 0;
        let initialScale = 1;

        function openLightbox(index) {
            currentIndex = index;
            updateImage();
            lightbox.style.display = 'flex';
            lightbox.classList.remove('hidden');
            document.body.style.overflow = 'hidden';
            resetZoom();
        }

        function closeLightbox() {
            lightbox.style.display = 'none';
            lightbox.classList.add('hidden');
            document.body.style.overflow = '';
            resetZoom();
        }

        function updateImage() {
            const item = items[currentIndex];
            lightboxImage.src = item.dataset.src;
            lightboxCounter.textContent = `${currentIndex + 1} / ${items.length}`;
            
            if (item.dataset.title || item.dataset.caption) {
                lightboxCaption.classList.remove('hidden');
                lightboxTitle.textContent = item.dataset.title || '';
                lightboxDesc.textContent = item.dataset.caption || '';
            } else {
                lightboxCaption.classList.add('hidden');
            }
            
            resetZoom();
        }

        function nextImage() {
            currentIndex = (currentIndex + 1) % items.length;
            updateImage();
        }

        function prevImage() {
            currentIndex = (currentIndex - 1 + items.length) % items.length;
            updateImage();
        }

        function resetZoom() {
            scale = 1;
            posX = 0;
            posY = 0;
            applyTransform();
            lightboxImage.style.cursor = 'zoom-in';
            zoomIndicator.classList.add('hidden');
        }

        function applyTransform() {
            lightboxImage.style.transform = `translate(${posX}px, ${posY}px) scale(${scale})`;
            if (scale > 1) {
                zoomLevel.textContent = Math.round(scale * 100) + '%';
                zoomIndicator.classList.remove('hidden');
                lightboxImage.style.cursor = 'grab';
            } else {
                zoomIndicator.classList.add('hidden');
                lightboxImage.style.cursor = 'zoom-in';
            }
        }

        function zoomAt(delta, clientX, clientY) {
            const rect = lightboxImage.getBoundingClientRect();
            const imgCenterX = rect.left + rect.width / 2;
            const imgCenterY = rect.top + rect.height / 2;
            
            const offsetX = clientX - imgCenterX;
            const offsetY = clientY - imgCenterY;
            
            const prevScale = scale;
            scale = Math.min(Math.max(scale + delta, 1), 5);
            
            if (scale > 1) {
                const scaleRatio = scale / prevScale;
                posX = posX * scaleRatio - offsetX * (scaleRatio - 1);
                posY = posY * scaleRatio - offsetY * (scaleRatio - 1);
            } else {
                posX = 0;
                posY = 0;
            }
            
            applyTransform();
        }

        // Click to open
        items.forEach((item, index) => {
            item.addEventListener('click', () => openLightbox(index));
        });

        // Close
        lightboxClose.addEventListener('click', closeLightbox);
        lightbox.addEventListener('click', (e) => {
            if (e.target === lightbox || e.target.id === 'lightboxContainer') {
                closeLightbox();
            }
        });

        // Navigation
        lightboxNext.addEventListener('click', (e) => { e.stopPropagation(); nextImage(); });
        lightboxPrev.addEventListener('click', (e) => { e.stopPropagation(); prevImage(); });

        // Keyboard
        document.addEventListener('keydown', (e) => {
            if (lightbox.style.display !== 'flex') return;
            if (e.key === 'Escape') closeLightbox();
            if (e.key === 'ArrowRight') nextImage();
            if (e.key === 'ArrowLeft') prevImage();
            if (e.key === '+' || e.key === '=') zoomAt(0.2, window.innerWidth / 2, window.innerHeight / 2);
            if (e.key === '-') zoomAt(-0.2, window.innerWidth / 2, window.innerHeight / 2);
            if (e.key === '0') resetZoom();
        });

        // Ctrl + Scroll untuk Zoom (Desktop)
        lightbox.addEventListener('wheel', (e) => {
            if (lightbox.style.display !== 'flex') return;
            if (e.ctrlKey || e.metaKey) {
                e.preventDefault();
                const delta = e.deltaY > 0 ? -0.15 : 0.15;
                zoomAt(delta, e.clientX, e.clientY);
            }
        }, { passive: false });

        // Double click untuk zoom in/out
        lightboxImage.addEventListener('dblclick', (e) => {
            if (scale > 1) {
                resetZoom();
            } else {
                zoomAt(1.5, e.clientX, e.clientY);
            }
        });

        // Drag untuk pan saat zoomed (Mouse)
        lightboxImage.addEventListener('mousedown', (e) => {
            if (scale <= 1) return;
            isDragging = true;
            startX = e.clientX - posX;
            startY = e.clientY - posY;
            lightboxImage.style.cursor = 'grabbing';
            e.preventDefault();
        });

        document.addEventListener('mousemove', (e) => {
            if (!isDragging) return;
            posX = e.clientX - startX;
            posY = e.clientY - startY;
            applyTransform();
        });

        document.addEventListener('mouseup', () => {
            isDragging = false;
            if (scale > 1) lightboxImage.style.cursor = 'grab';
        });

        // Touch: Pinch Zoom (Mobile)
        function getDistance(touches) {
            const dx = touches[0].clientX - touches[1].clientX;
            const dy = touches[0].clientY - touches[1].clientY;
            return Math.sqrt(dx * dx + dy * dy);
        }

        let touchStartX, touchStartY, lastTouchX, lastTouchY;
        
        lightboxImage.addEventListener('touchstart', (e) => {
            if (e.touches.length === 2) {
                // Pinch start
                initialDistance = getDistance(e.touches);
                initialScale = scale;
            } else if (e.touches.length === 1 && scale > 1) {
                // Pan start
                touchStartX = e.touches[0].clientX - posX;
                touchStartY = e.touches[0].clientY - posY;
                lastTouchX = e.touches[0].clientX;
                lastTouchY = e.touches[0].clientY;
            }
        }, { passive: true });

        lightboxImage.addEventListener('touchmove', (e) => {
            if (e.touches.length === 2) {
                // Pinch zoom
                e.preventDefault();
                const currentDistance = getDistance(e.touches);
                const ratio = currentDistance / initialDistance;
                scale = Math.min(Math.max(initialScale * ratio, 1), 5);
                if (scale === 1) { posX = 0; posY = 0; }
                applyTransform();
            } else if (e.touches.length === 1 && scale > 1) {
                // Pan
                e.preventDefault();
                posX = e.touches[0].clientX - touchStartX;
                posY = e.touches[0].clientY - touchStartY;
                applyTransform();
            }
        }, { passive: false });

        lightboxImage.addEventListener('touchend', (e) => {
            if (e.touches.length < 2) {
                initialDistance = 0;
            }
            if (scale <= 1) resetZoom();
        });

        // Swipe left/right untuk ganti gambar (saat tidak di-zoom)
        let swipeStartX = 0;
        lightbox.addEventListener('touchstart', (e) => {
            if (e.touches.length === 1 && scale <= 1) {
                swipeStartX = e.touches[0].clientX;
            }
        }, { passive: true });

        lightbox.addEventListener('touchend', (e) => {
            if (scale > 1) return;
            const swipeEndX = e.changedTouches[0].clientX;
            const diff = swipeStartX - swipeEndX;
            if (Math.abs(diff) > 50) {
                if (diff > 0) nextImage();
                else prevImage();
            }
        });
    })();
    </script>
    @endpush
@endsection