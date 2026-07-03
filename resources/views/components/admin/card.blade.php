@props(['class' => ''])

<div {{ $attributes->merge(['class' => "bg-white border border-neutral-200/80 rounded-2xl shadow-sm {$class}"]) }}>
    {{ $slot }}
</div>
