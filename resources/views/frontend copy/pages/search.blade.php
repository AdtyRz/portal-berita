<x-frontend.layouts.app>
    <x-slot name="title">Search Results</x-slot>

    <section class="bg-neutral-50 border-b border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-neutral-500 uppercase tracking-wider">Search</span>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2 mb-6" style="font-family: var(--font-heading);">Search Results</h1>

                <form method="GET" action="{{ route('frontend.search') }}" class="relative">
                    <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                    </svg>
                    <input type="text" name="q" value="{{ $query }}" placeholder="Search for articles, announcements, events..." class="w-full pl-12 pr-4 py-4 bg-white border border-neutral-200 rounded-xl text-base focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                </form>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            @if(strlen($query) < 2)
                <div class="text-center py-20">
                    <p class="text-neutral-500">Please enter at least 2 characters to search.</p>
                </div>
            @elseif($results->isEmpty())
                <div class="text-center py-20">
                    <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                        <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                    </div>
                    <h3 class="text-lg font-bold text-neutral-900 mb-1">No results found</h3>
                    <p class="text-sm text-neutral-500">Try different keywords or check your spelling.</p>
                </div>
            @else
                {{-- Posts --}}
                @if($results['posts']->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Articles ({{ $results['posts']->count() }})</h2>
                        <div class="space-y-4">
                            @foreach($results['posts'] as $post)
                                <article class="bg-white rounded-xl border border-neutral-200 p-5 hover:shadow-md transition-shadow">
                                    <a href="{{ route('frontend.posts.show', $post->slug) }}" class="block">
                                        <h3 class="text-lg font-semibold text-neutral-900 mb-2 hover:text-neutral-600 transition-colors">{{ $post->title }}</h3>
                                        @if($post->excerpt)
                                            <p class="text-sm text-neutral-600 line-clamp-2 mb-2">{{ $post->excerpt }}</p>
                                        @endif
                                        <div class="text-xs text-neutral-500">{{ $post->publish_date?->format('M d, Y') }}</div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Announcements --}}
                @if($results['announcements']->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Announcements ({{ $results['announcements']->count() }})</h2>
                        <div class="space-y-4">
                            @foreach($results['announcements'] as $announcement)
                                <article class="bg-white rounded-xl border border-neutral-200 p-5 hover:shadow-md transition-shadow">
                                    <a href="{{ route('frontend.announcements.show', $announcement->slug) }}" class="block">
                                        <h3 class="text-lg font-semibold text-neutral-900 mb-2 hover:text-neutral-600 transition-colors">{{ $announcement->title }}</h3>
                                        <div class="text-xs text-neutral-500">{{ $announcement->publish_date?->format('M d, Y') }}</div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Agendas --}}
                @if($results['agendas']->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Events ({{ $results['agendas']->count() }})</h2>
                        <div class="space-y-4">
                            @foreach($results['agendas'] as $agenda)
                                <article class="bg-white rounded-xl border border-neutral-200 p-5 hover:shadow-md transition-shadow">
                                    <a href="{{ route('frontend.agendas.show', $agenda->slug) }}" class="block">
                                        <h3 class="text-lg font-semibold text-neutral-900 mb-2 hover:text-neutral-600 transition-colors">{{ $agenda->title }}</h3>
                                        <div class="text-xs text-neutral-500">{{ $agenda->start_date->format('M d, Y') }}</div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- Achievements --}}
                @if($results['achievements']->count() > 0)
                    <div class="mb-12">
                        <h2 class="text-2xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">Achievements ({{ $results['achievements']->count() }})</h2>
                        <div class="space-y-4">
                            @foreach($results['achievements'] as $achievement)
                                <article class="bg-white rounded-xl border border-neutral-200 p-5 hover:shadow-md transition-shadow">
                                    <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="block">
                                        <h3 class="text-lg font-semibold text-neutral-900 mb-2 hover:text-neutral-600 transition-colors">{{ $achievement->title }}</h3>
                                        <div class="text-xs text-neutral-500">{{ $achievement->achievement_date?->format('M d, Y') }}</div>
                                    </a>
                                </article>
                            @endforeach
                        </div>
                    </div>
                @endif
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
