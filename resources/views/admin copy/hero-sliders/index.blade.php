<x-admin.layouts.app>
    <x-slot name="title">Hero Sliders</x-slot>

    <x-admin.page-header title="Hero Sliders" description="Manage homepage hero slider images">
        <x-admin.button href="{{ route('admin.hero-sliders.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New Slider
        </x-admin.button>
    </x-admin.page-header>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($sliders as $slider)
            <x-admin.card class="overflow-hidden group hover:shadow-md transition-shadow">
                <div class="aspect-video bg-neutral-100 overflow-hidden relative">
                    <img src="{{ asset('storage/' . $slider->image) }}" alt="{{ $slider->title }}" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-300">
                    <div class="absolute top-3 right-3">
                        @if($slider->status)
                            <x-admin.badge variant="success" size="xs">Active</x-admin.badge>
                        @else
                            <x-admin.badge variant="neutral" size="xs">Inactive</x-admin.badge>
                        @endif
                    </div>
                </div>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-3 mb-2">
                        <h3 class="text-base font-semibold text-neutral-900 line-clamp-1">{{ $slider->title }}</h3>
                        <span class="text-xs text-neutral-500 font-mono">#{{ $slider->order }}</span>
                    </div>
                    @if($slider->description)
                        <p class="text-sm text-neutral-500 line-clamp-2 mb-3">{{ $slider->description }}</p>
                    @endif
                    @if($slider->button_text)
                        <div class="text-xs text-neutral-600 mb-3">
                            Button: <span class="font-medium">{{ $slider->button_text }}</span>
                        </div>
                    @endif
                    <div class="flex items-center justify-between pt-3 border-t border-neutral-100">
                        <div class="flex items-center gap-1">
                            <a href="{{ route('admin.hero-sliders.edit', $slider) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100" title="Edit">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                            </a>
                            <form method="POST" action="{{ route('admin.hero-sliders.destroy', $slider) }}" onsubmit="return confirm('Delete this slider?');">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50" title="Delete">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        </div>
                        @if($slider->link)
                            <a href="{{ $slider->link }}" target="_blank" class="text-xs text-neutral-500 hover:text-neutral-900 flex items-center gap-1">
                                <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14" /></svg>
                                Visit
                            </a>
                        @endif
                    </div>
                </div>
            </x-admin.card>
        @empty
            <div class="col-span-full">
                <x-admin.card>
                    <x-admin.empty-state>
                        <x-slot name="title">No sliders found</x-slot>
                        <x-slot name="description">Create your first hero slider for the homepage.</x-slot>
                        <x-slot name="action">
                            <x-admin.button href="{{ route('admin.hero-sliders.create') }}">Create Slider</x-admin.button>
                        </x-slot>
                    </x-admin.empty-state>
                </x-admin.card>
            </div>
        @endforelse
    </div>

    @if($sliders->hasPages()) <div class="mt-6">{{ $sliders->links() }}</div> @endif
</x-admin.layouts.app>
