<x-frontend.layouts.app>
    <x-slot name="title">{{ $agenda->title }}</x-slot>

    <article class="py-12">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <nav class="flex items-center gap-2 text-sm text-neutral-500 mb-8">
                <a href="{{ route('home') }}" class="hover:text-neutral-900">Home</a>
                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" /></svg>
                <a href="{{ route('frontend.agendas.index') }}" class="hover:text-neutral-900">Agendas</a>
            </nav>

            <header class="mb-8">
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mb-6 leading-tight" style="font-family: var(--font-heading);">{{ $agenda->title }}</h1>

                <div class="bg-neutral-50 rounded-2xl p-6 mb-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                        <div>
                            <div class="text-xs text-neutral-500 mb-1">Date</div>
                            <div class="text-sm font-semibold text-neutral-900">{{ $agenda->start_date->format('M d, Y') }}</div>
                            <div class="text-xs text-neutral-600">{{ $agenda->start_date->format('H:i') }} {{ $agenda->end_date ? '- ' . $agenda->end_date->format('H:i') : '' }}</div>
                        </div>
                        @if($agenda->location)
                            <div>
                                <div class="text-xs text-neutral-500 mb-1">Location</div>
                                <div class="text-sm font-semibold text-neutral-900">{{ $agenda->location }}</div>
                            </div>
                        @endif
                        <div>
                            <div class="text-xs text-neutral-500 mb-1">Status</div>
                            @php
                                $statusVariants = ['draft' => 'warning', 'published' => 'success', 'cancelled' => 'danger', 'completed' => 'neutral'];
                            @endphp
                            <x-admin.badge :variant="$statusVariants[$agenda->status]">{{ ucfirst($agenda->status) }}</x-admin.badge>
                        </div>
                    </div>
                </div>
            </header>

            @if($agenda->thumbnail)
                <div class="aspect-[16/9] rounded-2xl overflow-hidden bg-neutral-100 mb-10">
                    <img src="{{ $agenda->thumbnail_url }}" alt="{{ $agenda->title }}" class="w-full h-full object-cover">
                </div>
            @endif

            @if($agenda->description)
                <p class="text-lg text-neutral-600 mb-8 leading-relaxed">{{ $agenda->description }}</p>
            @endif

            @if($agenda->content)
                <div class="prose prose-lg max-w-none">
                    {!! $agenda->content !!}
                </div>
            @endif
        </div>
    </article>
</x-frontend.layouts.app>
