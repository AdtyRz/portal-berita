<x-frontend.layouts.app>
    <x-slot name="title">{{ $announcement->title }}</x-slot>

    <article class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('frontend.announcements.index') }}" class="hover:text-neutral-900">Announcements</a>
            </nav>

            <header class="mb-8">
                @php
                    $priorityVariants = ['low' => 'neutral', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
                @endphp
                <x-admin.badge :variant="$priorityVariants[$announcement->priority]" size="sm">{{ ucfirst($announcement->priority) }}</x-admin.badge>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-4 mb-6 leading-tight" style="font-family: var(--font-heading);">{{ $announcement->title }}</h1>
                <div class="flex items-center gap-4 text-sm text-neutral-500 pb-8 border-b border-neutral-200">
                    <span>{{ $announcement->publish_date?->format('F d, Y') }}</span>
                    <span>•</span>
                    <span>{{ number_format($announcement->total_views) }} views</span>
                </div>
            </header>

            @if($announcement->thumbnail)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-100 mb-10">
                    <img src="{{ $announcement->thumbnail_url }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            <div class="prose prose-lg max-w-none">
                {!! $announcement->content !!}
            </div>
        </div>
    </article>
</x-frontend.layouts.app>
