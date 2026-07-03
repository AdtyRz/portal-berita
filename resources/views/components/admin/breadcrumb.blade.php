@props(['items' => []])

<nav class="flex items-center gap-2 text-sm text-neutral-500 mb-4">
    <a href="{{ route('dashboard') }}" class="hover:text-neutral-900 transition-colors">Dashboard</a>
    @foreach($items as $item)
        <svg class="w-3.5 h-3.5 text-neutral-300" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
        </svg>
        @if($loop->last)
            <span class="text-neutral-900 font-medium">{{ $item['label'] }}</span>
        @else
            <a href="{{ $item['url'] ?? '#' }}" class="hover:text-neutral-900 transition-colors">{{ $item['label'] }}</a>
        @endif
    @endforeach
</nav>
