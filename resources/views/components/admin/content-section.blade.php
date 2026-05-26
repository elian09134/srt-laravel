@props(['icon', 'iconBg', 'title', 'desc'])

<div {{ $attributes->merge(['class' => 'bg-white rounded-xl shadow-sm border border-gray-100']) }}>
    <div class="flex items-center gap-3 px-5 py-3.5 border-b border-gray-100">
        <div class="w-8 h-8 {{ $iconBg }} rounded-lg flex items-center justify-center flex-shrink-0">
            <i class="fas {{ $icon }} text-white text-sm"></i>
        </div>
        <div>
            <h2 class="text-sm font-semibold text-gray-900">{{ $title }}</h2>
            <p class="text-[11px] text-gray-500">{{ $desc }}</p>
        </div>
    </div>
    <div class="p-4 space-y-3">
        {{ $slot }}
    </div>
</div>
