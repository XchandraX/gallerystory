@extends('layouts.app')

@section('title', 'Upload Photo')

@section('content')
    <div class="max-w-2xl mx-auto">
        <h1 class="text-3xl font-bold mb-8 text-gray-900">Upload New Photos</h1>

        @if (session('success'))
            <div class="bg-green-50 border-l-4 border-green-400 text-green-700 p-4 mb-6 rounded" role="alert">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded" role="alert">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ url('/upload') }}" method="POST" enctype="multipart/form-data" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf

            <div>
                <label for="title" class="block text-sm font-medium text-gray-700 mb-1">Photo Title</label>
                <input type="text" name="title" id="title" required value="{{ old('title') }}"
                       class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>

            <div>
                <label for="category_id" class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                <select name="category_id" id="category_id" required
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    @foreach ($categories as $category)
                        <option value="{{ $category->id }}" {{ old('category_id') == $category->id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div>
                <label for="is_private" class="block text-sm font-medium text-gray-700 mb-1">Visibility</label>
                <select name="is_private" id="is_private" required
                        class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
                    <option value="public" {{ old('is_private') == 'public' ? 'selected' : '' }}>Public</option>
                    <option value="private" {{ old('is_private') == 'private' ? 'selected' : '' }}>Private</option>
                </select>
            </div>

            <div>
                <label for="images" class="block text-sm font-medium text-gray-700 mb-1">Images (multiple)</label>
                <input type="file" name="image[]" id="images" multiple required accept="image/*"
                       class="block w-full text-sm border text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-indigo-50 file:text-indigo-700 hover:file:bg-indigo-100">
                <p class="mt-1 text-sm text-gray-500">You can select multiple images at once.</p>
            </div>

            <div class="flex justify-end">
                <button type="submit" class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                    Upload
                </button>
            </div>
        </form>
    </div>
@endsection