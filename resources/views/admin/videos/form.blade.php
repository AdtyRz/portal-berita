@extends('admin.layouts.app')

@section('title', isset($video) ? 'Edit Video' : 'Create Video')

@section('content')
    <x-admin.page-header 
        title="{{ isset($video) ? 'Edit' : 'Create' }} Video" 
        description="Add video content from YouTube, Vimeo, or upload" 
    />

    <form method="POST" action="{{ isset($video) ? route('admin.videos.update', $video) : route('admin.videos.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($video)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $video->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $video->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $video->description ?? '')" rows="3" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Video Source</h3>
                        <x-admin.select label="Video Type" name="video_type" id="video_type" :options="['youtube' => 'YouTube', 'vimeo' => 'Vimeo', 'upload' => 'Upload File']" :value="old('video_type', $video->video_type ?? 'youtube')" required />
                        
                        <div id="url_field">
                            <x-admin.input label="Video URL" name="video_url" :value="old('video_url', $video->video_url ?? '')" placeholder="https://youtube.com/watch?v=..." help="Paste YouTube or Vimeo URL" />
                        </div>

                        <div id="upload_field" class="hidden">
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Upload Video File</label>
                            @if(isset($video) && $video->video_file)
                                <div class="mb-2 p-3 bg-neutral-50 rounded-lg text-sm text-neutral-600">
                                    Current: {{ $video->video_file }}
                                </div>
                            @endif
                            <input type="file" name="video_file" accept="video/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                            <p class="text-xs text-neutral-500 mt-1">Max 100MB. Supported: MP4, MOV, AVI, WebM</p>
                        </div>

                        <x-admin.input label="Duration (seconds)" name="duration" type="number" :value="old('duration', $video->duration ?? '')" placeholder="e.g., 120" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $video->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $video->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $video->status ?? 'draft')" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        @if(isset($video) && $video->thumbnail)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $video->thumbnail) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Auto-generated for YouTube/Vimeo if empty.</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.videos.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($video) ? 'Update' : 'Create' }} Video</x-admin.button>
        </div>
    </form>

    @push('scripts')
    <script>
        document.getElementById('video_type').addEventListener('change', function() {
            const urlField = document.getElementById('url_field');
            const uploadField = document.getElementById('upload_field');
            if (this.value === 'upload') {
                urlField.classList.add('hidden');
                uploadField.classList.remove('hidden');
            } else {
                urlField.classList.remove('hidden');
                uploadField.classList.add('hidden');
            }
        });
        document.getElementById('video_type').dispatchEvent(new Event('change'));
    </script>
    @endpush
@endsection