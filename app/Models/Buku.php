<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo; // (Relasi lama)
use Illuminate\Database\Eloquent\Relations\HasMany;   // (Relasi BARU)

class Buku extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'data_buku';

    /**
     * Kolom yang dikecualikan dari mass assignment.
     * Mengizinkan semua kolom diisi via Buku::create()
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Definisikan relasi "belongsTo" ke model Kategori.
     * (Relasi ini sudah ada sebelumnya)
     * * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function kategori(): BelongsTo
    {
        // Buku ini "dimiliki oleh" satu Kategori
        // 'kategori_id' adalah foreign key di tabel 'data_buku'
        return $this->belongsTo(Kategori::class, 'kategori_id');
    }

    /**
     * ========================================================
     * TAMBAHAN RELASI BARU
     * ========================================================
     *
     * Definisikan relasi "hasMany" ke model Peminjaman.
     * Satu buku bisa memiliki banyak riwayat peminjaman.
     * * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function peminjaman(): HasMany
    {
        // 'buku_id' adalah foreign key di tabel 'peminjaman'
        return $this->hasMany(Peminjaman::class, 'buku_id');
    }
}