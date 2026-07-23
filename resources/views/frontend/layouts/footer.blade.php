<footer class="bg-neutral-950 text-neutral-300 ">
    {{-- Main Content --}}
    <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-16">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-10">
            {{-- About School --}}
            <div class="lg:col-span-1">
                <div class="flex items-center gap-3 mb-5">
                    @if($schoolProfile->logo)
                        <img src="{{ $schoolProfile->logo_url }}" alt="{{ $schoolProfile->name }}" class="w-10 h-10 rounded-xl object-contain bg-white p-1">
                    @else
                        <div class="w-10 h-10 rounded-xl bg-white/10 flex items-center justify-center">
                            <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                            </svg>
                        </div>
                    @endif
                    <div>
                        <div class="font-bold text-white text-base" style="font-family: var(--font-heading);">{{ $schoolProfile->short_name ?? $schoolProfile->name }}</div>
                        <div class="text-xs text-neutral-500">{{ $schoolProfile->tagline ?? 'Excellence in Education' }}</div>
                    </div>
                </div>
                <p class="text-sm text-neutral-400 leading-relaxed">
                    {{ $schoolProfile->description ?? 'Providing quality education and fostering excellence in students.' }}
                </p>
                
                {{-- Social Media --}}
                @php $socials = $schoolProfile->social_links; @endphp
                @if(count($socials) > 0)
                <div class="flex items-center gap-2 mt-6 flex-wrap">
                    @if($socials['facebook'] ?? false)
                        <a href="{{ $socials['facebook'] }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-blue-600 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M24 12.073c0-6.627-5.373-12-12-12s-12 5.373-12 12c0 5.99 4.388 10.954 10.125 11.854v-8.385H7.078v-3.47h3.047V9.43c0-3.007 1.792-4.669 4.533-4.669 1.312 0 2.686.235 2.686.235v2.953H15.83c-1.491 0-1.956.925-1.956 1.874v2.25h3.328l-.532 3.47h-2.796v8.385C19.612 23.027 24 18.062 24 12.073z"/></svg>
                        </a>
                    @endif
                    @if($socials['instagram'] ?? false)
                        <a href="{{ $socials['instagram'] }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-pink-600 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M12 2.163c3.204 0 3.584.012 4.85.07 3.252.148 4.771 1.691 4.919 4.919.058 1.265.069 1.645.069 4.849 0 3.205-.012 3.584-.069 4.849-.149 3.225-1.664 4.771-4.919 4.919-1.266.058-1.644.07-4.85.07-3.204 0-3.584-.012-4.849-.07-3.26-.149-4.771-1.699-4.919-4.92-.058-1.265-.07-1.644-.07-4.849 0-3.204.013-3.583.07-4.849.149-3.227 1.664-4.771 4.919-4.919 1.266-.057 1.645-.069 4.849-.069z"/></svg>
                        </a>
                    @endif
                    @if($socials['twitter'] ?? false)
                        <a href="{{ $socials['twitter'] }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-sky-500 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M23.953 4.57a10 10 0 01-2.825.775 4.958 4.958 0 002.163-2.723c-.951.555-2.005.959-3.127 1.184a4.92 4.92 0 00-8.384 4.482C7.69 8.095 4.067 6.13 1.64 3.162a4.822 4.822 0 00-.666 2.475c0 1.71.87 3.213 2.189 4.096a4.904 4.904 0 01-2.228-.616v.06a4.923 4.923 0 003.946 4.827 4.996 4.996 0 01-2.212.085 4.936 4.936 0 004.604 3.417 9.867 9.867 0 01-6.102 2.105c-.39 0-.779-.023-1.17-.067a13.995 13.995 0 007.557 2.209c9.053 0 13.998-7.496 13.998-13.985 0-.21 0-.42-.015-.63A9.935 9.935 0 0024 4.59z"/></svg>
                        </a>
                    @endif
                    @if($socials['youtube'] ?? false)
                        <a href="{{ $socials['youtube'] }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-red-600 flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.615 3.184c-3.604-.246-11.631-.245-15.23 0-3.897.266-4.356 2.62-4.385 8.816.029 6.185.484 8.549 4.385 8.816 3.6.245 11.626.246 15.23 0 3.897-.266 4.356-2.62 4.385-8.816-.029-6.185-.484-8.549-4.385-8.816zm-10.615 12.816v-8l8 3.993-8 4.007z"/></svg>
                        </a>
                    @endif
                    @if($socials['tiktok'] ?? false)
                        <a href="{{ $socials['tiktok'] }}" target="_blank" class="w-9 h-9 rounded-lg bg-white/5 hover:bg-black flex items-center justify-center transition-colors">
                            <svg class="w-4 h-4 text-neutral-400 hover:text-white" fill="currentColor" viewBox="0 0 24 24"><path d="M19.59 6.69a4.83 4.83 0 01-3.77-4.25V2h-3.45v13.67a2.89 2.89 0 01-5.2 1.74 2.89 2.89 0 012.31-4.64 2.93 2.93 0 01.88.13V9.4a6.84 6.84 0 00-1-.05A6.33 6.33 0 005.8 20.1a6.34 6.34 0 0010.86-4.43v-7a8.16 8.16 0 004.77 1.52v-3.4a4.85 4.85 0 01-1.84-.1z"/></svg>
                        </a>
                    @endif
                </div>
                @endif
            </div>

            {{-- Quick Links --}}
            <div>
                <h4 class="font-bold text-white mb-5 text-sm tracking-wider uppercase">Quick Links</h4>
                <ul class="space-y-3 text-sm">
                    <li><a href="{{ route('home') }}" class="text-neutral-400 hover:text-white transition-colors">Home</a></li>
                    <li><a href="{{ route('frontend.posts.index') }}" class="text-neutral-400 hover:text-white transition-colors">News & Articles</a></li>
                    <li><a href="{{ route('frontend.about') }}" class="text-neutral-400 hover:text-white transition-colors">About Us</a></li>
                    <li><a href="{{ route('frontend.gallery') }}" class="text-neutral-400 hover:text-white transition-colors">Gallery</a></li>
                    <li><a href="{{ route('frontend.announcements.index') }}" class="text-neutral-400 hover:text-white transition-colors">Announcements</a></li>
                    <li><a href="{{ route('frontend.contact') }}" class="text-neutral-400 hover:text-white transition-colors">Contact Us</a></li>
                </ul>
            </div>

            {{-- Contact --}}
            <div>
                <h4 class="font-bold text-white mb-5 text-sm tracking-wider uppercase">Get in Touch</h4>
                <ul class="space-y-4 text-sm">
                    @if($schoolProfile->address)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-neutral-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                        </svg>
                        <span class="text-neutral-400">{{ $schoolProfile->address }}</span>
                    </li>
                    @endif
                    @if($schoolProfile->email)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-neutral-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                        </svg>
                        <a href="mailto:{{ $schoolProfile->email }}" class="text-neutral-400 hover:text-white transition-colors">{{ $schoolProfile->email }}</a>
                    </li>
                    @endif
                    @if($schoolProfile->phone)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-neutral-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                        </svg>
                        <a href="tel:{{ $schoolProfile->phone }}" class="text-neutral-400 hover:text-white transition-colors">{{ $schoolProfile->phone }}</a>
                    </li>
                    @endif
                    @if($schoolProfile->website)
                    <li class="flex items-start gap-3">
                        <svg class="w-4 h-4 mt-0.5 text-neutral-500 shrink-0" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M21 12a9 9 0 01-9 9m9-9a9 9 0 00-9-9m9 9H3m9 9a9 9 0 01-9-9m9 9c1.657 0 3-4.03 3-9s-1.343-9-3-9m0 18c-1.657 0-3-4.03-3-9s1.343-9 3-9m-9 9a9 9 0 019-9" />
                        </svg>
                        <a href="{{ $schoolProfile->website }}" target="_blank" class="text-neutral-400 hover:text-white transition-colors">{{ parse_url($schoolProfile->website, PHP_URL_HOST) }}</a>
                    </li>
                    @endif
                </ul>
            </div>

            {{-- Newsletter --}}
            <div>
                <h4 class="font-bold text-white mb-5 text-sm tracking-wider uppercase">Stay Updated</h4>
                <p class="text-sm text-neutral-400 mb-4">Subscribe to our newsletter for the latest news.</p>
                <form class="space-y-2">
                    <input type="email" placeholder="Enter your email" class="w-full px-4 py-2.5 bg-white/5 border border-white/10 rounded-lg text-sm text-white placeholder:text-neutral-500 focus:outline-none focus:border-white/30">
                    <button type="submit" class="w-full px-4 py-2.5 bg-white text-neutral-900 font-semibold text-sm rounded-lg hover:bg-neutral-100 transition-all">Subscribe</button>
                </form>
            </div>
        </div>
    </div>

    {{-- Bottom Bar --}}
    <div class="border-t border-white/10">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="text-xs text-neutral-500">
                © {{ date('Y') }} {{ $schoolProfile->name ?? 'School Portal' }}. All rights reserved.
            </div>
        </div>
    </div>
</footer>