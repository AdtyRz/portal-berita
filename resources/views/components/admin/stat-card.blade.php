@props(['label', 'value', 'icon', 'trend' => null, 'trendUp' => true, 'href' => null])

@php
    $tag = $href ? 'a' : 'div';
@endphp

<{{ $tag }}
    @if($href) href="{{ $href }}" @endif
    class="group block bg-white border border-neutral-200/80 rounded-2xl p-5 hover:shadow-md hover:border-neutral-300 transition-all duration-200">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <div class="text-sm font-medium text-neutral-500">{{ $label }}</div>
            <div class="mt-2 text-2xl font-bold text-neutral-900 tracking-tight" style="font-family: var(--font-heading);">{{ $value }}</div>
            @if($trend)
                <div class="mt-2 flex items-center gap-1 text-xs font-medium {{ $trendUp ? 'text-emerald-600' : 'text-red-600' }}">
                    <svg class="w-3 h-3 {{ $trendUp ? '' : 'rotate-180' }}" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2.5">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M5 10l7-7m0 0l7 7m-7-7v18" />
                    </svg>
                    <span>{{ $trend }}</span>
                </div>
            @endif
        </div>
        <div class="w-11 h-11 rounded-xl bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-neutral-600 transition-all duration-200 shrink-0">
            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
                <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
            </svg>
        </div>
    </div>
</{{ $tag }}>
