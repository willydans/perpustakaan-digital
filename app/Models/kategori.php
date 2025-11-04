<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Kategori extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel database secara eksplisit.
     * (Defaultnya Laravel akan mencari 'kategoris')
     */
    protected $table = 'kategori';

    /**
     * Izinkan Mass Assignment (agar 'Kategori::create()' berfungsi).
     * Ini memberi tahu Laravel bahwa semua kolom boleh diisi.
     */
    protected $guarded = [];

    /**
     * Definisikan relasi "hasMany" (satu-ke-banyak) ke model Buku.
     */
    public function bukus()
    {
        // Satu Kategori "memiliki banyak" (hasMany) Buku
        // 'kategori_id' adalah foreign key di tabel 'data_buku'
        return $this->hasMany(Buku::class, 'kategori_id');
    }
}

