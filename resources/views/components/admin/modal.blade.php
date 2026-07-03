@props(['name', 'maxWidth' => 'md', 'show' => false])

@php
    $maxWidths = [
        'sm' => 'sm:max-w-sm',
        'md' => 'sm:max-w-md',
        'lg' => 'sm:max-w-lg',
        'xl' => 'sm:max-w-xl',
        '2xl' => 'sm:max-w-2xl',
    ];
@endphp

<div x-data="{
        show: @js($show),
        focusables() {
            return [...this.$el.querySelectorAll('a, button, input, textarea, select, [tabindex]:not([tabindex=\'-1\'])')];
        },
        firstFocusable() { return this.focusables()[0]; },
        lastFocusable() { return this.focusables().slice(-1)[0]; }
     }"
     x-init="
        $watch('show', value => {
            if (value) {
                document.body.classList.add('overflow-y-hidden');
                this.$nextTick(() => { this.firstFocusable()?.focus(); });
            } else {
                document.body.classList.remove('overflow-y-hidden');
            }
        });
     "
     x-on:open-modal.window="$event.detail == '{{ $name }}' ? show = true : null"
     x-on:close-modal.window="$event.detail == '{{ $name }}' ? show = false : null"
     x-on:close.stop="show = false"
     x-on:keydown.escape.window="show = false"
     x-on:keydown.tab.prevent="$event.shiftKey || focusables().indexOf($event.target) === focusables().length - 1 ? firstFocusable().focus() : (focusables()[focusables().indexOf($event.target) + 1]).focus()"
     x-on:keydown.shift.tab.prevent="focusables().indexOf($event.target) === 0 ? lastFocusable().focus() : (focusables()[focusables().indexOf($event.target) - 1]).focus()"
     x-show="show"
     class="fixed inset-0 z-50 overflow-y-auto"
     style="display: {{ $show ? 'block' : 'none' }};">

    {{-- Backdrop --}}
    <div x-show="show"
         x-transition:enter="ease-out duration-300" x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
         x-transition:leave="ease-in duration-200" x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
         class="fixed inset-0 bg-neutral-900/60 backdrop-blur-sm"
         @click="show = false">
    </div>

    {{-- Modal --}}
    <div class="flex min-h-full items-center justify-center p-4">
        <div x-show="show"
             x-transition:enter="ease-out duration-300"
             x-transition:enter-start="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             x-transition:enter-end="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave="ease-in duration-200"
             x-transition:leave-start="opacity-100 translate-y-0 sm:scale-100"
             x-transition:leave-end="opacity-0 translate-y-4 sm:translate-y-0 sm:scale-95"
             {{ $attributes->merge(['class' => "relative w-full {$maxWidths[$maxWidth]} bg-white rounded-2xl shadow-xl"]) }}>

            {{-- Close button --}}
            <button type="button" @click="show = false" class="absolute top-4 right-4 p-1.5 rounded-lg text-neutral-400 hover:text-neutral-900 hover:bg-neutral-100 transition-colors z-10">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" />
                </svg>
            </button>

            {{ $slot }}
        </div>
    </div>
</div>
