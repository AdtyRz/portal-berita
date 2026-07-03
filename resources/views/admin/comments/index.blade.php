@extends('admin.layouts.app')

@section('content')
@section('title', 'Comments')

    <x-admin.page-header title="Comments" description="Manage user comments" />

    <x-admin.card class="mb-6">
        <form method="GET" class="p-4">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <input type="text" name="search" value="{{ request('search') }}" placeholder="Search comments..." class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                <select name="status" class="px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    <option value="">All Status</option>
                    <option value="approved" @selected(request('status') === 'approved')>Approved</option>
                    <option value="pending" @selected(request('status') === 'pending')>Pending</option>
                </select>
                <div class="flex gap-2">
                    <x-admin.button type="submit">Filter</x-admin.button>
                    <a href="{{ route('admin.comments.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Reset</a>
                </div>
            </div>
        </form>
    </x-admin.card>

    <div class="space-y-3">
        @forelse($comments as $comment)
            <x-admin.card>
                <div class="p-5">
                    <div class="flex items-start justify-between gap-4">
                        <div class="flex-1 min-w-0">
                            <div class="flex items-center gap-2 mb-2">
                                <div class="w-8 h-8 rounded-full bg-neutral-100 flex items-center justify-center text-xs font-semibold text-neutral-600">
                                    {{ strtoupper(substr($comment->author_name, 0, 1)) }}
                                </div>
                                <div>
                                    <span class="text-sm font-semibold text-neutral-900">{{ $comment->author_name }}</span>
                                    <span class="text-xs text-neutral-500 ml-2">{{ $comment->created_at->diffForHumans() }}</span>
                                </div>
                                @if(!$comment->is_approved)
                                    <x-admin.badge variant="warning" size="xs">Pending</x-admin.badge>
                                @else
                                    <x-admin.badge variant="success" size="xs">Approved</x-admin.badge>
                                @endif
                            </div>
                            <p class="text-sm text-neutral-700 mb-2">{{ $comment->content }}</p>
                            <div class="text-xs text-neutral-500">
                                on: <a href="{{ route('admin.posts.edit', $comment->post) }}" class="text-neutral-700 hover:underline font-medium">{{ Str::limit($comment->post->title, 50) }}</a>
                            </div>
                        </div>
                        <div class="flex items-center gap-2 shrink-0">
                            @if(!$comment->is_approved)
                                <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                                    @csrf
                                    <x-admin.button type="submit" variant="success" size="sm">Approve</x-admin.button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Delete?');">
                                @csrf @method('DELETE')
                                <x-admin.button type="submit" variant="danger" size="sm">Delete</x-admin.button>
                            </form>
                        </div>
                    </div>
                </div>
            </x-admin.card>
        @empty
            <x-admin.card>
                <x-admin.empty-state>
                    @section('title', 'No comments found')
                </x-admin.empty-state>
            </x-admin.card>
        @endforelse
    </div>

    @if($comments->hasPages()) <div class="mt-6">{{ $comments->links() }}</div> @endif
@endsection