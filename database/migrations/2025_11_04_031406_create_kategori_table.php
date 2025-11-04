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
        // Membuat tabel 'kategori'
        Schema::create('kategori', function (Blueprint $table) {
            $table->id(); // Primary Key (bigInteger, auto-increment)
            $table->string('nama_kategori')->unique();
            $table->timestamps(); // Buat kolom created_at dan updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('kategori');
    }
};
