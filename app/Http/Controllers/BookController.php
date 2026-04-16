<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(15);
        return view('books_admin.data_buku_clean', compact('books'));
    }

    public function destroy(Book $book)
    {
        $hasActiveBorrow = BorrowRequest::where('book_id', $book->id)
            ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending'])
            ->exists();

        if ($hasActiveBorrow) {
            return back()->withErrors([
                'delete_book' => 'Buku tidak bisa dihapus karena masih punya peminjaman aktif.',
            ]);
        }

        // Delete cover image
        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        // Delete profile folder and all contents
        if ($book->profile_path) {
            $fullProfilePath = storage_path('app/public/' . $book->profile_path);
            if (file_exists($fullProfilePath)) {
                // Delete all files in profile folder
                $files = glob($fullProfilePath . '/*');
                foreach ($files as $file) {
                    if (is_file($file)) {
                        unlink($file);
                    }
                }
                // Delete the folder itself
                rmdir($fullProfilePath);
            }
        }

        $book->delete();

        return back()->with('success', 'Buku dan profile berhasil dihapus.');
    }

    public function create()
    {
        return view('books_admin.tambah_buku_clean');
    }

    public function store(Request $request)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1901|max:'.(date('Y')+1),
            'stok' => 'required|integer|min:0|max:1000',
            'foto' => 'required|image|mimes:jpeg,png,jpg|max:2048',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn',
        ]);

        $coverPath = $request->file('foto')->store('cover_buku', 'public');

        // Get next book ID for kode_buku generation
        $nextId = Book::max('id') + 1;
        $kodeBuku = 'BK' . str_pad($nextId, 6, '0', STR_PAD_LEFT);

        // Create book with kode_buku
        $book = Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kategori' => $request->kategori,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'penerbit' => $request->penerbit,
            'isbn' => $request->isbn,
            'cover' => $coverPath,
            'kode_buku' => $kodeBuku,
        ]);

        // If kode_buku generation was wrong, fix it
        if ($book->kode_buku !== $kodeBuku) {
            $correctKodeBuku = 'BK' . str_pad($book->id, 6, '0', STR_PAD_LEFT);
            $book->update(['kode_buku' => $correctKodeBuku]);
            $kodeBuku = $correctKodeBuku;
        }

        // Create profile folder path
        $profilePath = 'book_profiles/' . $kodeBuku;

        // Create comprehensive book profile data
        $profileData = [
            'id' => $book->id,
            'kode_buku' => $kodeBuku,
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
            'profile_version' => '1.0',
            'metadata' => [
                'added_by' => auth()->user()->name ?? 'System',
                'added_at' => now()->toISOString(),
                'device_info' => request()->userAgent(),
                'ip_address' => request()->ip()
            ]
        ];

        // Create profile folder in storage
        $fullProfilePath = storage_path('app/public/' . $profilePath);
        if (!file_exists($fullProfilePath)) {
            mkdir($fullProfilePath, 0755, true);
        }

        // Save profile data as JSON file
        $profileFilePath = $fullProfilePath . '/profile.json';
        file_put_contents($profileFilePath, json_encode($profileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE));

        // Update book with profile data
        $book->update([
            'profile_path' => $profilePath,
            'book_profile' => json_encode($profileData)
        ]);

        return redirect()->route('admin.books.index')->with('success', "Buku berhasil ditambahkan dengan kode: {$kodeBuku}!");
    }

    public function showProfile(Book $book)
    {
        // Ensure user has permission to view book profile
        // You can add authorization logic here

        return view('books_admin.book_profile', compact('book'));
    }

    public function downloadProfile(Book $book)
    {
        $profilePath = storage_path('app/public/' . $book->profile_path . '/profile.json');

        if (!file_exists($profilePath)) {
            return back()->withErrors(['profile' => 'Profile file tidak ditemukan.']);
        }

        return response()->download($profilePath, $book->kode_buku . '_profile.json');
    }

    public function indexUser()
    {
        $books = Book::latest()->paginate(12);

        // Get active borrow requests for current user
        $activeBorrows = BorrowRequest::where('user_id', auth()->id())
            ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending'])
            ->get();

        // Create a map of book_id to borrow request for easy lookup
        $activeBorrowMap = [];
        foreach ($activeBorrows as $borrow) {
            $activeBorrowMap[$borrow->book_id] = $borrow;
        }

        return view('book_user.daftar_buku_user_borrow_clean', compact('books', 'activeBorrowMap'));
    }
}
