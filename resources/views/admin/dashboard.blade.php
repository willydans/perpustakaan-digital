@extends('layouts.app')

@section('title', 'Dashboard Admin - Perpustakaan Digital')

@section('content')
<div class="container mx-auto px-4 py-12">

    <!-- =======================
    STATISTIK UTAMA
    ======================== -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-12">
        <!-- Total Buku -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-blue-100 text-blue-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.746 0 3.332.477 4.5 1.253v13C19.832 18.477 18.246 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Buku::count() }}</h3>
                    <p class="text-gray-600">Total Buku</p>
                </div>
            </div>
        </div>

        <!-- Total Kategori -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-green-100 text-green-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Kategori::count() }}</h3>
                    <p class="text-gray-600">Total Kategori</p>
                </div>
            </div>
        </div>

        <!-- Total User -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-purple-100 text-purple-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197m13.5-9a2.5 2.5 0 11-5 0 2.5 2.5 0 015 0z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\User::count() }}</h3>
                    <p class="text-gray-600">Total User</p>
                </div>
            </div>
        </div>

        <!-- Total Peminjaman Aktif -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <div class="flex items-center">
                <div class="p-3 rounded-full bg-orange-100 text-orange-600">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <div class="ml-4">
                    <h3 class="text-2xl font-bold text-gray-800">{{ \App\Models\Peminjaman::where('status', 'dipinjam')->count() }}</h3>
                    <p class="text-gray-600">Peminjaman Aktif</p>
                </div>
            </div>
        </div>
    </div>

    <!-- =======================
    GRAFIK DAN CHART (FIKTIF)
    ======================== -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
        <!-- Chart Peminjaman Bulanan -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Peminjaman Bulanan</h3>
            <div class="h-64 flex items-end justify-between space-x-2">
                <div class="flex-1 bg-blue-200 rounded-t text-center py-2" style="height: 40%">45</div>
                <div class="flex-1 bg-blue-300 rounded-t text-center py-2" style="height: 60%">67</div>
                <div class="flex-1 bg-blue-400 rounded-t text-center py-2" style="height: 80%">89</div>
                <div class="flex-1 bg-blue-500 rounded-t text-center py-2" style="height: 70%">78</div>
                <div class="flex-1 bg-blue-600 rounded-t text-center py-2" style="height: 90%">102</div>
                <div class="flex-1 bg-blue-700 rounded-t text-center py-2" style="height: 100%">115</div>
            </div>
            <div class="flex justify-between mt-2 text-sm text-gray-600">
                <span>Jan</span>
                <span>Feb</span>
                <span>Mar</span>
                <span>Apr</span>
                <span>Mei</span>
                <span>Jun</span>
            </div>
        </div>

        <!-- Buku Terpopuler -->
        <div class="bg-white p-6 rounded-lg shadow-lg">
            <h3 class="text-xl font-bold text-gray-800 mb-4">Buku Terpopuler</h3>
            <div class="space-y-4">
                @php
                    $popularBooks = \App\Models\Buku::withCount('peminjaman')->orderBy('peminjaman_count', 'desc')->take(5)->get();
                @endphp
                @forelse($popularBooks as $book)
                <div class="flex items-center space-x-4">
                    <div class="w-12 h-16 bg-gray-200 rounded flex items-center justify-center text-xs text-gray-500">
                        @if($book->cover_thumbnail_url)
                            <img src="{{ Storage::url($book->cover_thumbnail_url) }}" alt="{{ $book->nama_buku }}" class="w-full h-full object-cover rounded">
                        @else
                            No Cover
                        @endif
                    </div>
                    <div class="flex-1">
                        <h4 class="font-semibold text-gray-800">{{ Str::limit($book->nama_buku, 30) }}</h4>
                        <p class="text-sm text-gray-600">{{ $book->nama_penulis }}</p>
                    </div>
                    <div class="text-right">
                        <span class="text-lg font-bold text-blue-600">{{ $book->peminjaman_count }}</span>
                        <p class="text-xs text-gray-500">dipinjam</p>
                    </div>
                </div>
                @empty
                <p class="text-gray-500">Belum ada data peminjaman</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- =======================
    TABEL PEMINJAMAN TERBARU
    ======================== -->
    <div class="bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Peminjaman Terbaru</h3>
        <div class="overflow-x-auto">
            <table class="min-w-full divide-y divide-gray-200">
                <thead class="bg-gray-50">
                    <tr>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">User</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Buku</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Tanggal Pinjam</th>
                        <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                    </tr>
                </thead>
                <tbody class="bg-white divide-y divide-gray-200">
                    @php
                        $recentLoans = \App\Models\Peminjaman::with(['user', 'buku'])->latest()->take(5)->get();
                    @endphp
                    @forelse($recentLoans as $loan)
                    <tr>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm font-medium text-gray-900">{{ $loan->user->name }}</div>
                            <div class="text-sm text-gray-500">{{ $loan->user->email }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <div class="text-sm text-gray-900">{{ Str::limit($loan->buku->nama_buku, 30) }}</div>
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap text-sm text-gray-500">
                            {{ $loan->tanggal_pinjam->format('d M Y') }}
                        </td>
                        <td class="px-6 py-4 whitespace-nowrap">
                            <span class="px-2 inline-flex text-xs leading-5 font-semibold rounded-full
                                @if($loan->status == 'dipinjam') bg-green-100 text-green-800
                                @elseif($loan->status == 'dikembalikan') bg-gray-100 text-gray-800
                                @else bg-yellow-100 text-yellow-800 @endif">
                                {{ ucfirst($loan->status) }}
                            </span>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="4" class="px-6 py-4 text-center text-sm text-gray-500">
                            Belum ada data peminjaman
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    <!-- =======================
    QUICK ACTIONS
    ======================== -->
    <div class="mt-12 bg-white p-6 rounded-lg shadow-lg">
        <h3 class="text-xl font-bold text-gray-800 mb-4">Quick Actions</h3>
        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
            <a href="{{ route('admin.buku.index') }}" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-300">
                Kelola Buku
            </a>
            <a href="{{ route('admin.kategori.index') }}" class="bg-purple-600 hover:bg-purple-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-300">
                Kelola Kategori
            </a>
            <a href="{{ route('admin.user.index') }}" class="bg-green-600 hover:bg-green-700 text-white font-bold py-3 px-4 rounded-lg text-center transition duration-300">
                Kelola User
            </a>
        </div>
    </div>
</div>
@endsection
