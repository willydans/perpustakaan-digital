@extends('layouts.app')

@section('title', 'Admin - Edit User')

@section('content')
<div class="container mx-auto px-4 py-12 max-w-2xl">
    <h1 class="text-4xl font-bold text-gray-800 mb-8">Edit User: {{ $user->name }}</h1>

    <!-- Menampilkan Error Validasi -->
    @if ($errors->any())
        <div class="bg-red-100 border border-red-400 text-red-700 px-4 py-3 rounded relative mb-6" role="alert">
            <strong class="font-bold">Oops! Ada yang salah dengan input:</strong>
            <ul class="mt-3 list-disc list-inside">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <!-- Form Edit User -->
    <div class="bg-white p-8 rounded-lg shadow-lg">
        <form action="{{ route('admin.user.update', $user) }}" method="POST">
            @csrf
            @method('PUT')

            <!-- Nama -->
            <div class="mb-4">
                <label for="name" class="block text-sm font-medium text-gray-700 mb-1">Nama Lengkap <span class="text-red-500">*</span></label>
                <input type="text" name="name" id="name" value="{{ old('name', $user->name) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('name') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Email -->
            <div class="mb-4">
                <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email <span class="text-red-500">*</span></label>
                <input type="email" name="email" id="email" value="{{ old('email', $user->email) }}" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('email') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Password (Opsional) -->
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password Baru (Opsional)</label>
                <input type="password" name="password" id="password" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500" placeholder="Biarkan kosong jika tidak ingin mengubah">
                @error('password') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
                <p class="text-sm text-gray-500 mt-1">Biarkan kosong jika tidak ingin mengubah password</p>
            </div>

            <!-- Konfirmasi Password -->
            <div class="mb-4">
                <label for="password_confirmation" class="block text-sm font-medium text-gray-700 mb-1">Konfirmasi Password Baru</label>
                <input type="password" name="password_confirmation" id="password_confirmation" class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                @error('password_confirmation') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Role -->
            <div class="mb-6">
                <label for="role" class="block text-sm font-medium text-gray-700 mb-1">Role <span class="text-red-500">*</span></label>
                <select name="role" id="role" required class="w-full border-gray-300 rounded-lg shadow-sm focus:border-blue-500 focus:ring-blue-500">
                    <option value="">-- Pilih Role --</option>
                    <option value="user" {{ old('role', $user->role) === 'user' ? 'selected' : '' }}>User</option>
                    <option value="admin" {{ old('role', $user->role) === 'admin' ? 'selected' : '' }}>Admin</option>
                </select>
                @error('role') <span class="text-red-500 text-sm">{{ $message }}</span> @enderror
            </div>

            <!-- Tombol Submit -->
            <div class="flex justify-between">
                <a href="{{ route('admin.user.index') }}" class="bg-gray-500 hover:bg-gray-600 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Batal
                </a>
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white font-bold py-2 px-4 rounded-lg shadow-md transition duration-300">
                    Update User
                </button>
            </div>
        </form>
    </div>
</div>
@endsection
