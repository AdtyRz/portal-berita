@extends('admin.layouts.app')

@section('title', 'Dashboard')

@section('content')
    {{-- ========================================= --}}
    {{-- SECTION 1: MAIN STATS (8 Cards) --}}
    {{-- ========================================= --}}
    <div class="mb-6">
        <h3 class="text-sm font-semibold text-neutral-500 uppercase tracking-wider mb-3">Overview</h3>
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4">
            <x-admin.stat-card
                label="Total Views"
                :value="number_format($stats['total_views'] ?? 0)"
                icon="M15 12a3 3 0 11-6 0 3 3 0 016 0z M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"
                color="success"
            />

            <x-admin.stat-card
                label="Total Posts"
                :value="$stats['total_posts'] ?? 0"
                icon="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"
                color="primary"
            />

            <x-admin.stat-card
                label="Pending Comments"
                :value="$stats['pending_comments'] ?? 0"
                icon="M8 12h.01M12 12h.01M16 12h.01M21 12c0 4.418-4.03 8-9 8a9.863 9.863 0 01-4.255-.949L3 20l1.395-3.72C3.512 15.042 3 13.57 3 12c0-4.418 4.03-8 9-8s9 3.582 9 8z"
                color="warning"
            />

            <x-admin.stat-card
                label="Unread Messages"
                :value="$stats['unread_contacts'] ?? 0"
                icon="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"
                color="danger"
            />

            <x-admin.stat-card
                label="Announcements"
                :value="$stats['total_announcements'] ?? 0"
                icon="M11 5.882V19.24a1.76 1.76 0 01-3.417.592l-2.147-6.15M18 13a3 3 0 100-6M5.436 13.683A4.001 4.001 0 017 6h1.832c4.1 0 7.625-1.234 9.168-3v14c-1.543-1.766-5.067-3-9.168-3H7a3.988 3.988 0 01-1.564-.317z"
                color="danger"
            />

            <x-admin.stat-card
                label="Agendas"
                :value="$stats['total_agendas'] ?? 0"
                icon="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"
                color="primary"
            />

            <x-admin.stat-card
                label="Achievements"
                :value="$stats['total_achievements'] ?? 0"
                icon="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z"
                color="warning"
            />

            <x-admin.stat-card
                label="Organizations"
                :value="$stats['total_organizations'] ?? 0"
                icon="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"
                color="info"
            />
        </div>
    </div>

    {{-- ========================================= --}}
    {{-- SECTION 2: RECENT ACTIVITY --}}
    {{-- ========================================= --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Recent Posts --}}
        <x-admin.card class="lg:col-span-2 overflow-hidden">
            <div class="p-5 border-b border-neutral-200/80 flex items-center justify-between">
                <h2 class="text-base font-semibold text-neutral-900" style="font-family: var(--font-heading);">
                    Recent Posts
                    <span class="text-xs font-normal text-neutral-500 ml-2">({{ $stats['total_posts'] ?? 0 }} total)</span>
                </h2>
                <a href="{{ route('admin.posts.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
            </div>

            {{-- FIXED HEIGHT CONTAINER --}}
            <div class="max-h-[200px] overflow-y-auto">
                <div class="divide-y divide-neutral-100">
                    @forelse($recentPosts ?? [] as $post)
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
                                    @if($post->category)
                                        <span class="text-xs text-neutral-500">• {{ $post->category->name }}</span>
                                    @endif
                                    <span class="text-xs text-neutral-500">• {{ $post->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <div class="text-right shrink-0">
                                <div class="text-sm font-medium text-neutral-900">{{ number_format($post->total_views ?? 0) }}</div>
                                <div class="text-xs text-neutral-500">views</div>
                            </div>
                        </a>
                    @empty
                        <div class="p-8 text-center text-sm text-neutral-500">No posts yet.</div>
                    @endforelse
                </div>
            </div>
        </x-admin.card>

        {{-- Recent Comments --}}
        <x-admin.card class="overflow-hidden">
            <div class="p-5 border-b border-neutral-200/80 flex items-center justify-between">
                <h2 class="text-base font-semibold text-neutral-900" style="font-family: var(--font-heading);">
                    Recent Comments
                    <span class="text-xs font-normal text-neutral-500 ml-2">({{ $stats['total_comments'] ?? 0 }} total)</span>
                </h2>
                <a href="{{ route('admin.comments.index') }}" class="text-sm font-medium text-neutral-600 hover:text-neutral-900">View all →</a>
            </div>

            {{-- FIXED HEIGHT CONTAINER --}}
            <div class="max-h-[200px] overflow-y-auto">
                <div class="divide-y divide-neutral-100">
                    @forelse($recentComments ?? [] as $comment)
                        <div class="p-4 hover:bg-neutral-50 transition-colors">
                            <div class="flex items-start gap-3">
                                <div class="w-8 h-8 rounded-full {{ ($comment['is_approved'] ?? true) ? 'bg-neutral-100' : 'bg-amber-100' }} flex items-center justify-center shrink-0">
                                    <span class="text-xs font-semibold {{ ($comment['is_approved'] ?? true) ? 'text-neutral-600' : 'text-amber-600' }}">
                                        {{ strtoupper(substr($comment['author_name'] ?? 'A', 0, 1)) }}
                                    </span>
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-center gap-2">
                                        <div class="text-sm font-semibold text-neutral-900 truncate">{{ $comment['author_name'] ?? 'Anonymous' }}</div>
                                        @if(!($comment['is_approved'] ?? true))
                                            <span class="px-1.5 py-0.5 text-[10px] font-bold text-amber-700 bg-amber-100 rounded">Pending</span>
                                        @endif
                                    </div>
                                    <p class="text-xs text-neutral-600 line-clamp-2 mt-1">{{ $comment['content'] ?? '' }}</p>
                                    <div class="flex items-center gap-2 mt-1">
                                        <span class="text-[10px] text-neutral-400">on</span>
                                        <span class="text-[10px] text-neutral-500 truncate">{{ $comment['post_title'] ?? 'Unknown' }}</span>
                                    </div>
                                    <div class="text-[10px] text-neutral-400 mt-0.5">
                                        {{ \Carbon\Carbon::parse($comment['created_at'] ?? now())->diffForHumans() }}
                                    </div>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="p-8 text-center text-sm text-neutral-500">No comments yet.</div>
                    @endforelse
                </div>
            </div>
        </x-admin.card>
    </div>
@endsection
