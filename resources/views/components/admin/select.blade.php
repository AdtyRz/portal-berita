@props(['label' => null, 'name', 'required' => false, 'help' => null, 'options' => []])

<div class="space-y-1.5">
    @if($label)
        <label for="{{ $name }}" class="block text-sm font-medium text-neutral-700">
            {{ $label }}
            @if($required) <span class="text-red-500">*</span> @endif
        </label>
    @endif
    <select id="{{ $name }}"
            name="{{ $name }}"
            {{ $attributes->merge([
                'class' => 'block w-full px-3.5 py-2 bg-white border border-neutral-200 rounded-lg text-sm text-neutral-900 focus:outline-none focus:ring-2 focus:ring-neutral-900/10 focus:border-neutral-400 transition-all' . ($errors->has($name) ? ' border-red-300 focus:ring-red-500/20 focus:border-red-400' : '')
            ]) }}
            @if($required) required @endif>
        @foreach($options as $value => $label)
            <option value="{{ $value }}" @selected(old($name, $attributes->get('value')) == $value)>{{ $label }}</option>
        @endforeach
    </select>
    @if($help)
        <p class="text-xs text-neutral-500">{{ $help }}</p>
    @endif
    @error($name)
        <p class="text-xs text-red-600">{{ $message }}</p>
    @enderror
</div>
