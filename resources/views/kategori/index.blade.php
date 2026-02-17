@extends('layouts.app')

@section('title', $category->name)

@section('content')
    <div class="flex justify-between items-center mb-8">
        <h1 class="text-3xl font-bold text-gray-900">{{ $category->name }}</h1>
        <x-sort-dropdown currentSort="{{ $sort ?? 'terbaru' }}" />
    </div>

    <div id="photo-container" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach($photos as $photo)
            <x-photo-card :photo="$photo" />
        @endforeach
    </div>

    @if($photos->hasMorePages())
        <div class="text-center mt-12">
            <button id="load-more" 
                    data-url="{{ url()->current() }}" 
                    data-next-page="{{ $photos->currentPage() + 1 }}"
                    data-sort="{{ $sort ?? 'terbaru' }}"
                    class="bg-indigo-600 text-white px-8 py-3 rounded-full hover:bg-indigo-700 transition shadow-md hover:shadow-lg inline-flex items-center space-x-2">
                <span>Load More</span>
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                </svg>
            </button>
        </div>
    @endif

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const loadMoreBtn = document.getElementById('load-more');
                if (!loadMoreBtn) return;

                let nextPage = parseInt(loadMoreBtn.dataset.nextPage);
                const url = loadMoreBtn.dataset.url;
                const sort = loadMoreBtn.dataset.sort;

                loadMoreBtn.addEventListener('click', async function() {
                    loadMoreBtn.disabled = true;
                    loadMoreBtn.innerHTML = '<svg class="animate-spin h-5 w-5 mr-2" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4" fill="none"/><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8v8h8a8 8 0 11-16 0z"/></svg> Loading...';

                    try {
                        const response = await fetch(`${url}?page=${nextPage}&sort=${sort}`, {
                            headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' }
                        });
                        const data = await response.json();

                        const container = document.getElementById('photo-container');
                        data.photos.forEach(photo => {
                            const card = document.createElement('div');
                            card.innerHTML = `
                                <div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 cursor-pointer" onclick="openLightbox('${photo.image_url}')">
                                    <img src="${photo.image_url}" alt="${photo.title}" class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-500">
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
                                    <div class="absolute bottom-0 left-0 right-0 p-4 text-white translate-y-full group-hover:translate-y-0 transition-transform duration-300">
                                        <h3 class="text-lg font-semibold truncate">${photo.title}</h3>
                                    </div>
                                </div>
                            `;
                            container.appendChild(card.firstElementChild);
                        });

                        nextPage = data.next_page;
                        if (!data.has_more) {
                            loadMoreBtn.remove();
                        } else {
                            loadMoreBtn.disabled = false;
                            loadMoreBtn.innerHTML = '<span>Load More</span><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" /></svg>';
                        }
                    } catch (error) {
                        console.error('Failed to load more photos:', error);
                        loadMoreBtn.disabled = false;
                        loadMoreBtn.textContent = 'Error, try again';
                    }
                });
            });
        </script>
    @endpush
@endsection