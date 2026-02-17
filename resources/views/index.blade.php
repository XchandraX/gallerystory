@extends('layouts.app')

@section('title', 'GaleriStory - Public')

@section('content')
    <h1 class="text-3xl font-bold mb-8 text-gray-900">GaleriStory</h1>

    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
        @foreach ($categories as $category)
            @php
                $randomPhoto = $category->fotos()->where('is_private', 'public')->inRandomOrder()->first();
            @endphp
            @if ($randomPhoto)
                <x-photo-card :photo="$randomPhoto" />
            @endif
        @endforeach
    </div>
@endsection