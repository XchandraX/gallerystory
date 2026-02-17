@props(['photo'])

<div class="group relative overflow-hidden rounded-lg shadow-md hover:shadow-xl transition-shadow duration-300 cursor-pointer" onclick="openLightbox('{{ asset('storage/' . $photo->image) }}')">
    <img src="{{ asset('storage/' . $photo->image) }}" alt="{{ $photo->title }}" class="w-full h-64 object-cover transform group-hover:scale-105 transition-transform duration-500 border border-purple-500">
    <div class="absolute inset-0 bg-gradient-to-t from-black/60 via-transparent to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-300"></div>
    <div class="absolute bottom-0 left-0 right-0 p-4 text-white translate-y-full group-hover:translate-y-0 transition-transform duration-300">
        <h3 class="text-lg font-semibold truncate">{{ $photo->title }}</h3>
    </div>
</div>