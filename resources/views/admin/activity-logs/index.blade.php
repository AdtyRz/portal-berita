@extends('admin.layouts.app')

@section('title', 'Activity Logs')

@section('content')
    <x-admin.page-header title="Activity Logs" description="Monitor all system activities" />

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search activities..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="action" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Actions</option>
                    <option value="created" @selected(request('action') === 'created')>Created</option>
                    <option value="updated" @selected(request('action') === 'updated')>Updated</option>
                    <option value="deleted" @selected(request('action') === 'deleted')>Deleted</option>
                    <option value="login" @selected(request('action') === 'login')>Login</option>
                    <option value="logout" @selected(request('action') === 'logout')>Logout</option>
                </select>
                <div class="flex gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.activity-logs.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <x-admin.table>
        <x-slot name="head">
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">User</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Action</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Description</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">IP Address</th>
            <th class="px-6 py-3 text-left text-xs font-semibold text-neutral-600 uppercase">Time</th>
        </x-slot>

        @forelse($logs as $log)
            <tr class="hover:bg-neutral-50/50">
                <td class="px-6 py-4">
                    @if($log->user)
                        <div class="flex items-center gap-2">
                            <div class="w-8 h-8 rounded-full bg-neutral-200 flex items-center justify-center text-xs font-bold text-neutral-700">
                                {{ strtoupper(substr($log->user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="text-sm font-medium text-neutral-900">{{ $log->user->name }}</div>
                                <div class="text-xs text-neutral-500">{{ $log->user->email }}</div>
                            </div>
                        </div>
                    @else
                        <span class="text-sm text-neutral-500">System</span>
                    @endif
                </td>
                <td class="px-6 py-4">
                    @php
                        $actionVariants = ['created' => 'success', 'updated' => 'info', 'deleted' => 'danger', 'login' => 'neutral', 'logout' => 'neutral'];
                    @endphp
                    <x-admin.badge :variant="$actionVariants[$log->action] ?? 'neutral'">{{ ucfirst($log->action) }}</x-admin.badge>
                </td>
                <td class="px-6 py-4 text-sm text-neutral-600 max-w-md truncate">{{ $log->description ?? '-' }}</td>
                <td class="px-6 py-4 text-xs text-neutral-500 font-mono">{{ $log->ip_address ?? '-' }}</td>
                <td class="px-6 py-4 text-sm text-neutral-500">{{ $log->created_at->diffForHumans() }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="5">
                    <x-admin.empty-state>
                        <x-slot name="title">No activity logs found</x-slot>
                    </x-admin.empty-state>
                </td>
            </tr>
        @endforelse
    </x-admin.table>

    @if($logs->hasPages())
        <div class="mt-6">{{ $logs->links() }}</div>
    @endif
@endsection