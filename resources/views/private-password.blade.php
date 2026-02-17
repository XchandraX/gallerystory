@extends('layouts.app')

@section('title', 'Private Access')

@section('content')
    <div class="max-w-md mx-auto">
        <h1 class="text-3xl font-bold mb-4 text-gray-900">Enter Private Gallery Password</h1>

        <p class="text-gray-600 mb-6">Masukkan password untuk mengakses gallery private.</p>

        @if ($errors->any())
            <div class="bg-red-50 border-l-4 border-red-400 text-red-700 p-4 mb-6 rounded" role="alert">
                {{ $errors->first() }}
            </div>
        @endif

        @if (session('success'))
            <div class="bg-green-50 border-l-4 bo border-green-400 text-green-700 p-4 mb-6 rounded" role="alert">
                {{ session('success') }}
            </div>

        @endif

        @if (session('error'))
            <div class="bg-yellow-50 border-l-4 border border-yellow-400 text-yellow-700 p-4 mb-6 rounded" role="alert">
                {{ session('error') }}
            </div>
        @endif

        <form action="{{ route('private.verify') }}" method="POST" class="bg-white rounded-lg shadow-md p-6 space-y-6">
            @csrf
            <div>
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                <input type="password" name="password" id="password" required autofocus
                    class="w-full rounded-md border border-gray-300 shadow-sm focus:border-indigo-500 focus:ring-indigo-500">
            </div>
            <div class="flex justify-end">
                <button type="submit"
                    class="bg-indigo-600 text-white px-6 py-2 rounded-md hover:bg-indigo-700 transition shadow-md hover:shadow-lg">
                    Enter Gallery
                </button>
            </div>
        </form>
    </div>
@endsection
