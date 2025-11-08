<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Menampilkan halaman manajemen user (daftar user)
     */
    public function index()
    {
        // Ambil semua data user dengan pagination
        // Kita pakai 'latest()' agar user yang baru daftar ada di atas
        $users = User::latest()->paginate(10);

        return view('admin.user.index', compact('users'));
    }

    /**
     * Menampilkan form tambah user.
     */
    public function create()
    {
        return view('admin.user.create');
    }

    /**
     * Menyimpan user baru.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        // Hash password
        $validatedData['password'] = Hash::make($validatedData['password']);

        // Simpan user baru
        User::create($validatedData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil ditambahkan!');
    }

    /**
     * Menampilkan form edit user.
     */
    public function edit(User $user)
    {
        return view('admin.user.edit', compact('user'));
    }

    /**
     * Update data user.
     */
    public function update(Request $request, User $user)
    {
        // Validasi input
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => ['required', 'string', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'password' => 'nullable|string|min:8|confirmed',
            'role' => ['required', Rule::in(['user', 'admin'])],
        ]);

        // Jika password diisi, hash password baru
        if ($request->filled('password')) {
            $validatedData['password'] = Hash::make($validatedData['password']);
        } else {
            // Jika password tidak diisi, hapus dari array agar tidak diupdate
            unset($validatedData['password']);
        }

        // Update data user
        $user->update($validatedData);

        return redirect()->route('admin.user.index')->with('success', 'User berhasil diperbarui!');
    }

    /**
     * Menghapus data user.
     */
    public function destroy(User $user)
    {
        // Cegah admin menghapus dirinya sendiri
        if ($user->id === auth()->id()) {
            return back()->with('error', 'Anda tidak dapat menghapus akun Anda sendiri!');
        }

        // Hapus user
        $user->delete();

        return back()->with('success', 'User berhasil dihapus!');
    }
}
