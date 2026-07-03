<x-frontend.layouts.app>
    <x-slot name="title">{{ $achievement->title }}</x-slot>

    <article class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('frontend.achievements.index') }}" class="hover:text-neutral-900">Achievements</a>
            </nav>

            <header class="mb-8">
                <div class="flex items-center gap-2 mb-4">
                    <x-admin.badge variant="info" size="sm">{{ ucfirst($achievement->level) }}</x-admin.badge>
                    @if($achievement->rank)
                        <x-admin.badge variant="success" size="sm">{{ $achievement->rank }}</x-admin.badge>
                    @endif
                </div>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-6 leading-tight" style="font-family: var(--font-heading);">{{ $achievement->title }}</h1>

                <div class="bg-neutral-50 rounded-2xl p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        @if($achievement->achiever_name)
                            <div>
                                <div class="text-xs text-neutral-500 mb-1">Achiever</div>
                                <div class="text-sm font-semibold text-neutral-900">{{ $achievement->achiever_name }}</div>
                            </div>
                        @endif
                        @if($achievement->competition_name)
                            <div>
                                <div class="text-xs text-neutral-500 mb-1">Competition</div>
                                <div class="text-sm font-semibold text-neutral-900">{{ $achievement->competition_name }}</div>
                            </div>
                        @endif
                        @if($achievement->achievement_date)
                            <div>
                                <div class="text-xs text-neutral-500 mb-1">Date</div>
                                <div class="text-sm font-semibold text-neutral-900">{{ $achievement->achievement_date->format('M d, Y') }}</div>
                            </div>
                        @endif
                    </div>
                </div>
            </header>

            @if($achievement->thumbnail)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-100 mb-10">
                    <img src="{{ $achievement->thumbnail_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if($achievement->description)
                <p class="text-lg text-neutral-600 mb-8 leading-relaxed">{{ $achievement->description }}</p>
            @endif

            @if($achievement->content)
                <div class="prose prose-lg max-w-none">
                    {!! $achievement->content !!}
                </div>
            @endif
        </div>
    </article>
</x-frontend.layouts.app>
