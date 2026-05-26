@props(['label', 'name', 'value' => '', 'type' => 'text', 'placeholder' => '', 'required' => false, 'icon' => ''])

<div {{ $attributes->whereDoesntStartWith('class')->merge(['class' => $attributes->get('class', '')]) }}>
    <label for="{{ $name }}" class="block text-xs font-medium text-gray-700 mb-1">
        @if($icon)<i class="{{ $icon }} mr-1"></i>@endif
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <input type="{{ $type }}"
           name="{{ $name }}"
           id="{{ $name }}"
           value="{{ old($name, $value) }}"
           placeholder="{{ $placeholder }}"
           class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white">
</div>
