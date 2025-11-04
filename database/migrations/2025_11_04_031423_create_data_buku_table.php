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
        // Membuat tabel 'data_buku'
        Schema::create('data_buku', function (Blueprint $table) {
            $table->id(); // Primary Key
            $table->string('nama_buku');
            $table->string('nama_penulis');
            // 'rating_buku' (misal: 4.5), total 2 digit, 1 di belakang koma
            $table->decimal('rating_buku', 2, 1)->nullable(); 
            $table->integer('jumlah_buku')->default(0); // Ini adalah stok
            $table->string('nomor_isbn')->unique()->nullable();
            $table->string('penerbit')->nullable();
            $table->year('tahun_buku')->nullable();
            $table->integer('jumlah_halaman')->nullable();
            $table->text('deskripsi_buku')->nullable();
            
            // Ini untuk "tabel gambar" Anda. Kita simpan nama filenya.
            $table->string('cover_thumbnail_url')->nullable(); 

            // Ini adalah 'kategori' Anda (Foreign Key)
            // Terhubung ke tabel 'kategori' di kolom 'id'
            $table->foreignId('kategori_id')
                  ->nullable()
                  ->constrained('kategori')
                  ->onDelete('set null') // Jika kategori dihapus, kolom ini jadi NULL
                  ->onUpdate('cascade');

            $table->timestamps(); // created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('data_buku');
    }
};
