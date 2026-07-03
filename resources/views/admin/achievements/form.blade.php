@extends('admin.layouts.app')

@section('content')
@section('title', '{{ isset($achievement) ? 'Edit' : 'Create' }} Achievement')

    <x-admin.page-header title="{{ isset($achievement) ? 'Edit' : 'Create' }} Achievement" description="Record student achievements" />

    <form method="POST" action="{{ isset($achievement) ? route('admin.achievements.update', $achievement) : route('admin.achievements.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($achievement)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $achievement->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $achievement->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $achievement->description ?? '')" rows="3" />
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Content</label>
                            <textarea name="content" rows="10" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">{{ old('content', $achievement->content ?? '') }}</textarea>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $achievement->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $achievement->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Details</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $achievement->status ?? 'draft')" required />
                        <x-admin.select label="Level" name="level" :options="['school' => 'School', 'district' => 'District', 'city' => 'City', 'province' => 'Province', 'national' => 'National', 'international' => 'International']" :value="old('level', $achievement->level ?? 'school')" required />
                        <x-admin.select label="Rank" name="rank" :options="['' => 'Select Rank', '1st' => '1st Place', '2nd' => '2nd Place', '3rd' => '3rd Place', 'honorable' => 'Honorable Mention', 'participant' => 'Participant']" :value="old('rank', $achievement->rank ?? '')" />
                        <x-admin.input label="Achiever Name" name="achiever_name" :value="old('achiever_name', $achievement->achiever_name ?? '')" placeholder="Student name" />
                        <x-admin.input label="Competition Name" name="competition_name" :value="old('competition_name', $achievement->competition_name ?? '')" />
                        <x-admin.input label="Achievement Type" name="achievement_type" :value="old('achievement_type', $achievement->achievement_type ?? '')" />
                        <x-admin.input label="Achievement Date" name="achievement_date" type="date" :value="old('achievement_date', $achievement->achievement_date?->format('Y-m-d') ?? '')" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        @if(isset($achievement) && $achievement->thumbnail)
                            <div class="mb-3">
                                <img src="{{ $achievement->thumbnail_url }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.achievements.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($achievement) ? 'Update' : 'Create' }} Achievement</x-admin.button>
        </div>
    </form>
@endsection