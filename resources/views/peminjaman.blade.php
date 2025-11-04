@extends('layouts.app')

{{-- Mengatur Judul Halaman --}}
@section('title', 'Katalog Buku - Perpustakaan Digital')

{{-- Konten Utama Halaman --}}
@section('content')

<div class="bg-gray-50 py-12 md:py-16">
    <div class="container mx-auto px-4">

        <!-- =======================
        PESAN SUKSES / ERROR (dari form pinjam)
        ======================== -->
        @if (session('success_pinjam'))
            <div class="bg-green-100 border border-green-400 text-green-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('success_pinjam') }}</span>
            </div>
        @endif
        @if (session('error_pinjam'))
            <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
                <span class="block sm:inline">{{ session('error_pinjam') }}</span>
            </div>
        @endif

        <!-- ============================================= -->
        <!-- FORM UNTUK SEMUA FILTER (Search + Sidebar) -->
        <!-- ============================================= -->
        <form action="{{ route('peminjaman') }}" method="GET" id="filterForm">
            
            <!-- HEADER (Judul & Search) -->
            <div class="flex flex-col md:flex-row justify-between items-center mb-8 gap-4">
                <h1 class="text-3xl md:text-4xl font-bold text-gray-800">
                    Katalog Buku
                </h1>
                
                <!-- Search Bar -->
                <div class="w-full md:w-1/3">
                    <div class="relative">
                        <span class="absolute inset-y-0 left-0 flex items-center pl-3">
                            <svg class="w-5 h-5 text-gray-400" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" d="m21 21-5.197-5.197m0 0A7.5 7.5 0 1 0 5.196 5.196a7.5 7.5 0 0 0 10.607 10.607Z" />
                            </svg>
                        </span>
                        <!-- Input 'search' -->
                        <input type="text" name="search" value="{{ request('search') }}" placeholder="Cari judul, penulis, atau ISBN..." class="w-full pl-10 pr-4 py-2.5 border border-gray-300 rounded-lg focus:outline-none focus:ring-2 focus:ring-perpustakaan-blue focus:border-transparent">
                        <button type="submit" class="hidden">Cari</button>
                    </div>
                </div>
            </div>

            <!-- LAYOUT UTAMA (Filter & Grid Buku) -->
            <div class="flex flex-col md:flex-row gap-8">

                <!-- KOLOM 1: FILTER (Sidebar) -->
                <aside class="w-full md:w-1/4 lg:w-1/5">
                    <div class="bg-white p-6 rounded-lg shadow-sm border border-gray-200">
                        <h3 class="text-xl font-bold text-gray-800 mb-4">Filter Buku</h3>

                        <!-- Filter Kategori (Dinamis) -->
                        <div class="mb-5">
                            <h4 class="font-semibold text-gray-700 mb-2">Kategori</h4>
                            <div class="space-y-1.5">
                                <div class="flex items-center">
                                    <input id="filter-kat-semua" name="kategori" value="semua" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('kategori', 'semua') == 'semua' ? 'checked' : '' }}>
                                    <label for="filter-kat-semua" class="ml-2 block text-sm text-gray-700">Semua Kategori</label>
                                </div>
                                @foreach($kategoris as $kategori)
                                <div class="flex items-center">
                                    <input id="filter-kat-{{ $kategori->id }}" name="kategori" value="{{ $kategori->id }}" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('kategori') == $kategori->id ? 'checked' : '' }}>
                                    <label for="filter-kat-{{ $kategori->id }}" class="ml-2 block text-sm text-gray-700">{{ $kategori->nama_kategori }}</label>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        
                        <!-- Filter Ketersediaan (Statis) -->
                        <div class="mb-5">
                            <h4 class="font-semibold text-gray-700 mb-2">Ketersediaan</h4>
                            <div class="space-y-1.5">
                                <div class="flex items-center">
                                    <input id="filter-semua" name="ketersediaan" value="semua" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue" 
                                           onchange="this.form.submit()"
                                           {{ request('ketersediaan', 'semua') == 'semua' ? 'checked' : '' }}>
                                    <label for="filter-semua" class="ml-2 block text-sm text-gray-700">Semua</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="filter-tersedia" name="ketersediaan" value="tersedia" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue" 
                                           onchange="this.form.submit()"
                                           {{ request('ketersediaan') == 'tersedia' ? 'checked' : '' }}>
                                    <label for="filter-tersedia" class="ml-2 block text-sm text-gray-700">Tersedia</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="filter-dipinjam" name="ketersediaan" value="dipinjam" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('ketersediaan') == 'dipinjam' ? 'checked' : '' }}>
                                    <label for="filter-dipinjam" class="ml-2 block text-sm text-gray-700">Dipinjam</label>
                                </div>
                            </div>
                        </div>

                        <!-- (REVISI BARU) Filter Tahun Terbit -->
                        <div>
                            <h4 class="font-semibold text-gray-700 mb-2">Tahun Terbit</h4>
                            <div class="space-y-1.5">
                                <div class="flex items-center">
                                    <input id="filter-tahun-semua" name="tahun" value="semua" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue" 
                                           onchange="this.form.submit()"
                                           {{ request('tahun', 'semua') == 'semua' ? 'checked' : '' }}>
                                    <label for="filter-tahun-semua" class="ml-2 block text-sm text-gray-700">Semua Tahun</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="filter-2021" name="tahun" value="2021-2025" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('tahun') == '2021-2025' ? 'checked' : '' }}>
                                    <label for="filter-2021" class="ml-2 block text-sm text-gray-700">2021-2025</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="filter-2011" name="tahun" value="2011-2020" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('tahun') == '2011-2020' ? 'checked' : '' }}>
                                    <label for="filter-2011" class="ml-2 block text-sm text-gray-700">2011-2020</label>
                                </div>
                                <div class="flex items-center">
                                    <input id="filter-2000" name="tahun" value="2000-2010" type="radio" 
                                           class="h-4 w-4 text-perpustakaan-blue border-gray-300 focus:ring-perpustakaan-blue"
                                           onchange="this.form.submit()"
                                           {{ request('tahun') == '2000-2010' ? 'checked' : '' }}>
                                    <label for="filter-2000" class="ml-2 block text-sm text-gray-700">2000-2010</label>
                                </div>
                            </div>
                        </div>

                    </div>
                </aside>

                <!-- KOLOM 2: GRID BUKU (Dinamis) -->
                <main class="w-full md:w-3/4 lg:w-4/5">
                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">

                        <!-- Loop data buku dari controller -->
                        @forelse ($bukus as $buku)
                        <!-- Tombol Kartu Buku (Memicu Modal) -->
                        <button type="button" data-id="{{ $buku->id }}" class="block group openModalBtn text-left cursor-pointer">
                            <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden flex flex-col group-hover:shadow-lg transition-shadow duration-300 h-full">
                                
                                <!-- Gambar Sampul -->
                                <div class="aspect-[3/4] overflow-hidden">
                                    @if($buku->cover_thumbnail_url)
                                        <img src="{{ Storage::url($buku->cover_thumbnail_url) }}" alt="{{ $buku->nama_buku }}" class="w-full h-full object-cover">
                                    @else
                                        <img src="https://placehold.co/300x400/e2e8f0/cccccc?text=No+Cover" alt="No Cover" class="w-full h-full object-cover">
                                    @endif
                                </div>
                                
                                <!-- Detail Teks -->
                                <div class="p-4 flex flex-col flex-grow">
                                    <h3 class="text-lg font-bold text-gray-800 mb-1 truncate" title="{{ $buku->nama_buku }}">{{ $buku->nama_buku }}</h3>
                                    <p class="text-sm text-gray-600 mb-2 truncate" title="{{ $buku->nama_penulis }}">{{ $buku->nama_penulis }}</p>
                                    
                                    <!-- Rating -->
                                    <div class="flex items-center mb-3">
                                        @php $rating = round($buku->rating_buku ?? 0); @endphp
                                        @for ($i = 1; $i <= 5; $i++)
                                            @if ($i <= $rating)
                                                <svg class="w-4 h-4 text-yellow-400" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.83 4.401 4.853.704c.806.117 1.13.916.547 1.481l-3.51 3.42.83 4.83c.135.798-.703 1.403-1.416 1.004L10 15.17l-4.325 2.274c-.713.398-1.55-.206-1.416-1.004l.83-4.83-3.51-3.42c-.583-.565-.259-1.364.547-1.481l4.853-.704L9.132 2.884Z" clip-rule="evenodd" /></svg>
                                            @else
                                                <svg class="w-4 h-4 text-gray-300" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.83 4.401 4.853.704c.806.117 1.13.916.547 1.481l-3.51 3.42.83 4.83c.135.798-.703 1.403-1.416 1.004L10 15.17l-4.325 2.274c-.713.398-1.55-.206-1.416-1.004l.83-4.83-3.51-3.42c-.583-.565-.259-1.364.547-1.481l4.853-.704L9.132 2.884Z" clip-rule="evenodd" /></svg>
                                            @endif
                                        @endfor
                                        <span class="text-xs text-gray-500 ml-1.5">({{ $buku->rating_buku ?? 'N/A' }})</span>
                                    </div>
                                    
                                    <!-- Status -->
                                    <div class="mt-auto">
                                        @if ($buku->jumlah_buku > 0)
                                            <span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Tersedia</span>
                                        @else
                                            <span class="text-xs font-semibold bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Dipinjam</span>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </button>
                        @empty
                        <!-- Tampilan jika tidak ada buku (setelah difilter) -->
                        <div class="col-span-1 sm:col-span-2 lg:col-span-3 xl:col-span-4 text-center py-12">
                            <h3 class="text-lg font-semibold text-gray-700">Tidak Ada Buku Ditemukan</h3>
                            <p class="text-gray-500 mt-2">Coba ganti kata kunci pencarian atau filter Anda.</p>
                        </div>
                        @endforelse
                        
                    </div>

                    <!-- Paginasi (dari controller) -->
                    <div class="mt-10">
                        <!-- Ini akan otomatis menampilkan link paginasi jika ada > 12 buku. -->
                        {{ $bukus->links() }}
                    </div>

                </main>
            </div>
        </form> <!-- Penutup <form> filter -->
    </div>
</div>


<!-- =================================== -->
<!-- MODAL 1: DETAIL BUKU (Tersembunyi) -->
<!-- =================================== -->
<div id="detailModal" class="fixed inset-0 bg-black bg-opacity-75 z-50 flex items-center justify-center p-4 hidden">
    <!-- Konten Modal -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-4xl max-h-[90vh] overflow-hidden relative">
        
        <!-- Header Modal -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Detail Buku</h3>
            <button id="closeDetailModalBtn" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Body Modal -->
        <div class="flex flex-col md:flex-row p-4 max-h-[calc(90vh-130px)] overflow-y-auto">

            <!-- Kiri: Gambar -->
            <div class="w-full md:w-1/3 flex-shrink-0 p-2">
                <div class="aspect-[3/4] border-2 border-gray-300 rounded-lg overflow-hidden bg-gray-100">
                    <img id="modal-cover" src="https://placehold.co/400x600/e2e8f0/cccccc?text=Loading..." alt="Cover Buku" class="w-full h-full object-contain">
                </div>
            </div>

            <!-- Kanan: Info -->
            <div class="w-full md:w-2/3 p-2 flex flex-col">
                <h2 id="modal-title" class="text-3xl font-bold text-gray-900 mb-2">Nama Buku Loading...</h2>
                <p id="modal-author" class="text-lg text-gray-600 mb-3">Nama Penulis</p>

                <!-- Rating & Status -->
                <div class="flex items-center gap-4 mb-4">
                    <div class="flex items-center">
                        <div id="modal-rating-stars" class="flex items-center"></div>
                        <span id="modal-rating-text" class="text-sm text-gray-600 ml-2">(N/A)</span>
                    </div>
                    <div id="modal-status-badge"></div>
                </div>

                <!-- Info Grid -->
                <div class="grid grid-cols-2 gap-x-6 gap-y-2 text-sm text-gray-700 mb-4">
                    <span class="font-semibold text-gray-500">ISBN:</span>
                    <span id="modal-isbn" class="font-medium">...</span>
                    <span class="font-semibold text-gray-500">Penerbit:</span>
                    <span id="modal-penerbit" class="font-medium">...</span>
                    <span class="font-semibold text-gray-500">Tahun:</span>
                    <span id="modal-tahun" class="font-medium">...</span>
                    <span class="font-semibold text-gray-500">Halaman:</span>
                    <span id="modal-halaman" class="font-medium">...</span>
                    <span class="font-semibold text-gray-500">Kategori:</span>
                    <span id="modal-kategori" class="font-medium">...</span>
                </div>

                <!-- Deskripsi -->
                <div class="mt-4 border-t pt-4">
                    <h4 class="font-semibold text-gray-800 mb-2">Deskripsi</h4>
                    <p id="modal-deskripsi" class="text-gray-600 text-sm leading-relaxed">...</p>
                </div>

                <!-- Tombol Pinjam (Footer Modal) -->
                <div class="mt-auto pt-6">
                    <button id="openPinjamFormBtn" class="w-full bg-perpustakaan-blue hover:bg-blue-800 text-white font-bold py-3 px-6 rounded-lg shadow-md transition duration-300 ease-in-out flex items-center justify-center gap-2">
                        <svg class="w-5 h-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"><path fill-rule="evenodd" d="M15.5 4.125a.75.75 0 0 0-1.5 0V6a2 2 0 0 0-2-2h-5a2 2 0 0 0-2 2v10a2 2 0 0 0 2 2h5a2 2 0 0 0 2-2V6a.75.75 0 0 0-.5-.707ZM12 6h-5v10h5V6Z" clip-rule="evenodd" /></svg>
                        Pinjam Buku Sekarang
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- =================================== -->
<!-- MODAL 2: FORM PINJAM (Tersembunyi) -->
<!-- =================================== -->
<div id="pinjamModal" class="fixed inset-0 bg-black bg-opacity-75 z-[60] flex items-center justify-center p-4 hidden">
    <!-- Konten Modal -->
    <div class="bg-white rounded-lg shadow-xl w-full max-w-lg overflow-hidden relative">
        
        <!-- Header Modal -->
        <div class="flex justify-between items-center p-4 border-b border-gray-200">
            <h3 class="text-xl font-bold text-gray-800">Form Peminjaman Buku</h3>
            <button id="closePinjamModalBtn" class="text-gray-500 hover:text-gray-800">
                <svg class="w-6 h-6" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="2" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
                </svg>
            </button>
        </div>

        <!-- Form Peminjaman -->
        <form action="{{ route('buku.pinjam') }}" method="POST">
            @csrf
            <!-- ID Buku (Tersembunyi) -->
            <input type="hidden" name="buku_id" id="pinjam-buku-id" value="">

            <div class="p-6 space-y-4">
                <!-- Judul Buku (Read-only) -->
                <div>
                    <label for="pinjam-nama-buku" class="block text-sm font-medium text-gray-700 mb-1">Judul Buku</label>
                    <input type="text" id="pinjam-nama-buku" class="w-full border-gray-300 rounded-lg shadow-sm bg-gray-100" value="Nama Buku..." readonly>
                </div>

                <!-- Durasi Peminjaman (Input Angka) -->
                <div>
                    <label for="pinjam-durasi" class="block text-sm font-medium text-gray-700 mb-1">Durasi Peminjaman (hari)</label>
                    <input type="number" name="durasi_peminjaman_hari" id="pinjam-durasi" min="1" max="30" value="14" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('durasi_peminjaman_hari')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
                
                <!-- Tanggal Pinjam -->
                <div>
                    <label for="pinjam-tanggal" class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pinjam</label>
                    <input type="date" name="tanggal_pinjam" id="pinjam-tanggal" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    @error('tanggal_pinjam')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>

                <!-- Catatan (Opsional) -->
                <div>
                    <label for="pinjam-catatan" class="block text-sm font-medium text-gray-700 mb-1">Catatan (Opsional)</label>
                    <textarea name="catatan" id="pinjam-catatan" rows="3" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Tambahkan catatan jika diperlukan..."></textarea>
                    @error('catatan')
                        <span class="text-red-500 text-sm">{{ $message }}</span>
                    @enderror
                </div>
            </div>

            <!-- Footer Modal (Tombol Aksi) -->
            <div class="flex items-center justify-end p-4 bg-gray-50 border-t border-gray-200 space-x-3">
                <button type="button" id="cancelPinjamBtn" class="bg-white hover:bg-gray-100 text-gray-700 font-bold py-2 px-4 rounded-lg border border-gray-300 transition duration-300">
                    Batal
                </button>
                <button type="submit" class="bg-perpustakaan-blue hover:bg-blue-800 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Konfirmasi Pinjam
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<!-- JAVASCRIPT UNTUK MODAL -->
<script>
    document.addEventListener('DOMContentLoaded', function () {
        // === Variabel Global ===
        const storageBaseUrl = "{{ rtrim(Storage::url(''), '/') }}";
        let currentBookData = null; 

        // === Elemen Modal Detail ===
        const detailModal = document.getElementById('detailModal');
        const closeDetailModalBtn = document.getElementById('closeDetailModalBtn');
        const openModalBtns = document.querySelectorAll('.openModalBtn');
        const modalCover = document.getElementById('modal-cover');
        const modalTitle = document.getElementById('modal-title');
        const modalAuthor = document.getElementById('modal-author');
        const modalRatingStars = document.getElementById('modal-rating-stars');
        const modalRatingText = document.getElementById('modal-rating-text');
        const modalStatusBadge = document.getElementById('modal-status-badge');
        const modalIsbn = document.getElementById('modal-isbn');
        const modalPenerbit = document.getElementById('modal-penerbit');
        const modalTahun = document.getElementById('modal-tahun');
        const modalHalaman = document.getElementById('modal-halaman');
        const modalKategori = document.getElementById('modal-kategori');
        const modalDeskripsi = document.getElementById('modal-deskripsi');
        const openPinjamFormBtn = document.getElementById('openPinjamFormBtn');

        // === Elemen Modal Pinjam ===
        const pinjamModal = document.getElementById('pinjamModal');
        const closePinjamModalBtn = document.getElementById('closePinjamModalBtn');
        const cancelPinjamBtn = document.getElementById('cancelPinjamBtn');
        const pinjamBukuIdInput = document.getElementById('pinjam-buku-id');
        const pinjamNamaBukuInput = document.getElementById('pinjam-nama-buku');
        const pinjamTanggalInput = document.getElementById('pinjam-tanggal');

        // === Fungsi untuk membuka Modal Detail ===
        const openDetailModal = async (bookId) => {
            if (!bookId) return;

            detailModal.classList.remove('hidden'); 
            document.body.classList.add('overflow-hidden');
            resetDetailModalContent(); 

            try {
                const routeUrl = "{{ route('buku.detail', ['buku' => ':id']) }}".replace(':id', bookId);
                const response = await fetch(routeUrl);
                
                if (!response.ok) {
                    throw new Error(`Gagal mengambil data buku: ${response.statusText}`);
                }
                const buku = await response.json();
                currentBookData = buku; 
                populateDetailModal(buku); 

            } catch (error) {
                console.error(error);
                modalTitle.textContent = 'Gagal Memuat Data';
                modalDeskripsi.textContent = 'Terjadi kesalahan saat mengambil detail buku. Silakan coba lagi.';
            }
        };

        // === Fungsi untuk mengisi konten Modal Detail ===
        const populateDetailModal = (buku) => {
            // URL cover
            if (buku.cover_thumbnail_url) {
                modalCover.src = `${storageBaseUrl}/${buku.cover_thumbnail_url}`;
                modalCover.alt = buku.nama_buku;
            } else {
                modalCover.src = `https://placehold.co/400x600/e2e8f0/cccccc?text=No+Cover`;
                modalCover.alt = "No Cover";
            }
            
            // Info Teks
            modalTitle.textContent = buku.nama_buku;
            modalAuthor.textContent = buku.nama_penulis;
            modalIsbn.textContent = buku.nomor_isbn;
            modalPenerbit.textContent = buku.penerbit;
            modalTahun.textContent = buku.tahun_buku;
            modalHalaman.textContent = `${buku.jumlah_halaman} halaman`;
            modalKategori.textContent = buku.kategori ? buku.kategori.nama_kategori : 'Tidak ada kategori';
            modalDeskripsi.textContent = buku.deskripsi_buku;

            // Rating Bintang
            const rating = Math.round(buku.rating_buku || 0);
            modalRatingStars.innerHTML = '';
            for (let i = 1; i <= 5; i++) {
                const starSvg = `
                    <svg class="w-5 h-5 ${i <= rating ? 'text-yellow-400' : 'text-gray-300'}" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor">
                        <path fill-rule="evenodd" d="M10.868 2.884c.321-.772 1.415-.772 1.736 0l1.83 4.401 4.853.704c.806.117 1.13.916.547 1.481l-3.51 3.42.83 4.83c.135.798-.703 1.403-1.416 1.004L10 15.17l-4.325 2.274c-.713.398-1.55-.206-1.416-1.004l.83-4.83-3.51-3.42c-.583-.565-.259-1.364.547-1.481l4.853-.704L9.132 2.884Z" clip-rule="evenodd" />
                    </svg>`;
                modalRatingStars.innerHTML += starSvg;
            }
            const ratingDisplay = buku.rating_buku ? parseFloat(buku.rating_buku).toFixed(1) : 'N/A';
            modalRatingText.textContent = `(${ratingDisplay})`;

            // Status Badge & Tombol
            if (buku.jumlah_buku > 0) {
                modalStatusBadge.innerHTML = `<span class="text-xs font-semibold bg-green-100 text-green-700 px-2 py-0.5 rounded-full">Tersedia</span>`;
                openPinjamFormBtn.disabled = false;
                openPinjamFormBtn.classList.remove('opacity-50', 'cursor-not-allowed');
            } else {
                modalStatusBadge.innerHTML = `<span class="text-xs font-semibold bg-red-100 text-red-700 px-2 py-0.5 rounded-full">Dipinjam</span>`;
                openPinjamFormBtn.disabled = true;
                openPinjamFormBtn.classList.add('opacity-50', 'cursor-not-allowed');
            }
        };

        // === Fungsi untuk mengosongkan Modal Detail (state loading) ===
        const resetDetailModalContent = () => {
            modalCover.src = 'https://placehold.co/400x600/e2e8f0/cccccc?text=Loading...';
            modalCover.alt = 'Loading...';
            modalTitle.textContent = 'Nama Buku Loading...';
            modalAuthor.textContent = 'Nama Penulis';
            modalRatingStars.innerHTML = '';
            modalRatingText.textContent = '(N/A)';
            modalStatusBadge.innerHTML = '';
            modalIsbn.textContent = '...';
            modalPenerbit.textContent = '...';
            modalTahun.textContent = '...';
            modalHalaman.textContent = '...';
            modalKategori.textContent = '...';
            modalDeskripsi.textContent = 'Deskripsi buku akan dimuat di sini...';
            openPinjamFormBtn.disabled = true;
            openPinjamFormBtn.classList.add('opacity-50', 'cursor-not-allowed');
        };

        // === Fungsi untuk menutup Modal Detail ===
        const closeDetailModal = () => {
            detailModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
            currentBookData = null; // Hapus data buku
        };

        // === Fungsi untuk membuka Modal Pinjam ===
        const openPinjamModal = () => {
            if (!currentBookData) return; 

            // Isi form dengan data dari modal sebelumnya
            pinjamBukuIdInput.value = currentBookData.id;
            pinjamNamaBukuInput.value = currentBookData.nama_buku;
            
            // Atur tanggal pinjam default ke hari ini
            pinjamTanggalInput.value = new Date().toISOString().split('T')[0];

            // Tutup modal detail, buka modal pinjam
            closeDetailModal();
            pinjamModal.classList.remove('hidden');
            document.body.classList.add('overflow-hidden'); 
        };

        // === Fungsi untuk menutup Modal Pinjam ===
        const closePinjamModal = () => {
            pinjamModal.classList.add('hidden');
            document.body.classList.remove('overflow-hidden');
        };

        // === Event Listeners ===
        
        // Buka Modal Detail saat kartu buku diklik
        openModalBtns.forEach(btn => {
            btn.addEventListener('click', () => {
                const bookId = btn.dataset.id;
                openDetailModal(bookId);
            });
        });

        // Tutup Modal Detail
        closeDetailModalBtn.addEventListener('click', closeDetailModal);

        // Buka Modal Pinjam (dari dalam Modal Detail)
        openPinjamFormBtn.addEventListener('click', openPinjamModal);

        // Tutup Modal Pinjam
        closePinjamModalBtn.addEventListener('click', closePinjamModal);
        cancelPinjamBtn.addEventListener('click', (e) => {
            e.preventDefault(); 
            closePinjamModal();
        });

        // (Opsional) Tutup modal jika klik di luar area konten
        detailModal.addEventListener('click', (e) => {
            if (e.target === detailModal) closeDetailModal();
        });
        pinjamModal.addEventListener('click', (e) => {
            if (e.target === pinjamModal) closePinjamModal();
        });

        // (Opsional) Tutup modal dengan tombol Escape
        document.addEventListener('keydown', (e) => {
            if (e.key === "Escape") {
                if (!detailModal.classList.contains('hidden')) closeDetailModal();
                if (!pinjamModal.classList.contains('hidden')) closePinjamModal();
            }
        });
    });
</script>
@endpush

