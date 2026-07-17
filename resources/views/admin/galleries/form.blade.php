@extends('admin.layouts.app')

@section('title', isset($gallery) ? 'Edit Gallery' : 'Create Gallery')

@section('content')
    <x-admin.page-header 
        title="{{ isset($gallery) ? 'Edit' : 'Create' }} Gallery" 
        description="Create photo gallery with multiple images" 
    />

    <form method="POST" action="{{ isset($gallery) ? route('admin.galleries.update', $gallery) : route('admin.galleries.store') }}" enctype="multipart/form-data" class="space-y-6">
        @csrf
        @if(isset($gallery)) @method('PUT') @endif

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
            <div class="lg:col-span-2 space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <x-admin.input label="Title" name="title" :value="old('title', $gallery->title ?? '')" required />
                        <x-admin.input label="Slug" name="slug" :value="old('slug', $gallery->slug ?? '')" />
                        <x-admin.textarea label="Description" name="description" :value="old('description', $gallery->description ?? '')" rows="3" />
                    </div>
                </x-admin.card>

               <x-admin.card>
    <div class="p-6 space-y-4">
        <div class="flex items-center justify-between mb-2">
            <h3 class="text-base font-semibold text-neutral-900">Gallery Images</h3>
            <span class="text-xs text-neutral-500">Add multiple images</span>
        </div>

        {{-- Display Mode Selector --}}
        <div class="bg-gradient-to-r from-neutral-50 to-neutral-100 rounded-xl p-4 border border-neutral-200">
            <label class="block text-sm font-medium text-neutral-700 mb-3">Display Mode</label>
            <div class="grid grid-cols-2 gap-3">
                <label class="relative cursor-pointer">
                    <input type="radio" name="display_mode" value="grid" 
                           class="peer sr-only" 
                           {{ old('display_mode', $gallery->display_mode ?? 'grid') === 'grid' ? 'checked' : '' }}>
                    <div class="p-4 bg-white border-2 border-neutral-200 rounded-xl peer-checked:border-neutral-900 peer-checked:bg-neutral-50 transition-all hover:border-neutral-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-neutral-900 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M4 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM14 5a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1V5zM4 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1H5a1 1 0 01-1-1v-4zM14 15a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-neutral-900">Grid Mode</div>
                                <div class="text-xs text-neutral-500">Clean grid, no captions</div>
                            </div>
                        </div>
                    </div>
                </label>

                <label class="relative cursor-pointer">
                    <input type="radio" name="display_mode" value="detailed" 
                           class="peer sr-only" 
                           {{ old('display_mode', $gallery->display_mode ?? 'grid') === 'detailed' ? 'checked' : '' }}>
                    <div class="p-4 bg-white border-2 border-neutral-200 rounded-xl peer-checked:border-neutral-900 peer-checked:bg-neutral-50 transition-all hover:border-neutral-300">
                        <div class="flex items-center gap-3 mb-2">
                            <div class="w-10 h-10 rounded-lg bg-neutral-900 flex items-center justify-center">
                                <svg class="w-5 h-5 text-white" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                                </svg>
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-neutral-900">Detailed Mode</div>
                                <div class="text-xs text-neutral-500">With title & caption</div>
                            </div>
                        </div>
                    </div>
                </label>
            </div>
        </div>

        {{-- Existing Images --}}
        @if(isset($gallery) && $gallery->items->count() > 0)
            <div class="grid grid-cols-2 md:grid-cols-3 gap-3">
                @foreach($gallery->items as $item)
                    <div class="relative group aspect-square rounded-lg overflow-hidden bg-neutral-100">
                        <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->title }}" class="w-full h-full object-cover">
                        <div class="absolute inset-0 bg-black/0 group-hover:bg-black/50 transition-colors flex items-center justify-center">
                            <label class="opacity-0 group-hover:opacity-100 transition-opacity">
                                <input type="checkbox" name="delete_items[]" value="{{ $item->id }}" class="sr-only peer">
                                <span class="px-3 py-1.5 bg-red-600 text-white text-xs font-medium rounded-lg cursor-pointer hover:bg-red-700">Delete</span>
                            </label>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif

        {{-- Upload Section --}}
        <div id="uploadSection">
            <label class="block text-sm font-medium text-neutral-700 mb-1.5">Add New Images</label>
            <input type="file" name="images[]" id="imagesInput" accept="image/*" multiple 
                   class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
            <p class="text-xs text-neutral-500 mt-1">Select multiple images at once.</p>
        </div>

        {{-- Caption Input (only shown in detailed mode) --}}
        <div id="captionsSection" class="hidden space-y-3">
            <label class="block text-sm font-medium text-neutral-700">Captions (optional)</label>
            <div id="captionsList" class="space-y-2 max-h-60 overflow-y-auto"></div>
            <p class="text-xs text-neutral-500">Add title/caption for each photo (leave blank if not needed).</p>
        </div>
    </div>
</x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-6">
                        <h3 class="text-base font-semibold text-neutral-900">SEO Settings</h3>
                        <x-admin.input label="Meta Title" name="meta_title" :value="old('meta_title', $gallery->meta_title ?? '')" />
                        <x-admin.textarea label="Meta Description" name="meta_description" :value="old('meta_description', $gallery->meta_description ?? '')" rows="2" />
                    </div>
                </x-admin.card>
            </div>

            <div class="space-y-6">
                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Publish</h3>
                        <x-admin.select label="Status" name="status" :options="['draft' => 'Draft', 'published' => 'Published', 'archived' => 'Archived']" :value="old('status', $gallery->status ?? 'draft')" required />
                    </div>
                </x-admin.card>

                <x-admin.card>
                    <div class="p-6 space-y-4">
                        <h3 class="text-base font-semibold text-neutral-900">Cover Image</h3>
                        @if(isset($gallery) && $gallery->cover_image)
                            <div class="mb-3">
                                <img src="{{ asset('storage/' . $gallery->cover_image) }}" alt="" class="w-full h-32 object-cover rounded-lg">
                            </div>
                        @endif
                        <input type="file" name="cover_image" accept="image/*" class="block w-full text-sm text-neutral-500 file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-medium file:bg-neutral-100 file:text-neutral-700 hover:file:bg-neutral-200">
                        <p class="text-xs text-neutral-500">Optional. If not set, first image will be used.</p>
                    </div>
                </x-admin.card>
            </div>
        </div>

        <div class="flex items-center justify-end gap-3">
            <a href="{{ route('admin.galleries.index') }}" class="px-4 py-2 text-sm font-medium text-neutral-700 bg-white border border-neutral-200 rounded-lg hover:bg-neutral-50">Cancel</a>
            <x-admin.button type="submit">{{ isset($gallery) ? 'Update' : 'Create' }} Gallery</x-admin.button>
        </div>
    </form>
@endsection

@push('scripts')
<script>
    const displayModeRadios = document.querySelectorAll('input[name="display_mode"]');
    const captionsSection = document.getElementById('captionsSection');
    const imagesInput = document.getElementById('imagesInput');
    const captionsList = document.getElementById('captionsList');

    // Track file list yang bisa di-modify
    let currentFiles = [];

    function updateMode() {
        const mode = document.querySelector('input[name="display_mode"]:checked').value;
        if (mode === 'detailed') {
            captionsSection.classList.remove('hidden');
        } else {
            captionsSection.classList.add('hidden');
        }
    }

    displayModeRadios.forEach(radio => {
        radio.addEventListener('change', updateMode);
    });

    // Render ulang daftar caption berdasarkan currentFiles
    function renderCaptions() {
        captionsList.innerHTML = '';
        
        if (document.querySelector('input[name="display_mode"]:checked').value !== 'detailed') {
            return;
        }

        currentFiles.forEach((fileData, index) => {
            const div = document.createElement('div');
            div.className = 'flex items-center gap-3 p-3 bg-neutral-50 rounded-lg border border-neutral-200 group';
            div.dataset.index = index;
            div.innerHTML = `
                <img src="${fileData.previewUrl}" class="w-12 h-12 rounded-lg object-cover shrink-0">
                <div class="flex-1 grid grid-cols-2 gap-2">
                    <input type="text" name="captions[${index}][title]" placeholder="Title" 
                           value="${fileData.title || ''}"
                           class="caption-title px-3 py-1.5 text-sm border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900/10">
                    <input type="text" name="captions[${index}][caption]" placeholder="Caption" 
                           value="${fileData.caption || ''}"
                           class="caption-caption px-3 py-1.5 text-sm border border-neutral-200 rounded-lg focus:outline-none focus:ring-2 focus:ring-neutral-900/10">
                </div>
                <button type="button" class="delete-file-btn p-2 text-red-500 hover:text-red-700 hover:bg-red-50 rounded-lg transition-colors shrink-0" title="Hapus foto ini">
                    <svg class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16" />
                    </svg>
                </button>
            `;
            captionsList.appendChild(div);

            // Event listener untuk simpan perubahan caption
            const titleInput = div.querySelector('.caption-title');
            const captionInput = div.querySelector('.caption-caption');
            
            titleInput.addEventListener('input', (e) => {
                currentFiles[index].title = e.target.value;
            });
            
            captionInput.addEventListener('input', (e) => {
                currentFiles[index].caption = e.target.value;
            });

            // Event listener untuk tombol delete
            div.querySelector('.delete-file-btn').addEventListener('click', () => {
                if (confirm(`Hapus foto "${fileData.file.name}" dari upload queue?`)) {
                    // Revoke object URL untuk free memory
                    URL.revokeObjectURL(fileData.previewUrl);
                    
                    // Hapus dari array
                    currentFiles.splice(index, 1);
                    
                    // Update FileList di input file
                    updateFileInput();
                    
                    // Render ulang
                    renderCaptions();
                }
            });
        });
    }

    // Update FileList di input file berdasarkan currentFiles
    function updateFileInput() {
        const dataTransfer = new DataTransfer();
        currentFiles.forEach(fileData => {
            dataTransfer.items.add(fileData.file);
        });
        imagesInput.files = dataTransfer.files;
    }

    imagesInput.addEventListener('change', function(e) {
        const newFiles = Array.from(e.target.files);
        
        // Tambahkan file baru ke currentFiles (tanpa hapus yang lama)
        newFiles.forEach(file => {
            currentFiles.push({
                file: file,
                previewUrl: URL.createObjectURL(file),
                title: '',
                caption: ''
            });
        });
        
        // Update input file dengan seluruh currentFiles
        updateFileInput();
        
        // Render captions
        renderCaptions();
    });

    // Reset input saat mode berubah ke grid
    displayModeRadios.forEach(radio => {
        radio.addEventListener('change', () => {
            updateMode();
            renderCaptions();
        });
    });

    updateMode();
</script>
@endpush