@extends('layouts.app')

@section('title', 'Riwayat Peminjaman - Perpustakaan Digital')

@section('content')
<div class="bg-gray-50 py-12 md:py-16 min-h-screen">
    <div class="container mx-auto px-4">
        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-8">Riwayat Peminjaman</h1>

        <div class="bg-white rounded-lg shadow-sm border border-gray-200 overflow-hidden">
            <div class="hidden md:grid grid-cols-6 gap-4 px-6 py-4 bg-gray-50 border-b border-gray-200">
                <div class="col-span-2 text-sm font-semibold text-gray-600 uppercase">Buku</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Tanggal Pinjam</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Batas Kembali</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Status</div>
                <div class="text-sm font-semibold text-gray-600 uppercase">Aksi</div>
            </div>

            <div class="divide-y divide-gray-200">
                @forelse($peminjamans as $peminjaman)
                <div class="grid grid-cols-1 md:grid-cols-6 gap-4 px-6 py-5 items-center">
                    <div class="col-span-2 flex items-center space-x-4">
                        @if($peminjaman->buku->cover_thumbnail_url)
                            <img src="{{ Storage::url($peminjaman->buku->cover_thumbnail_url) }}"
                                 alt="{{ $peminjaman->buku->nama_buku }}"
                                 class="w-16 h-20 object-cover rounded">
                        @else
                            <img src="https://placehold.co/80x100/e2e8f0/718096?text=No+Image"
                                 alt="{{ $peminjaman->buku->nama_buku }}"
                                 class="w-16 h-20 object-cover rounded">
                        @endif
                        <div>
                            <p class="font-semibold text-gray-900">{{ $peminjaman->buku->nama_buku }}</p>
                            <p class="text-sm text-gray-600">{{ $peminjaman->buku->nama_penulis }}</p>
                            @if($peminjaman->ulasan)
                                <p class="text-sm text-gray-600 mt-1"><strong>Ulasan:</strong> {{ $peminjaman->ulasan }}</p>
                            @endif
                        </div>
                    </div>

                    <div class="text-gray-700">
                        <span class="md:hidden font-semibold">Tgl Pinjam: </span>
                        {{ $peminjaman->tanggal_pinjam->format('d F Y') }}
                    </div>

                    <div class="text-gray-700">
                        <span class="md:hidden font-semibold">Batas: </span>
                        {{ $peminjaman->batas_kembali->format('d F Y') }}
                    </div>

                    <div>
                        @php
                            $status = 'Sedang Dipinjam';
                            $statusClass = 'bg-blue-100 text-blue-700';
                            $today = now()->toDateString();
                            if ($peminjaman->tanggal_pengembalian_aktual) {
                                $status = 'Dikembalikan';
                                $statusClass = 'bg-green-100 text-green-700';
                            } elseif ($peminjaman->batas_kembali->toDateString() < $today) {
                                $status = 'Terlambat';
                                $statusClass = 'bg-red-100 text-red-700';
                            }
                        @endphp
                        <span class="inline-block px-3 py-1 text-sm font-semibold rounded-full {{ $statusClass }}">
                            {{ $status }}
                        </span>
                    </div>

                    <!-- Aksi -->
                    <div class="flex space-x-4 text-sm font-medium">
                        @if($status == 'Dikembalikan')
                            <a href="{{ route('peminjaman') }}?search={{ urlencode($peminjaman->buku->nama_buku) }}" 
                               class="text-blue-600 hover:text-blue-800 transition-colors">
                               Pinjam Lagi
                            </a>

                            @if(!$peminjaman->ulasan)
                                <button onclick="openUlasanModal({{ $peminjaman->id }}, '{{ addslashes($peminjaman->buku->nama_buku) }}')" 
                                        class="text-gray-500 hover:text-gray-700 transition-colors">
                                    Ulasan
                                </button>
                            @else
                                <span class="text-green-600 italic">Sudah diulas</span>
                            @endif

                        @elseif($status == 'Sedang Dipinjam')
                            <div class="relative inline-block">
                                <button onclick="togglePerpanjangForm({{ $peminjaman->id }})"
                                    class="flex items-center bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1.5 px-3 rounded-lg shadow-sm transition-all duration-200 ease-in-out hover:shadow-md">
                                    <i class="fas fa-clock mr-1.5"></i> Perpanjang
                                </button>

                                <form id="perpanjang-form-{{ $peminjaman->id }}" 
                                      method="POST" 
                                      action="{{ route('riwayat.perpanjang', $peminjaman->id) }}" 
                                      class="absolute z-10 mt-2 hidden bg-white border border-gray-200 rounded-lg shadow-lg p-3 space-y-2 w-44 transition-all duration-300 ease-in-out">
                                    @csrf
                                    <label class="text-xs text-gray-700 font-medium">Tambahan Hari</label>
                                    <input type="number" name="hari_perpanjangan" min="1" max="30" value="7"
                                           class="w-full px-2 py-1 border rounded text-sm focus:ring-2 focus:ring-blue-400 focus:outline-none" required>
                                    <button type="submit"
                                        onclick="return confirm('Apakah Anda yakin ingin memperpanjang peminjaman ini?')"
                                        class="w-full bg-blue-600 hover:bg-blue-700 text-white font-semibold py-1 px-3 rounded text-sm transition-all duration-200">
                                        Konfirmasi
                                    </button>
                                </form>
                            </div>

                            <form method="POST" action="{{ route('riwayat.kembalikan', $peminjaman->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-red-600 hover:text-red-800 transition-colors">Kembalikan</button>
                            </form>

                        @else
                            <a href="#" class="text-red-600 hover:text-red-800">Bayar Denda</a>
                            <form method="POST" action="{{ route('riwayat.kembalikan', $peminjaman->id) }}" class="inline">
                                @csrf
                                <button type="submit" class="text-gray-500 hover:text-gray-700">Kembalikan</button>
                            </form>
                        @endif
                    </div>
                </div>
                @empty
                <div class="px-6 py-8 text-center text-gray-500">
                    <p>Belum ada riwayat peminjaman.</p>
                    <a href="{{ route('peminjaman') }}" class="text-blue-600 hover:text-blue-800 mt-2 inline-block">Mulai pinjam buku</a>
                </div>
                @endforelse
            </div>
        </div>
    </div>
</div>

<!-- Modal Ulasan -->
<div id="ulasanModal" class="fixed inset-0 bg-black bg-opacity-40 hidden items-center justify-center z-50">
    <div class="bg-white rounded-lg shadow-xl w-96 p-6 relative">
        <h2 id="ulasanJudul" class="text-lg font-semibold text-gray-800 mb-4">Beri Ulasan</h2>
        <form id="ulasanForm" method="POST" action="">
            @csrf
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Ulasan Anda</label>
                <textarea name="ulasan" rows="4" required
                    class="w-full border rounded px-2 py-1 focus:ring-2 focus:ring-blue-400 focus:outline-none"
                    placeholder="Tulis ulasan tentang buku ini..."></textarea>
            </div>
            <div class="flex justify-end space-x-2">
                <button type="button" onclick="closeUlasanModal()" 
                        class="px-3 py-1.5 rounded bg-gray-300 hover:bg-gray-400 text-gray-700">Batal</button>
                <button type="submit" 
                        class="px-3 py-1.5 rounded bg-blue-600 hover:bg-blue-700 text-white">Kirim</button>
            </div>
        </form>
    </div>
</div>
@endsection

<!-- Script -->
<script>
function togglePerpanjangForm(id) {
    const form = document.getElementById('perpanjang-form-' + id);
    form.classList.toggle('hidden');
    if (!form.classList.contains('hidden')) {
        form.style.opacity = 0;
        form.style.transform = "translateY(-5px)";
        setTimeout(() => {
            form.style.opacity = 1;
            form.style.transform = "translateY(0)";
        }, 50);
    }
}

function openUlasanModal(id, namaBuku) {
    document.getElementById('ulasanModal').classList.remove('hidden');
    document.getElementById('ulasanModal').classList.add('flex');
    document.getElementById('ulasanJudul').innerText = "Ulasan untuk " + namaBuku;
    document.getElementById('ulasanForm').action = "/riwayat/ulasan/" + id;
}

function closeUlasanModal() {
    document.getElementById('ulasanModal').classList.add('hidden');
    document.getElementById('ulasanModal').classList.remove('flex');
}
</script>
