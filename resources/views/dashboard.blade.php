@extends('layouts.app')

{{-- Mengatur Judul Halaman (opsional) --}}
@section('title', 'Selamat Datang di Perpustakaan Digital')

{{-- Konten Utama Halaman --}}
@section('content')

    <!-- =======================
    HERO CAROUSEL (Versi Swiper.js)
    ======================== -->
    <header class="swiper heroSwiper">
        <div class="swiper-wrapper">
            
            <!-- Slide 1 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1507842217343-583bb7270b66?q=80&w=2070&auto=format&fit=crop');">
                <div class="hero-caption">
                    <div class="w-full lg:w-2/3 px-4">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Selamat Datang di Perpustakaan Digital</h1>
                        <p class="text-lg md:text-xl mb-8">Akses ribuan koleksi buku digital dengan mudah. Pinjam, baca, dan kembalikan kapan saja, di mana saja.</p>
                        <a href="{{ route('register') }}" class="bg-perpustakaan-yellow text-perpustakaan-blue font-bold px-6 py-3 rounded-md text-lg hover:bg-yellow-300 transition duration-300">
                            Jelajahi Koleksi
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 2 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://images.unsplash.com/photo-1524995997946-a1c2e315a42f?q=80&w=2070&auto=format&fit=crop');">
                <div class="hero-caption">
                    <div class="w-full lg:w-2/3 px-4">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Koleksi Buku Terbaru</h1>
                        <p class="text-lg md:text-xl mb-8">Temukan buku-buku sains, novel, dan fiksi terbaru kami yang rilis minggu ini.</p>
                        <a href="#" class="bg-perpustakaan-yellow text-perpustakaan-blue font-bold px-6 py-3 rounded-md text-lg hover:bg-yellow-300 transition duration-300">
                            Lihat Sekarang
                        </a>
                    </div>
                </div>
            </div>

            <!-- Slide 3 -->
            <div class="swiper-slide hero-slide" style="background-image: url('https://media.istockphoto.com/id/171151211/id/foto/buku-buku-lama-di-perpustakaan.jpg?s=2048x2048&w=is&k=20&c=NodgVDSxAnhP2S4T7oqJgadSRZt0YUksmKMPid0XVxk=');">
                <div class="hero-caption">
                    <div class="w-full lg:w-2/3 px-4">
                        <h1 class="text-4xl md:text-6xl font-bold mb-4">Baca di Mana Saja</h1>
                        <p class="text-lg md:text-xl mb-8">Akses perpustakaan digital kami melalui perangkat apa pun, kapan pun Anda mau.</p>
                        <a href="{{ route('register') }}" class="bg-perpustakaan-yellow text-perpustakaan-blue font-bold px-6 py-3 rounded-md text-lg hover:bg-yellow-300 transition duration-300">
                            Daftar Gratis
                        </a>
                    </div>
                </div>
            </div>
            
        </div>
        <!-- Tombol Navigasi Carousel -->
        <div class="swiper-button-next text-white"></div>
        <div class="swiper-button-prev text-white"></div>
        <!-- Paginasi Carousel -->
        <div class="swiper-pagination"></div>
    </header>


    <!-- =======================
    TENTANG SECTION
    ======================== -->
    <section id="tentang" class="py-16 md:py-24">
        <div class="container mx-auto px-4">
            <div class="grid grid-cols-1 md:grid-cols-2 gap-12 items-center">
                <!-- Kolom Teks -->
                <div>
                    <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-6">Tentang Perpustakaan Digital</h2>
                    <p class="text-lg text-gray-600 mb-4">Perpustakaan Digital adalah platform inovatif yang menghubungkan Anda dengan dunia pengetahuan. Dengan koleksi lebih dari 50.000 buku digital, kami berkomitmen menyediakan akses mudah dan terjangkau untuk semua kalangan.</p>
                    <p class="text-gray-600 mb-8">Didirikan pada tahun 2020, kami telah melayani lebih dari 25.000 anggota aktif dengan sistem peminjaman yang mudah, aman, dan terpercaya.</p>
                    
                    <!-- Stats -->
                    <div class="grid grid-cols-3 gap-4 text-center">
                        <div>
                            <h3 class="text-3xl font-bold text-perpustakaan-blue">50K+</h3>
                            <p class="text-gray-500">Koleksi Buku</p>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-perpustakaan-blue">25K+</h3>
                            <p class="text-gray-500">Anggota Aktif</p>
                        </div>
                        <div>
                            <h3 class="text-3xl font-bold text-perpustakaan-blue">24/7</h3>
                            <p class="text-gray-500">Akses Online</p>
                        </div>
                    </div>
                </div>
                <!-- Kolom Gambar -->
                <div class="mt-8 md:mt-0">
                    <img src="https://i.pinimg.com/1200x/d4/08/d8/d408d8f291dbd85577e86f92e489c3cd.jpg" alt="Tentang PerpusDigital" class="rounded-lg shadow-xl w-full h-auto object-cover">
                </div>
            </div>
        </div>
    </section>

    <!-- =======================
    CARA KERJA SECTION
    ======================== -->
    <section id="cara-kerja" class="py-16 md:py-24 bg-gray-50">
        <div class="container mx-auto px-4 text-center">
            <h2 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">Cara Kerja Sistem</h2>
            <p class="text-lg text-gray-600 mb-12 max-w-2xl mx-auto">Empat langkah mudah untuk menikmati layanan perpustakaan digital kami</p>

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-8">
                <!-- Item 1 -->
                <div class="p-6">
                    <!-- Icon (Heroicons - Ganti BS Icons) -->
                    <svg class="w-16 h-16 text-perpustakaan-blue mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M19 7.5v3m0 0v3m0-3h3m-3 0h-3m-2.25-4.125a3.375 3.375 0 1 1-6.75 0 3.375 3.375 0 0 1 6.75 0ZM3 19.235v-.11a6.375 6.375 0 0 1 12.75 0v.109A12.318 12.318 0 0 1 9.374 21c-2.331 0-4.512-.645-6.374-1.766Z" />
                    </svg>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">1. Daftar Akun</h4>
                    <p class="text-gray-600">Buat akun gratis dengan data diri yang valid untuk mengakses layanan.</p>
                </div>
                <!-- Item 2 -->
                <div class="p-6">
                    <svg class="w-16 h-16 text-perpustakaan-blue mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                    </svg>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">2. Cari Buku</h4>
                    <p class="text-gray-600">Jelajahi katalog dan temukan buku yang Anda inginkan dengan mudah.</p>
                </div>
                <!-- Item 3 -->
                <div class="p-6">
                    <svg class="w-16 h-16 text-perpustakaan-blue mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M12 6.042A8.967 8.967 0 0 0 6 3.75c-1.052 0-2.062.18-3 .512v14.25A8.987 8.987 0 0 1 6 18c2.105 0 4.079.542 5.672 1.57A8.987 8.987 0 0 1 18 18c1.052 0 2.062-.18 3-.512V3.75A8.987 8.987 0 0 0 18 3c-2.105 0-4.079.542-5.672 1.57A8.967 8.967 0 0 0 12 6.042Z" />
                    </svg>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">3. Pinjam Buku</h4>
                    <p class="text-gray-600">Klik tombol pinjam dan buku akan tersedia di akun Anda.</p>
                </div>
                <!-- Item 4 -->
                <div class="p-6">
                    <svg class="w-16 h-16 text-perpustakaan-blue mx-auto mb-4" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M16.023 9.348h4.992v-.001M2.985 19.644v-4.992m0 0h4.992m-4.992 0 4.992-4.992m6.015 6.015-4.992-4.992m0 0h4.992m-4.992 0v4.992m6.015-6.015 4.992 4.992m0 0v4.992m0 0h-4.992m4.992 0-4.992-4.992" />
                    </svg>
                    <h4 class="text-xl font-bold text-gray-800 mb-2">4. Kembalikan</h4>
                    <p class="text-gray-600">Kembalikan buku sebelum batas waktu atau perpanjang masa pinjam.</p>
                </div>
            </div>
        </div>
    </section>

@endsection

