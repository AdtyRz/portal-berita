@props(['icon' => 'M20 13V6a2 2 0 00-2-2H6a2 2 0 00-2 2v7m16 0v5a2 2 0 01-2 2H6a2 2 0 01-2-2v-5m16 0h-2.586a1 1 0 00-.707.293l-2.414 2.414a1 1 0 01-.707.293h-3.172a1 1 0 01-.707-.293l-2.414-2.414A1 1 0 006.586 13H4'])

<div class="flex flex-col items-center justify-center py-16 text-center">
    <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mb-4">
        <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
        </svg>
    </div>
    @if(isset($title))
        <h3 class="text-base font-semibold text-neutral-900 mb-1">{{ $title }}</h3>
    @endif
    @if(isset($description))
        <p class="text-sm text-neutral-500 max-w-sm mb-6">{{ $description }}</p>
    @endif
    @if(isset($action))
        {{ $action }}
    @endif
</div>
