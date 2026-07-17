@extends('admin.layouts.app')

@section('title', 'Comment Details')

@section('content')
    <x-admin.page-header 
        title="Comment Details" 
        description="View full comment information" 
    />

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">
            <x-admin.card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-neutral-900">Comment Information</h3>
                </x-slot>

                <div class="p-6 space-y-6">
                    {{-- Commenter Info --}}
                    <div class="flex items-start gap-4 pb-6 border-b border-neutral-200">
                        <div class="w-16 h-16 rounded-full bg-gradient-to-br from-blue-500 to-purple-600 flex items-center justify-center text-white text-2xl font-bold shrink-0">
                            {{ strtoupper(substr($comment->name ?? 'A', 0, 1)) }}
                        </div>
                        <div class="flex-1">
                            <h4 class="text-xl font-bold text-neutral-900 mb-1">
                                {{ $comment->name ?? 'Anonymous' }}
                            </h4>
                            @if($comment->email)
                                <p class="text-sm text-neutral-600 mb-2">
                                    <a href="mailto:{{ $comment->email }}" class="text-blue-600 hover:underline">
                                        {{ $comment->email }}
                                    </a>
                                </p>
                            @endif
                            <div class="flex items-center gap-3 text-sm text-neutral-500">
                                <span>Posted {{ $comment->created_at->diffForHumans() }}</span>
                                <span>•</span>
                                <span>{{ $comment->created_at->format('M d, Y H:i') }}</span>
                            </div>
                        </div>
                        <div>
                            @if(!$comment->is_approved)
                                <x-admin.badge variant="warning" size="sm">Pending Approval</x-admin.badge>
                            @else
                                <x-admin.badge variant="success" size="sm">Approved</x-admin.badge>
                            @endif
                        </div>
                    </div>

                    {{-- Comment Content --}}
                    <div>
                        <h5 class="text-sm font-semibold text-neutral-700 uppercase tracking-wider mb-3">Comment Message</h5>
                        <div class="bg-neutral-50 rounded-xl p-6">
                            <p class="text-neutral-900 whitespace-pre-wrap leading-relaxed">
                                {{ $comment->content }}
                            </p>
                        </div>
                    </div>

                    {{-- Post Information --}}
                    @if($comment->post)
                        <div class="pt-6 border-t border-neutral-200">
                            <h5 class="text-sm font-semibold text-neutral-700 uppercase tracking-wider mb-3">Posted On</h5>
                            <a href="{{ route('admin.posts.edit', $comment->post) }}" class="block p-4 bg-blue-50 border border-blue-200 rounded-xl hover:bg-blue-100 transition-colors">
                                <div class="flex items-start gap-3">
                                    @if($comment->post->thumbnail)
                                        <img src="{{ asset('storage/' . $comment->post->thumbnail) }}" alt="{{ $comment->post->title }}" class="w-16 h-16 rounded-lg object-cover shrink-0">
                                    @else
                                        <div class="w-16 h-16 rounded-lg bg-blue-200 flex items-center justify-center shrink-0">
                                            <svg class="w-8 h-8 text-blue-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                                <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                            </svg>
                                        </div>
                                    @endif
                                    <div class="flex-1 min-w-0">
                                        <h6 class="text-base font-semibold text-neutral-900 mb-1">
                                            {{ $comment->post->title }}
                                        </h6>
                                        <p class="text-sm text-neutral-600 line-clamp-2 mb-2">
                                            {{ Str::limit($comment->post->excerpt ?? $comment->post->content, 100) }}
                                        </p>
                                        <div class="flex items-center gap-2 text-xs text-neutral-500">
                                            <span>By {{ $comment->post->author->name }}</span>
                                            <span>•</span>
                                            <span>{{ $comment->post->created_at->format('M d, Y') }}</span>
                                        </div>
                                    </div>
                                </div>
                            </a>
                        </div>
                    @endif
                </div>
            </x-admin.card>
        </div>

        {{-- Sidebar Actions --}}
        <div class="space-y-6">
            <x-admin.card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-neutral-900">Actions</h3>
                </x-slot>

                <div class="p-6 space-y-3">
                    @if(!$comment->is_approved)
                        <form method="POST" action="{{ route('admin.comments.approve', $comment) }}">
                            @csrf
                            <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-colors">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                                </svg>
                                Approve Comment
                            </button>
                        </form>
                    @else
                        <div class="p-4 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center gap-2 text-green-800">
                                <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z" />
                                </svg>
                                <span class="text-sm font-medium">This comment is approved</span>
                            </div>
                        </div>
                    @endif

                    <form method="POST" action="{{ route('admin.comments.destroy', $comment) }}" onsubmit="return confirm('Are you sure you want to delete this comment?')">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-red-600 text-white rounded-lg hover:bg-red-700 transition-colors">
                            <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                            </svg>
                            Delete Comment
                        </button>
                    </form>

                    <a href="{{ route('admin.comments.index') }}" class="w-full inline-flex items-center justify-center gap-2 px-4 py-3 bg-neutral-100 text-neutral-700 rounded-lg hover:bg-neutral-200 transition-colors">
                        <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M10 19l-7-7m0 0l7-7m-7 7h18" />
                        </svg>
                        Back to Comments
                    </a>
                </div>
            </x-admin.card>

            {{-- Metadata Card --}}
            <x-admin.card>
                <x-slot name="header">
                    <h3 class="text-lg font-semibold text-neutral-900">Metadata</h3>
                </x-slot>

                <div class="p-6 space-y-4">
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wider mb-1">Comment ID</div>
                        <div class="text-sm font-medium text-neutral-900">#{{ $comment->id }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wider mb-1">IP Address</div>
                        <div class="text-sm font-medium text-neutral-900">{{ $comment->ip_address ?? 'N/A' }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wider mb-1">Created At</div>
                        <div class="text-sm font-medium text-neutral-900">{{ $comment->created_at->format('M d, Y H:i:s') }}</div>
                    </div>
                    <div>
                        <div class="text-xs text-neutral-500 uppercase tracking-wider mb-1">Updated At</div>
                        <div class="text-sm font-medium text-neutral-900">{{ $comment->updated_at->format('M d, Y H:i:s') }}</div>
                    </div>
                </div>
            </x-admin.card>
        </div>
    </div>
@endsection