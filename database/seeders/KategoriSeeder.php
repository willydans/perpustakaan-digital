<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class KategoriSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $kategoris = [
            ['nama_kategori' => 'Fiksi'],
            ['nama_kategori' => 'Non-Fiksi'],
            ['nama_kategori' => 'Teknologi'],
            ['nama_kategori' => 'Sejarah'],
            ['nama_kategori' => 'Biografi'],
            ['nama_kategori' => 'Sains'],
            ['nama_kategori' => 'Sastra'],
            ['nama_kategori' => 'Pendidikan'],
            ['nama_kategori' => 'Agama'],
            ['nama_kategori' => 'Hobi'],
        ];

        foreach ($kategoris as $kategori) {
            \App\Models\Kategori::create($kategori);
        }
    }
}
