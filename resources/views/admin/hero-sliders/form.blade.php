@extends('admin.layouts.app')

@section('title', isset($heroSlider) ? 'Edit Hero Slider' : 'Create Hero Slider')

@section('content')
    <x-admin.page-header 
        title="{{ isset($heroSlider) ? 'Edit' : 'Create' }} Hero Slider" 
        description="Manage homepage hero slider images" 
    />

    <form method="POST" action="{{ isset($heroSlider) ? route('admin.hero-sliders.update', $heroSlider) : route('admin.hero-sliders.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($heroSlider)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input 
                            label="Title" 
                            name="title" 
                            :value="old('title', $heroSlider->title ?? '')" 
                            required 
                            placeholder="e.g., Welcome to Our School"
                        />
                        
                        <x-admin.textarea 
                            label="Description" 
                            name="description" 
                            :value="old('description', $heroSlider->description ?? '')" 
                            rows="3" 
                            placeholder="Short description for hero section"
                        />

                        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                            <x-admin.input 
                                label="Link URL" 
                                name="link" 
                                type="url" 
                                :value="old('link', $heroSlider->link ?? '')" 
                                placeholder="https://example.com/page"
                                help="Optional: URL when slider is clicked"
                            />
                            
                            <x-admin.input 
                                label="Button Text" 
                                name="button_text" 
                                :value="old('button_text', $heroSlider->button_text ?? '')" 
                                placeholder="e.g., Learn More"
                                help="Text shown on CTA button"
                            />
                        </div>
                    </div>
                </x-admin.card>

                {{-- Live Preview --}}
                <x-admin.card>
                    <div class="p-6">
                        <h3 class="text-base font-semibold text-neutral-900 mb-4">Preview</h3>
                        <div class="relative aspect-[16/6] bg-gradient-to-br from-neutral-900 via-neutral-800 to-neutral-900 rounded-xl overflow-hidden">
                            <img id="preview-image" 
                                 src="{{ isset($heroSlider) && $heroSlider->image ? asset('storage/' . $heroSlider->image) : '' }}" 
                                 alt="Preview" 
                                 class="w-full h-full object-cover absolute inset-0 {{ !isset($heroSlider) || !$heroSlider->image ? 'hidden' : '' }}">
                            
                            <div class="absolute inset-0 bg-gradient-to-t from-black/80 via-black/40 to-transparent"></div>
                            
                            <div class="absolute bottom-0 left-0 right-0 p-6">
                                <span class="inline-block px-2.5 py-1 bg-white/10 backdrop-blur-sm border border-white/20 rounded-full text-[10px] font-semibold text-white uppercase tracking-wider mb-2">Featured</span>
                                <h3 id="preview-title" class="text-xl md:text-2xl font-bold text-white mb-2" style="font-family: var(--font-heading);">
                                    {{ old('title', $heroSlider->title ?? 'Slider Title Preview') }}
                                </h3>
                                <p id="preview-description" class="text-sm text-neutral-200 mb-3 line-clamp-2">
                                    {{ old('description', $heroSlider->description ?? 'Slider description will appear here...') }}
                                </p>
                                <span id="preview-button" class="inline-flex items-center gap-2 px-4 py-2 bg-white text-neutral-900 text-sm font-semibold rounded-lg {{ !old('button_text', $heroSlider->button_text ?? '') ? 'hidden' : '' }}">
                                    {{ old('button_text', $heroSlider->button_text ?? '') }}
                                </span>
                            </div>
                        </div>
                    </div>
                </x-admin.card>
            </div>

            {{-- Sidebar Settings --}}
            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Settings</h3>
                        
                        <div class="flex items-center gap-3">
                            <input type="hidden" name="status" value="0">
                            <input type="checkbox" 
                                   name="status" 
                                   value="1" 
                                   id="status" 
                                   @checked(old('status', $heroSlider->status ?? true)) 
                                   class="rounded border-neutral-300 text-neutral-900 focus:ring-neutral-900/20">
                            <label for="status" class="text-sm text-neutral-700">Active</label>
                        </div>
                        
                        <x-admin.input 
                            label="Order" 
                            name="order" 
                            type="number" 
                            :value="old('order', $heroSlider->order ?? 0)" 
                            help="Lower number = shown first"
                        />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Image</h3>
                        
                        @if(isset($heroSlider) && $heroSlider->image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $heroSlider->image) }}" 
                                     alt="Current image" 
                                     class="w-full h-40 object-cover rounded-lg">
                                <p class="text-xs text-neutral-500 mt-2">Current image</p>
                            </div>
                        @endif
                        
                        <input type="file" 
                               name="image" 
                               id="image-input"
                               accept="image/*" 
                               {{ !isset($heroSlider) ? 'required' : '' }} 
                               class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        
                        <p class="text-xs text-neutral-500">Recommended: 1920x800px. Max 5MB. JPG, PNG, WebP.</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.hero-sliders.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($heroSlider) ? 'Update' : 'Create' }} Slider</x-admin.button>
        </div>
    </form>

    @push('scripts')
    <script>
        // Live preview untuk image
        document.getElementById('image-input').addEventListener('change', function(e) {
            const file = e.target.files[0];
            if (file) {
                const reader = new FileReader();
                reader.onload = function(e) {
                    const preview = document.getElementById('preview-image');
                    preview.src = e.target.result;
                    preview.classList.remove('hidden');
                }
                reader.readAsDataURL(file);
            }
        });

        // Live preview untuk title
        document.querySelector('input[name="title"]').addEventListener('input', function(e) {
            document.getElementById('preview-title').textContent = e.target.value || 'Slider Title Preview';
        });

        // Live preview untuk description
        document.querySelector('textarea[name="description"]').addEventListener('input', function(e) {
            document.getElementById('preview-description').textContent = e.target.value || 'Slider description will appear here...';
        });

        // Live preview untuk button text
        document.querySelector('input[name="button_text"]').addEventListener('input', function(e) {
            const btn = document.getElementById('preview-button');
            if (e.target.value) {
                btn.textContent = e.target.value;
                btn.classList.remove('hidden');
            } else {
                btn.classList.add('hidden');
            }
        });
    </script>
    @endpush
@endsection