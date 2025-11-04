<!-- =======================
NAVBAR (Versi Tailwind)
======================== -->
<nav class="bg-perpustakaan-blue text-white fixed w-full top-0 z-50 shadow-lg">
    <div class="container mx-auto px-4">
        <div class="flex justify-between items-center h-17 py-3">
            
            <!-- Logo -->
            <a class="flex items-center space-x-2" href="/">
                <img src="https://i.ibb.co/mRwnSGC/logo-demo.png" alt="PerpusDigital" class="h-8 w-8">
                <span class="font-bold text-xl">PerpusDigital</span>
            </a>
            
            <!-- Link Navigasi Kiri (Desktop) -->
            <div class="hidden md:flex items-center space-x-6">
                <a href="{{ route('dashboard') }}" class="hover:text-perpustakaan-yellow transition duration-300">Dashboard</a>
                <a href="{{ route('peminjaman') }}" class="hover:text-perpustakaan-yellow transition duration-300">Peminjaman Buku</a>
                <a href="{{ route('riwayat') }}" class="hover:text-perpustakaan-yellow transition duration-300">Riwayat Peminjaman</a>
            </div>
            
            <!-- Tombol Autentikasi Kanan (Desktop) -->
            <div class="hidden md:flex items-center space-x-4">
                <a href="{{ route('login') }}" class="hover:text-perpustakaan-yellow transition duration-300">Masuk</a>
                <a href="{{ route('register') }}" class="bg-perpustakaan-yellow text-perpustakaan-blue font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition duration-300">
                    Daftar
                </a>
            </div>

            <!-- Tombol Menu Mobile -->
            <div class="md:hidden">
                <button id="mobile-menu-button" class="text-white focus:outline-none">
                    <svg class="h-6 w-6" fill="none" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" viewBox="0 0 24 24" stroke="currentColor">
                        <path d="M4 6h16M4 12h16m-7 6h7"></path>
                    </svg>
                </button>
            </div>

        </div>
    </div>
    
    <!-- Menu Mobile (Dropdown) -->
    <div id="mobile-menu" class="hidden md:hidden bg-perpustakaan-blue/90 backdrop-blur-sm">
        <div class="container mx-auto px-4 pt-2 pb-4 space-y-3">
            <a href="{{ route('dashboard') }}" class="block hover:text-perpustakaan-yellow transition duration-300">Dashboard</a>
            <a href="{{ route('peminjaman') }}" class="block hover:text-perpustakaan-yellow transition duration-300">Peminjaman Buku</a>
            <a href="{{ route('riwayat') }}" class="block hover:text-perpustakaan-yellow transition duration-300">Riwayat Peminjaman</a>
            <hr class="border-gray-600">
            <a href="{{ route('login') }}" class="block hover:text-perpustakaan-yellow transition duration-300">Masuk</a>
            <a href="{{ route('register') }}" class="block bg-perpustakaan-yellow text-perpustakaan-blue text-center font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition duration-300">
                Daftar
            </a>
        </div>
    </div>
</nav>
