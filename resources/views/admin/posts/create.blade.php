@extends('admin.layouts.app')

@section('title', 'Create Post')

@section('content')
    <x-admin.page-header title="Create Post" description="Write and publish a new article" />

    <form method="POST" action="{{ route('admin.posts.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug')" help="Leave empty to auto-generate" />
                        
                        {{-- EXCERPT - Pakai native textarea untuk debug --}}
                        <div>
                            <label for="excerpt" class="block text-sm font-medium text-neutral-700 mb-1.5">
                                Excerpt
                            </label>
                            <textarea 
                                name="excerpt" 
                                id="excerpt" 
                                rows="3"
                                maxlength="500"
                                class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 @error('excerpt') border-red-300 @enderror"
                                placeholder="Brief summary for listings..."
                            >{{ old('excerpt') }}</textarea>
                            @error('excerpt')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                            <p class="mt-1 text-xs text-neutral-500">Brief summary for listings (max 500 characters)</p>
                        </div>

                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Content <span class="text-red-500">*</span></label>
                            <textarea name="content" id="content" rows="15" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 @error('content') border-red-300 @enderror">{{ old('content') }}</textarea>
                            @error('content')
                                <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
                            @enderror
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description')" rows="2" />
                        <x-admin.input label="Keywords" name="keywords" :value="old('keywords')" help="Comma separated" />
                    </div>
                </x-admin.card>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', 'draft')" required />
                        <x-admin.input label="Publish Date" name="publish_date" type="datetime-local" :value="old('publish_date')" />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="featured" value="0">
                            <input type="checkbox" name="featured" value="1" id="featured" @checked(old('featured')) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="featured" class="text-sm text-neutral-700">Featured Post</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="breaking_news" value="0">
                            <input type="checkbox" name="breaking_news" value="1" id="breaking" @checked(old('breaking_news')) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="breaking" class="text-sm text-neutral-700">Breaking News</label>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Category</h3>
                        <x-admin.select label="Category" name="category_id" :options="$categories->pluck('name', 'id')->toArray()" :value="old('category_id')" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer text-sm">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', []))) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">Create Post</x-admin.button>
        </div>
    </form>
@endsection