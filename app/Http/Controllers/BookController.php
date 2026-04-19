<?php

namespace App\Http\Controllers;

use App\Models\BorrowRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class BookController extends Controller
{
    private function buildProfileData(Book $book): array
    {
        return [
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
            'profile_version' => '1.0',
            'metadata' => [
                'added_by' => auth()->user()->name ?? 'System',
                'added_at' => $book->created_at ? $book->created_at->toISOString() : now()->toISOString(),
                'updated_at' => now()->toISOString(),
                'device_info' => request()->userAgent(),
                'ip_address' => request()->ip(),
            ],
        ];
    }

    private function syncBookProfile(Book $book): void
    {
        if (! $book->profile_path) {
            return;
        }

        $profileData = $this->buildProfileData($book);
        $fullProfilePath = storage_path('app/public/' . $book->profile_path);

        if (!file_exists($fullProfilePath)) {
            mkdir($fullProfilePath, 0755, true);
        }

        file_put_contents(
            $fullProfilePath . '/profile.json',
            json_encode($profileData, JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE)
        );

        $book->updateQuietly([
            'book_profile' => json_encode($profileData),
        ]);
    }

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

        // Create profile folder in storage
        $fullProfilePath = storage_path('app/public/' . $profilePath);
        if (!file_exists($fullProfilePath)) {
            mkdir($fullProfilePath, 0755, true);
        }

        $book->update([
            'profile_path' => $profilePath,
        ]);

        $this->syncBookProfile($book->refresh());

        return redirect()->route('admin.books.index')->with('success', "Buku berhasil ditambahkan dengan kode: {$kodeBuku}!");
    }

    public function edit(Book $book)
    {
        return view('books_admin.edit_buku_clean', compact('book'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'judul' => 'required|string|max:255',
            'penulis' => 'required|string|max:255',
            'kategori' => 'required|string|max:100',
            'tahun_terbit' => 'required|integer|min:1901|max:'.(date('Y')+1),
            'stok' => 'required|integer|min:0|max:1000',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg|max:2048',
            'penerbit' => 'nullable|string|max:255',
            'isbn' => 'nullable|string|max:20|unique:books,isbn,' . $book->id,
        ]);

        if ($request->hasFile('foto')) {
            if ($book->cover) {
                Storage::disk('public')->delete($book->cover);
            }

            $book->cover = $request->file('foto')->store('cover_buku', 'public');
        }

        $book->judul = $request->judul;
        $book->penulis = $request->penulis;
        $book->kategori = $request->kategori;
        $book->tahun_terbit = $request->tahun_terbit;
        $book->stok = $request->stok;
        $book->penerbit = $request->penerbit;
        $book->isbn = $request->isbn;
        $book->save();

        $this->syncBookProfile($book);

        return redirect()->route('admin.books.index')->with('success', 'Data buku berhasil diperbarui.');
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
