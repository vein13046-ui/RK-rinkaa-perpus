@extends('layouts.panel')

@section('page-title', 'Info Aplikasi')
@section('page-description', 'Detail tentang aplikasi perpustakaan dan informasi pembuat web.')

@section('content')
    <div class="mx-auto max-w-6xl space-y-6">
        <div class="relative overflow-hidden rounded-[2rem] border border-slate-100 bg-white p-6 shadow-xl shadow-slate-200/60 sm:p-8">
            <div class="pointer-events-none absolute inset-0 bg-[radial-gradient(circle_at_top_right,rgba(59,130,246,0.10),transparent_30%),radial-gradient(circle_at_bottom_left,rgba(16,185,129,0.08),transparent_28%)]"></div>

            <div class="relative flex flex-col gap-6 lg:flex-row lg:items-center lg:justify-between">
                <div class="max-w-3xl">
                    <div class="inline-flex items-center gap-2 rounded-full border border-blue-100 bg-blue-50 px-3 py-1 text-xs font-bold uppercase tracking-[0.22em] text-blue-700">
                        <span class="h-2 w-2 rounded-full bg-blue-500"></span>
                        Tentang Aplikasi
                    </div>
                    <h1 class="mt-4 text-3xl font-black tracking-tight text-slate-900 sm:text-4xl">
                        Info Aplikasi <span class="text-blue-600">Perpustakaan</span>
                    </h1>
                    <p class="mt-4 max-w-2xl text-base leading-7 text-slate-600">
                        Halaman ini menjelaskan tujuan aplikasi, fitur utama, dan kontak pembuat agar pengguna lebih mudah memahami sistem yang digunakan.
                    </p>
                </div>

                <div class="grid w-full max-w-sm grid-cols-2 gap-3">
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Fokus</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Manajemen buku</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Akses</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Admin dan user</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Fitur</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Peminjaman buku</p>
                    </div>
                    <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4 shadow-sm backdrop-blur">
                        <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Riwayat</p>
                        <p class="mt-2 text-sm font-semibold text-slate-900">Status & pengembalian</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="grid gap-6 lg:grid-cols-[1.35fr_0.85fr]">
            <div class="space-y-6">
                <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/50 sm:p-8">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-blue-50 text-blue-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Deskripsi</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-900">Fungsi Aplikasi</h2>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 md:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Manajemen Buku</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Aplikasi ini membantu pengelolaan koleksi buku, stok, kategori, dan data penulis dalam satu tampilan yang sederhana dan efisien.
                            </p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Peminjaman Buku</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Pengguna dapat mengajukan peminjaman, melihat status, dan memantau proses pengambilan maupun pengembalian buku.
                            </p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Kontrol Admin</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Admin memiliki akses untuk memverifikasi permintaan, mengelola data pengguna, dan memantau aktivitas peminjaman.
                            </p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <h3 class="text-base font-bold text-slate-900">Riwayat Transaksi</h3>
                            <p class="mt-2 text-sm leading-6 text-slate-600">
                                Riwayat peminjaman tersimpan dengan rapi sehingga proses pelacakan, evaluasi, dan pencarian data menjadi lebih mudah.
                            </p>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/50 sm:p-8">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-emerald-50 text-emerald-600">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Kelebihan</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-900">Apa yang Membuatnya Praktis</h2>
                        </div>
                    </div>

                    <div class="mt-6 grid gap-4 sm:grid-cols-2">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-bold text-emerald-700">Tampilan lebih bersih</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Susunan kartu dan spacing dibuat supaya informasi lebih mudah dibaca.</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-5">
                            <p class="text-sm font-bold text-blue-700">Alur lebih jelas</p>
                            <p class="mt-2 text-sm leading-6 text-slate-600">Pengguna dapat memahami proses dari katalog hingga status peminjaman dengan cepat.</p>
                        </div>
                    </div>
                </div>
            </div>

            <aside class="space-y-6">
                <div class="rounded-[2rem] border border-slate-100 bg-white p-6 shadow-lg shadow-slate-200/50 sm:p-8">
                    <div class="flex items-center gap-3">
                        <div class="flex h-12 w-12 items-center justify-center rounded-2xl bg-slate-900 text-white">
                            <svg class="h-6 w-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 12H8m8 4H8m2 8h4a2 2 0 002-2v-2H8v2a2 2 0 002 2zm6-18H6a2 2 0 00-2 2v12a2 2 0 002 2h12a2 2 0 002-2V6a2 2 0 00-2-2z"></path>
                            </svg>
                        </div>
                        <div>
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Pembuat</p>
                            <h2 class="mt-1 text-2xl font-black text-slate-900">Informasi Kontak</h2>
                        </div>
                    </div>

                    <div class="mt-6 space-y-4">
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Nama</p>
                            <p class="mt-1 text-sm font-semibold text-slate-900">Daelingka Gilgin Gesando</p>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">Email</p>
                            <a href="mailto:vein13046@gmail.com" class="mt-1 inline-block text-sm font-semibold text-blue-600 hover:underline">
                                vein13046@gmail.com
                            </a>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">WA / Telepon</p>
                            <a href="tel:083102226823" class="mt-1 inline-block text-sm font-semibold text-blue-600 hover:underline">
                                083102226823
                            </a>
                        </div>
                        <div class="rounded-3xl border border-slate-200 bg-slate-50 p-4">
                            <p class="text-[11px] font-bold uppercase tracking-[0.18em] text-slate-400">GitHub</p>
                            <a href="https://github.com/vein13046" target="_blank" rel="noopener noreferrer" class="mt-1 inline-block text-sm font-semibold text-blue-600 hover:underline">
                                github.com/vein13046
                            </a>
                        </div>
                    </div>
                </div>

                <div class="rounded-[2rem] border border-slate-100 bg-gradient-to-br from-slate-900 to-slate-800 p-6 text-white shadow-lg shadow-slate-200/50 sm:p-8">
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-300">Ringkasan</p>
                    <h2 class="mt-2 text-2xl font-black">Kontak Singkat</h2>
                    <p class="mt-3 text-sm leading-6 text-slate-300">
                        Gunakan informasi di bawah ini jika ingin menghubungi pembuat aplikasi untuk pertanyaan, masukan, atau pengembangan lanjutan.
                    </p>

                    <div class="mt-6 space-y-3">
                        <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-300">Email</p>
                            <p class="mt-1 text-sm font-semibold">vein13046@gmail.com</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-300">Telepon</p>
                            <p class="mt-1 text-sm font-semibold">083102226823</p>
                        </div>
                        <div class="rounded-3xl bg-white/10 p-4 backdrop-blur">
                            <p class="text-xs font-bold uppercase tracking-[0.18em] text-slate-300">GitHub</p>
                            <p class="mt-1 text-sm font-semibold">github.com/vein13046</p>
                        </div>
                    </div>
                </div>
            </aside>
        </div>
    </div>
@endsection
