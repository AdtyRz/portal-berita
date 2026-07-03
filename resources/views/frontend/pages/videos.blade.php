<x-frontend.layouts.app>
    <x-slot name="title">Videos</x-slot>

    <section class="bg-neutral-50 border-b border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Watch</span>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2 mb-4" style="font-family: var(--font-heading);">Videos</h1>
                <p class="text-lg text-neutral-600">Video content from our school activities and events.</p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <form method="GET" class="mb-10 max-w-xl">
                <div class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search videos..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($videos as $video)
                    <article class="bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('frontend.videos.show', $video->slug) }}" class="block aspect-video bg-neutral-100 relative group">
                            @if($video->thumbnail)
                                <img src="{{ $video->thumbnail_url }}" alt="{{ $video->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                    <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                            <div class="absolute inset-0 flex items-center justify-center bg-black/20 group-hover:bg-black/30 transition-colors">
                                <div class="w-16 h-16 rounded-full bg-white/90 flex items-center justify-center">
                                    <svg class="w-6 h-6 text-neutral-900 ml-1" fill="currentColor" viewBox="0 0 24 24"><path d="M8 5v14l11-7z"/></svg>
                                </div>
                            </div>
                            @if($video->duration)
                                <div class="absolute bottom-3 right-3 px-2 py-1 bg-black/80 text-white text-xs font-mono rounded">
                                    {{ $video->duration_formatted }}
                                </div>
                            @endif
                        </a>
                        <div class="p-5">
                            <h2 class="text-base font-bold text-neutral-900 line-clamp-2 mb-2" style="font-family: var(--font-heading);">
                                <a href="{{ route('frontend.videos.show', $video->slug) }}" class="hover:text-neutral-600 transition-colors">{{ $video->title }}</a>
                            </h2>
                            <div class="flex items-center gap-2 text-xs text-neutral-500">
                                <span>{{ $video->created_at->format('M d, Y') }}</span>
                                <span>•</span>
                                <span>{{ number_format($video->total_views) }} views</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">No videos found</h3>
                        <p class="text-sm text-neutral-500">Check back later for new videos.</p>
                    </div>
                @endforelse
            </div>

            @if($videos->hasPages())
                <div class="mt-12">{{ $videos->links() }}</div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
