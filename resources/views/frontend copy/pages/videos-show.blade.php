<x-frontend.layouts.app>
    <x-slot name="title">{{ $video->title }}</x-slot>

    <article class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('frontend.videos.index') }}" class="hover:text-neutral-900">Videos</a>
            </nav>

            <header class="mb-8">
                <h1 class="text-3xl md:text-4xl font-bold text-neutral-900 mb-4 leading-tight" style="font-family: var(--font-heading);">{{ $video->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-neutral-500 pb-8 border-b border-neutral-200">
                    <span>{{ $video->created_at->format('F d, Y') }}</span>
                    <span>•</span>
                    <span>{{ number_format($video->total_views) }} views</span>
                    @if($video->duration)
                        <span>•</span>
                        <span>{{ $video->duration_formatted }}</span>
                    @endif
                </div>
            </header>

            {{-- Video Player --}}
            <div class="aspect-video bg-neutral-900 rounded-2xl overflow-hidden mb-8">
                @if($video->video_type === 'youtube' && $video->embed_url)
                    <iframe src="{{ $video->embed_url }}" class="w-full h-full" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                @elseif($video->video_type === 'vimeo' && $video->embed_url)
                    <iframe src="{{ $video->embed_url }}" class="w-full h-full" frameborder="0" allow="autoplay; fullscreen; picture-in-picture" allowfullscreen></iframe>
                @elseif($video->video_type === 'upload' && $video->video_file)
                    <video controls class="w-full h-full">
                        <source src="{{ asset('storage/' . $video->video_file) }}" type="video/mp4">
                        Your browser does not support the video tag.
                    </video>
                @else
                    <div class="w-full h-full flex items-center justify-center text-neutral-400">
                        <p>Video not available</p>
                    </div>
                @endif
            </div>

            @if($video->description)
                <div class="prose prose-lg max-w-none">
                    {!! $video->description !!}
                </div>
            @endif
        </div>
    </article>
</x-frontend.layouts.app>
