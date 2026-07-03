<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" class="h-full">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Dashboard') — {{ config('app.name', 'School Portal') }}</title>

    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700|plus-jakarta-sans:500,600,700,800|jetbrains-mono:400,500" rel="stylesheet" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }
    </style>
</head>
<body class="h-full bg-neutral-50 font-body text-neutral-900 antialiased" style="font-family: var(--font-body);">
    <div class="min-h-full flex">
        {{-- Sidebar --}}
        @include('admin.layouts.sidebar')

        {{-- Main Content --}}
        <div class="flex-1 flex flex-col lg:pl-72">
            {{-- Header --}}
            @include('admin.layouts.header')

            {{-- Page Content --}}
            <main class="flex-1 overflow-y-auto">
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
             class="fixed inset-0 z-40 bg-neutral-900/50 backdrop-blur-sm lg:hidden"
             x-on:click="open = false">
        </div>
        <div x-show="open"
             x-transition:enter="transition ease-in-out duration-300 transform"
             x-transition:enter-start="-translate-x-full" x-transition:enter-end="translate-x-0"
             x-transition:leave="transition ease-in-out duration-300 transform"
             x-transition:leave-start="translate-x-0" x-transition:leave-end="-translate-x-full"
             class="fixed inset-y-0 left-0 z-50 w-72 lg:hidden">
            @include('admin.layouts.sidebar')
        </div>
    </div>

    @stack('scripts')
</body>
</html>
