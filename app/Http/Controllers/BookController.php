<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use App\Models\Book;

class BookController extends Controller
{
    public function index()
    {
        $books = Book::latest()->paginate(15);
        return view('books_admin.data_buku', compact('books'));
    }

    public function create()
    {
        return view('books_admin.tambah_buku');
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
        return view('book_user.daftar_buku_user', compact('books'));
    }
}

