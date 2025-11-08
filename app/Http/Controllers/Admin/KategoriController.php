<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
    /**
     * Menampilkan daftar kategori.
     */
    public function index()
    {
        $kategoris = Kategori::orderBy('nama_kategori')->paginate(10);
        return view('admin.kategori.index', compact('kategoris'));
    }

    /**
     * Menyimpan kategori baru dari form 'quick add'.
     */
    public function store(Request $request)
    {
        // 1. Validasi input
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori') // Pastikan nama kategori unik
            ]
        ], [
            'nama_kategori.unique' => 'Kategori dengan nama ini sudah ada.'
        ]);

        // 2. Simpan ke database
        Kategori::create([
            'nama_kategori' => $request->nama_kategori
        ]);

        // 3. Kembali ke halaman sebelumnya dengan pesan sukses
        // Kita gunakan key 'success_kategori' agar tidak bentrok dengan pesan sukses upload buku
        return back()->with('success_kategori', 'Kategori baru berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit kategori.
     */
    public function edit(Kategori $kategori)
    {
        return view('admin.kategori.edit', compact('kategori'));
    }

    /**
     * Update kategori.
     */
    public function update(Request $request, Kategori $kategori)
    {
        $request->validate([
            'nama_kategori' => [
                'required',
                'string',
                'max:255',
                Rule::unique('kategori', 'nama_kategori')->ignore($kategori->id)
            ]
        ], [
            'nama_kategori.unique' => 'Kategori dengan nama ini sudah ada.'
        ]);

        $kategori->update([
            'nama_kategori' => $request->nama_kategori
        ]);

        return redirect()->route('admin.kategori.index')->with('success', 'Kategori berhasil diperbarui!');
    }

    /**
     * Hapus kategori.
     */
    public function destroy(Kategori $kategori)
    {
        // Cek apakah kategori masih digunakan oleh buku
        if ($kategori->bukus()->exists()) {
            return back()->with('error', 'Kategori tidak dapat dihapus karena masih digunakan oleh buku.');
        }

        $kategori->delete();

        return back()->with('success', 'Kategori berhasil dihapus!');
    }
}
