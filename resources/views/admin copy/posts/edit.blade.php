<x-admin.layouts.app>
    <x-slot name="title">Edit Post</x-slot>

    <x-admin.page-header title="Edit Post" description="Update article content and settings" />

    <form method="POST" action="{{ route('admin.posts.update', $post) }}" enctype="multipart/form-data" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $post->title)" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $post->slug)" />
                        <x-admin.textarea label="Excerpt" name="excerpt" :value="old('excerpt', $post->excerpt)" rows="3" />
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Content <span class="text-red-500">*</span></label>
                            <textarea name="content" id="content" rows="15" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">{{ old('content', $post->content) }}</textarea>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $post->meta_title)" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $post->meta_description)" rows="2" />
                        <x-admin.input label="Keywords" name="keywords" :value="old('keywords', $post->keywords)" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $post->status)" required />
                        <x-admin.input label="Publish Date" name="publish_date" type="datetime-local" :value="old('publish_date', $post->publish_date?->format('Y-m-d\TH:i'))" />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="featured" value="0">
                            <input type="checkbox" name="featured" value="1" id="featured" @checked(old('featured', $post->featured)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="featured" class="text-sm text-neutral-700">Featured Post</label>
                        </div>
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="breaking_news" value="0">
                            <input type="checkbox" name="breaking_news" value="1" id="breaking" @checked(old('breaking_news', $post->breaking_news)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="breaking" class="text-sm text-neutral-700">Breaking News</label>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Category</h3>
                        <x-admin.select label="Category" name="category_id" :options="$categories->pluck('name', 'id')->toArray()" :value="old('category_id', $post->category_id)" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Tags</h3>
                        <div class="flex flex-wrap gap-2">
                            @foreach($tags as $tag)
                                <label class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-lg border border-neutral-200 hover:bg-neutral-50 cursor-pointer text-sm">
                                    <input type="checkbox" name="tags[]" value="{{ $tag->id }}" @checked(in_array($tag->id, old('tags', $post->tags->pluck('id')->toArray()))) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                                    {{ $tag->name }}
                                </label>
                            @endforeach
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        @if($post->thumbnail)
                            <div class="mb-3">
                                <img src="{{ $post->thumbnail_url }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.posts.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">Update Post</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
