<x-admin.layouts.app>
    <x-slot name="title">{{ isset($document) ? 'Edit' : 'Create' }} Document</x-slot>

    <x-admin.page-header title="{{ isset($document) ? 'Edit' : 'Create' }} Document" description="Upload and manage downloadable documents" />

    <form method="POST" action="{{ isset($document) ? route('admin.documents.update', $document) : route('admin.documents.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($document)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $document->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $document->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $document->description ?? '')" rows="3" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $document->status ?? 'draft')" required />
                        <x-admin.select label="Category" name="category" :options="['academic' => 'Academic', 'administrative' => 'Administrative', 'regulation' => 'Regulation', 'form' => 'Form', 'other' => 'Other']" :value="old('category', $document->category ?? 'other')" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">File</h3>
                        @if(isset($document) && $document->file)
                            <div class="p-3 bg-neutral-50 rounded-lg">
                                <div class="flex items-center gap-2 text-sm text-neutral-600">
                                    <svg class="w-4 h-4 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                    </svg>
                                    <span class="truncate">{{ $document->file }}</span>
                                </div>
                                <div class="text-xs text-neutral-500 mt-1">{{ $document->file_size_formatted }}</div>
                            </div>
                        @endif
                        <input type="file" name="file" accept=".pdf,.doc,.docx,.xls,.xlsx,.ppt,.pptx,.zip" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Max 20MB. PDF, DOC, XLS, PPT, ZIP</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.documents.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($document) ? 'Update' : 'Create' }} Document</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
