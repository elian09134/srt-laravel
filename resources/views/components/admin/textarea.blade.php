@props(['label', 'name', 'value' => '', 'rows' => 3, 'placeholder' => '', 'required' => false])

<div {{ $attributes->whereDoesntStartWith('class')->merge(['class' => $attributes->get('class', '')]) }}>
    <label for="{{ $name }}" class="block text-xs font-medium text-gray-700 mb-1">
        {{ $label }}
        @if($required)<span class="text-red-500">*</span>@endif
    </label>
    <textarea name="{{ $name }}"
              id="{{ $name }}"
              rows="{{ $rows }}"
              placeholder="{{ $placeholder }}"
              class="block w-full px-3 py-1.5 border border-gray-200 rounded-lg text-xs focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition-all bg-white">{{ old($name, $value) }}</textarea>
</div>
