@extends('admin.layouts.app')

@section('title', 'Manage Admins')

@section('content')
<x-admin.page-header title="Manage Admins" description="Control access and permissions for your team" />

<x-admin.card>
    {{-- Header dengan Tombol Tambah Admin --}}
    <div class="p-4 border-b border-neutral-200 flex items-center justify-between">
        <h3 class="text-lg font-semibold text-neutral-900">Administrator List</h3>
        <x-admin.button href="{{ route('admin.manage-admins.create') }}" variant="primary">
            <svg class="w-4 h-4 mr-2" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
            </svg>
            Tambah Admin
        </x-admin.button>
    </div>

    <div class="overflow-x-auto">
        <table class="min-w-full divide-y divide-neutral-200">
            <thead class="bg-neutral-50">
                <tr>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">User</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Role</th>
                    <th class="px-6 py-3 text-left text-xs font-medium text-neutral-500 uppercase tracking-wider">Permissions</th>
                    <th class="px-6 py-3 text-right text-xs font-medium text-neutral-500 uppercase tracking-wider">Actions</th>
                </tr>
            </thead>
            <tbody class="bg-white divide-y divide-neutral-200">
                @foreach($admins as $admin)
                <tr class="hover:bg-neutral-50/50 transition-colors">
                    <td class="px-6 py-4 whitespace-nowrap">
                        <div class="flex items-center">
                            <div class="flex-shrink-0 h-10 w-10 rounded-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center text-white font-bold">
                                {{ strtoupper(substr($admin->name, 0, 1)) }}
                            </div>
                            <div class="ml-4">
                                <div class="text-sm font-medium text-neutral-900">{{ $admin->name }}</div>
                                <div class="text-sm text-neutral-500">{{ $admin->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap">
                        @foreach($admin->roles as $role)
                        <span class="px-2.5 py-0.5 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                            {{ ucfirst($role->name) }}
                        </span>
                        @endforeach
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                        @if($admin->hasRole('super-admin'))
                        <span class="text-purple-600 font-semibold flex items-center gap-1">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                            </svg>
                            Management Access
                        </span>
                        @else
                        <span class="text-neutral-700 font-medium">{{ $admin->permissions->count() }} permissions assigned</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                        @if($admin->hasRole('super-admin'))
                        <a href="{{ route('admin.manage-admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium">Edit</a>
                        @else
                        <a href="{{ route('admin.manage-admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3 font-medium">Edit</a>
                        <form action="{{ route('admin.manage-admins.destroy', $admin) }}" method="POST" class="inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="text-red-600 hover:text-red-900 font-medium" onclick="return confirm('Are you sure you want to delete this admin?')">Delete</button>
                        </form>
                        @endif
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</x-admin.card>
@endsection
