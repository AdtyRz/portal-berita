@extends('admin.layouts.app')

@section('title', 'School Settings')

@section('content')
    <x-admin.page-header title="School Settings" description="Manage school profile, contact info, and social media" />

    @if(session('success'))
        <div class="mb-6 p-4 bg-emerald-50 border border-emerald-200 rounded-xl text-sm text-emerald-800">
            {{ session('success') }}
        </div>
    @endif

    <form method="POST" action="{{ route('admin.settings.update') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @method('PUT')

        {{-- Basic Information --}}
        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center gap-2" style="font-family: var(--font-heading);">
                    <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4" />
                    </svg>
                    Basic Information
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-admin.input label="School Name *" name="name" :value="old('name', $profile->name ?? 'School Portal')" required placeholder="e.g., SMA Negeri 1 Jakarta" />
                    <x-admin.input label="Short Name" name="short_name" :value="old('short_name', $profile->short_name ?? '')" placeholder="e.g., SMAN 1" />
                    <x-admin.input label="Tagline" name="tagline" :value="old('tagline', $profile->tagline ?? '')" placeholder="e.g., Excellence in Education" class="md:col-span-2" />
                    <x-admin.input label="Principal Name" name="principal_name" :value="old('principal_name', $profile->principal_name ?? '')" placeholder="e.g., Dr. John Doe, M.Pd" />
                    <x-admin.input label="Founded Year" name="founded_year" type="number" :value="old('founded_year', $profile->founded_year ?? '')" placeholder="e.g., 1985" />
                    <x-admin.input label="Accreditation" name="accreditation" :value="old('accreditation', $profile->accreditation ?? '')" placeholder="e.g., A" />
                </div>
                <x-admin.textarea label="Description" name="description" :value="old('description', $profile->description ?? '')" rows="3" placeholder="Short description about the school..." />
            </div>
        </x-admin.card>

        {{-- Vision & Mission --}}
        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center gap-2" style="font-family: var(--font-heading);">
                    <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z" />
                    </svg>
                    Vision & Mission
                </h3>
                @php
                    // Helper untuk konversi vision/mission ke string
                    $visionValue = old('vision');
                    if ($visionValue === null) {
                        $visionRaw = $profile->vision ?? '';
                        $visionValue = is_array($visionRaw) ? implode("\n", $visionRaw) : $visionRaw;
                    }
                    
                    $missionValue = old('mission');
                    if ($missionValue === null) {
                        $missionRaw = $profile->mission ?? '';
                        $missionValue = is_array($missionRaw) ? implode("\n", $missionRaw) : $missionRaw;
                    }
                @endphp
                <x-admin.textarea label="Vision" name="vision" :value="$visionValue" rows="3" placeholder="The vision of the school..." />
                <x-admin.textarea label="Mission" name="mission" :value="$missionValue" rows="6" placeholder="Write each mission point on a new line:&#10;1. Provide quality education&#10;2. Foster student character&#10;3. Develop skills for the future" help="Each line will be displayed as a separate point" />
            </div>
        </x-admin.card>

        {{-- Contact Information --}}
        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center gap-2" style="font-family: var(--font-heading);">
                    <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                    </svg>
                    Contact Information
                </h3>
                <x-admin.textarea label="Address" name="address" :value="old('address', $profile->address ?? '')" rows="2" placeholder="Full address..." />
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-admin.input label="Phone" name="phone" :value="old('phone', $profile->phone ?? '')" placeholder="+62 21 1234 5678" />
                    <x-admin.input label="Email" name="email" type="email" :value="old('email', $profile->email ?? '')" placeholder="info@school.sch.id" />
                    <x-admin.input label="Website" name="website" type="url" :value="old('website', $profile->website ?? '')" placeholder="https://school.sch.id" class="md:col-span-2" />
                </div>
            </div>
        </x-admin.card>

        {{-- Social Media --}}
        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center gap-2" style="font-family: var(--font-heading);">
                    <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1" />
                    </svg>
                    Social Media
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <x-admin.input label="Facebook" name="facebook" type="url" :value="old('facebook', $profile->facebook ?? '')" placeholder="https://facebook.com/school" />
                    <x-admin.input label="Instagram" name="instagram" type="url" :value="old('instagram', $profile->instagram ?? '')" placeholder="https://instagram.com/school" />
                    <x-admin.input label="Twitter/X" name="twitter" type="url" :value="old('twitter', $profile->twitter ?? '')" placeholder="https://twitter.com/school" />
                    <x-admin.input label="YouTube" name="youtube" type="url" :value="old('youtube', $profile->youtube ?? '')" placeholder="https://youtube.com/@school" />
                    <x-admin.input label="LinkedIn" name="linkedin" type="url" :value="old('linkedin', $profile->linkedin ?? '')" placeholder="https://linkedin.com/school" />
                    <x-admin.input label="TikTok" name="tiktok" type="url" :value="old('tiktok', $profile->tiktok ?? '')" placeholder="https://tiktok.com/@school" />
                </div>
            </div>
        </x-admin.card>

        {{-- Branding (Logo, Favicon, Cover) --}}
        <x-admin.card>
            <div class="p-6 space-y-6">
                <h3 class="text-lg font-semibold text-neutral-900 flex items-center gap-2" style="font-family: var(--font-heading);">
                    <svg class="w-5 h-5 text-neutral-600" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z" />
                    </svg>
                    Branding
                </h3>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    {{-- Logo --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Logo</label>
                        @if(!empty($profile->logo))
                            <div class="mb-3 p-3 bg-neutral-50 rounded-lg">
                                <img src="{{ asset('storage/' . $profile->logo) }}" alt="Logo" class="w-20 h-20 object-contain mx-auto">
                            </div>
                        @endif
                        <input type="file" name="logo" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500 mt-1">PNG/SVG, max 2MB</p>
                    </div>

                    {{-- Favicon --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Favicon</label>
                        @if(!empty($profile->favicon))
                            <div class="mb-3 p-3 bg-neutral-50 rounded-lg">
                                <img src="{{ asset('storage/' . $profile->favicon) }}" alt="Favicon" class="w-12 h-12 object-contain mx-auto">
                            </div>
                        @endif
                        <input type="file" name="favicon" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500 mt-1">ICO/PNG, max 1MB</p>
                    </div>

                    {{-- Cover --}}
                    <div>
                        <label class="block text-sm font-medium text-neutral-700 mb-2">Cover Image</label>
                        @if(!empty($profile->cover_image))
                            <div class="mb-3 p-3 bg-neutral-50 rounded-lg">
                                <img src="{{ asset('storage/' . $profile->cover_image) }}" alt="Cover" class="w-full h-20 object-cover rounded">
                            </div>
                        @endif
                        <input type="file" name="cover_image" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-3 file:py-1.5 file:px-3 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500 mt-1">1920x600px, max 5MB</p>
                    </div>
                </div>
            </div>
        </x-admin.card>

        <div class="flex items-center justify-end gap-3">
            <x-admin.button type="submit" variant="primary">
                <svg class="w-4 h-4" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7" />
                </svg>
                Save Changes
            </x-admin.button>
        </div>
    </form>
@endsection