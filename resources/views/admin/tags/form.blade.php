@extends('admin.layouts.app')

@section('content')
@section('title', '{{ isset($tag) ? 'Edit' : 'Create' }} Tag')

    <x-admin.page-header title="{{ isset($tag) ? 'Edit' : 'Create' }} Tag" />

    <form method="POST" action="{{ isset($tag) ? route('admin.tags.update', $tag) : route('admin.tags.store') }}" class="space-y-6">
        @csrf
        @if(isset($tag)) @method('PUT') @endif

        <x-admin.card>
            <div class="p-6 space-y-6">
                <x-admin.input label="Name" name="name" :value="old('name', $tag->name ?? '')" required />
                <x-admin.input label="Slug" name="slug" :value="old('slug', $tag->slug ?? '')" help="Leave empty to auto-generate" />
                <x-admin.input label="Color" name="color" type="color" :value="old('color', $tag->color ?? '#6b7280')" />
                <x-admin.select label="Status" name="status" :options="['1' => 'Active', '0' => 'Inactive']" :value="old('status', $tag->status ?? '1')" required />
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-base font-semibold text-neutral-900">SEO</h3>
                <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $tag->meta_title ?? '')" />
                <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $tag->meta_description ?? '')" rows="2" />
            </div>
        </x-admin.card>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.tags.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($tag) ? 'Update' : 'Create' }} Tag</x-admin.button>
        </div>
    </form>
@endsection