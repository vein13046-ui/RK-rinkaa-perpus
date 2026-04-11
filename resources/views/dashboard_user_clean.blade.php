@extends('layouts.panel')

@section('page-title', 'Dashboard Pengguna')
@section('page-description', 'Ringkasan koleksi, aktivitas, dan akses cepat dalam satu tampilan yang rapi.')

@section('content')
    @php
        $bookCount = (int) ($stats['bookCount'] ?? 0);
        $stockCount = (int) ($stats['stockCount'] ?? 0);
        $availableCount = (int) ($stats['availableCount'] ?? 0);
        $categoryCount = (int) ($stats['categoryCount'] ?? 0);
        $availabilityRate = $bookCount > 0 ? (int) round(($availableCount / $bookCount) * 100) : 0;
        $avgStockPerBook = $bookCount > 0 ? round($stockCount / $bookCount, 1) : 0;
        $featuredTotal = $featuredBooks->count();
    @endphp

    <div class="space-y-6 sm:space-y-7">
        <section class="relative overflow-hidden rounded-[2rem] border border-slate-200/70 bg-gradient-to-br from-slate-900 via-blue-900 to-cyan-800 p-6 sm:p-8 text-white shadow-xl shadow-blue-900/20">
            <div class="pointer-events-none absolute -right-20 -top-20 h-56 w-56 rounded-full bg-white/10 blur-3xl"></div>
            <div class="pointer-events-none absolute -bottom-24 -left-20 h-56 w-56 rounded-full bg-cyan-300/10 blur-3xl"></div>

            <div class="relative grid grid-cols-1 gap-6 lg:grid-cols-[1.2fr_0.8fr] lg:items-end">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-blue-100">Ruang Baca Digital</p>
                    <h3 class="mt-3 text-2xl font-black leading-tight sm:text-4xl">Selamat datang, {{ Auth::user()->name }}.</h3>
                    <p class="mt-3 max-w-2xl text-sm text-blue-100 sm:text-base">
                        Dashboard ini dirancang untuk bantu kamu memantau koleksi aktif, menemukan buku baru, dan lanjut ke proses peminjaman lebih cepat.
                    </p>

                    <div class="mt-5 flex flex-wrap items-center gap-2.5 text-xs sm:text-sm">
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5">
                            <span class="h-2 w-2 rounded-full bg-emerald-300 animate-pulse"></span>
                            Ketersediaan {{ $availabilityRate }}%
                        </span>
                        <span class="inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/10 px-3 py-1.5">
                            {{ number_format($featuredTotal) }} buku terbaru ditampilkan
                        </span>
                    </div>
                </div>

                <div class="grid grid-cols-1 gap-3 sm:grid-cols-2 lg:grid-cols-1">
                    <a href="{{ route('user.books') }}" class="inline-flex items-center justify-between rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        <span>Buka Daftar Buku</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"></path>
                        </svg>
                    </a>
                    <a href="{{ route('borrow.user.index') }}" class="inline-flex items-center justify-between rounded-2xl border border-white/20 bg-white/10 px-4 py-3 text-sm font-semibold text-white transition hover:bg-white/20">
                        <span>Lihat Status Peminjaman</span>
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                        </svg>
                    </a>
                </div>
            </div>
        </section>

        <section class="grid grid-cols-1 gap-4 sm:grid-cols-2 xl:grid-cols-4">
            <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-500">Total Buku</p>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-50 text-blue-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($bookCount) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500">Koleksi terdaftar</p>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-500">Total Stok</p>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-emerald-50 text-emerald-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 13V7a2 2 0 00-2-2h-4m-4 0H6a2 2 0 00-2 2v6m16 0v4a2 2 0 01-2 2h-4m-4 0H6a2 2 0 01-2-2v-4m16 0H4"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($stockCount) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500">Seluruh stok fisik</p>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-500">Buku Tersedia</p>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-50 text-cyan-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($availableCount) }}</p>
                <div class="mt-2 h-2 w-full overflow-hidden rounded-full bg-slate-100">
                    <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-blue-600" style="width: {{ max(0, min(100, $availabilityRate)) }}%"></div>
                </div>
                <p class="mt-2 text-xs font-medium text-slate-500">Ketersediaan {{ $availabilityRate }}%</p>
            </article>

            <article class="rounded-3xl border border-slate-200 bg-white p-5 shadow-sm shadow-slate-200/70 transition hover:-translate-y-0.5 hover:shadow-lg">
                <div class="flex items-center justify-between">
                    <p class="text-sm font-semibold text-slate-500">Kategori</p>
                    <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-amber-50 text-amber-700">
                        <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 7h.01M7 3h5c.53 0 1.04.21 1.41.59l7 7a2 2 0 010 2.82l-4.18 4.18a2 2 0 01-2.82 0l-7-7A2 2 0 016 9V4a1 1 0 011-1z"></path>
                        </svg>
                    </span>
                </div>
                <p class="mt-4 text-3xl font-black text-slate-900">{{ number_format($categoryCount) }}</p>
                <p class="mt-2 text-xs font-medium text-slate-500">Rata-rata stok/buku: {{ number_format($avgStockPerBook, 1) }}</p>
            </article>
        </section>

        <section class="grid grid-cols-1 gap-6 xl:grid-cols-3">
            <div class="xl:col-span-2 rounded-[2rem] border border-slate-200 bg-white p-5 sm:p-6 shadow-lg shadow-slate-200/60">
                <div class="mb-5 flex flex-wrap items-end justify-between gap-3">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Kurasi Minggu Ini</p>
                        <h4 class="mt-2 text-2xl font-black text-slate-900">Buku Terbaru Untuk Kamu</h4>
                    </div>
                    <a href="{{ route('user.books') }}" class="inline-flex items-center gap-2 rounded-xl border border-slate-200 px-3.5 py-2 text-sm font-semibold text-slate-700 transition hover:border-blue-200 hover:bg-blue-50 hover:text-blue-700">
                        Jelajahi Semua
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </a>
                </div>

                <div class="grid grid-cols-1 gap-4 md:grid-cols-2">
                    @forelse ($featuredBooks as $book)
                        <article class="group flex gap-3 rounded-2xl border border-slate-100 bg-slate-50/70 p-3.5 transition hover:border-blue-100 hover:bg-white hover:shadow-md">
                            <div class="h-28 w-20 shrink-0 overflow-hidden rounded-xl bg-white shadow-sm">
                                @if ($book->cover)
                                    <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                                @else
                                    <div class="flex h-full w-full items-center justify-center bg-slate-100 text-slate-400">
                                        <svg class="h-7 w-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                @endif
                            </div>

                            <div class="min-w-0">
                                <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-blue-700">{{ $book->kategori }}</span>
                                <h5 class="mt-2 text-sm font-black leading-snug text-slate-900 sm:text-base">{{ $book->judul }}</h5>
                                <p class="mt-1 text-xs text-slate-500 sm:text-sm">{{ $book->penulis }}</p>
                                <p class="mt-2 text-[11px] text-slate-400">{{ $book->penerbit ?? 'Penerbit tidak tersedia' }} - {{ $book->tahun_terbit }}</p>
                            </div>
                        </article>
                    @empty
                        <div class="col-span-full rounded-2xl border border-dashed border-slate-200 bg-slate-50 p-8 text-center text-sm text-slate-500">
                            Belum ada data buku terbaru untuk ditampilkan.
                        </div>
                    @endforelse
                </div>
            </div>

            <div class="space-y-5">
                <section class="rounded-[2rem] border border-slate-200 bg-white p-5 sm:p-6 shadow-lg shadow-slate-200/60">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Akses Cepat</p>
                    <h4 class="mt-2 text-xl font-black text-slate-900">Menu Utama</h4>

                    <div class="mt-4 space-y-3">
                        <a href="{{ route('user.books') }}" class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3 text-slate-700 transition hover:border-blue-200 hover:bg-blue-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-blue-600 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">Daftar Buku</p>
                                <p class="text-xs text-slate-500">Lihat koleksi lengkap</p>
                            </div>
                        </a>

                        <a href="{{ route('borrow.user.index') }}" class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3 text-slate-700 transition hover:border-cyan-200 hover:bg-cyan-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-600 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">Status Peminjaman</p>
                                <p class="text-xs text-slate-500">Pantau proses pinjam</p>
                            </div>
                        </a>

                        <a href="{{ route('profile') }}" class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-3 text-slate-700 transition hover:border-slate-300 hover:bg-slate-50">
                            <span class="inline-flex h-10 w-10 items-center justify-center rounded-xl bg-slate-900 text-white">
                                <svg class="h-5 w-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                </svg>
                            </span>
                            <div class="min-w-0">
                                <p class="text-sm font-semibold text-slate-900">Profil Saya</p>
                                <p class="text-xs text-slate-500">Kelola akun pengguna</p>
                            </div>
                        </a>
                    </div>
                </section>

                <section class="rounded-[2rem] border border-slate-200 bg-white p-5 sm:p-6 shadow-lg shadow-slate-200/60">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Insight Koleksi</p>
                    <h4 class="mt-2 text-xl font-black text-slate-900">Ringkasan Cepat</h4>

                    <div class="mt-4 space-y-4">
                        <div>
                            <div class="mb-1.5 flex items-center justify-between text-xs text-slate-500">
                                <span>Ketersediaan buku</span>
                                <span class="font-semibold text-slate-700">{{ $availabilityRate }}%</span>
                            </div>
                            <div class="h-2 w-full overflow-hidden rounded-full bg-slate-100">
                                <div class="h-full rounded-full bg-gradient-to-r from-cyan-500 to-blue-600" style="width: {{ max(0, min(100, $availabilityRate)) }}%"></div>
                            </div>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3.5">
                            <p class="text-xs font-semibold text-slate-500">Rata-rata stok per buku</p>
                            <p class="mt-1 text-lg font-black text-slate-900">{{ number_format($avgStockPerBook, 1) }}</p>
                        </div>

                        <div class="rounded-2xl border border-slate-100 bg-slate-50 p-3.5">
                            <p class="text-xs font-semibold text-slate-500">Kerapatan kategori</p>
                            <p class="mt-1 text-lg font-black text-slate-900">{{ number_format($categoryCount) }} kategori aktif</p>
                        </div>
                    </div>
                </section>
            </div>
        </section>
    </div>
@endsection
