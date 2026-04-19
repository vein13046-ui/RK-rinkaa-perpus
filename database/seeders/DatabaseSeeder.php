<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        \App\Models\User::updateOrCreate(
            ['email' => 'sarin@gmail.com'],
            [
                'name' => 'Sarin',
                'password' => \Illuminate\Support\Facades\Hash::make('11223344'),
                'role' => 'admin',
                'profile_photo' => 'avatars/rinn.jpg',
            ]
        );

        // Sample books for testing persistence
        $books = [
            [
                'judul' => 'Laravel 11 for Beginners',
                'penulis' => 'John Doe',
                'penerbit' => 'Packt Publishing',
                'kategori' => 'Web Development',
                'tahun_terbit' => 2024,
                'isbn' => '978-1804619494',
                'stok' => 15,
                'cover' => 'cover_buku/sample1.jpg',
                'kode_buku' => 'BK000001',
            ],
            [
                'judul' => 'Clean Code',
                'penulis' => 'Robert C. Martin',
                'penerbit' => 'Prentice Hall',
                'kategori' => 'Software Engineering',
                'tahun_terbit' => 2008,
                'isbn' => '978-0132350884',
                'stok' => 8,
                'cover' => 'cover_buku/sample2.jpg',
                'kode_buku' => 'BK000002',
            ],
            [
                'judul' => 'Belajar PHP dari Nol',
                'penulis' => 'Sarin',
                'penerbit' => 'Self Published',
                'kategori' => 'PHP',
                'tahun_terbit' => 2024,
                'isbn' => null,
                'stok' => 25,
                'kode_buku' => 'BK000003',
            ],
            [
                'judul' => 'Desain Pattern PHP',
                'penulis' => 'Ahmad Rosid',
                'penerbit' => 'Elex Media',
                'kategori' => 'Design Pattern',
                'tahun_terbit' => 2023,
                'isbn' => '978-623-00-1234-5',
                'stok' => 12,
                'cover' => 'cover_buku/sample4.jpg',
                'kode_buku' => 'BK000004',
            ],
            [
                'judul' => 'JavaScript Modern',
                'penulis' => 'Jane Smith',
                'penerbit' => 'O\'Reilly',
                'kategori' => 'JavaScript',
                'tahun_terbit' => 2023,
                'isbn' => null,
                'stok' => 20,
                'kode_buku' => 'BK000005',
            ],
            // Anime book data from cover_buku/anime
            [
                'judul' => 'Naruto',
                'penulis' => 'Masashi Kishimoto',
                'penerbit' => 'Shonen Jump',
                'kategori' => 'Anime',
                'tahun_terbit' => 1999,
                'isbn' => 'ANIME-001',
                'stok' => 10,
                'cover' => 'cover_buku/anime/naruto.jpg',
                'kode_buku' => 'BK000006',
            ],
            [
                'judul' => 'Attack on Titan',
                'penulis' => 'Hajime Isayama',
                'penerbit' => 'Kodansha',
                'kategori' => 'Anime',
                'tahun_terbit' => 2009,
                'isbn' => 'ANIME-002',
                'stok' => 10,
                'cover' => 'cover_buku/anime/attack on titan.jpg',
                'kode_buku' => 'BK000007',
            ],
            [
                'judul' => 'Jujutsu Kaisen',
                'penulis' => 'Gege Akutami',
                'penerbit' => 'Shueisha',
                'kategori' => 'Anime',
                'tahun_terbit' => 2018,
                'isbn' => 'ANIME-003',
                'stok' => 10,
                'cover' => 'cover_buku/anime/jujutsu kaisen.jpg',
                'kode_buku' => 'BK000008',
            ],
            [
                'judul' => 'Baki Hanma',
                'penulis' => 'Keisuke Itagaki',
                'penerbit' => 'Akita Shoten',
                'kategori' => 'Anime',
                'tahun_terbit' => 1991,
                'isbn' => 'ANIME-004',
                'stok' => 10,
                'cover' => 'cover_buku/anime/baki hanmajpg.jpg',
                'kode_buku' => 'BK000009',
            ],
            [
                'judul' => 'Kangean Asura',
                'penulis' => 'Unknown',
                'penerbit' => 'Anime Press',
                'kategori' => 'Anime',
                'tahun_terbit' => 2024,
                'isbn' => 'ANIME-005',
                'stok' => 10,
                'cover' => 'cover_buku/anime/kangean asura.jpg',
                'kode_buku' => 'BK000010',
            ],
            [
                'judul' => 'Kangean of the Baki',
                'penulis' => 'Unknown',
                'penerbit' => 'Anime Press',
                'kategori' => 'Anime',
                'tahun_terbit' => 2024,
                'isbn' => 'ANIME-006',
                'stok' => 10,
                'cover' => 'cover_buku/anime/kangean of the baki.jpg',
                'kode_buku' => 'BK000011',
            ],
            [
                'judul' => 'Suzune',
                'penulis' => 'Unknown',
                'penerbit' => 'Anime Press',
                'kategori' => 'Anime',
                'tahun_terbit' => 2024,
                'isbn' => 'ANIME-007',
                'stok' => 10,
                'cover' => 'cover_buku/anime/suzune.jpg',
                'kode_buku' => 'BK000012',
            ],
        ];

        foreach ($books as $bookData) {
            \App\Models\Book::firstOrCreate(
                ['judul' => $bookData['judul']],
                $bookData
            );
        }
    }
}
