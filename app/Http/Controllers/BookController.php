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

        if ($book->cover) {
            Storage::disk('public')->delete($book->cover);
        }

        $book->delete();

        return back()->with('success', 'Buku berhasil dihapus.');
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

        Book::create([
            'judul' => $request->judul,
            'penulis' => $request->penulis,
            'kategori' => $request->kategori,
            'tahun_terbit' => $request->tahun_terbit,
            'stok' => $request->stok,
            'penerbit' => $request->penerbit,
            'isbn' => $request->isbn,
            'cover' => $coverPath,
        ]);

        return redirect()->route('admin.books.index')->with('success', 'Buku berhasil ditambahkan!');
    }

    public function indexUser()
    {
        $books = Book::latest()->paginate(12);
        $activeBorrowMap = BorrowRequest::where('user_id', Auth::id())
            ->whereIn('status', ['pending', 'approved', 'picked_up', 'return_pending'])
            ->latest()
            ->get()
            ->keyBy('book_id');

        return view('book_user.daftar_buku_user_borrow_clean', compact('books', 'activeBorrowMap'));
    }
}
