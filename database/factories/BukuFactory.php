<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Buku>
 */
class BukuFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nama_buku' => $this->faker->sentence(3), // Random book title
            'nama_penulis' => $this->faker->name, // Random author name
            'rating_buku' => $this->faker->randomFloat(1, 1, 5), // Rating between 1 and 5
            'jumlah_buku' => $this->faker->numberBetween(1, 50), // Stock between 1 and 50
            'nomor_isbn' => $this->faker->isbn13, // Random ISBN
            'penerbit' => $this->faker->company, // Random publisher
            'tahun_buku' => $this->faker->year, // Random year
            'jumlah_halaman' => $this->faker->numberBetween(100, 1000), // Pages between 100 and 1000
            'deskripsi_buku' => $this->faker->paragraph, // Random description
            'cover_thumbnail_url' => 'https://placehold.co/200x300/e2e8f0/718096?text=' . urlencode($this->faker->word), // Placeholder image
            'kategori_id' => $this->faker->numberBetween(1, 5), // Assume categories 1-5 exist
        ];
    }
}
