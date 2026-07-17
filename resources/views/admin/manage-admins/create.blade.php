@extends('admin.layouts.app')

@section('title', 'Create New Admin')

@section('content')
<x-admin.page-header title="Create New Admin" description="Add a new administrator to the system" />

<form method="POST" action="{{ route('admin.manage-admins.store') }}" class="space-y-6">
    @csrf

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Left Column: Basic Info --}}
        <div class="space-y-6">
            <x-admin.card>
                <div class="p-6 space-y-4">
                    <h3 class="text-lg font-semibold text-neutral-900">Basic Information</h3>
                    <x-admin.input label="Name *" name="name" :value="old('name')" required />
                    <x-admin.input label="Email *" name="email" type="email" :value="old('email')" required />
                    <x-admin.input label="Password *" name="password" type="password" required />
                    <x-admin.input label="Confirm Password *" name="password_confirmation" type="password" required />

                    <div class="pt-4 border-t border-neutral-200">
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Role</label>
                        <select name="role" class="w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                            @foreach($roles as $role)
                            <option value="{{ $role->name }}" selected>
                                {{ ucfirst($role->name) }}
                            </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </x-admin.card>
        </div>

        {{-- Right Column: Permissions --}}
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card>
                <div class="p-6">
                    <div class="flex items-center justify-between mb-6">
                        <h3 class="text-lg font-semibold text-neutral-900">Granular Permissions</h3>
                        <div class="flex gap-3">
                            <button type="button" onclick="toggleAllPermissions(true)" class="text-xs text-blue-600 hover:text-blue-800 font-medium hover:underline">Select All Modules</button>
                            <span class="text-neutral-300">|</span>
                            <button type="button" onclick="toggleAllPermissions(false)" class="text-xs text-red-600 hover:text-red-800 font-medium hover:underline">Deselect All Modules</button>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        @foreach($permissions as $module => $perms)
                        <div class="border border-neutral-200 rounded-xl p-4 bg-neutral-50/50 hover:bg-white hover:shadow-sm transition-all">
                            <div class="flex items-center justify-between mb-3 pb-2 border-b border-neutral-200">
                                <h4 class="text-sm font-bold text-neutral-800 uppercase tracking-wider">{{ $module }}</h4>
                                <label class="inline-flex items-center cursor-pointer">
                                    <input type="checkbox" class="module-toggle form-checkbox h-4 w-4 text-neutral-900 rounded border-neutral-300 focus:ring-neutral-900" data-module="{{ $module }}">
                                    <span class="ml-2 text-xs text-neutral-600 font-medium">All</span>
                                </label>
                            </div>
                            <div class="space-y-2">
                                @foreach($perms as $perm)
                                @php
                                $cleanName = str_replace(['.', '-'], ' ', $perm->name);
                                $words = explode(' ', $cleanName);
                                $actions = ['create', 'edit', 'delete', 'view', 'update', 'manage', 'publish', 'approve'];
                                $label = (in_array(strtolower($words[0]), $actions) && count($words) > 1) ? ucfirst($words[0]) : ucfirst(end($words));
                                @endphp
                                <label class="flex items-center space-x-3 cursor-pointer group">
                                    <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                        class="form-checkbox h-4 w-4 text-neutral-900 rounded border-neutral-300 focus:ring-neutral-900 permission-checkbox"
                                        data-module="{{ $module }}">
                                    <span class="text-sm text-neutral-700 group-hover:text-neutral-900 capitalize">{{ $label }}</span>
                                </label>
                                @endforeach
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>

    <div class="flex items-center justify-end gap-3">
        <a href="{{ route('admin.manage-admins.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
        <x-admin.button type="submit">Create Admin</x-admin.button>
    </div>
</form>

@push('scripts')
<script>
    function toggleAllPermissions(state) {
        document.querySelectorAll('.permission-checkbox').forEach(cb => cb.checked = state);
        document.querySelectorAll('.module-toggle').forEach(cb => cb.checked = state);
    }

    document.querySelectorAll('.module-toggle').forEach(toggle => {
        toggle.addEventListener('change', function() {
            const module = this.dataset.module;
            const isChecked = this.checked;
            document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`).forEach(cb => {
                cb.checked = isChecked;
            });
        });
    });

    document.querySelectorAll('.permission-checkbox').forEach(cb => {
        cb.addEventListener('change', function() {
            const module = this.dataset.module;
            const allInModule = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]`);
            const checkedInModule = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked`);
            const moduleToggle = document.querySelector(`.module-toggle[data-module="${module}"]`);

            if (moduleToggle) {
                moduleToggle.checked = (allInModule.length > 0 && allInModule.length === checkedInModule.length);
            }
        });
    });
</script>
@endpush
@endsection
