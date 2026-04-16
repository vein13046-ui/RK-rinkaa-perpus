<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Book;

class BookProfileSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $books = Book::all();

        foreach ($books as $book) {
            // Generate kode buku jika belum ada
            if (empty($book->kode_buku)) {
                $kodeBuku = 'BK' . str_pad($book->id, 6, '0', STR_PAD_LEFT);
                $book->update(['kode_buku' => $kodeBuku]);
            }

            // Create book profile data
            $profileData = [
                'id' => $book->id,
                'kode_buku' => $book->kode_buku,
                'judul' => $book->judul,
                'penulis' => $book->penulis,
                'penerbit' => $book->penerbit,
                'kategori' => $book->kategori,
                'tahun_terbit' => $book->tahun_terbit,
                'isbn' => $book->isbn,
                'stok' => $book->stok,
                'cover' => $book->cover,
                'created_at' => $book->created_at,
                'updated_at' => $book->updated_at,
                'status' => 'active',
                'profile_version' => '1.0'
            ];

            // Create profile folder path
            $profilePath = 'book_profiles/' . $book->kode_buku;

            // Update book with profile data
            $book->update([
                'profile_path' => $profilePath,
                'book_profile' => json_encode($profileData)
            ]);

            $this->command->info("Updated book: {$book->judul} with code: {$book->kode_buku}");
        }
    }
}
