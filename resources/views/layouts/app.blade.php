<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    
    <!-- Judul Halaman dinamis, dengan default -->
    <title>@yield('title', 'Perpustakaan Digital')</title>

    <!-- 1. Tailwind CSS Play CDN (Masih diperlukan) -->
    <script src="https://cdn.tailwindcss.com"></script>

    <!-- 2. Swiper.js Carousel CDN (CSS) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.css" />
    
    <!-- 3. Google Font (Inter) -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;700;800&display=swap" rel="stylesheet">

    <!-- 4. Kustom CSS Eksternal (BARU) -->
    <!-- CSS ini harus Anda buat di folder /public/css/custom.css -->
    <link rel="stylesheet" href="{{ asset('css/custom.css') }}">
    
    <!-- Ikon Bootstrap (karena dipakai di footer) -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
</head>
<body class="bg-white antialiased">

    <!-- =======================
    Memanggil Header
    ======================== -->
    @include('layouts.header')

    <!-- =======================
    Konten Halaman
    ======================== -->
    <main>
        <!-- Konten dari file (seperti home.blade.php) akan disuntikkan di sini -->
        @yield('content')
    </main>

    <!-- =======================
    Memanggil Footer
    ======================== -->
    @include('layouts.footer')


    <!-- =======================
    SCRIPT
    ======================== -->
    
    <!-- 5. Swiper.js & Kustom JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@11/swiper-bundle.min.js"></script>
    <script>
        // Inisialisasi Swiper.js untuk Carousel
        var swiper = new Swiper(".heroSwiper", {
            loop: true,
            autoplay: {
                delay: 5000,
                disableOnInteraction: false,
            },
            pagination: {
                el: ".swiper-pagination",
                clickable: true,
            },
            navigation: {
                nextEl: ".swiper-button-next",
                prevEl: ".swiper-button-prev",
            },
        });

        // Script untuk Toggle Menu Mobile
        const menuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        // Pastikan tombol ada sebelum menambah event listener (menghindari error di halaman lain)
        if (menuButton) {
            menuButton.addEventListener('click', () => {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
    
    <!-- Script tambahan khusus per halaman (jika ada) -->
    @stack('scripts')
</body>
</html>
