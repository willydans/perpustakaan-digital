<?php

namespace App\Http\Controllers;

use App\Models\Buku;
use App\Models\Kategori;
use App\Models\Peminjaman;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon; // Pastikan 'use Carbon\Carbon' ada di atas

class PeminjamanController extends Controller
{
    /**
     * (REVISI BESAR)
     * Menampilkan halaman katalog buku (peminjaman)
     * Sekarang dengan logika filter & search
     */
    public function index(Request $request)
    {
        // (2) Ambil semua kategori untuk sidebar
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();

        // (3) Mulai query dasar untuk buku
        $query = Buku::query();

        // (4) Terapkan filter berdasarkan input 'search'
        if ($request->has('search') && $request->input('search') != '') {
            $searchTerm = $request->input('search');
            // 'where' di dalam 'function' untuk mengelompokkan query 'OR'
            $query->where(function($q) use ($searchTerm) {
                $q->where('nama_buku', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nama_penulis', 'like', '%' . $searchTerm . '%')
                  ->orWhere('nomor_isbn', 'like', '%' . $searchTerm . '%');
            });
        }

        // (5) Terapkan filter berdasarkan input 'kategori'
        if ($request->has('kategori') && $request->input('kategori') != 'semua' && $request->input('kategori') != '') {
            $query->where('kategori_id', $request->input('kategori'));
        }

        // (6) Terapkan filter berdasarkan input 'ketersediaan'
        if ($request->has('ketersediaan') && $request->input('ketersediaan') != 'semua') {
            if ($request->input('ketersediaan') == 'tersedia') {
                $query->where('jumlah_buku', '>', 0);
            } elseif ($request->input('ketersediaan') == 'dipinjam') {
                $query->where('jumlah_buku', '<=', 0); // Stok 0 atau kurang
            }
        }

        // (REVISI BARU) Terapkan filter berdasarkan input 'tahun'
        if ($request->has('tahun') && $request->input('tahun') != 'semua') {
            $tahunValue = $request->input('tahun');
            
            if ($tahunValue == '2021-2025') {
                $query->whereBetween('tahun_buku', [2021, 2025]);
            } elseif ($tahunValue == '2011-2020') {
                $query->whereBetween('tahun_buku', [2011, 2020]);
            } elseif ($tahunValue == '2000-2010') {
                $query->whereBetween('tahun_buku', [2000, 2010]);
            }
            // Anda bisa tambahkan 'else' untuk tahun yang lebih lama jika perlu
        }

        // (7) Eksekusi query dengan paginasi (12 buku per halaman)
        // 'withQueryString()' akan memastikan filter (misal: ?search=...) 
        // tetap ada di link paginasi (halaman 1, 2, 3)
        $bukus = $query->latest()->paginate(12)->withQueryString();

        // (8) Tampilkan view dan kirim data yang sudah difilter
        return view('peminjaman', compact('bukus', 'kategoris'));
    }

    /**
     * Menampilkan halaman detail buku lengkap.
     */
    public function show(Request $request, Buku $buku)
    {
        // Laravel otomatis akan mengambil data buku berdasarkan ID di URL.
        $buku->load('kategori'); // Ambil juga data relasi kategorinya

        // Ambil ulasan dari peminjam yang sudah mengembalikan buku
        $reviews = Peminjaman::where('buku_id', $buku->id)
            ->whereNotNull('ulasan')
            ->whereNotNull('tanggal_pengembalian_aktual')
            ->with('user:id,name')
            ->latest()
            ->get();

        // Jika request AJAX (untuk modal), kembalikan JSON
        if ($request->wantsJson()) {
            return response()->json([
                'buku' => $buku,
                'reviews' => $reviews
            ]);
        }

        // Kembalikan view dengan data buku dan ulasan
        return view('peminjaman-detail', compact('buku', 'reviews'));
    }

    /**
     * Menyimpan data dari Form Peminjaman Buku
     */
    public function pinjam(Request $request)
    {
        // 1. Validasi
        $validated = $request->validate([
            'buku_id' => 'required|integer|exists:data_buku,id',
            'tanggal_pinjam' => 'required|date',
            'durasi_peminjaman_hari' => 'required|integer|min:1|max:30',
            'catatan' => 'nullable|string|max:1000',
        ]);

        // 2. Dapatkan ID user
        $userId = Auth::id();
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk meminjam buku.');
        }

        // 3. Cek stok buku
        $buku = Buku::findOrFail($validated['buku_id']);
        if ($buku->jumlah_buku <= 0) {
            return back()->with('error_pinjam', 'Gagal meminjam, stok buku ini sudah habis.');
        }

        // 4. Hitung tanggal
        $tanggalPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $durasi = (int)$validated['durasi_peminjaman_hari'];
        $batasKembali = $tanggalPinjam->copy()->addDays($durasi);

        // 5. Simpan data
        try {
            // A. Catat transaksi
            Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $validated['buku_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'durasi_peminjaman_hari' => $validated['durasi_peminjaman_hari'],
                'batas_kembali' => $batasKembali,
                'catatan' => $validated['catatan'],
                'status' => 'Dipinjam',
            ]);

            // B. Kurangi stok
            $buku->decrement('jumlah_buku');

            // 6. Kembalikan
            return back()->with('success_pinjam', 'Buku berhasil dipinjam! Cek di halaman Riwayat Peminjaman.');

        } catch (\Exception $e) {
            report($e);
            return back()->with('error_pinjam', 'Terjadi kesalahan. Gagal meminjam buku.');
        }
    }

    /**
     * Menampilkan riwayat peminjaman untuk user yang sedang login
     */
    public function riwayat()
    {
        // Ambil data peminjaman user dengan relasi buku, diurutkan dari yang terbaru
        $peminjamans = Peminjaman::where('user_id', Auth::id())
            ->with('buku')
            ->latest()
            ->get();

        // Kirim data ke view
        return view('riwayat', compact('peminjamans'));
    }

    /**
     * Memperpanjang batas pengembalian buku berdasarkan input hari
     */
    public function perpanjang(Request $request, $id)
    {
        // Validasi input
        $validated = $request->validate([
            'hari_perpanjangan' => 'required|integer|min:1|max:30',
        ]);

        $peminjaman = Peminjaman::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Cek apakah buku sudah dikembalikan
        if ($peminjaman->tanggal_pengembalian_aktual) {
            return back()->with('error', 'Buku sudah dikembalikan, tidak dapat diperpanjang.');
        }

        // Perpanjang batas kembali berdasarkan input
        $hari = $validated['hari_perpanjangan'];
        $peminjaman->batas_kembali = $peminjaman->batas_kembali->addDays($hari);
        $peminjaman->save();

        return back()->with('success', 'Batas pengembalian berhasil diperpanjang ' . $hari . ' hari.');
    }

    /**
     * Mengembalikan buku
     */
    public function kembalikan($id)
    {
        $peminjaman = Peminjaman::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Cek apakah buku sudah dikembalikan
        if ($peminjaman->tanggal_pengembalian_aktual) {
            return back()->with('error', 'Buku sudah dikembalikan.');
        }

        try {
            // Set tanggal pengembalian aktual
            $peminjaman->tanggal_pengembalian_aktual = Carbon::now();
            $peminjaman->status = 'Dikembalikan';
            $peminjaman->save();

            // Tambah stok buku
            $peminjaman->buku->increment('jumlah_buku');

            return back()->with('success', 'Buku berhasil dikembalikan.');
        } catch (\Exception $e) {
            report($e);
            return back()->with('error', 'Terjadi kesalahan saat mengembalikan buku.');
        }
    }

    /**
     * Menyimpan ulasan untuk peminjaman yang sudah dikembalikan
     */
    public function ulasan(Request $request, $id)
    {
        $request->validate([
            'ulasan' => 'required|string|max:1000',
        ]);

        $peminjaman = Peminjaman::where('id', $id)->where('user_id', Auth::id())->firstOrFail();

        // Pastikan buku sudah dikembalikan dulu
        if (!$peminjaman->tanggal_pengembalian_aktual) {
            return back()->with('error', 'Anda hanya dapat memberi ulasan setelah mengembalikan buku.');
        }

        $peminjaman->ulasan = $request->ulasan;
        $peminjaman->save();

        return back()->with('success', 'Terima kasih atas ulasannya!');
    }

}

