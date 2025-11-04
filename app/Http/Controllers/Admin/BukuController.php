<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Buku; // Panggil Model Buku
use App\Models\Kategori; // Panggil Model Kategori
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage; // Panggil Storage untuk hapus file
use Illuminate\Validation\Rule; // Untuk validasi 'unique'

class BukuController extends Controller
{
    /**
     * Menampilkan halaman manajemen buku (form upload dan daftar buku)
     */
    public function index()
    {
        // Ambil semua data buku dari database
        // Kita pakai 'latest()' agar buku yang baru di-upload ada di atas
        $bukus = Buku::with('kategori')->latest()->get(); 
        
        // Ambil juga semua data kategori (untuk <select> dropdown)
        $kategoris = Kategori::orderBy('nama_kategori')->get();
        
        // Tampilkan view dan kirim data $bukus DAN $kategoris ke dalamnya
        return view('admin.buku', [
            'bukus' => $bukus,
            'kategoris' => $kategoris
        ]);
    }

    /**
     * Menyimpan buku baru (Upload)
     */
    public function store(Request $request)
    {
        // 1. Validasi SEMUA input dari form baru
        $validatedData = $request->validate([
            // Kolom Kiri
            'nama_buku' => 'required|string|max:255',
            'nama_penulis' => 'required|string|max:255',
            'nomor_isbn' => [
                'required',
                'string',
                'max:20',
                Rule::unique('data_buku', 'nomor_isbn') // Pastikan ISBN unik
            ],
            'penerbit' => 'required|string|max:255',
            
            // Kolom Kanan
            'kategori_id' => [
                'required',
                'integer',
                Rule::exists('kategori', 'id') // Pastikan kategori_id ada di tabel 'kategori'
            ],
            'tahun_buku' => 'required|integer|min:1800|max:' . (date('Y') + 1), // Tahun valid
            'jumlah_halaman' => 'required|integer|min:1',
            'jumlah_buku' => 'required|integer|min:0', // Stok boleh 0
            'rating_buku' => 'nullable|numeric|min:0|max:5', // Boleh kosong
            'cover' => 'required|image|mimes:jpeg,png,jpg,webp|max:2048', // Wajib gambar, maks 2MB
            
            // Kolom Bawah
            'deskripsi_buku' => 'required|string|min:10',
        ]);

        // 2. Simpan file gambar
        // Gambar akan disimpan di 'storage/app/public/covers'
        $path = $request->file('cover')->store('covers', 'public');

        // 3. Tambahkan path gambar ke data yang akan disimpan
        $validatedData['cover_thumbnail_url'] = $path;
        
        // Hapus 'cover' dari array, karena itu adalah file, bukan string path
        unset($validatedData['cover']); 

        // 4. Simpan SEMUA data ke database
        Buku::create($validatedData);

        // 5. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Buku berhasil di-upload!');
    }

    /**
     * Menghapus data buku (Delete)
     */
    public function destroy(Buku $buku) // <-- Route-Model Binding
    {
        // 1. Hapus file gambar dari storage
        // Pastikan file ada sebelum dihapus
        if ($buku->cover_thumbnail_url) {
            Storage::disk('public')->delete($buku->cover_thumbnail_url);
        }

        // 2. Hapus data buku dari database
        $buku->delete();

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        return back()->with('success', 'Buku berhasil dihapus!');
    }
}

