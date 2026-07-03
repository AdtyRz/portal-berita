<x-admin.layouts.app>
    <x-slot name="title">{{ isset($user) ? 'Edit' : 'Create' }} User</x-slot>

    <x-admin.page-header title="{{ isset($user) ? 'Edit' : 'Create' }} User" description="Manage user account and permissions" />

    <form method="POST" action="{{ isset($user) ? route('admin.users.update', $user) : route('admin.users.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($user)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Name" name="name" :value="old('name', $user->name ?? '')" required />
                        <x-admin.input label="Email" name="email" type="email" :value="old('email', $user->email ?? '')" required />
                        <x-admin.input label="Password" name="password" type="password" :value="''" help="{{ isset($user) ? 'Leave empty to keep current password' : 'Minimum 8 characters' }}" />
                        <x-admin.input label="Confirm Password" name="password_confirmation" type="password" :value="''" />
                        <x-admin.input label="Phone" name="phone" :value="old('phone', $user->phone ?? '')" />
                        <x-admin.textarea label="Address" name="address" :value="old('address', $user->address ?? '')" rows="3" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Role & Status</h3>
                        <x-admin.select label="Role" name="role" :options="$roles->pluck('name', 'name')->map(fn($name) => ucfirst($name))->toArray()" :value="old('role', $user?->roles->first()?->name ?? '')" required />
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" name="status" value="1" id="status" @checked(old('status', $user->status ?? true)) class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="status" class="text-sm text-neutral-700">Active</label>
                        </div>
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Avatar</h3>
                        @if(isset($user) && $user->avatar)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $user->avatar) }}" alt="" class="w-20 h-20 object-cover rounded-full mx-auto">
                            </div>
                        @endif
                        <input type="file" name="avatar" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($user) ? 'Update' : 'Create' }} User</x-admin.button>
        </div>
    </form>
</x-admin.layouts.app>
