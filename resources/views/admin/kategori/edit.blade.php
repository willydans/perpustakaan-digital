@extends('layouts.app')

@section('title', 'Admin - Edit Kategori')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Edit Kategori</h1>

    <!-- Form Edit Kategori -->
    <div class="bg-white p-8 rounded-lg shadow-lg max-w-lg">
        <h2 class="text-2xl font-semibold mb-6">Edit Kategori: {{ $kategori->nama_kategori }}</h2>

        <form action="{{ route('admin.kategori.update', $kategori) }}" method="POST">
            @csrf
            @method('PUT')

            <div class="mb-4">
                <label for="nama_kategori" class="block text-sm font-medium text-gray-700 mb-2">
                    Nama Kategori
                </label>
                <input type="text" name="nama_kategori" id="nama_kategori" value="{{ old('nama_kategori', $kategori->nama_kategori) }}" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" required>
                @error('nama_kategori')
                    <span class="text-red-500 text-sm">{{ $message }}</span>
                @enderror
            </div>

            <div class="flex gap-4">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Simpan Perubahan
                </button>
                <a href="{{ route('admin.kategori.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
