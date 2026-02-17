<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'GaleriStory')</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <script src="{{ asset('js/lightbox.js') }}" defer></script>
    @stack('styles')
</head>

<body class="bg-gray-50 text-gray-800 antialiased flex flex-col min-h-screen">

    {{-- Navigation --}}
    <nav class="bg-white shadow-sm sticky top-0 z-40" x-data="{ mobileMenuOpen: false }">
        <nav class="bg-white shadow-sm sticky top-0 z-40" x-data="{ mobileMenuOpen: false }">
            <div class="container mx-auto px-4 sm:px-6 lg:px-8">
                <div class="flex justify-between items-center h-16">
                    {{-- Logo --}}
                    <a href="{{ url('/') }}"
                        class="text-2xl font-bold text-indigo-600 tracking-tight">GaleriStory</a>

                    {{-- Desktop Menu --}}
                    <div class="hidden md:flex items-center space-x-8">
                        <x-categories-dropdown />
                        <a href="{{ url('/kategori/create') }}"
                            class="text-gray-600 hover:text-indigo-600 transition">Tambah Kategori</a>
                        <a href="{{ route('private.form') }}"
                            class="text-gray-600 hover:text-indigo-600 transition">Private</a>
                        <a href="{{ url('/upload') }}" class="text-gray-600 hover:text-indigo-600 transition">Upload</a>
                    </div>

                    {{-- Mobile menu button --}}
                    <button @click="mobileMenuOpen = !mobileMenuOpen"
                        class="md:hidden p-2 rounded-md text-gray-400 hover:text-gray-500 hover:bg-gray-100 focus:outline-none">
                        <svg class="h-6 w-6" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M4 6h16M4 12h16M4 18h16" />
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div x-show="mobileMenuOpen" @click.away="mobileMenuOpen = false" x-transition
                class="md:hidden bg-white border-t">
                <div class="px-2 pt-2 pb-3 space-y-1">
                    <x-categories-dropdown mobile />
                    <a href="{{ url('/kategori/create') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Tambah
                        Kategori</a>
                    <a href="{{ route('private.form') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Private</a>
                    <a href="{{ url('/upload') }}"
                        class="block px-3 py-2 rounded-md text-base font-medium text-gray-700 hover:text-indigo-600 hover:bg-gray-50">Upload</a>
                </div>
            </div>
        </nav>
    </nav>

    {{-- Main Content (akan mengisi ruang kosong) --}}
    <main class="flex-grow container mx-auto px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    {{-- Footer --}}
    <footer class="bg-white border-t py-6 text-center text-sm text-gray-500">
        &copy; {{ date('Y') }} GaleriStory. All rights reserved.
    </footer>

    {{-- Lightbox component --}}
    <x-lightbox />

    @stack('scripts')
</body>

</html>
