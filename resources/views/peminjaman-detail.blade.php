@extends('layouts.app')

{{-- Judul halaman akan dinamis berdasarkan nama buku --}}
@section('title', $buku->nama_buku)

@section('content')

<div class="bg-gray-50 py-12 md:py-20">
    <div class="container mx-auto px-4">
        
        <!-- Tombol Kembali ke Katalog -->
        <div class="mb-6">
            <a href="{{ route('peminjaman') }}" class="text-gray-600 hover:text-perpustakaan-blue transition-colors duration-300 flex items-center">
                <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor" class="w-5 h-5 mr-2">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 19.5 8.25 12l7.5-7.5" />
                </svg>
                Kembali ke Katalog
            </a>
        </div>

        <!-- Kotak Detail Buku -->
        <div class="bg-white p-6 md:p-10 rounded-lg shadow-lg border border-gray-200">
            <div class="flex flex-col md:flex-row gap-8 md:gap-12">

                <!-- Kolom 1: Cover Buku -->
                <div class="w-full md:w-1/3 flex-shrink-0">
                    <div class="aspect-[3/4] overflow-hidden rounded-lg shadow-md">
                        @if($buku->cover_thumbnail_url)
                            <img src="{{ Storage::url($buku->cover_thumbnail_url) }}" alt="{{ $buku->nama_buku }}" class="w-full h-full object-cover">
                        @else
                            <div class="w-full h-full bg-gray-200 flex items-center justify-center">
                                <span class="text-gray-500 text-lg">No Cover</span>
                            </div>
                        @endif
                    </div>
                </div>

                <!-- Kolom 2: Info Buku -->
                <div class="w-full md:w-2/3">
                    <!-- Judul -->
                    <h1 class="text-3xl md:text-4xl font-bold text-gray-900">{{ $buku->nama_buku }}</h1>
                    <!-- Penulis -->
                    <p class="text-xl text-gray-600 mt-2">{{ $buku->nama_penulis }}</p>

                    <!-- Rating -->
                    <div class="flex items-center my-4">
                        @php $rating = round($buku->rating_buku ?? 0); @endphp
                        @for ($i = 1; $i <= 5; $i++)
                            @if ($i <= $rating)
                                <svg class="w-5 h-5 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.83 4.401 4.853.704c.806.117 1.13.916.547 1.481l-3.51 3.42.83 4.83c.135.798-.703 1.403-1.416 1.004L10 15.17l-4.325 2.274c-.713.398-1.55-.206-1.416-1.004l.83-4.83-3.51-3.42c-.583-.565-.259-1.364.547-1.481l4.853-.704L9.132 2.884Z" clip-rule="evenodd" /></svg>
                            @else
                                <svg class="w-5 h-5 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.83 4.401 4.853.704c.806.117 1.13.916.547 1.481l-3.51 3.42.83 4.83c.135.798-.703 1.403-1.416 1.004L10 15.17l-4.325 2.274c-.713.398-1.55-.206-1.416-1.004l.83-4.83-3.51-3.42c-.583-.565-.259-1.364.547-1.481l4.853-.704L9.132 2.884Z" clip-rule="evenodd" /></svg>
                            @endif
                        @endfor
                        <span class="text-sm text-gray-500 ml-2">({{ $buku->rating_buku ?? 'N/A' }} / 5)</span>
                    </div>

                    <!-- Status -->
                    <div class="mb-6">
                        @if ($buku->jumlah_buku > 0)
                            <span class="text-sm font-semibold bg-green-100 text-green-700 px-3 py-1 rounded-full">
                                Tersedia
                            </span>
                        @else
                            <span class="text-sm font-semibold bg-red-100 text-red-700 px-3 py-1 rounded-full">
                                Dipinjam
                            </span>
                        @endif
                    </div>

                    <!-- Detail Meta Data -->
                    <div class="space-y-3 text-gray-700">
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-500">ISBN</span>
                            <span>: {{ $buku->nomor_isbn }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-500">Penerbit</span>
                            <span>: {{ $buku->penerbit }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-500">Tahun</span>
                            <span>: {{ $buku->tahun_buku }}</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-500">Halaman</span>
                            <span>: {{ $buku->jumlah_halaman }} halaman</span>
                        </div>
                        <div class="flex">
                            <span class="w-24 font-semibold text-gray-500">Kategori</span>
                            <!-- Kita panggil relasi 'kategori' -->
                            <span>: {{ $buku->kategori->nama_kategori ?? 'Tidak ada kategori' }}</span>
                        </div>
                    </div>

                    <!-- Deskripsi -->
                    <div class="mt-8 border-t pt-6">
                        <h4 class="font-semibold text-gray-800 mb-2 text-lg">Deskripsi</h4>
                        <p class="text-gray-600 leading-relaxed">{{ $buku->deskripsi_buku }}</p>
                    </div>

                    <!-- Tombol Pinjam -->
                    <div class="mt-10">
                        @if ($buku->jumlah_buku > 0)
                            <button class="w-full md:w-auto bg-perpustakaan-blue hover:bg-blue-800 text-white font-bold py-3 px-8 rounded-lg shadow-md transition duration-300 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="w-5 h-5 mr-2">
                                    <path fill-rule="evenodd" d="M10 18a8 8 0 1 0 0-16 8 8 0 0 0 0 16ZM.75 10a9.25 9.25 0 1 0 18.5 0 9.25 9.25 0 0 0-18.5 0Z" clip-rule="evenodd" />
                                </svg>
                                Pinjam Buku Sekarang
                            </button>
                        @else
                            <button class="w-full md:w-auto bg-gray-400 text-white font-bold py-3 px-8 rounded-lg shadow-md cursor-not-allowed" disabled>
                                Stok Habis
                            </button>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
