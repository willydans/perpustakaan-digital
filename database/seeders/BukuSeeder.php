<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Buku;
use App\Models\Kategori;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class BukuSeeder extends Seeder
{
    public function run()
    {
        // Pastikan folder covers ada di storage
        if (!Storage::disk('public')->exists('covers')) {
            Storage::disk('public')->makeDirectory('covers');
        }

        // Path gambar dummy
        $sourcePath = database_path('seeders/images/covers');
        $destinationPath = storage_path('app/public/covers');

        // Copy semua gambar dari folder dummy ke storage
        if (File::exists($sourcePath)) {
            $files = File::files($sourcePath);
            foreach ($files as $file) {
                $filename = $file->getFilename();
                File::copy($file->getPathname(), $destinationPath . '/' . $filename);
            }
        }

        // Ambil semua kategori
        $kategoris = Kategori::all();

        // Data buku untuk setiap kategori
        $bukuData = [
            'Biografi' => [
                [
                    'nama_buku' => 'Steve Jobs: The Exclusive Biography',
                    'nama_penulis' => 'Walter Isaacson',
                    'nomor_isbn' => '9781451648539',
                    'penerbit' => 'Simon & Schuster',
                    'tahun_buku' => 2011,
                    'jumlah_halaman' => 630,
                    'deskripsi_buku' => 'Biografi lengkap tentang pendiri Apple Inc, Steve Jobs, yang mengubah industri teknologi.',
                    'jumlah_buku' => 5,
                    'rating_buku' => 4.5,
                    'cover' => 'biografi-1.jpg'
                ],
                [
                    'nama_buku' => 'Long Walk to Freedom',
                    'nama_penulis' => 'Nelson Mandela',
                    'nomor_isbn' => '9780316548182',
                    'penerbit' => 'Little Brown & Co',
                    'tahun_buku' => 1995,
                    'jumlah_halaman' => 656,
                    'deskripsi_buku' => 'Autobiografi Nelson Mandela tentang perjuangannya melawan apartheid di Afrika Selatan.',
                    'jumlah_buku' => 3,
                    'rating_buku' => 4.8,
                    'cover' => 'biografi-2.jpg'
                ]
            ],
            'Fiksi' => [
                [
                    'nama_buku' => 'Harry Potter and the Philosopher\'s Stone',
                    'nama_penulis' => 'J.K. Rowling',
                    'nomor_isbn' => '9780747532699',
                    'penerbit' => 'Bloomsbury',
                    'tahun_buku' => 1997,
                    'jumlah_halaman' => 223,
                    'deskripsi_buku' => 'Petualangan Harry Potter di Sekolah Sihir Hogwarts dimulai.',
                    'jumlah_buku' => 10,
                    'rating_buku' => 4.9,
                    'cover' => 'fiksi-1.jpg'
                ],
                [
                    'nama_buku' => 'The Great Gatsby',
                    'nama_penulis' => 'F. Scott Fitzgerald',
                    'nomor_isbn' => '9780743273565',
                    'penerbit' => 'Scribner',
                    'tahun_buku' => 1925,
                    'jumlah_halaman' => 180,
                    'deskripsi_buku' => 'Kisah tragis tentang Jay Gatsby dan obsesinya dengan masa lalu.',
                    'jumlah_buku' => 4,
                    'rating_buku' => 4.2,
                    'cover' => 'fiksi-2.jpg'
                ]
            ],
            'Hobi' => [
                [
                    'nama_buku' => 'The Art of Photography',
                    'nama_penulis' => 'Bruce Barnbaum',
                    'nomor_isbn' => '9781681982410',
                    'penerbit' => 'Rocky Nook',
                    'tahun_buku' => 2017,
                    'jumlah_halaman' => 432,
                    'deskripsi_buku' => 'Panduan lengkap tentang teknik fotografi dari dasar hingga mahir.',
                    'jumlah_buku' => 6,
                    'rating_buku' => 4.6,
                    'cover' => 'hobi-1.jpg'
                ],
                [
                    'nama_buku' => 'Mastering the Art of French Cooking',
                    'nama_penulis' => 'Julia Child',
                    'nomor_isbn' => '9780375413407',
                    'penerbit' => 'Knopf',
                    'tahun_buku' => 1961,
                    'jumlah_halaman' => 752,
                    'deskripsi_buku' => 'Buku masakan Perancis klasik dengan resep-resep otentik.',
                    'jumlah_buku' => 3,
                    'rating_buku' => 4.7,
                    'cover' => 'hobi-2.jpg'
                ]
            ],
            'Non-Fiksi' => [
                [
                    'nama_buku' => 'Sapiens: A Brief History of Humankind',
                    'nama_penulis' => 'Yuval Noah Harari',
                    'nomor_isbn' => '9780062316110',
                    'penerbit' => 'Harper',
                    'tahun_buku' => 2015,
                    'jumlah_halaman' => 443,
                    'deskripsi_buku' => 'Sejarah singkat umat manusia dari zaman batu hingga era modern.',
                    'jumlah_buku' => 8,
                    'rating_buku' => 4.8,
                    'cover' => 'non-fiksi-1.jpg'
                ],
                [
                    'nama_buku' => 'Educated',
                    'nama_penulis' => 'Tara Westover',
                    'nomor_isbn' => '9780399590504',
                    'penerbit' => 'Random House',
                    'tahun_buku' => 2018,
                    'jumlah_halaman' => 334,
                    'deskripsi_buku' => 'Memoir tentang kekuatan pendidikan untuk mengubah hidup seseorang.',
                    'jumlah_buku' => 5,
                    'rating_buku' => 4.7,
                    'cover' => 'non-fiksi-2.jpg'
                ]
            ],
            'Pendidikan' => [
                [
                    'nama_buku' => 'How Children Learn',
                    'nama_penulis' => 'John Holt',
                    'nomor_isbn' => '9780201484045',
                    'penerbit' => 'Da Capo Press',
                    'tahun_buku' => 1995,
                    'jumlah_halaman' => 320,
                    'deskripsi_buku' => 'Pandangan revolusioner tentang cara anak-anak belajar secara alami.',
                    'jumlah_buku' => 4,
                    'rating_buku' => 4.4,
                    'cover' => 'pendidikan-1.jpg'
                ],
                [
                    'nama_buku' => 'The 7 Habits of Highly Effective People',
                    'nama_penulis' => 'Stephen Covey',
                    'nomor_isbn' => '9781982137274',
                    'penerbit' => 'Simon & Schuster',
                    'tahun_buku' => 2020,
                    'jumlah_halaman' => 464,
                    'deskripsi_buku' => 'Panduan untuk pengembangan diri dan efektivitas personal.',
                    'jumlah_buku' => 7,
                    'rating_buku' => 4.6,
                    'cover' => 'pendidikan-2.jpg'
                ]
            ],
            'Romantis' => [
                [
                    'nama_buku' => 'Pride and Prejudice',
                    'nama_penulis' => 'Jane Austen',
                    'nomor_isbn' => '9780141439518',
                    'penerbit' => 'Penguin Classics',
                    'tahun_buku' => 1813,
                    'jumlah_halaman' => 432,
                    'deskripsi_buku' => 'Kisah romansa klasik antara Elizabeth Bennet dan Mr. Darcy.',
                    'jumlah_buku' => 5,
                    'rating_buku' => 4.9,
                    'cover' => 'romantis-1.jpg'
                ],
                [
                    'nama_buku' => 'The Notebook',
                    'nama_penulis' => 'Nicholas Sparks',
                    'nomor_isbn' => '9780446676090',
                    'penerbit' => 'Grand Central Publishing',
                    'tahun_buku' => 1996,
                    'jumlah_halaman' => 214,
                    'deskripsi_buku' => 'Kisah cinta yang mengharukan tentang pasangan yang tidak terpisahkan.',
                    'jumlah_buku' => 6,
                    'rating_buku' => 4.5,
                    'cover' => 'romantis-2.jpg'
                ]
            ],
            'Sains' => [
                [
                    'nama_buku' => 'A Brief History of Time',
                    'nama_penulis' => 'Stephen Hawking',
                    'nomor_isbn' => '9780553380163',
                    'penerbit' => 'Bantam',
                    'tahun_buku' => 1988,
                    'jumlah_halaman' => 256,
                    'deskripsi_buku' => 'Penjelasan tentang alam semesta, dari Big Bang hingga lubang hitam.',
                    'jumlah_buku' => 4,
                    'rating_buku' => 4.7,
                    'cover' => 'sains-1.jpg'
                ],
                [
                    'nama_buku' => 'The Selfish Gene',
                    'nama_penulis' => 'Richard Dawkins',
                    'nomor_isbn' => '9780198788607',
                    'penerbit' => 'Oxford University Press',
                    'tahun_buku' => 1976,
                    'jumlah_halaman' => 360,
                    'deskripsi_buku' => 'Penjelasan revolusioner tentang evolusi dari perspektif gen.',
                    'jumlah_buku' => 3,
                    'rating_buku' => 4.6,
                    'cover' => 'sains-2.jpg'
                ]
            ],
            'Sastra' => [
                [
                    'nama_buku' => 'To Kill a Mockingbird',
                    'nama_penulis' => 'Harper Lee',
                    'nomor_isbn' => '9780061120084',
                    'penerbit' => 'Harper Perennial',
                    'tahun_buku' => 1960,
                    'jumlah_halaman' => 324,
                    'deskripsi_buku' => 'Novel tentang ketidakadilan rasial di Amerika Selatan tahun 1930-an.',
                    'jumlah_buku' => 7,
                    'rating_buku' => 4.8,
                    'cover' => 'sastra-1.jpg'
                ],
                [
                    'nama_buku' => '1984',
                    'nama_penulis' => 'George Orwell',
                    'nomor_isbn' => '9780451524935',
                    'penerbit' => 'Signet Classic',
                    'tahun_buku' => 1949,
                    'jumlah_halaman' => 328,
                    'deskripsi_buku' => 'Dystopia tentang masyarakat totalitarian yang mengontrol segala aspek kehidupan.',
                    'jumlah_buku' => 6,
                    'rating_buku' => 4.9,
                    'cover' => 'sastra-2.jpg'
                ]
            ]
        ];

        // Insert buku berdasarkan kategori
        foreach ($kategoris as $kategori) {
            $namaKategori = $kategori->nama_kategori;
            
            if (isset($bukuData[$namaKategori])) {
                foreach ($bukuData[$namaKategori] as $data) {
                    Buku::create([
                        'nama_buku' => $data['nama_buku'],
                        'nama_penulis' => $data['nama_penulis'],
                        'nomor_isbn' => $data['nomor_isbn'],
                        'penerbit' => $data['penerbit'],
                        'tahun_buku' => $data['tahun_buku'],
                        'jumlah_halaman' => $data['jumlah_halaman'],
                        'deskripsi_buku' => $data['deskripsi_buku'],
                        'jumlah_buku' => $data['jumlah_buku'],
                        'rating_buku' => $data['rating_buku'],
                        'kategori_id' => $kategori->id,
                        'cover_thumbnail_url' => 'covers/' . $data['cover']
                    ]);
                }
            }
        }

        $this->command->info('✅ Berhasil membuat ' . Buku::count() . ' buku dengan cover!');
    }
}