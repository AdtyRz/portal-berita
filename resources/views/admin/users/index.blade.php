@extends('admin.layouts.app')

@section('content')
@section('title', 'Users')

    <x-admin.page-header title="Users" description="Manage system users and roles">
        <x-admin.button href="{{ route('admin.users.create') }}">
            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" /></svg>
            New User
        </x-admin.button>
    </x-admin.page-header>

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search users..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="role" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Roles</option>
                    @foreach($roles as $role)
                        <option value="{{ $role->name }}" @selected(request('role') === $role->name)>{{ ucfirst($role->name) }}</option>
                    @endforeach
                </select>
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="active" @selected(request('status') === 'active')>Active</option>
                    <option value="inactive" @selected(request('status') === 'inactive')>Inactive</option>
                </select>
                <div class="flex gap-2">
                    <a href="{{ route('admin.users.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.users.create') }}" class="px-4 py-2 text-sm font-medium text-white bg-neutral-900 border border-neutral-900 rounded-lg hover:bg-neutral-800">Create New </a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">User</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Role</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Status</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Joined</th>
            <th class="px-6 py-3 text-right text-xs font-semibold text-neutral-600 uppercase">Actions</th>
        </x-slot>

        @forelse($users as $user)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-gradient-to-br from-neutral-700 to-neutral-900 flex items-center justify-center text-white text-sm font-bold shrink-0">
                            {{ strtoupper(substr($user->name, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate">{{ $user->name }}</div>
                            <div class="text-xs text-neutral-500 truncate">{{ $user->email }}</div>
                        </div>
                    </div>
                </td>
                <td class="px-6 py-4">
                    @foreach($user->roles as $role)
                        <x-admin.badge variant="info" size="sm">{{ ucfirst($role->name) }}</x-admin.badge>
                    @endforeach
                </td>
                <td class="px-6 py-4">
                    @if($user->status)
                        <x-admin.badge variant="success">Active</x-admin.badge>
                    @else
                        <x-admin.badge variant="neutral">Inactive</x-admin.badge>
                    @endif
                </td>
                <td class="px-6 py-4 text-sm text-neutral-500">{{ $user->created_at->format('M d, Y') }}</td>
                <td class="px-6 py-4 text-right">
                    <div class="flex items-center justify-end gap-2">
                        <a href="{{ route('admin.users.edit', $user) }}" class="p-1.5 rounded-lg text-neutral-600 hover:text-neutral-900 hover:bg-neutral-100">
                            <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z" /></svg>
                        </a>
                        @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}" onsubmit="return confirm('Delete this user?');">
                                @csrf @method('DELETE')
                                <button class="p-1.5 rounded-lg text-red-600 hover:text-red-700 hover:bg-red-50">
                                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" /></svg>
                                </button>
                            </form>
                        @endif
                    </div>
                </td>
            </tr>
        @empty
            <tr><td colspan="5"><x-admin.empty-state>@section('title', 'No users found')<x-slot name="action"><x-admin.button href="{{ route('admin.users.create') }}">Create User</x-admin.button></x-slot></x-admin.empty-state></td></tr>
        @endforelse
    </x-admin.table>

    @if($users->hasPages()) <div class="mt-6">{{ $users->links() }}</div> @endif
@endsection