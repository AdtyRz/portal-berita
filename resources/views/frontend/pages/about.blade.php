@extends('frontend.layouts.app')

@section('title', 'About ' . ($schoolProfile->name ?? 'Us'))
@section('metaDescription', $schoolProfile->description ?? 'Learn more about our school')

@section('content')
    {{-- Hero Section --}}
    <section class="relative bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 text-white py-24 overflow-hidden">
        @if($schoolProfile->cover_image)
            <img src="{{ $schoolProfile->cover_url }}" alt="" class="absolute inset-0 w-full h-full object-cover opacity-30">
        @endif
        <div class="absolute inset-0 bg-gradient-to-t from-neutral-900 to-transparent"></div>
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s;"></div>
        </div>
        
        <div class="relative mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold text-red-400 uppercase tracking-wider">About Our School</span>
            <h1 class="text-4xl md:text-6xl font-bold mt-2 mb-4" style="font-family: var(--font-heading);">
                {{ $schoolProfile->name ?? 'Our School' }}
            </h1>
            @if($schoolProfile->tagline)
                <p class="text-xl text-neutral-300 max-w-3xl mx-auto">{{ $schoolProfile->tagline }}</p>
            @endif
            @if($schoolProfile->founded_year)
                <div class="mt-6 inline-flex items-center gap-2 px-4 py-2 bg-white/10 backdrop-blur-sm rounded-full text-sm">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Established {{ $schoolProfile->founded_year }}
                    @if($schoolProfile->accreditation)
                        <span class="mx-2">•</span>
                        Accreditation: {{ $schoolProfile->accreditation }}
                    @endif
                </div>
            @endif
        </div>
    </section>

    {{-- Description --}}
    @if($schoolProfile->description)
    <section class="py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <div class="prose prose-lg max-w-none prose-headings:font-bold prose-headings:tracking-tight">
                <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 text-center mb-8" style="font-family: var(--font-heading);">Who We Are</h2>
                <p class="text-lg text-neutral-700 leading-relaxed text-center">{{ $schoolProfile->description }}</p>
            </div>
        </div>
    </section>
    @endif

    {{-- Vision & Mission --}}
    @if($schoolProfile->vision || count($schoolProfile->mission_list) > 0)
    <section class="py-20 bg-neutral-50">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                @if($schoolProfile->vision)
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-neutral-200 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                            <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3" style="font-family: var(--font-heading);">Our Vision</h2>
                    <p class="text-neutral-600 leading-relaxed">{{ is_array($schoolProfile->vision) ? implode(' ', $schoolProfile->vision) : $schoolProfile->vision }}</p>
                </div>
                @endif

                @if(count($schoolProfile->mission_list) > 0)
                <div class="bg-white rounded-2xl p-8 shadow-sm border border-neutral-200 hover:shadow-lg transition-shadow">
                    <div class="w-12 h-12 rounded-xl bg-gradient-to-br from-pink-500 to-orange-500 flex items-center justify-center text-white mb-4">
                        <svg class="w-6 h-6" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M13 10V3L4 14h7v7l9-11h-7z" />
                        </svg>
                    </div>
                    <h2 class="text-2xl font-bold text-neutral-900 mb-3" style="font-family: var(--font-heading);">Our Mission</h2>
                    <ol class="space-y-2">
                        @foreach($schoolProfile->mission_list as $index => $mission)
                            <li class="flex items-start gap-3 text-neutral-600">
                                <span class="w-6 h-6 rounded-full bg-gradient-to-br from-pink-500 to-orange-500 text-white text-xs font-bold flex items-center justify-center shrink-0 mt-0.5">{{ $index + 1 }}</span>
                                <span class="leading-relaxed">{{ preg_replace('/^\d+\.\s*/', '', $mission) }}</span>
                            </li>
                        @endforeach
                    </ol>
                </div>
                @endif
            </div>
        </div>
    </section>
    @endif

    {{-- Stats --}}
    <section class="py-20 bg-gradient-to-br from-neutral-900 to-neutral-800 text-white">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="text-center mb-12">
                <h2 class="text-3xl md:text-4xl font-bold" style="font-family: var(--font-heading);">Our Impact</h2>
            </div>
            <div class="grid grid-cols-2 md:grid-cols-4 gap-6">
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-purple-400 to-pink-400">500+</div>
                    <div class="text-sm text-neutral-300">Students</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-pink-400 to-orange-400">50+</div>
                    <div class="text-sm text-neutral-300">Teachers</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-orange-400 to-yellow-400">100+</div>
                    <div class="text-sm text-neutral-300">Achievements</div>
                </div>
                <div class="text-center">
                    <div class="text-4xl md:text-5xl font-bold mb-2 text-transparent bg-clip-text bg-gradient-to-r from-yellow-400 to-green-400">
                        {{ $schoolProfile->founded_year ? (date('Y') - $schoolProfile->founded_year) . '+' : '25+' }}
                    </div>
                    <div class="text-sm text-neutral-300">Years Experience</div>
                </div>
            </div>
        </div>
    </section>

    {{-- Principal --}}
    @if($schoolProfile->principal_name)
    <section class="py-20">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <span class="text-xs font-bold text-red-600 uppercase tracking-wider">Message from</span>
            <h2 class="text-3xl md:text-4xl font-bold text-neutral-900 mt-2 mb-8" style="font-family: var(--font-heading);">Our Principal</h2>
            <div class="bg-white rounded-2xl p-8 md:p-12 shadow-lg border border-neutral-200">
                <div class="w-24 h-24 rounded-full bg-gradient-to-br from-purple-500 to-pink-500 flex items-center justify-center text-white text-3xl font-bold mx-auto mb-4">
                    {{ strtoupper(substr($schoolProfile->principal_name, 0, 1)) }}
                </div>
                <h3 class="text-2xl font-bold text-neutral-900 mb-2" style="font-family: var(--font-heading);">{{ $schoolProfile->principal_name }}</h3>
                <p class="text-sm text-neutral-500 mb-6">Principal of {{ $schoolProfile->name }}</p>
                <div class="relative">
                    <svg class="absolute -top-4 -left-4 w-8 h-8 text-neutral-200" fill="currentColor" viewBox="0 0 24 24">
                        <path d="M14.017 21v-7.391c0-5.704 3.731-9.57 8.983-10.609l.995 2.151c-2.432.917-3.995 3.638-3.995 5.849h4v10h-9.983zm-14.017 0v-7.391c0-5.704 3.748-9.57 9-10.609l.996 2.151c-2.433.917-3.996 3.638-3.996 5.849h3.983v10h-9.983z"/>
                    </svg>
                    <p class="text-lg text-neutral-700 italic leading-relaxed pl-6">
                        "Welcome to {{ $schoolProfile->name }}. We are committed to providing quality education and fostering excellence in every student who walks through our doors."
                    </p>
                </div>
            </div>
        </div>
    </section>
    @endif

    {{-- Contact CTA --}}
    <section class="py-20 bg-gradient-to-br from-blue-600 to-purple-600 text-white">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8 text-center">
            <h2 class="text-3xl md:text-4xl font-bold mb-4" style="font-family: var(--font-heading);">Get in Touch</h2>
            <p class="text-lg text-blue-100 mb-8">Have questions? We'd love to hear from you.</p>
            <div class="flex flex-col sm:flex-row items-center justify-center gap-4">
                <a href="{{ route('frontend.contact') }}" class="px-8 py-4 bg-white text-blue-600 font-semibold rounded-xl hover:bg-neutral-100 transition-all shadow-xl">
                    Contact Us
                </a>
                @if($schoolProfile->email)
                    <a href="mailto:{{ $schoolProfile->email }}" class="px-8 py-4 bg-white/10 backdrop-blur-sm border border-white/20 text-white font-semibold rounded-xl hover:bg-white/20 transition-all">
                        {{ $schoolProfile->email }}
                    </a>
                @endif
            </div>
        </div>
    </section>
@endsection