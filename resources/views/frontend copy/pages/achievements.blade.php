<x-frontend.layouts.app>
    <x-slot name="title">Achievements</x-slot>

    <section class="bg-neutral-900 text-white py-20">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="max-w-3xl">
                <span class="text-xs font-bold text-yellow-400 uppercase tracking-wider">Celebrating Excellence</span>
                <h1 class="text-4xl md:text-5xl font-bold mt-2 mb-4" style="font-family: var(--font-heading);">Achievements</h1>
                <p class="text-xl text-neutral-300">Outstanding accomplishments from our students and staff.</p>
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
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search achievements..." class="w-full pl-12 pr-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                    </div>
                </form>
                <form method="GET" class="md:w-48">
                    <select name="level" onchange="this.form.submit()" class="w-full px-4 py-3 bg-white border border-neutral-200 rounded-xl text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400">
                        <option value="">All Levels</option>
                        <option value="school" @selected(request('level') === 'school')>School</option>
                        <option value="district" @selected(request('level') === 'district')>District</option>
                        <option value="city" @selected(request('level') === 'city')>City</option>
                        <option value="province" @selected(request('level') === 'province')>Province</option>
                        <option value="national" @selected(request('level') === 'national')>National</option>
                        <option value="international" @selected(request('level') === 'international')>International</option>
                    </select>
                </form>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                @forelse($achievements as $achievement)
                    <article class="bg-white rounded-2xl border border-neutral-200 overflow-hidden hover:shadow-lg transition-shadow">
                        @if($achievement->thumbnail)
                            <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="block aspect-[16/10] overflow-hidden bg-neutral-100">
                                <img src="{{ $achievement->thumbnail_url }}" alt="{{ $achievement->title }}" class="w-full h-full object-cover hover:scale-105 transition-transform duration-300">
                            </a>
                        @endif
                        <div class="p-6">
                            <div class="flex items-center gap-2 mb-3">
                                <x-admin.badge variant="info" size="xs">{{ ucfirst($achievement->level) }}</x-admin.badge>
                                @if($achievement->rank)
                                    <x-admin.badge variant="success" size="xs">{{ $achievement->rank }}</x-admin.badge>
                                @endif
                            </div>
                            <h2 class="text-lg font-bold text-neutral-900 mb-2 line-clamp-2" style="font-family: var(--font-heading);">
                                <a href="{{ route('frontend.achievements.show', $achievement->slug) }}" class="hover:text-neutral-600 transition-colors">{{ $achievement->title }}</a>
                            </h2>
                            @if($achievement->achiever_name)
                                <p class="text-sm text-neutral-600 mb-2">{{ $achievement->achiever_name }}</p>
                            @endif
                            @if($achievement->competition_name)
                                <p class="text-xs text-neutral-500">{{ $achievement->competition_name }}</p>
                            @endif
                        </div>
                    </article>
                @empty
                    <div class="col-span-full text-center py-20">
                        <div class="w-16 h-16 rounded-2xl bg-neutral-100 flex items-center justify-center mx-auto mb-4">
                            <svg class="w-7 h-7 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="1.5">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M5 3v4M3 5h4M6 17v4m-2-2h4m5-16l2.286 6.857L21 12l-5.714 2.143L13 21l-2.286-6.857L5 12l5.714-2.143L13 3z" />
                            </svg>
                        </div>
                        <h3 class="text-lg font-bold text-neutral-900 mb-1">No achievements found</h3>
                        <p class="text-sm text-neutral-500">Check back later for new achievements.</p>
                    </div>
                @endforelse
            </div>

            @if($achievements->hasPages())
                <div class="mt-12">{{ $achievements->links() }}</div>
            @endif
        </div>
    </section>
</x-frontend.layouts.app>
