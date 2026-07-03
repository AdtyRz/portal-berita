<x-admin.layouts.app>
    <x-slot name="title">{{ isset($banner) ? 'Edit' : 'Create' }} Banner</x-slot>

    <x-admin.page-header title="{{ isset($banner) ? 'Edit' : 'Create' }} Banner" description="Create promotional banner" />

    <form method="POST" action="{{ isset($banner) ? route('admin.banners.update', $banner) : route('admin.banners.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($banner)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $banner->title ?? '')" required />
                        <x-admin.input label="Link URL" name="link" type="url" :value="old('link', $banner->link ?? '')" placeholder="https://..." />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Settings</h3>
                        <x-admin.select label="Position" name="position" :options="['header' => 'Header', 'sidebar' => 'Sidebar', 'footer' => 'Footer', 'popup' => 'Popup']" :value="old('position', $banner->position ?? 'sidebar')" required />
                        <x-admin.input label="Order" name="order" type="number" :value="old('order', $banner->order ?? 0)" />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" id="status" @checked(old('status', $banner->status ?? true)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="status" class="text-sm text-neutral-700">Active</label>
                        </div>
                        <x-admin.input label="Start Date" name="start_date" type="datetime-local" :value="old('start_date', $banner->start_date?->format('Y-m-d\TH:i') ?? '')" />
                        <x-admin.input label="End Date" name="end_date" type="datetime-local" :value="old('end_date', $banner->end_date?->format('Y-m-d\TH:i') ?? '')" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Image</h3>
                        @if(isset($banner) && $banner->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $banner->image) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="image" accept="image/*" required class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.banners.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($banner) ? 'Update' : 'Create' }} Banner</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
