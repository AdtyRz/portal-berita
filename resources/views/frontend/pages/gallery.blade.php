@extends('frontend.layouts.app')

@section('title', 'Gallery')

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Gallery</h1>
            <p class="text-lg text-neutral-600 mb-12">Explore moments and memories from our school activities and events.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleries as $gallery)
                    <article
                        class="bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-lg transition-shadow">
                        <a href="{{ route('frontend.gallery.show', $gallery->slug) }}" class="block">
                            <div class="aspect-square overflow-hidden bg-neutral-100">
                                @if ($gallery->cover_image)
                                    <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="{{ $gallery->title }}"
                                        class="w-full h-full object-cover hover:scale-105 transition-transform duration-500">
                                @else
                                    <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                        <svg class="w-12 h-12" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                            stroke-width="1.5">
                                            <path stroke-linecap="round" stroke-linejoin="round"
                                                d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                @endif
                            </div>
                        </a>
                        <div class="p-6">
                            <h2 class="text-xl font-bold text-neutral-900 mb-2" style="font-family: var(--font-heading);">
                                <a href="{{ route('frontend.gallery.show', $gallery->slug) }}"
                                    class="hover:text-neutral-600 transition-colors">{{ $gallery->title }}</a>
                            </h2>
                            @if ($gallery->description)
                                <p class="text-sm text-neutral-600 line-clamp-2 mb-3">{{ $gallery->description }}</p>
                            @endif
                            <div class="flex items-center justify-between pt-4 border-t border-neutral-100">
                                <div class="flex items-center gap-1.5 text-xs text-neutral-500">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor"
                                        stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round"
                                            d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                    {{ $gallery->items_count ?? $gallery->items->count() }} photos
                                </div>
                                <span class="text-xs text-neutral-400">{{ $gallery->created_at->format('M d, Y') }}</span>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <p class="text-neutral-500">No galleries yet.</p>
                    </div>
                @endforelse
            </div>

            @if ($galleries->hasPages())
                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
