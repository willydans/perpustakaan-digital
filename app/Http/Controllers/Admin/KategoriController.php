<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Kategori;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class KategoriController extends Controller
{
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
}
