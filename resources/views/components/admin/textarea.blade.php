@props([
    'label' => null,
    'name' => '',
    'value' => '',
    'placeholder' => null,
    'rows' => 4,
    'required' => false,
    'help' => null,
    'id' => null,
])

@php
    $inputId = $id ?? $name;
    $currentValue = old($name, $value);
@endphp

<div>
    @if($label)
        <label for="{{ $inputId }}" class="block text-sm font-medium text-neutral-700 mb-1.5">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    
    <textarea 
        name="{{ $name }}" 
        id="{{ $inputId }}" 
        rows="{{ $rows }}"
        placeholder="{{ $placeholder }}"
        @if($required) required @endif
        class="block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 @error($name) border-red-300 focus:border-red-500 @enderror"
    >{{ $currentValue }}</textarea>
    
    @if($help)
        <p class="mt-1 text-xs text-neutral-500">{{ $help }}</p>
    @endif
    
    @error($name)
        <p class="mt-1 text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>