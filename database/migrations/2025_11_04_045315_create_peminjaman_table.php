<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('peminjaman', function (Blueprint $table) {
            $table->id(); // ID unik untuk setiap transaksi peminjaman

            // (1) Kunci Asing (Foreign Key) ke tabel 'users'
            //    Untuk mencatat SIAPA yang meminjam.
            //    (Asumsi Anda memiliki tabel 'users' standar Laravel)
            $table->foreignId('user_id')
                  ->constrained('users')
                  ->onDelete('cascade'); // Jika user dihapus, data pinjamannya juga terhapus

            // (2) Kunci Asing (Foreign Key) ke tabel 'data_buku'
            //    Untuk mencatat BUKU APA yang dipinjam.
            $table->foreignId('buku_id')
                  ->constrained('data_buku')
                  ->onDelete('cascade'); // Jika buku dihapus, data pinjamannya juga terhapus

            // (3) Kolom dari Form Anda
            $table->date('tanggal_pinjam');
            
            // (REVISI) Menyimpan durasi sebagai angka (misal: 14)
            $table->integer('durasi_peminjaman_hari'); 
            
            $table->date('batas_kembali'); // Dihitung dari tanggal_pinjam + durasi
            $table->text('catatan')->nullable(); // Opsional

            // (4) Kolom Status
            //    Untuk melacak status peminjaman
            $table->enum('status', ['Dipinjam', 'Dikembalikan', 'Terlambat'])
                  ->default('Dipinjam');
            
            $table->date('tanggal_pengembalian_aktual')->nullable(); // Diisi saat user mengembalikan

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('peminjaman');
    }
};