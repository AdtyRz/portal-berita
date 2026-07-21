@extends('admin.layouts.app')

@section('title', 'Edit Admin: ' . $user->name)

@section('content')
    <x-admin.page-header title="Edit Admin" description="Manage profile and permissions for {{ $user->name }}" />

    <form method="POST" action="{{ route('admin.manage-admins.update', $user) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Left Column: Basic Info & Role --}}
            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Basic Information</h3>

                        <x-admin.input label="Name *" name="name" :value="old('name', $user->name)" required />
                        <x-admin.input label="Email *" name="email" type="email" :value="old('email', $user->email)" required />

                        <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <x-admin.input label="New Password" name="password" type="password" placeholder="Leave blank to keep current password" />
                            <p class="text-xs text-neutral-500 mt-1">Minimum 8 characters.</p>
                        </div>

                        <x-admin.input label="Confirm New Password" name="password_confirmation" type="password" placeholder="Re-type new password" />

                        <div class="pt-4 border-t border-neutral-200 dark:border-neutral-700">
                            <label class="block text-sm font-medium text-neutral-700 dark:text-neutral-300 mb-2">Role</label>
                            <select name="role"
                                    class="w-full px-3.5 py-2 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 disabled:opacity-50 disabled:cursor-not-allowed"
                                    @disabled($user->hasRole('super-admin'))>
                                @foreach($roles as $role)
                                    <option value="{{ $role->name }}" @selected(old('role', $user->hasRole($role->name) ? $role->name : '') === $role->name)>
                                        {{ ucfirst($role->name) }}
                                    </option>
                                @endforeach
                            </select>
                            @if($user->hasRole('super-admin'))
                                <p class="text-xs text-neutral-500 mt-1 flex items-center gap-1">
                                    <svg class="w-3 h-3" fill="none" viewBox="0 0 24 24" stroke="currentColor"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" /></svg>
                                    Super Admin role and permissions are locked.
                                </p>
                            @else
                                <p class="text-xs text-neutral-500 mt-1">Only 'admin' role is available for modification.</p>
                            @endif
                        </div>
                    </div>
                </x-admin.card>
            </div>

            {{-- Right Column: Granular Permissions --}}
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6">
                        <div class="flex items-center justify-between mb-6">
                            <h3 class="text-lg font-semibold text-neutral-900 dark:text-white">Granular Permissions</h3>
                            @if(!$user->hasRole('super-admin'))
                                <div class="flex gap-3">
                                    <button type="button" onclick="toggleAllPermissions(true)" class="text-xs text-blue-600 hover:text-blue-800 dark:text-blue-400 dark:hover:text-blue-300 font-medium hover:underline">Select All Modules</button>
                                    <span class="text-neutral-300 dark:text-neutral-600">|</span>
                                    <button type="button" onclick="toggleAllPermissions(false)" class="text-xs text-red-600 hover:text-red-800 dark:text-red-400 dark:hover:text-red-300 font-medium hover:underline">Deselect All Modules</button>
                                </div>
                            @endif
                        </div>

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            @foreach($permissions as $module => $perms)
                                @php
                                    // Cek apakah SEMUA permission di modul ini sudah dicentang
                                    $modulePermNames = $perms->pluck('name')->toArray();
                                    $allChecked = count(array_intersect($modulePermNames, $userPermissions)) === count($modulePermNames);
                                    $isSuperAdmin = $user->hasRole('super-admin');
                                @endphp

                                <div class="border border-neutral-200 dark:border-neutral-700 rounded-xl p-4 bg-neutral-50/50 dark:bg-neutral-800/30 hover:bg-white dark:hover:bg-neutral-800 hover:shadow-sm transition-all {{ $isSuperAdmin ? 'opacity-60' : '' }}">
                                    <div class="flex items-center justify-between mb-3 pb-2 border-b border-neutral-200 dark:border-neutral-700">
                                        <h4 class="text-sm font-bold text-neutral-800 dark:text-neutral-200 uppercase tracking-wider">{{ $module }}</h4>
                                        <label class="inline-flex items-center cursor-pointer">
                                            <input type="checkbox"
                                                   class="module-toggle form-checkbox h-4 w-4 text-neutral-900 rounded border-neutral-300 focus:ring-neutral-900 disabled:opacity-50 disabled:cursor-not-allowed"
                                                   data-module="{{ $module }}"
                                                   @checked($allChecked)
                                                   @disabled($isSuperAdmin)>
                                            <span class="ml-2 text-xs text-neutral-600 dark:text-neutral-400 font-medium">All</span>
                                        </label>
                                    </div>

                                    <div class="space-y-2">
                                        @foreach($perms as $perm)
                                            @php
                                                $cleanName = str_replace(['.', '-'], ' ', $perm->name);
                                                $words = explode(' ', $cleanName);
                                                $actions = ['create', 'edit', 'delete', 'view', 'update', 'manage', 'publish', 'approve'];

                                                if (in_array(strtolower($words[0]), $actions) && count($words) > 1) {
                                                    $label = ucfirst($words[0]);
                                                } else {
                                                    $label = ucfirst(end($words));
                                                }
                                            @endphp

                                            <label class="flex items-center space-x-3 cursor-pointer group {{ $isSuperAdmin ? 'cursor-not-allowed' : '' }}">
                                                <input type="checkbox" name="permissions[]" value="{{ $perm->name }}"
                                                       @checked(in_array($perm->name, $userPermissions))
                                                       @disabled($isSuperAdmin)
                                                       class="form-checkbox h-4 w-4 text-neutral-900 rounded border-neutral-300 focus:ring-neutral-900 permission-checkbox disabled:opacity-50 disabled:cursor-not-allowed"
                                                       data-module="{{ $module }}">
                                                <span class="text-sm text-neutral-700 dark:text-neutral-300 group-hover:text-neutral-900 dark:group-hover:text-white capitalize">
                                                    {{ $label }}
                                                </span>
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
            <a href="{{ route('admin.manage-admins.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 dark:text-neutral-300 bg-white dark:bg-neutral-800 border border-neutral-200 dark:border-neutral-700 rounded-lg hover:bg-neutral-50 dark:hover:bg-neutral-700">Cancel</a>
            <x-admin.button type="submit">Save Changes</x-admin.button>
        </div>
    </form>

    @push('scripts')
    <script>
        // 1. Toggle All Modules (abaikan yang disabled)
        function toggleAllPermissions(state) {
            document.querySelectorAll('.permission-checkbox:not(:disabled)').forEach(cb => cb.checked = state);
            document.querySelectorAll('.module-toggle:not(:disabled)').forEach(cb => cb.checked = state);
        }

        // 2. Module-level toggle logic (abaikan yang disabled)
        document.querySelectorAll('.module-toggle:not(:disabled)').forEach(toggle => {
            toggle.addEventListener('change', function() {
                const module = this.dataset.module;
                const isChecked = this.checked;
                document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not(:disabled)`).forEach(cb => {
                    cb.checked = isChecked;
                });
            });
        });

        // 3. Update module toggle automatically if all children are checked/unchecked manually
        document.querySelectorAll('.permission-checkbox:not(:disabled)').forEach(cb => {
            cb.addEventListener('change', function() {
                const module = this.dataset.module;
                const allInModule = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:not(:disabled)`);
                const checkedInModule = document.querySelectorAll(`.permission-checkbox[data-module="${module}"]:checked:not(:disabled)`);
                const moduleToggle = document.querySelector(`.module-toggle[data-module="${module}"]:not(:disabled)`);

                if (moduleToggle && allInModule.length > 0) {
                    moduleToggle.checked = (allInModule.length === checkedInModule.length);
                }
            });
        });
    </script>
    @endpush
@endsection
