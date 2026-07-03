@extends('frontend.layouts.app')

@section('title', isset($category) ? $category->name : 'News')

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="mb-8">
                <h1 class="text-4xl font-bold text-neutral-900 mb-2" style="font-family: var(--font-heading);">
                    {{ isset($category) ? $category->name : 'Latest News' }}
                </h1>
                @if(isset($category) && $category->description)
                    <p class="text-lg text-neutral-600">{{ $category->description }}</p>
                @endif
            </div>

            {{-- Search & Filter --}}
            <div class="bg-white border border-neutral-200 rounded-2xl p-6 mb-8">
                <form method="GET" class="flex flex-col md:flex-row gap-4">
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search articles..." class="flex-1 px-4 py-2.5 bg-neutral-50 border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800">Search</button>
                    @if(request()->hasAny(['search', 'category', 'tag']))
                        <a href="{{ route('frontend.posts.index') }}" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                    @endif
                </form>
            </div>

            {{-- Posts Grid --}}
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($posts as $post)
                    <article class="bg-white rounded-2xl overflow-hidden border border-neutral-200 group hover:shadow-lg transition-shadow">
                        <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                            <div class="aspect-[16/9] overflow-hidden bg-neutral-100">
                                <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                            </div>
                            <div class="p-6">
                                @if($post->category)
                                    <span class="inline-block px-2 py-1 text-xs font-semibold text-neutral-700 bg-neutral-100 rounded mb-3">{{ $post->category->name }}</span>
                                @endif
                                <h2 class="text-xl font-semibold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2 mb-2">{{ $post->title }}</h2>
                                <p class="text-sm text-neutral-500 line-clamp-2 mb-4">{{ $post->excerpt }}</p>
                                <div class="flex items-center gap-3 text-xs text-neutral-400">
                                    <span>{{ $post->author->name }}</span>
                                    <span>•</span>
                                    <span>{{ $post->publish_date->format('M d, Y') }}</span>
                                </div>
                            </div>
                        </a>
                    </article>
                @empty
                    <div class="col-span-full">
                        <div class="text-center py-12">
                            <svg class="mx-auto h-12 w-12 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z" />
                            </svg>
                            <h3 class="mt-2 text-sm font-semibold text-neutral-900">No posts found</h3>
                            <p class="mt-1 text-sm text-neutral-500">Try adjusting your search or filters.</p>
                        </div>
                    </div>
                @endforelse
            </div>

            {{-- Pagination --}}
            @if($posts->hasPages())
                <div class="mt-12">
                    {{ $posts->links() }}
                </div>
            @endif
        </div>
    </section>
@endsection
