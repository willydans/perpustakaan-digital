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
                @guest
                    <a href="{{ route('login') }}" class="hover:text-perpustakaan-yellow transition duration-300">Masuk</a>
                    <a href="{{ route('register') }}" class="bg-perpustakaan-yellow text-perpustakaan-blue font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition duration-300">
                        Daftar
                    </a>
                @else
                    <div class="relative">
                        <button id="profile-menu-button" class="flex items-center space-x-2 hover:text-perpustakaan-yellow transition duration-300 focus:outline-none">
                            <div class="w-8 h-8 bg-perpustakaan-yellow rounded-full flex items-center justify-center text-perpustakaan-blue font-bold">
                                {{ substr(Auth::user()->name, 0, 1) }}
                            </div>
                            <span>{{ Auth::user()->name }}</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"></path>
                            </svg>
                        </button>
                        <div id="profile-menu" class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 z-50 hidden">
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                            <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                            <form action="{{ route('logout') }}" method="POST" class="inline">
                                @csrf
                                <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                            </form>
                        </div>
                    </div>
                @endguest
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
            @guest
                <a href="{{ route('login') }}" class="block hover:text-perpustakaan-yellow transition duration-300">Masuk</a>
                <a href="{{ route('register') }}" class="block bg-perpustakaan-yellow text-perpustakaan-blue text-center font-bold px-4 py-2 rounded-md hover:bg-yellow-300 transition duration-300">
                    Daftar
                </a>
            @else
                <div class="text-center py-2 relative">
                    <button id="mobile-profile-menu-button" class="w-8 h-8 bg-perpustakaan-yellow rounded-full flex items-center justify-center text-perpustakaan-blue font-bold mx-auto mb-2 hover:bg-yellow-300 transition duration-300 focus:outline-none">
                        {{ substr(Auth::user()->name, 0, 1) }}
                    </button>
                    <span class="block text-white text-sm">{{ Auth::user()->name }}</span>
                    <div id="mobile-profile-menu" class="mt-2 w-full bg-white rounded-md shadow-lg py-1 hidden">
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profil</a>
                        <a href="#" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Settings</a>
                        <form action="{{ route('logout') }}" method="POST" class="inline">
                            @csrf
                            <button type="submit" class="block w-full text-left px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Keluar</button>
                        </form>
                    </div>
                </div>
            @endguest
        </div>
    </div>

    <!-- JavaScript untuk Dropdown Menu -->
    <script>
        // Desktop Profile Menu
        const profileMenuButton = document.getElementById('profile-menu-button');
        const profileMenu = document.getElementById('profile-menu');

        if (profileMenuButton && profileMenu) {
            profileMenuButton.addEventListener('click', function() {
                profileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!profileMenuButton.contains(event.target) && !profileMenu.contains(event.target)) {
                    profileMenu.classList.add('hidden');
                }
            });
        }

        // Mobile Profile Menu
        const mobileProfileMenuButton = document.getElementById('mobile-profile-menu-button');
        const mobileProfileMenu = document.getElementById('mobile-profile-menu');

        if (mobileProfileMenuButton && mobileProfileMenu) {
            mobileProfileMenuButton.addEventListener('click', function() {
                mobileProfileMenu.classList.toggle('hidden');
            });

            // Close menu when clicking outside
            document.addEventListener('click', function(event) {
                if (!mobileProfileMenuButton.contains(event.target) && !mobileProfileMenu.contains(event.target)) {
                    mobileProfileMenu.classList.add('hidden');
                }
            });
        }

        // Mobile Menu Toggle
        const mobileMenuButton = document.getElementById('mobile-menu-button');
        const mobileMenu = document.getElementById('mobile-menu');

        if (mobileMenuButton && mobileMenu) {
            mobileMenuButton.addEventListener('click', function() {
                mobileMenu.classList.toggle('hidden');
            });
        }
    </script>
</nav>
