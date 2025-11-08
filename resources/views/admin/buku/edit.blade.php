@extends('layouts.app')

@section('title', 'Admin - Edit Buku')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Edit Buku</h1>

    <!-- Form Edit Buku -->
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">Edit Buku: {{ $buku->nama_buku }}</h2>

        <!-- Pesan Sukses/Error -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        @if ($errors->any())
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Oops! Ada yang salah dengan input:</strong>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('admin.buku.update', $buku) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                <!-- Kolom Kiri -->
                <div>
                    <!-- Nama Buku -->
                    <div class="mb-4">
                        <label for="nama_buku" class="block text-sm font-medium text-gray-700 mb-1">Nama Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_buku" id="nama_buku" value="{{ old('nama_buku', $buku->nama_buku) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Penulis -->
                    <div class="mb-4">
                        <label for="nama_penulis" class="block text-sm font-medium text-gray-700 mb-1">Nama Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_penulis" id="nama_penulis" value="{{ old('nama_penulis', $buku->nama_penulis) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nomor ISBN -->
                    <div class="mb-4">
                        <label for="nomor_isbn" class="block text-sm font-medium text-gray-700 mb-1">Nomor ISBN <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_isbn" id="nomor_isbn" value="{{ old('nomor_isbn', $buku->nomor_isbn) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: 978-602-03-8591-6">
                        @error('nomor_isbn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Penerbit -->
                    <div class="mb-4">
                        <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit', $buku->penerbit) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('penerbit') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Kolom Kanan -->
                <div>
                    <!-- Kategori (Dropdown) -->
                    <div class="mb-4">
                        <label for="kategori_id" class="block text-sm font-medium text-gray-700 mb-1">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori_id" id="kategori_id" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                            <option value="">-- Pilih Kategori --</option>
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id', $buku->kategori_id) == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Grid 3 Kolom (Tahun, Halaman, Stok) -->
                    <div class="grid grid-cols-3 gap-4 mb-4 mt-6">
                        <div>
                            <label for="tahun_buku" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_buku" id="tahun_buku" value="{{ old('tahun_buku', $buku->tahun_buku) }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="2024">
                            @error('tahun_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="jumlah_halaman" class="block text-sm font-medium text-gray-700 mb-1">Halaman <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_halaman" id="jumlah_halaman" value="{{ old('jumlah_halaman', $buku->jumlah_halaman) }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="300">
                            @error('jumlah_halaman') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="jumlah_buku" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_buku" id="jumlah_buku" value="{{ old('jumlah_buku', $buku->jumlah_buku) }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="10">
                            @error('jumlah_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Rating (Bisa di-skip/nullable) -->
                    <div class="mb-4">
                        <label for="rating_buku" class="block text-sm font-medium text-gray-700 mb-1">Rating (Opsional)</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating_buku" id="rating_buku" value="{{ old('rating_buku', $buku->rating_buku) }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Contoh: 4.5">
                        @error('rating_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cover Thumbnail -->
                    <div class="mb-4">
                        <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">Cover Thumbnail (Opsional)</label>
                        <input type="file" name="cover" id="cover" class="w-full border border-gray-300 rounded-lg p-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @if($buku->cover_thumbnail_url)
                            <div class="mt-2">
                                <img src="{{ Storage::url($buku->cover_thumbnail_url) }}" alt="Current Cover" class="w-20 h-28 object-cover rounded border">
                                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah cover</p>
                            </div>
                        @endif
                        @error('cover') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tombol Submit (Span Penuh) -->
                <div class="md:col-span-2">
                     <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="deskripsi_buku" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_buku" id="deskripsi_buku" rows="4" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi_buku', $buku->deskripsi_buku) }}</textarea>
                        @error('deskripsi_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <div class="flex gap-4">
                        <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Simpan Perubahan
                        </button>
                        <a href="{{ route('admin.buku.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                            Batal
                        </a>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
