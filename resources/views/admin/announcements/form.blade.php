@extends('admin.layouts.app')

@section('content')
@section('title', '{{ isset($announcement) ? 'Edit' : 'Create' }} Announcement')

    <x-admin.page-header title="{{ isset($announcement) ? 'Edit' : 'Create' }} Announcement" description="Publish important announcements" />

    <form method="POST" action="{{ isset($announcement) ? route('admin.announcements.update', $announcement) : route('admin.announcements.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($announcement)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $announcement->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $announcement->slug ?? '')" help="Leave empty to auto-generate" />
                        <x-admin.textarea label="Excerpt" name="excerpt" :value="old('excerpt', $announcement->excerpt ?? '')" rows="3" />
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Content <span class="text-red-500">*</span></label>
                            <textarea name="content" rows="12" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">{{ old('content', $announcement->content ?? '') }}</textarea>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $announcement->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $announcement->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $announcement->status ?? 'draft')" required />
                        <x-admin.select label="Priority" name="priority" :options="['low' => 'Low', 'medium' => 'Medium', 'high' => 'High', 'urgent' => 'Urgent']" :value="old('priority', $announcement->priority ?? 'medium')" required />
                        <x-admin.input label="Publish Date" name="publish_date" type="datetime-local" :value="old('publish_date', $announcement->publish_date?->format('Y-m-d\TH:i') ?? '')" />
                        <x-admin.input label="Expired Date" name="expired_date" type="datetime-local" :value="old('expired_date', $announcement->expired_date?->format('Y-m-d\TH:i') ?? '')" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        @if(isset($announcement) && $announcement->thumbnail)
                            <div class="mb-3">
                                <img src="{{ $announcement->thumbnail_url }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.announcements.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($announcement) ? 'Update' : 'Create' }} Announcement</x-admin.button>
        </div>
    </form>
@endsection