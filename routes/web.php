<?php

use Illuminate\Support\Facades\Route;
// (1) Impor KETIGA controller
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\PeminjamanController; // <-- Ini penting

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Di sinilah Anda dapat mendaftarkan rute web untuk aplikasi Anda. Rute-rute
| ini dimuat oleh RouteServiceProvider dan semuanya akan
| ditugaskan ke grup middleware "web". Buat sesuatu yang hebat!
|
*/

// Rute untuk Homepage (Halaman Depan)
Route::get('/', function () {
    return view('home'); 
})->name('home');

// === RUTE AUTENTIKASI (Belum Dibuat) ===
Route::get('/login', function () {
    return "Ini halaman Login"; 
})->name('login');

Route::get('/register', function () {
    return "Ini halaman Register"; 
})->name('register');


// === RUTE SETELAH LOGIN (Sudah Diperbaiki) ===

// Rute untuk Halaman Katalog Buku
Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

// Rute untuk Halaman Detail Buku
Route::get('/buku/{buku}', [PeminjamanController::class, 'show'])->name('buku.detail');

// (BARU) Rute untuk memproses Form Peminjaman
Route::post('/pinjam', [PeminjamanController::class, 'pinjam'])->name('buku.pinjam');


// Rute untuk Halaman Riwayat Peminjaman
Route::get('/riwayat', function () {
    // Pastikan Anda sudah membuat file 'resources/views/riwayat.blade.php'
    return view('riwayat');
})->name('riwayat');

// Rute untuk Halaman Dashboard Pengguna
Route::get('/dashboard', function () {
    // Pastikan Anda sudah membuat file 'resources/views/dashboard.blade.php'
    return view('dashboard');
})->name('dashboard');


// === RUTE ADMIN ===
Route::prefix('admin')->name('admin.')->group(function () {
    
    // Rute Manajemen Buku
    Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
    Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
    Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

    // Rute untuk 'quick add' Kategori
    Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');

});