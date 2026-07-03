<x-frontend.layouts.app>
    <x-slot name="title">Agendas & Events</x-slot>

    <section class="bg-neutral-50 border-b border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Calendar</span>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2 mb-4" style="font-family: var(--font-heading);">Agendas & Events</h1>
                <p class="text-lg text-neutral-600">Upcoming school events and activities.</p>
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
                    <input type="text" name="search" value="{{ request('search') }}" placeholder="Search events..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                </div>
            </form>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($agendas as $agenda)
                    <article class="bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-lg transition-shadow">
                        @if($agenda->thumbnail)
                            <a href="{{ route('frontend.agendas.show', $agenda->slug) }}" class="block aspect-[16/10] overflow-hidden bg-neutral-100">
                                <img src="{{ $agenda->thumbnail_url }}" alt="{{ $agenda->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-3 mb-3">
                                <div class="text-center shrink-0">
                                    <div class="text-[10px] font-bold text-neutral-500 uppercase">{{ $agenda->start_date->format('M') }}</div>
                                    <div class="text-2xl font-bold text-neutral-900 leading-none">{{ $agenda->start_date->format('d') }}</div>
                                </div>
                                <div class="flex-1 min-w-0">
                                    @php
                                        $statusVariants = ['draft' => 'warning', 'published' => 'success', 'cancelled' => 'danger', 'completed' => 'neutral'];
                                    @endphp
                                    <x-admin.badge :variant="$statusVariants[$agenda->status]" size="xs">{{ ucfirst($agenda->status) }}</x-admin.badge>
                                </div>
                            </div>
                            <h2 class="text-lg font-bold text-neutral-900 mb-2 line-clamp-2" style="font-family: var(--font-heading);">
                                <a href="{{ route('frontend.agendas.show', $agenda->slug) }}" class="hover:text-neutral-600 transition-colors">{{ $agenda->title }}</a>
                            </h2>
                            @if($agenda->location)
                                <div class="flex items-center gap-1 text-xs text-neutral-500 mb-3">
                                    <svg class="w-3.5 h-3.5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" /></svg>
                                    {{ $agenda->location }}
                                </div>
                            @endif
                            <div class="text-xs text-neutral-500">{{ $agenda->start_date->format('H:i') }} {{ $agenda->end_date ? '- ' . $agenda->end_date->format('H:i') : '' }}</div>
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">No events found</h3>
                        <p class="text-sm text-neutral-500">Check back later for upcoming events.</p>
                    </div>
                @endforelse
            </div>

            @if($agendas->hasPages())
                <div class="mt-12">{{ $agendas->links() }}</div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
