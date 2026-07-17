<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full bg-neutral-50 dark:bg-neutral-900">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'School Portal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:500,600,700,800|jetbrains-mono:400,500" rel="stylesheet" />
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.13.3/dist/cdn.min.js"></script>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }

        /* Smooth transition untuk perubahan tema */
        body,
        div,
        nav,
        main,
        aside,
        header,
        footer,
        input,
        textarea,
        select,
        button,
        a,
        span,
        p,
        h1,
        h2,
        h3,
        h4,
        h5,
        h6 {
            transition-property: background-color, border-color, color, fill, stroke;
            transition-timing-function: cubic-bezier(0.4, 0, 0.2, 1);
            transition-duration: 150ms;
        }
    </style>
</head>
<!-- Tambahkan dark:bg-neutral-900 dan dark:text-neutral-100 di body -->

<body class="h-full bg-neutral-50 dark:bg-neutral-900 font-body text-neutral-900 dark:text-neutral-100 antialiased" style="font-family: var(--font-body);">
    <div class="min-h-full flex bg-neutral-50 dark:bg-neutral-900">
        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col lg:pl-72 bg-neutral-50 dark:bg-neutral-900">
            {{-- Header --}}
            @include('admin.layouts.header')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto bg-neutral-50 dark:bg-neutral-900">
                <div class="px-6 py-8 mx-auto max-w-7xl">
                    {{-- Flash Messages --}}
                    @if(session('success'))
                    <x-admin.alert type="success" :message="session('success')" class="mb-6" />
                    @endif
                    @if(session('error'))
                    <x-admin.alert type="error" :message="session('error')" class="mb-6" />
                    @endif
                    @if($errors->any())
                    <x-admin.alert type="error" class="mb-6">
                        <ul class="list-disc list-inside text-sm">
                            @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </x-admin.alert>
                    @endif

                    {{-- Content --}}
                    @yield('content')
                </div>
            </main>

            {{-- Footer --}}
            @include('admin.layouts.footer')
        </div>
    </div>

    {{-- Mobile Sidebar Overlay --}}
    <div x-data="{ open: false }" x-on:toggle-sidebar.window="open = !open">
        <div x-show="open" x-transition:enter="transition-opacity ease-linear duration-300"
            x-transition:enter-start="opacity-0" x-transition:enter-end="opacity-100"
            x-transition:leave="transition-opacity ease-linear duration-300"
            x-transition:leave-start="opacity-100" x-transition:leave-end="opacity-0"
            class="fixed inset-0 z-40 bg-neutral-900/50 dark:bg-black/70 backdrop-blur-sm lg:hidden"
            x-on:click="open = false">
        </div>
        <!-- Tambahkan dark mode class pada container sidebar mobile -->
        <div x-show="open"
            x-transition:enter="transition ease-in-out duration-300 transform"
            x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
            x-transition:leave="transition ease-in-out duration-300 transform"
            x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
            class="fixed inset-y-0 left-0 z-50 w-72 lg:hidden bg-white dark:bg-neutral-900 border-r border-neutral-200 dark:border-neutral-800">
            @include('admin.layouts.sidebar')
        </div>
    </div>

    @stack('scripts')

    <script type="module">
        import Echo from 'laravel-echo';
        import Pusher from 'pusher-js';

        window.Pusher = Pusher;

        window.Echo = new Echo({
            broadcaster: 'reverb',
            key: import.meta.env.VITE_REVERB_APP_KEY,
            wsHost: import.meta.env.VITE_REVERB_HOST,
            wsPort: import.meta.env.VITE_REVERB_PORT ?? 80,
            wssPort: import.meta.env.VITE_REVERB_PORT ?? 443,
            forceTLS: (import.meta.env.VITE_REVERB_SCHEME ?? 'https') === 'https',
            enabledTransports: ['ws', 'wss'],
        });

        window.Echo.channel('admin-dashboard')
            .listen('.new.comment', (e) => {
                console.log('Komentar baru dari:', e.comment.name);

                let badge = document.querySelector('.comments-badge');
                if (badge) {
                    let currentCount = parseInt(badge.innerText) || 0;
                    badge.innerText = currentCount + 1;
                    badge.classList.remove('hidden');
                }
            });
    </script>
</body>

</html>
