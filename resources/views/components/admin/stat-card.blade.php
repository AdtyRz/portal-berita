@props([
    'label' => 'Stat',
    'value' => '0',
    'icon' => '',
    'href' => null,
    'trend' => null,
    'color' => 'neutral',
])

@php
    $colors = [
        'neutral' => 'bg-neutral-100 text-neutral-600',
        'primary' => 'bg-blue-100 text-blue-600',
        'success' => 'bg-emerald-100 text-emerald-600',
        'warning' => 'bg-amber-100 text-amber-600',
        'danger' => 'bg-red-100 text-red-600',
        'info' => 'bg-cyan-100 text-cyan-600',
    ];
    $colorClass = $colors[$color] ?? $colors['neutral'];
@endphp

<div class="bg-white border border-neutral-200 rounded-xl p-5 hover:shadow-md transition-shadow">
    <div class="flex items-start justify-between">
        <div class="flex-1 min-w-0">
            <p class="text-sm font-medium text-neutral-600 truncate">{{ $label }}</p>
            <p class="text-2xl font-bold text-neutral-900 mt-1" style="font-family: var(--font-heading);">
                {{ $value }}
            </p>
            @if($trend)
                <p class="text-xs text-emerald-600 mt-1 font-medium">{{ $trend }}</p>
            @endif
        </div>
        @if(!empty($icon))
            <div class="w-10 h-10 rounded-lg {{ $colorClass }} flex items-center justify-center shrink-0 ml-3">
                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
                </svg>
            </div>
        @endif
    </div>
    @if($href)
        <a href="{{ $href }}" class="mt-3 inline-flex items-center text-sm font-medium text-neutral-600 hover:text-neutral-900">
            View details
            <svg class="w-4 h-4 ml-1" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
            </svg>
        </a>
    @endif
</div>