@extends('admin.layouts.app')

@section('content')
@section('title', 'Settings')

    <x-admin.page-header title="Settings" description="Configure website settings" />

    <form method="POST" action="{{ route('admin.settings.update') }}" class="space-y-6">
        @csrf @method('PUT')

        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-base font-semibold text-neutral-900">General Settings</h3>
                <x-admin.input label="Site Name" name="site_name" :value="old('site_name', $general['site_name'] ?? 'School Portal')" required />
                <x-admin.textarea label="Site Description" name="site_description" :value="old('site_description', $general['site_description'] ?? '')" rows="3" />
                <x-admin.input label="Site Email" name="site_email" type="email" :value="old('site_email', $general['site_email'] ?? '')" />
                <x-admin.input label="Site Phone" name="site_phone" :value="old('site_phone', $general['site_phone'] ?? '')" />
                <x-admin.textarea label="Site Address" name="site_address" :value="old('site_address', $general['site_address'] ?? '')" rows="2" />
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $seo['meta_title'] ?? '')" />
                <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $seo['meta_description'] ?? '')" rows="3" />
                <x-admin.input label="Meta Keywords" name="meta_keywords" :value="old('meta_keywords', $seo['meta_keywords'] ?? '')" help="Comma separated" />
            </div>
        </x-admin.card>

        <x-admin.card>
            <div class="p-6 space-y-4">
                <div class="flex items-center justify-between">
                    <h3 class="text-base font-semibold text-neutral-900">Social Media</h3>
                    <button type="button" onclick="addSocial()" class="text-sm text-blue-600 hover:text-blue-700 font-medium">+ Add Social</button>
                </div>
                <div id="socials_container" class="space-y-3">
                    @forelse($socials as $index => $social)
                        <div class="flex gap-3 items-end social-item">
                            <x-admin.input label="Platform" name="socials[{{ $index }}][platform]" :value="$social->platform" class="flex-1" />
                            <x-admin.input label="URL" name="socials[{{ $index }}][url]" type="url" :value="$social->url" class="flex-[2]" />
                            <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                            </button>
                        </div>
                    @empty
                        <p class="text-sm text-neutral-500">No social media added yet.</p>
                    @endforelse
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center justify-end gap-3">
            <x-admin.button type="submit">Save Settings</x-admin.button>
        </div>
    </form>

    @push('scripts')
    <script>
        let socialIndex = {{ $socials->count() }};
        function addSocial() {
            const container = document.getElementById('socials_container');
            const div = document.createElement('div');
            div.className = 'flex gap-3 items-end social-item';
            div.innerHTML = `
                <div class="flex-1">
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">Platform</label>
                    <input type="text" name="socials[${socialIndex}][platform]" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm">
                </div>
                <div class="flex-[2]">
                    <label class="block text-sm font-medium text-neutral-700 mb-1.5">URL</label>
                    <input type="url" name="socials[${socialIndex}][url]" class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm">
                </div>
                <button type="button" onclick="this.parentElement.remove()" class="p-2 text-red-600 hover:bg-red-50 rounded-lg">
                    <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M6 18L18 6M6 6l12 12" /></svg>
                </button>
            `;
            container.appendChild(div);
            socialIndex++;
        }
    </script>
    @endpush
@endsection