<footer class="border-t bg-white/80 dark:bg-neutral-900/80 border-b border-neutral-200 dark:border-neutral-800 transition-colors duration-300">
    <div class="px-6 py-4 mx-auto max-w-7xl flex flex-col sm:flex-row items-center justify-between gap-2">
        <div class="text-sm text-neutral-500">
            © {{ date('Y') }} {{ config('app.name', 'School Portal') }}. All rights reserved.
        </div>
        <div class="flex items-center gap-4 text-sm text-neutral-500">
            <span>v1.0.0</span>
            <span class="w-1 h-1 rounded-full bg-neutral-300"></span>
            <span>Laravel {{ app()->version() }}</span>
        </div>
    </div>
</footer>
