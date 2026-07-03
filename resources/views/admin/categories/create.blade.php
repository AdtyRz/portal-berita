@extends('admin.layouts.app')

@section('content')
@section('title', 'Create Category')

    <x-slot name="breadcrumbs">
        <a href="{{ route('admin.categories.index') }}" class="hover:text-neutral-900">Categories</a>
        <span class="text-neutral-900 font-medium">Create</span>
    </x-slot>

    <x-admin.page-header title="Create Category" description="Add a new category to organize your content" />

    <form method="POST" action="{{ route('admin.categories.store') }}" class="space-y-6">
        @csrf

        <x-admin.card>
            <div class="p-6 space-y-6">
                <x-admin.input
                    label="Name"
                    name="name"
                    :value="old('name')"
                    required
                    help="The name will be used to generate the slug automatically"
                />

                <x-admin.input
                    label="Slug"
                    name="slug"
                    :value="old('slug')"
                    help="Leave empty to auto-generate from name"
                />

                <x-admin.textarea
                    label="Description"
                    name="description"
                    :value="old('description')"
                    rows="3"
                />

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.input
                        label="Icon (SVG Path)"
                        name="icon"
                        :value="old('icon')"
                        help="Optional: Lucide icon path"
                    />

                    <x-admin.input
                        label="Color"
                        name="color"
                        type="color"
                        :value="old('color', '#6b7280')"
                    />
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <x-admin.select
                        label="Status"
                        name="status"
                        :options="['1' => 'Active', '0' => 'Inactive']"
                        :value="old('status', '1')"
                        required
                    />

                    <x-admin.input
                        label="Order"
                        name="order"
                        type="number"
                        :value="old('order', '0')"
                    />
                </div>
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="p-6">
                <h3 class="text-base font-semibold text-neutral-900 mb-4">SEO Settings</h3>
                <div class="space-y-6">
                    <x-admin.input
                        label="Meta Title"
                        name="meta_title"
                        :value="old('meta_title')"
                        help="Leave empty to use category name"
                    />

                    <x-admin.textarea
                        label="Meta Description"
                        name="meta_description"
                        :value="old('meta_description')"
                        rows="2"
                        help="Brief description for search engines"
                    />
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.categories.index') }}"
               class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50 transition-colors">
                Cancel
            </a>
            <x-admin.button type="submit">Create Category</x-admin.button>
        </div>
    </form>
@endsection