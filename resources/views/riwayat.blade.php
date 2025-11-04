@extends('layouts.app')

{{-- Mengatur Judul Halaman --}}
@section('title', 'Riwayat Peminjaman - Perpustakaan Digital')

{{-- Konten Utama Halaman --}}
@section('content')

<div class="bg-gray-50 py-12 md:py-16 min-h-screen">
    <div class="container mx-auto px-4">

        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">
            Riwayat Peminjaman
        </h1>

        <!-- Wadah utama untuk tabel riwayat -->
        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            
            <!-- Header Tabel (Hanya tampil di layar medium ke atas) -->
            <div class="hidden md:grid grid-cols-6 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="col-span-2 text-sm font-semibold text-gray-600 uppercase">Buku</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Tanggal Pinjam</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Batas Kembali</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Status</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Aksi</div>
            </div>

            <!-- Daftar Riwayat (Data) -->
            <div class="divide-y divide-gray-200">
                
                <!-- Item 1: Dikembalikan -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 px-6 py-5 items-center">
                    <!-- Buku -->
                    <div class="col-span-2 flex items-center space-x-4">
                        <img src="https://placehold.co/80x100/e2e8f0/718096?text=Laskar" alt="Laskar Pelangi" class="w-16 h-20 object-cover rounded">
                        <div>
                            <p class="font-semibold text-gray-900">Laskar Pelangi</p>
                            <p class="text-sm text-gray-600">Andrea Hirata</p>
                        </div>
                    </div>
                    <!-- Tanggal Pinjam -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Tgl Pinjam: </span>15 Oktober 2024</div>
                    <!-- Batas Kembali -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Batas: </span>29 Oktober 2024</div>
                    <!-- Status -->
                    <div>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-green-100 text-green-700">
                            Dikembalikan
                        </span>
                    </div>
                    <!-- Aksi -->
                    <div class="flex space-x-4 text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-800">Pinjam Lagi</a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">Ulasan</a>
                    </div>
                </div>

                <!-- Item 2: Sedang Dipinjam -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 px-6 py-5 items-center">
                    <!-- Buku -->
                    <div class="col-span-2 flex items-center space-x-4">
                        <img src="https://placehold.co/80x100/e2e8f0/718096?text=Fisika" alt="Fisika Dasar" class="w-16 h-20 object-cover rounded">
                        <div>
                            <p class="font-semibold text-gray-900">Fisika Dasar untuk Mahasiswa</p>
                            <p class="text-sm text-gray-600">Prof. Dr. Bambang Ruwanto</p>
                        </div>
                    </div>
                    <!-- Tanggal Pinjam -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Tgl Pinjam: </span>20 Oktober 2024</div>
                    <!-- Batas Kembali -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Batas: </span>3 November 2024</div>
                    <!-- Status -->
                    <div>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-blue-100 text-blue-700">
                            Sedang Dipinjam
                        </span>
                    </div>
                    <!-- Aksi -->
                    <div class="flex space-x-4 text-sm font-medium">
                        <a href="#" class="text-blue-600 hover:text-blue-800">Perpanjang</a>
                        <a href="#" class="text-red-600 hover:text-red-800">Kembalikan</a>
                    </div>
                </div>

                <!-- Item 3: Terlambat -->
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 px-6 py-5 items-center">
                    <!-- Buku -->
                    <div class="col-span-2 flex items-center space-x-4">
                        <img src="https://placehold.co/80x100/e2e8f0/718096?text=Sejarah" alt="Sejarah Nasional" class="w-16 h-20 object-cover rounded">
                        <div>
                            <p class="font-semibold text-gray-900">Sejarah Nasional Indonesia</p>
                            <p class="text-sm text-gray-600">Marwati Djoened Poesponegoro</p>
                        </div>
                    </div>
                    <!-- Tanggal Pinjam -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Tgl Pinjam: </span>5 Oktober 2024</div>
                    <!-- Batas Kembali -->
                    <div class="text-gray-700"><span class="md:hidden font-semibold">Batas: </span>19 Oktober 2024</div>
                    <!-- Status -->
                    <div>
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full bg-red-100 text-red-700">
                            Terlambat
                        </span>
                    </div>
                    <!-- Aksi -->
                    <div class="flex space-x-4 text-sm font-medium">
                        <a href="#" class="text-red-600 hover:text-red-800">Bayar Denda</a>
                        <a href="#" class="text-gray-500 hover:text-gray-700">Kembalikan</a>
                    </div>
                </div>

            </div>
            <!-- Akhir Daftar Riwayat -->
        </div>
        <!-- Akhir Wadah Tabel -->

    </div>
</div>

@endsection

