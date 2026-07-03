@extends('admin.layouts.app')

@section('content')
@section('title', '{{ isset($slider) ? 'Edit' : 'Create' }} Hero Slider')

    <x-admin.page-header title="{{ isset($slider) ? 'Edit' : 'Create' }} Hero Slider" description="Add slider to homepage hero section" />

    <form method="POST" action="{{ isset($slider) ? route('admin.hero-sliders.update', $slider) : route('admin.hero-sliders.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($slider)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $slider->title ?? '')" required />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $slider->description ?? '')" rows="3" />
                        <x-admin.input label="Link URL" name="link" type="url" :value="old('link', $slider->link ?? '')" placeholder="https://..." />
                        <x-admin.input label="Button Text" name="button_text" :value="old('button_text', $slider->button_text ?? '')" placeholder="e.g., Learn More" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Settings</h3>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" id="status" @checked(old('status', $slider->status ?? true)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="status" class="text-sm text-neutral-700">Active</label>
                        </div>
                        <x-admin.input label="Order" name="order" type="number" :value="old('order', $slider->order ?? 0)" help="Lower number = shown first" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Image</h3>
                        @if(isset($slider) && $slider->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $slider->image) }}" alt="" class="w-full h-40 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" required class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Recommended: 1920x800px. Max 5MB.</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.hero-sliders.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($slider) ? 'Update' : 'Create' }} Slider</x-admin.button>
        </div>
    </form>
@endsection