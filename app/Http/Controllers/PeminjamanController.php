<?php

namespace App\Http\Controllers;

use App\Models\Buku;       // Panggil Model Buku
use App\Models\Kategori;   // Panggil Model Kategori
use App\Models\Peminjaman; // Panggil Model Peminjaman
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;    // (PENTING) Untuk mendapatkan user yang login
use Carbon\Carbon;                      // (PENTING) Untuk menghitung tanggal

class PeminjamanController extends Controller
{
    /**
     * Menampilkan halaman katalog buku (peminjaman)
     */
    public function index()
    {
        // Ambil data buku untuk katalog
        $bukus = Buku::latest()->paginate(12); 
        
        // Ambil data kategori untuk sidebar filter
        $kategoris = Kategori::orderBy('nama_kategori', 'asc')->get();

        // Tampilkan view dan kirim data $bukus dan $kategoris
        return view('peminjaman', compact('bukus', 'kategoris'));
    }

    /**
     * Menampilkan data satu buku sebagai JSON untuk modal.
     */
    public function show(Buku $buku)
    {
        // Laravel otomatis akan mengambil data buku berdasarkan ID di URL.
        $buku->load('kategori'); // Ambil juga data relasi kategorinya
        
        // Kembalikan data sebagai JSON
        return response()->json($buku);
    }

    /**
     * ========================================================
     * (METHOD BARU)
     * Menyimpan data dari Form Peminjaman Buku
     * ========================================================
     */
    public function pinjam(Request $request)
    {
        // 1. Validasi input dari form modal peminjaman
        $validated = $request->validate([
            'buku_id' => 'required|integer|exists:data_buku,id',
            'tanggal_pinjam' => 'required|date',
            // (REVISI) Validasi durasi sebagai angka
            'durasi_peminjaman_hari' => 'required|integer|min:1|max:30', // Maks 30 hari
            'catatan' => 'nullable|string|max:1000',
        ]);

        // 2. Dapatkan ID user yang sedang login
        //    Ini adalah implementasi Kriteria UTP "Autentikasi" Anda
        $userId = Auth::id();

        // Jika tidak ada user yang login (misal, belum login), kembalikan ke halaman login
        if (!$userId) {
            return redirect()->route('login')->with('error', 'Anda harus login untuk meminjam buku.');
        }

        // 3. Cek stok buku
        $buku = Buku::findOrFail($validated['buku_id']);
        if ($buku->jumlah_buku <= 0) {
            // Jika stok 0, kembalikan dengan pesan error
            return back()->with('error_pinjam', 'Gagal meminjam, stok buku ini sudah habis.');
        }

        // 4. Hitung tanggal batas kembali
        $tanggalPinjam = Carbon::parse($validated['tanggal_pinjam']);
        $durasi = (int)$validated['durasi_peminjaman_hari'];
        $batasKembali = $tanggalPinjam->copy()->addDays($durasi);

        // 5. Simpan data peminjaman ke database
        try {
            // A. Catat transaksi peminjaman
            Peminjaman::create([
                'user_id' => $userId,
                'buku_id' => $validated['buku_id'],
                'tanggal_pinjam' => $validated['tanggal_pinjam'],
                'durasi_peminjaman_hari' => $validated['durasi_peminjaman_hari'],
                'batas_kembali' => $batasKembali,
                'catatan' => $validated['catatan'],
                'status' => 'Dipinjam', // Status default
            ]);

            // B. Kurangi stok buku (-1)
            $buku->decrement('jumlah_buku');

            // 6. Kembalikan ke halaman katalog dengan pesan sukses
            return back()->with('success_pinjam', 'Buku berhasil dipinjam! Cek di halaman Riwayat Peminjaman.');

        } catch (\Exception $e) {
            // Jika terjadi error (misal, database mati), kembalikan dengan pesan error
            report($e); // Laporkan error
            return back()->with('error_pinjam', 'Terjadi kesalahan. Gagal meminjam buku.');
        }
    }
}