{{-- resources/views/components/categories-dropdown.blade.php --}}
@props(['mobile' => false])

@php
    $categories = App\Models\Category::all();
@endphp

@if($mobile)
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="w-full text-left px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50 focus:outline-none flex justify-between items-center">
            <span>Categories</span>
            <svg :class="{'rotate-180': open}" class="w-5 h-5 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition class="mt-1 bg-white rounded-md shadow-lg py-1">
            @foreach($categories as $category)
                <a href="{{ url('/kategori/' . $category->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
@else
    <div x-data="{ open: false }" class="relative">
        <button @click="open = !open" class="text-gray-600 hover:text-indigo-600 transition inline-flex items-center space-x-1">
            <span>Categories</span>
            <svg :class="{'rotate-180': open}" class="w-4 h-4 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
            </svg>
        </button>
        <div x-show="open" @click.away="open = false" x-transition class="absolute left-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50">
            @foreach($categories as $category)
                <a href="{{ url('/kategori/' . $category->slug) }}" class="block px-4 py-2 text-sm text-gray-700 hover:bg-indigo-50 hover:text-indigo-600">
                    {{ $category->name }}
                </a>
            @endforeach
        </div>
    </div>
@endif