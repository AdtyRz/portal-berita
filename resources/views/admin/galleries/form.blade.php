@extends('admin.layouts.app')

@section('content')
@section('title', '{{ isset($gallery) ? 'Edit' : 'Create' }} Gallery')

    <x-admin.page-header title="{{ isset($gallery) ? 'Edit' : 'Create' }} Gallery" description="Create photo gallery with multiple images" />

    <form method="POST" action="{{ isset($gallery) ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($gallery)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $gallery->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $gallery->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $gallery->description ?? '')" rows="3" />
                    </div>
                </x-admin.card>

                {{-- Gallery Items --}}
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <div class="flex items-center justify-between">
                            <h3 class="text-base font-semibold text-neutral-900">Gallery Images</h3>
                            <span class="text-xs text-neutral-500">Add multiple images</span>
                        </div>

                        @if(isset($gallery) && $gallery->items->count() > 0)
                            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                                @foreach($gallery->items as $item)
                                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-neutral-100">
                                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-colors flex items-center justify-center">
                                            <label class="opacity-0 group-hover:opacity-100 transition-opacity">
                                                <input type="checkbox" name="delete_items[]" value="{{ $item->id }}" class="sr-only peer">
                                                <span class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-lg cursor-pointer hover:bg-red-700">Delete</span>
                                            </label>
                                        </div>
                                        @if($item->caption)
                                            <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black/70 to-transparent p-2">
                                                <p class="text-xs text-white truncate">{{ $item->caption }}</p>
                                            </div>
                                        @endif
                                    </div>
                                @endforeach
                            </div>
                            <p class="text-xs text-neutral-500">Check images to delete them when updating.</p>
                        @endif

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Add New Images</label>
                            <input type="file" name="images[]" accept="image/*" multiple class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                            <p class="text-xs text-neutral-500 mt-1">You can select multiple images at once.</p>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $gallery->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $gallery->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $gallery->status ?? 'draft')" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Cover Image</h3>
                        @if(isset($gallery) && $gallery->cover_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="cover_image" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Optional. If not set, first image will be used.</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($gallery) ? 'Update' : 'Create' }} Gallery</x-admin.button>
        </div>
    </form>
@endsection