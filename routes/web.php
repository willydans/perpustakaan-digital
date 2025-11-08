<?php

use Illuminate\Support\Facades\Route;
// (1) Impor KETIGA controller
use App\Http\Controllers\Admin\BukuController;
use App\Http\Controllers\Admin\KategoriController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\PeminjamanController; // <-- Ini penting
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;

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

// === RUTE AUTENTIKASI ===
Route::get('/login', [LoginController::class, 'showLoginForm'])->name('login');
Route::post('/login', [LoginController::class, 'login']);
Route::post('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/register', [RegisterController::class, 'showRegistrationForm'])->name('register');
Route::post('/register', [RegisterController::class, 'register']);


// === RUTE SETELAH LOGIN (Dengan Middleware Auth) ===
Route::middleware('auth')->group(function () {

    // Rute untuk Halaman Katalog Buku
    Route::get('/peminjaman', [PeminjamanController::class, 'index'])->name('peminjaman');

    // Rute untuk Halaman Detail Buku
    Route::get('/buku/{buku}', [PeminjamanController::class, 'show'])->name('buku.detail');

    // (BARU) Rute untuk memproses Form Peminjaman
    Route::post('/pinjam', [PeminjamanController::class, 'pinjam'])->name('buku.pinjam');

    // Rute untuk Halaman Riwayat Peminjaman
    Route::get('/riwayat', [PeminjamanController::class, 'riwayat'])->name('riwayat');

    // Rute untuk Perpanjang Peminjaman
    Route::post('/riwayat/perpanjang/{id}', [PeminjamanController::class, 'perpanjang'])->name('riwayat.perpanjang');

    // Rute untuk Kembalikan Buku
    Route::post('/riwayat/kembalikan/{id}', [PeminjamanController::class, 'kembalikan'])->name('riwayat.kembalikan');

    // Rute untuk Ulasan Buku
    Route::post('/riwayat/ulasan/{id}', [PeminjamanController::class, 'ulasan'])->name('riwayat.ulasan');

    // Rute untuk Halaman Dashboard Pengguna
    Route::get('/dashboard', function () {
        // Pastikan Anda sudah membuat file 'resources/views/dashboard.blade.php'
        return view('dashboard');
    })->name('dashboard');

    // Rute untuk Dashboard Admin
    Route::get('/admin/dashboard', function () {
        return view('admin.dashboard');
    })->name('admin.dashboard');

    // === RUTE ADMIN ===
    Route::prefix('admin')->name('admin.')->middleware('admin')->group(function () {

        // Rute Manajemen Buku
        Route::get('/buku', [BukuController::class, 'index'])->name('buku.index');
        Route::post('/buku', [BukuController::class, 'store'])->name('buku.store');
        Route::get('/buku/{buku}/edit', [BukuController::class, 'edit'])->name('buku.edit');
        Route::put('/buku/{buku}', [BukuController::class, 'update'])->name('buku.update');
        Route::delete('/buku/{buku}', [BukuController::class, 'destroy'])->name('buku.destroy');

        // Rute Manajemen Kategori
        Route::get('/kategori', [KategoriController::class, 'index'])->name('kategori.index');
        Route::post('/kategori', [KategoriController::class, 'store'])->name('kategori.store');
        Route::get('/kategori/{kategori}/edit', [KategoriController::class, 'edit'])->name('kategori.edit');
        Route::put('/kategori/{kategori}', [KategoriController::class, 'update'])->name('kategori.update');
        Route::delete('/kategori/{kategori}', [KategoriController::class, 'destroy'])->name('kategori.destroy');

        // Rute Manajemen User
        Route::get('/user', [UserController::class, 'index'])->name('user.index');
        Route::get('/user/create', [UserController::class, 'create'])->name('user.create');
        Route::post('/user', [UserController::class, 'store'])->name('user.store');
        Route::get('/user/{user}/edit', [UserController::class, 'edit'])->name('user.edit');
        Route::put('/user/{user}', [UserController::class, 'update'])->name('user.update');
        Route::delete('/user/{user}', [UserController::class, 'destroy'])->name('user.destroy');

        Route::post('/peminjaman/{id}/ulasan', [PeminjamanController::class, 'ulasan'])->name('peminjaman.ulasan')->middleware('auth');


    });

});
