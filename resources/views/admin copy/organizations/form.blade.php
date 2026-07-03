<x-admin.layouts.app>
    <x-slot name="title">{{ isset($organization) ? 'Edit' : 'Create' }} Organization</x-slot>

    <x-admin.page-header title="{{ isset($organization) ? 'Edit' : 'Create' }} Organization" description="Add organization member or structure" />

    <form method="POST" action="{{ isset($organization) ? route('admin.organizations.update', $organization) : route('admin.organizations.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($organization)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Name" name="name" :value="old('name', $organization->name ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $organization->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $organization->description ?? '')" rows="3" />
                        <x-admin.input label="Position" name="position" :value="old('position', $organization->position ?? '')" placeholder="e.g., Principal, Teacher" />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Social Media</h3>
                        <x-admin.input label="Facebook URL" name="facebook" type="url" :value="old('facebook', $organization->facebook ?? '')" />
                        <x-admin.input label="Instagram URL" name="instagram" type="url" :value="old('instagram', $organization->instagram ?? '')" />
                        <x-admin.input label="Twitter URL" name="twitter" type="url" :value="old('twitter', $organization->twitter ?? '')" />
                        <x-admin.input label="LinkedIn URL" name="linkedin" type="url" :value="old('linkedin', $organization->linkedin ?? '')" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Settings</h3>
                        <x-admin.select label="Type" name="organization_type" :options="['structural' => 'Structural', 'student' => 'Student', 'extracurricular' => 'Extracurricular']" :value="old('organization_type', $organization->organization_type ?? 'structural')" required />
                        <x-admin.input label="Order" name="order" type="number" :value="old('order', $organization->order ?? 0)" />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" id="status" @checked(old('status', $organization->status ?? true)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="status" class="text-sm text-neutral-700">Active</label>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Logo</h3>
                        @if(isset($organization) && $organization->logo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $organization->logo) }}" alt="" class="w-20 h-20 object-cover rounded-full mx-auto">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Photo</h3>
                        @if(isset($organization) && $organization->photo)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $organization->photo) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="photo" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.organizations.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($organization) ? 'Update' : 'Create' }} Organization</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
