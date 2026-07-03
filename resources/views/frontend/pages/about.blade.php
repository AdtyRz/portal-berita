@extends('frontend.layouts.app')

@section('title', 'About Us')

@section('content')
    <section class="py-16">
        <div class="mx-auto max-w-4xl px-4 sm:px-6 lg:px-8">
            <h1 class="text-4xl font-bold text-neutral-900 mb-6" style="font-family: var(--font-heading);">About Our School</h1>

            <div class="prose prose-lg max-w-none">
                <p class="text-lg text-neutral-600 leading-relaxed">
                    Welcome to School Portal, where we are committed to providing excellence in education and fostering the growth of every student. Our school has a long history of academic achievement and character development.
                </p>

                <h2 class="text-2xl font-bold text-neutral-900 mt-8 mb-4">Our Vision</h2>
                <p class="text-neutral-600">
                    To be a leading educational institution that inspires innovation, cultivates critical thinking, and nurtures compassionate global citizens.
                </p>

                <h2 class="text-2xl font-bold text-neutral-900 mt-8 mb-4">Our Mission</h2>
                <p class="text-neutral-600">
                    We are dedicated to providing a supportive and challenging learning environment where students can discover their passions, develop their talents, and prepare for future success.
                </p>
            </div>

            @if($organizations->count() > 0)
                <div class="mt-16">
                    <h2 class="text-3xl font-bold text-neutral-900 mb-8" style="font-family: var(--font-heading);">Our Organization</h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                        @foreach($organizations as $org)
                            <div class="bg-white border border-neutral-200 rounded-2xl p-6 text-center">
                                <div class="w-20 h-20 rounded-full bg-neutral-100 mx-auto mb-4 overflow-hidden">
                                    <img src="{{ $org->photo_url }}" alt="{{ $org->name }}" class="w-full h-full object-cover">
                                </div>
                                <h3 class="text-lg font-semibold text-neutral-900">{{ $org->name }}</h3>
                                @if($org->position)
                                    <p class="text-sm text-neutral-500 mt-1">{{ $org->position }}</p>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </section>
@endsection
