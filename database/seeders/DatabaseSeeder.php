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

        \App\Models\User::firstOrCreate(
            ['email' => 'sarin@gmail.com'],
            [
                'name' => 'Sarin',
                'password' => \Illuminate\Support\Facades\Hash::make('11223344'),
                'role' => 'admin',
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
            ],
            [
                'judul' => 'Belajar PHP dari Nol',
                'penulis' => 'Sarin',
                'penerbit' => 'Self Published',
                'kategori' => 'PHP',
                'tahun_terbit' => 2024,
                'isbn' => null,
                'stok' => 25,
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
            ],
            [
                'judul' => 'JavaScript Modern',
                'penulis' => 'Jane Smith',
                'penerbit' => 'O\'Reilly',
                'kategori' => 'JavaScript',
                'tahun_terbit' => 2023,
                'isbn' => null,
                'stok' => 20,
            ],
        ];

        foreach ($books as $bookData) {
            \App\Models\Book::firstOrCreate(
                ['isbn' => $bookData['isbn']],
                $bookData
            );
        }
    }
}
