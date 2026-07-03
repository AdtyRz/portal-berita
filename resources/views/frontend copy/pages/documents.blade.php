<x-frontend.layouts.app>
    <x-slot name="title">Documents</x-slot>

    <section class="bg-neutral-50 border-b border-neutral-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-blue-600 uppercase tracking-wider">Resources</span>
                <h1 class="text-4xl md:text-5xl font-bold text-neutral-900 mt-2 mb-4" style="font-family: var(--font-heading);">Documents</h1>
                <p class="text-lg text-neutral-600">Downloadable resources and files.</p>
            </div>
        </div>
    </section>

    <section class="py-16">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex flex-col md:flex-row gap-4 mb-10">
                <form method="GET" class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 -translate-y-1/2 w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z" />
                        </svg>
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search documents..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    </div>
                </form>
                <form method="GET" class="md:w-48">
                    <select name="category" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                        <option value="">All Categories</option>
                        <option value="academic" @selected(request('category') === 'academic')>Academic</option>
                        <option value="administrative" @selected(request('category') === 'administrative')>Administrative</option>
                        <option value="regulation" @selected(request('category') === 'regulation')>Regulation</option>
                        <option value="form" @selected(request('category') === 'form')>Form</option>
                        <option value="other" @selected(request('category') === 'other')>Other</option>
                    </select>
                </form>
            </div>

            <div class="space-y-3">
                @forelse($documents as $document)
                    <div class="bg-white rounded-xl border border-neutral-200 p-5 hover:shadow-md transition-shadow">
                        <div class="flex items-center gap-4">
                            <div class="w-12 h-12 rounded-lg bg-blue-50 flex items-center justify-center text-blue-600 shrink-0">
                                <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="text-base font-semibold text-neutral-900 mb-1 truncate">{{ $document->title }}</h3>
                                <div class="flex items-center gap-3 text-xs text-neutral-500">
                                    <x-admin.badge variant="neutral" size="xs">{{ ucfirst($document->category) }}</x-admin.badge>
                                    <span>{{ strtoupper($document->file_type ?? 'PDF') }}</span>
                                    <span>•</span>
                                    <span>{{ $document->file_size_formatted }}</span>
                                    <span>•</span>
                                    <span>{{ number_format($document->download_count) }} downloads</span>
                                </div>
                            </div>
                            <a href="{{ route('frontend.documents.download', $document) }}" class="inline-flex items-center gap-2 px-4 py-2 bg-neutral-900 text-white text-sm font-medium rounded-lg hover:bg-neutral-800 transition-colors shrink-0">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 16v1a3 3 0 003 3h10a3 3 0 003-3v-1m-4-4l-4 4m0 0l-4-4m4 4V4" />
                                </svg>
                                Download
                            </a>
                        </div>
                    </div>
                @empty
                    <div class="text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">No documents found</h3>
                        <p class="text-sm text-neutral-500">Check back later for new resources.</p>
                    </div>
                @endforelse
            </div>

            @if($documents->hasPages())
                <div class="mt-12">{{ $documents->links() }}</div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
