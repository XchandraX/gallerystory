@props(['currentSort' => 'terbaru'])

<div x-data="{ open: false, selected: '{{ $currentSort }}' }" class="relative">
    <button @click="open = !open" class="inline-flex items-center space-x-2 bg-white border border-gray-300 rounded-md px-4 py-2 text-sm font-medium text-gray-700 hover:bg-gray-50 focus:outline-none">
        <span x-text="selected === 'terbaru' ? 'Terbaru' : 'Terlama'"></span>
        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
        </svg>
    </button>
    <div x-show="open" @click.away="open = false" class="absolute right-0 mt-2 w-40 bg-white rounded-md shadow-lg z-10">
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terbaru']) }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
           @click="selected = 'terbaru'">Terbaru</a>
        <a href="{{ request()->fullUrlWithQuery(['sort' => 'terlama']) }}" 
           class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100"
           @click="selected = 'terlama'">Terlama</a>
    </div>
</div>