@extends('frontend.layouts.app')

@section('title', $post->meta_title ?? $post->title)

@section('content')
    <article class="py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <header class="mb-8">
                @if($post->category)
                    <a href="{{ route('frontend.categories.show', $post->category->slug) }}" class="inline-block px-3 py-1 text-sm font-semibold text-neutral-700 bg-neutral-100 rounded-full mb-4 hover:bg-neutral-200 transition-colors">
                        {{ $post->category->name }}
                    </a>
                @endif
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4 leading-tight" style="font-family: var(--font-heading);">{{ $post->title }}</h1>

                <div class="flex items-center gap-4 text-sm text-neutral-500">
                    <div class="flex items-center gap-2">
                        <div class="w-10 h-10 rounded-full bg-neutral-200 flex items-center justify-center text-sm font-semibold text-neutral-600">
                            {{ strtoupper(substr($post->author->name, 0, 1)) }}
                        </div>
                        <div>
                            <div class="font-medium text-neutral-900">{{ $post->author->name }}</div>
                            <div class="text-xs">{{ $post->publish_date->format('F d, Y') }}</div>
                        </div>
                    </div>
                    <span>•</span>
                    <span>{{ number_format($post->total_views) }} views</span>
                </div>
            </header>

            {{-- Featured Image --}}
            @if($post->thumbnail)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-100 mb-8">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Content --}}
            <div class="prose prose-lg max-w-none mb-12">
                {!! $post->content !!}
            </div>

            {{-- Tags --}}
            @if($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-12 pt-8 border-t border-neutral-200">
                    @foreach($post->tags as $tag)
                        <a href="{{ route('frontend.posts.index', ['tag' => $tag->slug]) }}" class="px-3 py-1 text-sm font-medium text-neutral-700 bg-neutral-100 rounded-full hover:bg-neutral-200 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

            {{-- Comments --}}
            <section class="border-t border-neutral-200 pt-12">
                <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Comments ({{ $post->approvedComments->count() }})</h2>

                <div class="space-y-6 mb-8">
                    @forelse($post->approvedComments as $comment)
                        <div class="flex gap-4">
                            <div class="w-10 h-10 rounded-full bg-neutral-200 flex items-center justify-center text-sm font-semibold text-neutral-600 shrink-0">
                                {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-1">
                                    <span class="font-semibold text-neutral-900">{{ $comment->author_name }}</span>
                                    <span class="text-xs text-neutral-400">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                <p class="text-neutral-700">{{ $comment->content }}</p>
                            </div>
                        </div>
                    @empty
                        <p class="text-neutral-500">No comments yet. Be the first to comment!</p>
                    @endforelse
                </div>

                {{-- Comment Form --}}
                <div class="bg-neutral-50 rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-neutral-900 mb-4">Leave a Comment</h3>
                    <form method="POST" action="#" class="space-y-4">
                        @csrf
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <input type="text" name="name" placeholder="Your Name" required class="px-4 py-2.5 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                            <input type="email" name="email" placeholder="Your Email" required class="px-4 py-2.5 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                        </div>
                        <textarea name="content" rows="4" placeholder="Your comment..." required class="w-full px-4 py-2.5 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 resize-none"></textarea>
                        <button type="submit" class="inline-flex items-center justify-center px-6 py-2.5 text-sm font-medium text-white bg-neutral-900 rounded-lg hover:bg-neutral-800">Post Comment</button>
                    </form>
                </div>
            </section>

            {{-- Related Posts --}}
            @if($relatedPosts->count() > 0)
                <section class="border-t border-neutral-200 pt-12 mt-12">
                    <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Related Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($relatedPosts as $related)
                            <article class="bg-white rounded-xl overflow-hidden border border-neutral-200 group hover:shadow-md transition-shadow">
                                <a href="{{ route('frontend.posts.show', $related->slug) }}" class="block">
                                    <div class="aspect-[16/9] overflow-hidden bg-neutral-100">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <div class="p-5">
                                        <h3 class="text-lg font-semibold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2">{{ $related->title }}</h3>
                                        <div class="text-xs text-neutral-400 mt-2">{{ $related->publish_date->format('M d, Y') }}</div>
                                    </div>
                                </a>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endif
        </div>
    </article>
@endsection
