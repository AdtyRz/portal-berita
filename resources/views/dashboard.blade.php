@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    <x-admin.page-header title="Dashboard" description="Welcome back, {{ auth()->user()->name }}. Here's what's happening today." />

    {{-- Stats Grid --}}
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
        <x-admin.stat-card
            label="Total Posts"
            :value="$stats['total_posts']"
            icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
            href="{{ route('admin.posts.index') }}"
        />
        <x-admin.stat-card
            label="Total Views"
            :value="number_format($stats['total_views'])"
            icon="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
        />
        <x-admin.stat-card
            label="Pending Comments"
            :value="$stats['pending_comments']"
            icon="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.57 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
            href="{{ route('admin.comments.index') }}"
        />
        <x-admin.stat-card
            label="Unread Messages"
            :value="$stats['unread_contacts']"
            icon="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
            href="{{ route('admin.contacts.index') }}"
        />
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Posts --}}
        <x-admin.card class="lg:col-span-2">
            <div class="p-5 border-b border-neutral-200/80 flex items-center justify-between">
                <h2 class="text-base font-semibold text-neutral-900" style="font-family: var(--font-heading);">Recent Posts</h2>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
            </div>
            <div class="divide-y divide-neutral-100">
                @forelse($recentPosts as $post)
                    <a href="{{ route('admin.posts.edit', $post) }}" class="flex items-center gap-4 p-4 hover:bg-neutral-50 transition-colors">
                        <div class="w-16 h-12 rounded-lg bg-neutral-100 overflow-hidden shrink-0">
                            @if($post->thumbnail)
                                <img src="{{ $post->thumbnail_url }}" alt="" class="w-full h-full object-cover">
                            @else
                                <div class="w-full h-full flex items-center justify-center text-neutral-400">
                                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                                    </svg>
                                </div>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="text-sm font-semibold text-neutral-900 truncate">{{ $post->title }}</div>
                            <div class="flex items-center gap-2 mt-1">
                                <x-admin.badge :variant="$post->status === 'published' ? 'success' : 'neutral'" size="xs">
                                    {{ ucfirst($post->status) }}
                                </x-admin.badge>
                                <span class="text-xs text-neutral-500">{{ $post->created_at->diffForHumans() }}</span>
                            </div>
                        </div>
                        <div class="text-right shrink-0">
                            <div class="text-sm font-medium text-neutral-900">{{ number_format($post->total_views) }}</div>
                            <div class="text-xs text-neutral-500">views</div>
                        </div>
                    </a>
                @empty
                    <div class="p-8 text-center text-sm text-neutral-500">No posts yet.</div>
                @endforelse
            </div>
        </x-admin.card>

        {{-- Quick Actions --}}
        <x-admin.card>
            <div class="p-5 border-b border-neutral-200/80">
                <h2 class="text-base font-semibold text-neutral-900" style="font-family: var(--font-heading);">Quick Actions</h2>
            </div>
            <div class="p-3 space-y-1">
                <a href="{{ route('admin.posts.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 transition-colors group">
                    <div class="w-9 h-9 rounded-lg bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-neutral-600 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 4v16m8-8H4" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-neutral-900">New Post</div>
                        <div class="text-xs text-neutral-500">Create article</div>
                    </div>
                </a>
                <a href="{{ route('admin.announcements.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 transition-colors group">
                    <div class="w-9 h-9 rounded-lg bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-neutral-600 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-neutral-900">Announcement</div>
                        <div class="text-xs text-neutral-500">Publish news</div>
                    </div>
                </a>
                <a href="{{ route('admin.agendas.create') }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-neutral-50 transition-colors group">
                    <div class="w-9 h-9 rounded-lg bg-neutral-100 group-hover:bg-neutral-900 group-hover:text-white flex items-center justify-center text-neutral-600 transition-all">
                        <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                    </div>
                    <div>
                        <div class="text-sm font-medium text-neutral-900">Schedule Event</div>
                        <div class="text-xs text-neutral-500">Add agenda</div>
                    </div>
                </a>
            </div>
        </x-admin.card>
    </div>
@endsection
