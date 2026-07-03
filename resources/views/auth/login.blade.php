<x-guest-layout>
    <div class="min-h-screen flex items-center justify-center relative overflow-hidden" style="font-family: var(--font-body);">
        {{-- Background Gradient --}}
        <div class="absolute inset-0 bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900"></div>
        
        {{-- Animated Background Pattern --}}
        <div class="absolute inset-0 opacity-20">
            <div class="absolute top-0 -left-4 w-72 h-72 bg-purple-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse"></div>
            <div class="absolute top-0 -right-4 w-72 h-72 bg-cyan-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 2s;"></div>
            <div class="absolute -bottom-8 left-20 w-72 h-72 bg-pink-500 rounded-full mix-blend-multiply filter blur-xl animate-pulse" style="animation-delay: 4s;"></div>
        </div>

        {{-- Login Card --}}
        <div class="relative w-full max-w-md mx-4">
            <div class="backdrop-blur-xl bg-white/10 border border-white/20 rounded-3xl shadow-2xl p-8">
                {{-- Logo --}}
                <div class="text-center mb-8">
                    <div class="inline-flex items-center justify-center w-16 h-16 rounded-2xl bg-gradient-to-br from-white to-neutral-200 mb-4 shadow-lg">
                        <svg class="w-8 h-8 text-neutral-900" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                        </svg>
                    </div>
                    <h2 class="text-3xl font-bold text-white mb-2" style="font-family: var(--font-heading);">Welcome Back</h2>
                    <p class="text-neutral-300 text-sm">Sign in to your administration panel</p>
                </div>

                {{-- Session Status --}}
                @if (session('status'))
                    <div class="mb-4 p-4 rounded-xl bg-emerald-500/20 border border-emerald-500/30 text-emerald-100 text-sm">
                        {{ session('status') }}
                    </div>
                @endif

                {{-- Login Form --}}
                <form method="POST" action="{{ route('login') }}" class="space-y-5">
                    @csrf

                    {{-- Email --}}
                    <div>
                        <label for="email" class="block text-sm font-medium text-neutral-200 mb-2">
                            Email Address
                        </label>
                        <div class="relative">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                </svg>
                            </div>
                            <input id="email" type="email" name="email" value="{{ old('email') }}" required autofocus 
                                   class="w-full pl-10 pr-4 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all"
                                   placeholder="admin@school.com">
                        </div>
                        @error('email')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Password --}}
                    <div>
                        <label for="password" class="block text-sm font-medium text-neutral-200 mb-2">
                            Password
                        </label>
                        <div class="relative" x-data="{ show: false }">
                            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                                <svg class="w-5 h-5 text-neutral-400" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z" />
                                </svg>
                            </div>
                            <input id="password" type="password" name="password" required 
                                   :type="show ? 'text' : 'password'"
                                   class="w-full pl-10 pr-12 py-3 bg-white/10 border border-white/20 rounded-xl text-white placeholder:text-neutral-400 focus:outline-none focus:ring-2 focus:ring-white/30 focus:border-transparent transition-all"
                                   placeholder="••••••••">
                            <button type="button" @click="show = !show" class="absolute inset-y-0 right-0 pr-3 flex items-center text-neutral-400 hover:text-white transition-colors">
                                <svg x-show="!show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z" />
                                </svg>
                                <svg x-show="show" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21" />
                                </svg>
                            </button>
                        </div>
                        @error('password')
                            <p class="mt-2 text-sm text-red-300">{{ $message }}</p>
                        @enderror
                    </div>

                    {{-- Remember Me & Forgot Password --}}
                    <div class="flex items-center justify-between">
                        <label for="remember_me" class="inline-flex items-center">
                            <input id="remember_me" type="checkbox" name="remember" 
                                   class="rounded border-neutral-600 bg-white/10 text-white focus:ring-white/30 focus:ring-offset-0">
                            <span class="ml-2 text-sm text-neutral-300">Remember me</span>
                        </label>

                        @if (Route::has('password.request'))
                            <a href="{{ route('password.request') }}" class="text-sm font-medium text-white hover:text-neutral-200 transition-colors">
                                Forgot password?
                            </a>
                        @endif
                    </div>

                    {{-- Submit Button --}}
                    <button type="submit" 
                            class="w-full py-3 px-4 bg-white text-neutral-900 font-semibold rounded-xl hover:bg-neutral-100 focus:outline-none focus:ring-2 focus:ring-white/50 focus:ring-offset-2 focus:ring-offset-neutral-900 transition-all duration-200 shadow-lg hover:shadow-xl transform hover:-translate-y-0.5">
                        Sign In
                    </button>
                </form>

                {{-- Footer --}}
                <div class="mt-8 pt-6 border-t border-white/10 text-center">
                    <p class="text-sm text-neutral-400">
                        School Portal Administration
                    </p>
                    <p class="text-xs text-neutral-500 mt-1">
                        © {{ date('Y') }} All rights reserved
                    </p>
                </div>
            </div>
        </div>
    </div>

    <style>
        :root {
            --font-heading: 'Plus Jakarta Sans', sans-serif;
            --font-body: 'Inter', sans-serif;
        }
    </style>
</x-guest-layout>