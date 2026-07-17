@extends('admin.layouts.app')

@section('title', 'Manage Admins')

@section('content')
    <x-admin.page-header title="Manage Admins" description="Control access and permissions for your team" />

    <x-admin.card>
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
                        <tr>
                            <td class="px-6 py-4 whitespace-nowrap">
                                <div class="flex items-center">
                                    <div class="flex-shrink-0 h-10 w-10 rounded-full bg-neutral-200 flex items-center justify-center text-neutral-700 font-bold">
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
                                    <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full {{ $role->name === 'super-admin' ? 'bg-purple-100 text-purple-800' : 'bg-blue-100 text-blue-800' }}">
                                        {{ ucfirst($role->name) }}
                                    </span>
                                @endforeach
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-sm text-neutral-500">
                                @if($admin->hasRole('super-admin'))
                                    <span class="text-purple-600 font-semibold">All Access</span>
                                @else
                                    {{ $admin->permissions->count() }} permissions assigned
                                @endif
                            </td>
                            <td class="px-6 py-4 whitespace-nowrap text-right text-sm font-medium">
                                @if($admin->id !== auth()->id())
                                    <a href="{{ route('admin.manage-admins.edit', $admin) }}" class="text-indigo-600 hover:text-indigo-900 mr-3">Edit</a>
                                    <form action="{{ route('admin.manage-admins.destroy', $admin) }}" method="POST" class="inline">
                                        @csrf @method('DELETE')
                                        <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm('Are you sure?')">Delete</button>
                                    </form>
                                @else
                                    <span class="text-neutral-400">Current User</span>
                                @endif
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </x-admin.card>
@endsection