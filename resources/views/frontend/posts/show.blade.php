@extends('frontend.layouts.app')

@section('title', $post->meta_title ?? $post->title)

@section('content')
    <article class="py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            {{-- Header --}}
            <header class="mb-8">
                @if ($post->category)
                    <a href="{{ route('frontend.categories.show', $post->category->slug) }}"
                        class="inline-block px-3 py-1 text-sm font-semibold text-neutral-700 bg-neutral-100 rounded-full mb-4 hover:bg-neutral-200 transition-colors">
                        {{ $post->category->name }}
                    </a>
                @endif
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-4 leading-tight"
                    style="font-family: var(--font-heading);">{{ $post->title }}</h1>

                <div class="flex items-center gap-4 text-sm text-neutral-500">
                    <div class="flex items-center gap-2">
                        <div
                            class="w-10 h-10 rounded-full bg-neutral-200 flex items-center justify-center text-sm font-semibold text-neutral-600">
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
            @if ($post->thumbnail)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-100 mb-8">
                    <img src="{{ $post->thumbnail_url }}" alt="{{ $post->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            {{-- Content --}}
            <div class="prose prose-lg max-w-none mb-12">
                {!! $post->content !!}
            </div>

            {{-- Tags --}}
            @if ($post->tags->count() > 0)
                <div class="flex flex-wrap gap-2 mb-12 pt-8 border-t border-neutral-200">
                    @foreach ($post->tags as $tag)
                        <a href="{{ route('frontend.posts.index', ['tag' => $tag->slug]) }}"
                            class="px-3 py-1 text-sm font-medium text-neutral-700 bg-neutral-100 rounded-full hover:bg-neutral-200 transition-colors">
                            #{{ $tag->name }}
                        </a>
                    @endforeach
                </div>
            @endif

           {{-- Comments Section --}}
<section class="py-12 border-t border-neutral-200">
    <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
        <h2 class="text-2xl font-bold text-neutral-900 mb-8" style="font-family: var(--font-heading);">
            Comments ({{ $post->approvedComments->count() }})
        </h2>

        {{-- Success Message --}}
        @if(session('success'))
            <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl flex items-start gap-3">
                <svg class="w-5 h-5 text-emerald-600 shrink-0 mt-0.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                </svg>
                <div class="text-sm text-emerald-800">{{ session('success') }}</div>
            </div>
        @endif

        {{-- Comment Form --}}
        <form method="POST" action="{{ route('frontend.posts.comment', $post->slug) }}" class="bg-gradient-to-br from-neutral-50 to-neutral-100 rounded-2xl p-6 mb-8 border border-neutral-200">
            @csrf
            <div class="space-y-4">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                        </svg>
                    </div>
                    <div>
                        <h3 class="text-base font-semibold text-neutral-900">Leave a Comment</h3>
                        <p class="text-xs text-neutral-500">Your comment will be reviewed before being published</p>
                    </div>
                </div>

                {{-- Name (Optional) --}}
                <div>
                    <label for="name" class="block text-sm font-medium text-neutral-700 mb-2">
                        Name <span class="text-neutral-400">(Optional - Leave blank for Anonymous)</span>
                    </label>
                    <input type="text" name="name" id="name" value="{{ old('name') }}"
                           class="w-full px-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 transition-all"
                           placeholder="Your name (optional)">
                    @error('name')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                {{-- Content (Required) --}}
                <div>
                    <label for="content" class="block text-sm font-medium text-neutral-700 mb-2">
                        Comment <span class="text-red-500">*</span>
                    </label>
                    <textarea name="content" id="content" rows="4" required
                              class="w-full px-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 transition-all resize-none"
                              placeholder="Share your thoughts about this article...">{{ old('content') }}</textarea>
                    @error('content')
                        <p class="mt-1 text-sm text-red-600">{{ $message }}</p>
                    @enderror
                </div>

                <div class="flex items-center justify-between pt-2">
                    <div class="flex items-center gap-2 text-xs text-neutral-500">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                        </svg>
                        <span>Admin akan review komentar sebelum ditampilkan</span>
                    </div>
                    <button type="submit" class="inline-flex items-center gap-2 px-6 py-3 bg-neutral-900 text-white text-sm font-semibold rounded-xl hover:bg-neutral-800 transition-all shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 19l9 2-9-18-9 18 9-2zm0 0v-8" />
                        </svg>
                        Kirim
                    </button>
                </div>
            </div>
        </form>

        {{-- Comments List --}}
        <div class="space-y-4">
            @forelse($post->approvedComments as $comment)
                <div class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-md transition-shadow">
                    <div class="flex items-start gap-4">
                        <div class="w-11 h-11 rounded-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr($comment->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <h4 class="text-sm font-semibold text-neutral-900">{{ $comment->name ?? 'Anonymous' }}</h4>
                                <span class="text-xs text-neutral-500">•</span>
                                <span class="text-xs text-neutral-500">{{ $comment->created_at->diffForHumans() }}</span>
                            </div>
                            <p class="text-sm text-neutral-700 leading-relaxed whitespace-pre-wrap">{{ $comment->content }}</p>
                        </div>
                    </div>
                </div>
            @empty
                <div class="text-center py-12 bg-neutral-50 rounded-2xl border border-dashed border-neutral-300">
                    <svg class="w-12 h-12 text-neutral-300 mx-auto mb-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.574 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z" />
                    </svg>
                    <p class="text-neutral-500 text-sm">No comments yet. Be the first to comment!</p>
                </div>
            @endforelse
        </div>
    </div>
</section>

            {{-- Related Posts --}}
            @if ($relatedPosts->count() > 0)
                <section class="border-t border-neutral-200 pt-12 mt-12">
                    <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Related
                        Articles</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach ($relatedPosts as $related)
                            <article
                                class="bg-white rounded-xl overflow-hidden border border-neutral-200 group hover:shadow-md transition-shadow">
                                <a href="{{ route('frontend.posts.show', $related->slug) }}" class="block">
                                    <div class="aspect-[16/9] overflow-hidden bg-neutral-100">
                                        <img src="{{ $related->thumbnail_url }}" alt="{{ $related->title }}"
                                            class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                                    </div>
                                    <div class="p-5">
                                        <h3
                                            class="text-lg font-semibold text-neutral-900 group-hover:text-neutral-600 transition-colors line-clamp-2">
                                            {{ $related->title }}</h3>
                                        <div class="text-xs text-neutral-400 mt-2">
                                            {{ $related->publish_date->format('M d, Y') }}</div>
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
