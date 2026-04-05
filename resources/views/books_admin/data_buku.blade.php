@extends('layouts.app')

@section('title', 'Data Buku - Admin LibEdu')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <h1 class="text-3xl font-bold text-slate-800 tracking-tight">Katalog Buku</h1>
            <p class="text-slate-500 mt-1">Kelola dan pantau seluruh koleksi buku perpustakaan.</p>
        </div>
        
        <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center gap-2 bg-blue-600 hover:bg-blue-700 text-white px-6 py-3 rounded-xl font-semibold shadow-sm shadow-blue-600/20 hover:shadow-md transition-all duration-200 hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
            </svg>
            Tambah Buku Baru
        </a>
    </div>

    @if (session('success'))
        <div class="bg-emerald-50 border border-emerald-200 text-emerald-700 px-6 py-4 rounded-xl mb-8 flex items-center gap-3">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"></path>
            </svg>
            <span class="font-medium">{{ session('success') }}</span>
        </div>
    @endif

    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead class="bg-slate-50/80 border-b border-slate-200">
                    <tr>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Cover</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Detail Buku</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Kategori</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider">Tahun</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Stok</th>
                        <th class="px-6 py-4 text-xs font-bold text-slate-500 uppercase tracking-wider text-right">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    @forelse ($books as $book)
                        <tr class="hover:bg-slate-50/50 transition-colors group">
                            
                            <td class="px-6 py-4">
                                @if ($book->cover)
                                    <img src="{{ Storage::url($book->cover) }}" alt="Cover {{ $book->judul }}" class="w-14 h-20 object-cover rounded-lg shadow-sm border border-slate-200">
                                @else
                                    <div class="w-14 h-20 bg-slate-100 rounded-lg border border-slate-200 flex items-center justify-center">
                                        <svg class="w-6 h-6 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <p class="font-bold text-slate-800 line-clamp-1 mb-1">{{ $book->judul }}</p>
                                <p class="text-sm font-medium text-slate-600 mb-0.5">{{ $book->penulis }}</p>
                                @if ($book->penerbit)
                                    <p class="text-xs text-slate-400">{{ $book->penerbit }}</p>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <span class="inline-flex px-3 py-1 rounded-md text-xs font-semibold bg-indigo-50 text-indigo-700 border border-indigo-100">
                                    {{ $book->kategori }}
                                </span>
                            </td>

                            <td class="px-6 py-4">
                                <span class="text-sm text-slate-600 font-medium">{{ $book->tahun_terbit }}</span>
                            </td>

                            <td class="px-6 py-4 text-center">
                                @if ($book->stok > 0)
                                    <div class="inline-flex flex-col items-center">
                                        <span class="text-sm font-bold text-emerald-600">{{ $book->stok }}</span>
                                        <span class="text-[10px] uppercase font-bold text-emerald-500 bg-emerald-50 px-2 py-0.5 rounded-full mt-1">Tersedia</span>
                                    </div>
                                @else
                                    <span class="inline-flex px-3 py-1 bg-red-50 text-red-600 border border-red-100 rounded-md text-xs font-bold">
                                        Habis
                                    </span>
                                @endif
                            </td>

                            <td class="px-6 py-4">
                                <div class="flex items-center justify-end gap-2 opacity-100 sm:opacity-0 group-hover:opacity-100 transition-opacity">
                                    
                                    <a href="#" class="p-2 text-blue-600 bg-blue-50 hover:bg-blue-600 hover:text-white rounded-lg transition-colors shadow-sm" title="Edit Buku">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15.232 5.232l3.536 3.536m-2.036-5.036a2.5 2.5 0 113.536 3.536L6.5 21.5h3m1.5 1.5H6a2 2 0 01-2-2V7a2 2 0 012-2h11a2 2 0 012 2v8a2 2 0 01-2 2z"></path>
                                        </svg>
                                    </a>

                                    <form action="#" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?');" class="inline-block">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="p-2 text-red-600 bg-red-50 hover:bg-red-600 hover:text-white rounded-lg transition-colors shadow-sm" title="Hapus Buku">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                            </svg>
                                        </button>
                                    </form>

                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-6 py-24 text-center">
                                <div class="w-24 h-24 bg-slate-50 rounded-full flex items-center justify-center mx-auto mb-4 border border-slate-100">
                                    <svg class="w-10 h-10 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                    </svg>
                                </div>
                                <h3 class="text-xl font-bold text-slate-800 mb-2">Belum Ada Koleksi Buku</h3>
                                <p class="text-slate-500 mb-6 max-w-sm mx-auto text-sm">Data buku perpustakaan masih kosong. Tambahkan buku baru untuk mulai mengelola inventaris.</p>
                                
                                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center gap-2 bg-slate-800 hover:bg-slate-900 text-white px-6 py-2.5 rounded-xl font-semibold transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                                    </svg>
                                    Tambah Buku Pertama
                                </a>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>

    @if ($books->hasPages())
        <div class="mt-8">
            {{ $books->links() }}
        </div>
    @endif

</div>
@endsection