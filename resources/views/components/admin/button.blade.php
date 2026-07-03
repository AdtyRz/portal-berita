@props(['variant' => 'primary', 'size' => 'md', 'type' => 'button'])

@php
    $baseClasses = 'inline-flex items-center justify-center gap-2 font-medium rounded-lg transition-all duration-200 focus:outline-none focus:ring-2 focus:ring-offset-2 disabled:opacity-50 disabled:cursor-not-allowed';

    $variants = [
        'primary' => 'bg-neutral-900 text-white hover:bg-neutral-800 focus:ring-neutral-900 shadow-sm',
        'secondary' => 'bg-white text-neutral-700 border border-neutral-200 hover:bg-neutral-50 hover:border-neutral-300 focus:ring-neutral-200',
        'danger' => 'bg-red-600 text-white hover:bg-red-700 focus:ring-red-600 shadow-sm',
        'success' => 'bg-emerald-600 text-white hover:bg-emerald-700 focus:ring-emerald-600 shadow-sm',
        'ghost' => 'text-neutral-700 hover:bg-neutral-100 focus:ring-neutral-200',
    ];

    $sizes = [
        'xs' => 'px-2.5 py-1.5 text-xs',
        'sm' => 'px-3 py-1.5 text-sm',
        'md' => 'px-4 py-2 text-sm',
        'lg' => 'px-5 py-2.5 text-base',
    ];

    $classes = $baseClasses . ' ' . ($variants[$variant] ?? $variants['primary']) . ' ' . ($sizes[$size] ?? $sizes['md']);
@endphp

<button type="{{ $type }}" {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</button>
