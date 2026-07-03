<x-admin.layouts.app>
    <x-slot name="title">{{ isset($agenda) ? 'Edit' : 'Create' }} Agenda</x-slot>

    <x-admin.page-header title="{{ isset($agenda) ? 'Edit' : 'Create' }} Agenda" description="Schedule school events" />

    <form method="POST" action="{{ isset($agenda) ? route('admin.agendas.update', $agenda) : route('admin.agendas.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($agenda)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $agenda->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $agenda->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $agenda->description ?? '')" rows="3" />
                        <div>
                            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Content</label>
                            <textarea name="content" rows="10" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">{{ old('content', $agenda->content ?? '') }}</textarea>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $agenda->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $agenda->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Schedule</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'cancelled' => 'Cancelled', 'completed' => 'Completed']" :value="old('status', $agenda->status ?? 'draft')" required />
                        <x-admin.input label="Start Date" name="start_date" type="datetime-local" :value="old('start_date', $agenda->start_date?->format('Y-m-d\TH:i') ?? '')" required />
                        <x-admin.input label="End Date" name="end_date" type="datetime-local" :value="old('end_date', $agenda->end_date?->format('Y-m-d\TH:i') ?? '')" />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="is_all_day" value="0">
                            <input type="checkbox" name="is_all_day" value="1" id="is_all_day" @checked(old('is_all_day', $agenda->is_all_day ?? false)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="is_all_day" class="text-sm text-neutral-700">All Day Event</label>
                        </div>
                        <x-admin.input label="Location" name="location" :value="old('location', $agenda->location ?? '')" placeholder="Event location" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Thumbnail</h3>
                        @if(isset($agenda) && $agenda->thumbnail)
                            <div class="mb-3">
                                <img src="{{ $agenda->thumbnail_url }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="thumbnail" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.agendas.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($agenda) ? 'Update' : 'Create' }} Agenda</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
