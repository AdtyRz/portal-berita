@extends('frontend.layouts.app')

@section('title', 'Gallery')

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Gallery</h1>
            <p class="text-lg text-neutral-600 mb-12">Explore moments and memories from our school activities and events.</p>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($galleries as $gallery)
                    <article class="bg-white rounded-2xl overflow-hidden border border-neutral-200 group hover:shadow-lg transition-shadow">
                        <div class="aspect-square overflow-hidden bg-neutral-100">
                            <img src="{{ $gallery->cover_url }}" alt="{{ $gallery->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                        </div>
                        <div class="p-6">
                            <h2 class="text-xl font-semibold text-neutral-900 mb-2">{{ $gallery->title }}</h2>
                            @if($gallery->description)
                                <p class="text-sm text-neutral-500 line-clamp-2 mb-3">{{ $gallery->description }}</p>
                            @endif
                            <div class="text-xs text-neutral-400">{{ $gallery->items_count }} photos</div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-neutral-900">No galleries yet</h3>
                            <p class="mt-1 text-sm text-neutral-500">Check back later for new photos.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            @if($galleries->hasPages())
                <div class="mt-12">
                    {{ $galleries->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
