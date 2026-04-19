@extends('layouts.panel')

@section('page-title', 'Katalog Buku')
@section('page-description', 'Tampilan katalog admin yang lebih bersih, rapi, dan mudah dipindai.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('delete_book'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                {{ $errors->first('delete_book') }}
            </div>
        @endif

        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Data Buku</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Katalog Buku Admin</h3>
                    <p class="mt-3 text-slate-600">Kelola koleksi dengan tampilan yang lebih konsisten dan profesional.</p>
                </div>

                <a href="{{ route('admin.books.create') }}" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Buku
                </a>
            </div>

            <div class="mb-6">
                <label for="adminBookSearch" class="sr-only">Cari buku admin</label>
                <div class="relative max-w-3xl">
                    <input id="adminBookSearch" type="search" data-search-target="#adminBooksTable" data-search-rows=".search-row" placeholder="Cari buku atau penulis..." class="search-input w-full rounded-2xl border border-slate-200 bg-slate-50 pr-12 pl-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100" />
                    <button type="button" class="search-button absolute right-3 top-1/2 -translate-y-1/2 inline-flex h-10 w-10 items-center justify-center text-slate-400 transition hover:text-slate-900">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-4.35-4.35m1.7-5.65a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                    </button>
                    <div class="search-popup-overlay hidden fixed inset-0 bg-slate-900/10 backdrop-blur-sm"></div>
                    <div class="search-popup hidden fixed left-1/2 top-1/2 z-50 w-[min(90vw,58rem)] -translate-x-1/2 -translate-y-1/2 rounded-3xl border border-slate-200 bg-white p-4 shadow-2xl opacity-0 scale-95 transition duration-300 ease-out">
                        <div class="flex items-center justify-between gap-3">
                            <p class="search-count text-sm text-slate-700"></p>
                            <button type="button" class="search-close text-slate-400 transition hover:text-slate-900" aria-label="Tutup">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                                </svg>
                            </button>
                        </div>
                        <div class="search-popup-results mt-3 max-h-[80vh] overflow-y-auto">
                            <table class="w-full text-left">
                                <thead class="search-popup-head bg-slate-50"></thead>
                                <tbody class="search-popup-body"></tbody>
                            </table>
                        </div>
                    </div>
                    <p class="search-status mt-2 text-sm text-rose-600 hidden"></p>
                </div>
            </div>

            <div id="adminBooksTable" class="overflow-hidden rounded-[1.5rem] border border-slate-100">
                <div class="max-h-[38rem] overflow-y-auto">
                    <table class="w-full text-left">
                        <thead class="sticky top-0 z-10 bg-slate-50">
                        <tr class="text-[11px] uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-5 py-4">Cover</th>
                            <th class="px-5 py-4">Info Buku</th>
                            <th class="px-5 py-4 text-center">Tahun</th>
                            <th class="px-5 py-4 text-center">Stok</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                        </thead>
                        <tbody class="divide-y divide-slate-100 bg-white">
                            @forelse ($books as $book)
                                <tr class="search-row hover:bg-slate-50/80 transition" data-search-key="{{ mb_strtolower($book->judul.' '.$book->penulis.' '.$book->kategori.' '.$book->penerbit) }}">
                                    <td class="px-5 py-5 align-top">
                                        <div class="w-16 h-24 rounded-2xl overflow-hidden bg-slate-100 shadow-sm ring-1 ring-slate-100">
                                            @if ($book->cover)
                                                <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" class="w-full h-full object-cover">
                                            @else
                                                <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                    </svg>
                                                </div>
                                            @endif
                                        </div>
                                    </td>

                                    <td class="px-5 py-5 align-top">
                                        <div class="max-w-xl">
                                            <h4 class="text-lg font-bold text-slate-900 leading-tight">{{ $book->judul }}</h4>
                                            <p class="mt-2 text-sm font-medium text-slate-600">{{ $book->penulis }}</p>
                                            <div class="mt-3 flex flex-wrap items-center gap-2">
                                                <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-blue-700">{{ $book->kategori }}</span>
                                                @if ($book->penerbit)
                                                    <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600">{{ $book->penerbit }}</span>
                                                @endif
                                            </div>
                                        </div>
                                    </td>

                                    <td class="px-5 py-5 text-center align-top">
                                        <span class="font-semibold text-slate-800">{{ $book->tahun_terbit }}</span>
                                    </td>

                                    <td class="px-5 py-5 text-center align-top">
                                        <span class="inline-flex items-center justify-center rounded-full px-3 py-1 text-sm font-black {{ $book->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700' }}">
                                            {{ $book->stok }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-5 text-center align-top">
                                        <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] {{ $book->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700' }}">
                                            <span class="h-2 w-2 rounded-full {{ $book->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500' }}"></span>
                                            {{ $book->stok > 0 ? 'Tersedia' : 'Habis' }}
                                        </span>
                                    </td>

                                    <td class="px-5 py-5 text-center align-top">
                                        <div class="flex items-center justify-center gap-3">
                                            <a href="{{ route('admin.books.edit', $book) }}" class="inline-flex items-center gap-2 rounded-2xl border border-blue-200 bg-white px-4 py-2 text-sm font-semibold text-blue-600 transition hover:bg-blue-50 hover:text-blue-700">
                                                Edit
                                            </a>
                                            <form action="{{ route('admin.books.destroy', $book) }}" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                                @csrf
                                                @method('DELETE')
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Hapus
                                                </button>
                                            </form>
                                        </div>
                                    </td>
                                </tr>
                            @empty
                                <tr>
                                    <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                                        Belum ada buku di katalog.
                                    </td>
                                </tr>
                            @endforelse
                        </tbody>
                    </table>
                </div>
            </div>

            @if ($books->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $books->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
