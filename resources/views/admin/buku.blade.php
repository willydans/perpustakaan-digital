@extends('layouts.app')

@section('title', 'Admin - Manajemen Buku')

@section('content')
<div class="container mx-auto px-4 py-12">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Admin: Manajemen Buku</h1>

    <!-- =================================== -->
    <!-- (1) FORM TAMBAH KATEGORI (TERPISAH) -->
    <!-- =================================== -->
    <div class="bg-white p-8 rounded-lg shadow-lg mb-8">
        <h2 class="text-2xl font-semibold mb-4">Manajemen Kategori (Tester)</h2>

        <!-- Pesan Sukses Tambah Kategori -->
        @if (session('success_kategori'))
            <div class="bg-blue-100 border border-blue-400 text-blue-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success_kategori') }}</span>
            </div>
        @endif

        <!-- Form "Quick Add" Kategori (SEKARANG DI LUAR) -->
        <form action="{{ route('admin.kategori.store') }}" method="POST" class="flex items-center gap-2 max-w-lg">
            @csrf
            <div class="flex-grow">
                <label for="nama_kategori_baru" class="sr-only">Nama Kategori Baru</label>
                <input type="text" name="nama_kategori" id="nama_kategori_baru" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Ketik nama kategori baru..." required>
                @error('nama_kategori') 
                    <span class="text-red-500 text-sm">{{ $message }}</span> 
                @enderror
            </div>
            <button type="submit" class="bg-gray-600 hover:bg-gray-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                Tambah Kategori
            </button>
        </form>
    </div>


    <!-- =================================== -->
    <!-- (2) SECTION FORM UPLOAD BUKU        -->
    <!-- =================================== -->
    <div class="bg-white p-8 rounded-lg shadow-lg mb-12">
        <h2 class="text-2xl font-semibold mb-6">Upload Buku Baru</h2>

        <!-- Pesan Sukses Upload Buku -->
        @if (session('success'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success') }}</span>
            </div>
        @endif

        <!-- Menampilkan Error Validasi (Jika ada) -->
        @if ($errors->any() && !$errors->has('nama_kategori'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <strong class="font-bold">Oops! Ada yang salah dengan input buku:</strong>
                <ul class="mt-3 list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- FORM UTAMA UPLOAD BUKU -->
        <form action="{{ route('admin.buku.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="grid grid-cols-1 md:grid-cols-2 gap-x-8 gap-y-6">

                <!-- Kolom Kiri -->
                <div>
                    <!-- Nama Buku -->
                    <div class="mb-4">
                        <label for="nama_buku" class="block text-sm font-medium text-gray-700 mb-1">Nama Buku <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_buku" id="nama_buku" value="{{ old('nama_buku') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nama Penulis -->
                    <div class="mb-4">
                        <label for="nama_penulis" class="block text-sm font-medium text-gray-700 mb-1">Nama Penulis <span class="text-red-500">*</span></label>
                        <input type="text" name="nama_penulis" id="nama_penulis" value="{{ old('nama_penulis') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                        @error('nama_penulis') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Nomor ISBN -->
                    <div class="mb-4">
                        <label for="nomor_isbn" class="block text-sm font-medium text-gray-700 mb-1">Nomor ISBN <span class="text-red-500">*</span></label>
                        <input type="text" name="nomor_isbn" id="nomor_isbn" value="{{ old('nomor_isbn') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Contoh: 978-602-03-8591-6">
                        @error('nomor_isbn') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Penerbit -->
                    <div class="mb-4">
                        <label for="penerbit" class="block text-sm font-medium text-gray-700 mb-1">Penerbit <span class="text-red-500">*</span></label>
                        <input type="text" name="penerbit" id="penerbit" value="{{ old('penerbit') }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
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
                            {{-- Loop data kategori dari controller --}}
                            @foreach($kategoris as $kategori)
                                <option value="{{ $kategori->id }}" {{ old('kategori_id') == $kategori->id ? 'selected' : '' }}>
                                    {{ $kategori->nama_kategori }}
                                </option>
                            @endforeach
                        </select>
                        @error('kategori_id') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                    
                    <!-- Form "quick add" LAMA SUDAH DIHAPUS DARI SINI -->

                    <!-- Grid 3 Kolom (Tahun, Halaman, Stok) -->
                    <div class="grid grid-cols-3 gap-4 mb-4 mt-6">
                        <div>
                            <label for="tahun_buku" class="block text-sm font-medium text-gray-700 mb-1">Tahun <span class="text-red-500">*</span></label>
                            <input type="number" name="tahun_buku" id="tahun_buku" value="{{ old('tahun_buku', date('Y')) }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="2024">
                            @error('tahun_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="jumlah_halaman" class="block text-sm font-medium text-gray-700 mb-1">Halaman <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_halaman" id="jumlah_halaman" value="{{ old('jumlah_halaman') }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="300">
                            @error('jumlah_halaman') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                        <div>
                            <label for="jumlah_buku" class="block text-sm font-medium text-gray-700 mb-1">Stok <span class="text-red-500">*</span></label>
                            <input type="number" name="jumlah_buku" id="jumlah_buku" value="{{ old('jumlah_buku', 1) }}" required class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="10">
                            @error('jumlah_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                        </div>
                    </div>

                    <!-- Rating (Bisa di-skip/nullable) -->
                    <div class="mb-4">
                        <label for="rating_buku" class="block text-sm font-medium text-gray-700 mb-1">Rating (Opsional)</label>
                        <input type="number" step="0.1" min="0" max="5" name="rating_buku" id="rating_buku" value="{{ old('rating_buku') }}" class="w-full border-gray-300 rounded-lg shadow-sm" placeholder="Contoh: 4.5">
                        @error('rating_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <!-- Cover Thumbnail -->
                    <div class="mb-4">
                        <label for="cover" class="block text-sm font-medium text-gray-700 mb-1">Cover Thumbnail <span class="text-red-500">*</span></label>
                        <input type="file" name="cover" id="cover" required class="w-full border border-gray-300 rounded-lg p-2 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-lg file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100">
                        @error('cover') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>
                </div>

                <!-- Tombol Submit (Span Penuh) -->
                <div class="md:col-span-2">
                     <!-- Deskripsi -->
                    <div class="mb-4">
                        <label for="deskripsi_buku" class="block text-sm font-medium text-gray-700 mb-1">Deskripsi <span class="text-red-500">*</span></label>
                        <textarea name="deskripsi_buku" id="deskripsi_buku" rows="4" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">{{ old('deskripsi_buku') }}</textarea>
                        @error('deskripsi_buku') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                    </div>

                    <button type="submit" class="w-full bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out">
                        Upload Buku Baru
                    </button>
                </div>
            </div>
        </form>
    </div>

    <!-- =================================== -->
    <!-- (3) SECTION DAFTAR BUKU (TABEL)     -->
    <!-- =================================== -->
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <h2 class="text-2xl font-semibold mb-6">Daftar Buku Ter-upload</h2>

        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Cover</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Buku</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Penulis</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stok</th>
                        <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    
                    @forelse ($bukus as $buku)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            @if($buku->cover_thumbnail_url)
                                <img src="{{ Storage::url($buku->cover_thumbnail_url) }}" alt="{{ $buku->nama_buku }}" class="w-16 h-20 object-cover rounded">
                            @else
                                <div class="w-16 h-20 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">No Cover</div>
                            @endif
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $buku->nama_buku }}</div>
                            <div class="text-sm text-gray-500">{{ $buku->nomor_isbn }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $buku->nama_penulis }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $buku->jumlah_buku }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                            <form action="{{ route('admin.buku.destroy', $buku->id) }}" method="POST" onsubmit="return confirm('Apakah Anda yakin ingin menghapus buku ini?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-red-600 hover:text-red-900">Hapus</button>
                            </form>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="5" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada buku yang di-upload.
                        </td>
                    </tr>
                    {{-- INI ADALAH PERBAIKANNYA --}}
                    @endforelse

                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection

