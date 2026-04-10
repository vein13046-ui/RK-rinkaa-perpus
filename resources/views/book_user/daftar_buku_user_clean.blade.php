@extends('layouts.panel')

@section('page-title', 'Daftar Buku')
@section('page-description', 'Koleksi buku untuk pengguna dengan tampilan yang lebih bersih dan modern.')

@section('content')
    <div class="space-y-6">
        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Koleksi</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Daftar Buku Tersedia</h3>
                    <p class="mt-3 text-slate-600">{{ $books->total() }} buku tersedia di katalog.</p>
                </div>
                <a href="{{ route('dashboard') }}" class="inline-flex items-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
                    </svg>
                    Kembali ke Dashboard
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-5">
            @forelse ($books as $book)
                <article class="group overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-lg shadow-slate-200/50 transition hover:-translate-y-1 hover:shadow-2xl">
                    <div class="relative h-72 bg-slate-100">
                        @if ($book->cover)
                            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif
                        <div class="absolute right-4 top-4">
                            <span class="inline-flex items-center rounded-full bg-white/90 px-3 py-1 text-xs font-bold text-slate-700 shadow-sm">
                                Stok {{ $book->stok }}
                            </span>
                        </div>
                    </div>

                    <div class="p-5">
                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-blue-700">{{ $book->kategori }}</span>
                        <h4 class="mt-3 text-lg font-black leading-tight text-slate-900">{{ $book->judul }}</h4>
                        <p class="mt-2 text-sm font-medium text-slate-600">{{ $book->penulis }}</p>
                        <p class="mt-3 text-sm text-slate-500">{{ $book->penerbit ?? 'Penerbit tidak tersedia' }} • {{ $book->tahun_terbit }}</p>
                    </div>
                </article>
            @empty
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white p-12 text-center text-slate-500">
                    Belum ada buku yang tersedia.
                </div>
            @endforelse
        </div>

        @if ($books->hasPages())
            <div class="flex justify-center">
                {{ $books->links() }}
            </div>
        @endif
    </div>
@endsection
