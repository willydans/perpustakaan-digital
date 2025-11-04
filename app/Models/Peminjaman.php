<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Peminjaman extends Model
{
    use HasFactory;

    /**
     * Tentukan nama tabel yang digunakan oleh model ini.
     *
     * @var string
     */
    protected $table = 'peminjaman';

    /**
     * Kolom yang dikecualikan dari mass assignment.
     * Mengizinkan semua kolom diisi via Peminjaman::create()
     *
     * @var array
     */
    protected $guarded = [];

    /**
     * Tentukan tipe data asli untuk kolom-kolom.
     * Ini akan mengubah string tanggal dari DB menjadi objek Carbon (objek Tanggal).
     *
     * @var array
     */
    protected $casts = [
        'tanggal_pinjam' => 'date',
        'batas_kembali' => 'date',
        'tanggal_pengembalian_aktual' => 'date',
    ];

    /**
     * Definisikan relasi "belongsTo" ke model User.
     * Sebuah peminjaman dimiliki oleh satu user.
     */
    public function user(): BelongsTo
    {
        // 'user_id' adalah foreign key di tabel 'peminjaman'
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Definisikan relasi "belongsTo" ke model Buku.
     * Sebuah peminjaman adalah untuk satu buku.
     */
    public function buku(): BelongsTo
    {
        // 'buku_id' adalah foreign key di tabel 'peminjaman'
        return $this->belongsTo(Buku::class, 'buku_id');
    }
}