@props(['variant' => 'neutral', 'size' => 'sm'])

@php
    $variants = [
        'neutral' => 'bg-neutral-100 text-neutral-700 ring-neutral-200/60',
        'success' => 'bg-emerald-50 text-emerald-700 ring-emerald-200/60',
        'warning' => 'bg-amber-50 text-amber-700 ring-amber-200/60',
        'danger' => 'bg-red-50 text-red-700 ring-red-200/60',
        'info' => 'bg-blue-50 text-blue-700 ring-blue-200/60',
        'purple' => 'bg-purple-50 text-purple-700 ring-purple-200/60',
    ];

    $sizes = [
        'xs' => 'px-1.5 py-0.5 text-[10px]',
        'sm' => 'px-2 py-0.5 text-xs',
        'md' => 'px-2.5 py-1 text-xs',
    ];
@endphp

<span {{ $attributes->merge(['class' => "inline-flex items-center gap-1 font-medium rounded-md ring-1 ring-inset {$variants[$variant]} {$sizes[$size]}"]) }}>
    {{ $slot }}
</span>
