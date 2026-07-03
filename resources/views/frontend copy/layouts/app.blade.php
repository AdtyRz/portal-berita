<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="scroll-smooth">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    {{-- SEO Meta Tags --}}
    <title>@yield('title', 'Home') — {{ config('app.name', 'School Portal') }}</title>
    <meta name="description" content="@yield('metaDescription', 'School Portal - Excellence in Education, News, Announcements, and Events.')">
    <meta name="keywords" content="@yield('metaKeywords', 'school, news, education, announcements, events')">
    <meta name="author" content="School Portal">
    <meta name="robots" content="index, follow">
    <link rel="canonical" href="{{ url()->current() }}">

    {{-- Open Graph / Facebook --}}
    <meta property="og:type" content="website">
    <meta property="og:url" content="{{ url()->current() }}">
    <meta property="og:title" content="@yield('title', 'Home') — {{ config('app.name', 'School Portal') }}">
    <meta property="og:description" content="@yield('metaDescription', 'School Portal - Excellence in Education.')">
    <meta property="og:image" content="@yield('ogImage', asset('images/og-default.jpg'))">

    {{-- Twitter --}}
    <meta property="twitter:card" content="summary_large_image">
    <meta property="twitter:url" content="{{ url()->current() }}">
    <meta property="twitter:title" content="@yield('title', 'Home') — {{ config('app.name', 'School Portal') }}">
    <meta property="twitter:description" content="@yield('metaDescription', 'School Portal - Excellence in Education.')">
    <meta property="twitter:image" content="@yield('ogImage', asset('images/og-default.jpg'))">

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:500,600,700,800"
        rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
        }

        body {
            font-family: var(--font-body);
        }

        .fade-up {
            opacity: 0;
            transform: translateY(20px);
            animation: fadeUp 0.6s ease forwards;
        }

        @keyframes fadeUp {
            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #fafafa;
        }

        ::-webkit-scrollbar-thumb {
            background: #d4d4d4;
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: #a3a3a3;
        }
    </style>
</head>

<body class="bg-white text-neutral-900 antialiased">
    @include('frontend.layouts.header')

    <main class="min-h-screen">
        @yield('content')
    </main>

    @include('frontend.layouts.footer')

    {{-- Back to Top --}}
    <button onclick="window.scrollTo({top: 0, behavior: 'smooth'})"
        class="fixed bottom-6 right-6 w-11 h-11 bg-neutral-900 text-white rounded-full shadow-lg hover:bg-neutral-800 transition-all opacity-0 translate-y-4 z-40"
        id="backToTop">
        <svg class="w-5 h-5 mx-auto" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
            <path stroke-linecap="round" stroke-linejoin="round" d="M5 15l7-7 7 7" />
        </svg>
    </button>

    <script>
        window.addEventListener('scroll', function() {
            const btn = document.getElementById('backToTop');
            if (window.scrollY > 400) {
                btn.style.opacity = '1';
                btn.style.transform = 'translateY(0)';
            } else {
                btn.style.opacity = '0';
                btn.style.transform = 'translateY(1rem)';
            }
        });
        // Auto Lazy Load Images
        document.addEventListener("DOMContentLoaded", function() {
            var images = document.querySelectorAll("img:not([loading])");
            for (var i = 0; i < images.length; i++) {
                images[i].loading = "lazy";
                images[i].decoding = "async";
            }
        });
    </script>

    @stack('scripts')
</body>

</html>
