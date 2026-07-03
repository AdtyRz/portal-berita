@props(['title', 'description' => null, 'action' => null])

<div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4 mb-8">
    <div>
        <h1 class="text-2xl font-bold text-neutral-900 tracking-tight" style="font-family: var(--font-heading);">{{ $title }}</h1>
        @if($description)
            <p class="mt-1 text-sm text-neutral-500">{{ $description }}</p>
        @endif
    </div>
    @if($action)
        <div class="flex items-center gap-2 shrink-0">
            {{ $action }}
        </div>
    @endif
</div>
