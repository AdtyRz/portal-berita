<x-frontend.layouts.app>
    <x-slot name="title">Announcements</x-slot>

    <section class="bg-neutral-50 border-b border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Stay Informed</span>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2 mb-4" style="font-family: var(--font-heading);">Announcements</h1>
                <p class="text-lg text-neutral-600">Important updates and news from our school.</p>
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search announcements..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                </div>
            </form>

            <div class="space-y-6">
                @forelse($announcements as $announcement)
                    <article class="bg-white rounded-2xl border border-neutral-200 p-6 hover:shadow-lg transition-shadow">
                        <div class="flex flex-col md:flex-row gap-6">
                            @if($announcement->thumbnail)
                                <a href="{{ route('frontend.announcements.show', $announcement->slug) }}" class="md:w-48 md:h-32 shrink-0 block">
                                    <div class="w-full h-48 md:h-full rounded-xl overflow-hidden bg-neutral-100">
                                        <img src="{{ $announcement->thumbnail_url }}" alt="{{ $announcement->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                                    </div>
                                </a>
                            @endif
                            <div class="flex-1">
                                <div class="flex items-center gap-2 mb-3">
                                    @php
                                        $priorityVariants = ['low' => 'neutral', 'medium' => 'info', 'high' => 'warning', 'urgent' => 'danger'];
                                    @endphp
                                    <x-admin.badge :variant="$priorityVariants[$announcement->priority]" size="sm">{{ ucfirst($announcement->priority) }}</x-admin.badge>
                                    <span class="text-xs text-neutral-500">{{ $announcement->publish_date?->format('M d, Y') }}</span>
                                </div>
                                <h2 class="text-xl font-bold text-neutral-900 mb-2" style="font-family: var(--font-heading);">
                                    <a href="{{ route('frontend.announcements.show', $announcement->slug) }}" class="hover:text-neutral-600 transition-colors">{{ $announcement->title }}</a>
                                </h2>
                                @if($announcement->excerpt)
                                    <p class="text-sm text-neutral-600 line-clamp-2 mb-3">{{ $announcement->excerpt }}</p>
                                @endif
                                <a href="{{ route('frontend.announcements.show', $announcement->slug) }}" class="inline-flex items-center gap-1 text-sm font-semibold text-neutral-900 hover:text-neutral-600">
                                    Read more
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17 8l4 4m0 0l-4 4m4-4H3" /></svg>
                                </a>
                            </div>
                        </div>
                    </article>
                @empty
                    <div class="text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">No announcements found</h3>
                        <p class="text-sm text-neutral-500">Check back later for updates.</p>
                    </div>
                @endforelse
            </div>

            @if($announcements->hasPages())
                <div class="mt-12">{{ $announcements->links() }}</div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
