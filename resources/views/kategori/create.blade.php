@extends('layouts.app')

@section('content')
<h1 class="text-2xl font-bold mb-4">Tambah Kategori Baru</h1>

@if ($errors->any())
    <div class="text-red-500 mb-2">
        {{ $errors->first() }}
    </div>
@endif

<form action="{{ url('/kategori/create') }}" method="POST" class="space-y-2">
    @csrf
    <input type="text" name="name" placeholder="Nama Kategori" required class="border p-2 w-full">
    <input type="text" name="slug" placeholder="Slug (unik, lowercase, tanpa spasi)" required class="border p-2 w-full">
    <button type="submit" class="bg-blue-500 text-white px-4 py-2">Tambah Kategori</button>
</form>
@endsection
