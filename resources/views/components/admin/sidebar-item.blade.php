@props(['href', 'active' => false, 'icon'])

<li>
    <a href="{{ $href }}"
       @class([
           'flex items-center gap-3 px-3 py-2 rounded-lg text-sm font-medium transition-all duration-200',
           'bg-neutral-900 text-white shadow-sm' => $active,
           'text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100' => !$active,
       ])>
        <svg class="w-5 h-5 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.8">
            <path stroke-linecap="round" stroke-linejoin="round" d="{{ $icon }}" />
        </svg>
        <span class="truncate">{{ $slot }}</span>
        @if($active)
            <span class="ml-auto w-1.5 h-1.5 rounded-full bg-white/60"></span>
        @endif
    </a>
</li>
