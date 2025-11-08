@extends('layouts.app')

@section('title', 'Admin - Manajemen Kategori')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Manajemen Kategori</h1>

    <!-- Pesan Sukses/Error -->
    @if (session('success'))
        <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('success') }}</span>
        </div>
    @endif

    @if (session('error'))
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <span class="block sm:inline">{{ session('error') }}</span>
        </div>
    @endif

    <!-- Form Tambah Kategori -->
    <div class="bg-white p-6 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold mb-4">Tambah Kategori Baru</h2>

        <!-- Pesan Sukses Tambah Kategori -->
        @if (session('success_kategori'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success_kategori') }}</span>
            </div>
        @endif

        <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex items-center gap-2 max-w-lg">
            @csrf
            <div class="flex-grow">
                <label for="nama_kategori_baru" class="sr-only">Nama Kategori Baru</label>
                <input type="text" name="nama_kategori" id="nama_kategori_baru" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ketik nama kategori baru..." required>
                @error('nama_kategori') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>
            <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Tambah Kategori
            </button>
        </form>
    </div>

    <!-- Tabel Daftar Kategori -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-4">Daftar Kategori</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">No</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Kategori</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Jumlah Buku</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @forelse ($kategoris as $index => $kategori)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-900">
                            {{ $kategoris->firstItem() + $index }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium text-gray-900">
                            {{ $kategori->nama_kategori }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $kategori->bukus->count() }} buku
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium space-x-2">
                            <a href="{{ route('admin.kategori.edit', $kategori) }}" class="text-blue-600 hover:text-blue-900">Edit</a>
                            <form action="{{ route('admin.kategori.destroy', $kategori) }}" method="POST" class="inline" onsubmit="return confirm('Apakah Anda yakin ingin menghapus kategori ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada kategori yang ditambahkan.
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        @if ($kategoris->hasPages())
            <div class="mt-6">
                {{ $kategoris->links() }}
            </div>
        @endif
    </div>
</div>
@endsection
