@extends('layouts.panel')

@section('page-title', 'Riwayat Peminjaman')
@section('page-description', 'Lihat riwayat peminjaman buku yang telah dikembalikan.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        <div class="px-6 sm:px-8 py-5">
            <label for="historySearch" class="sr-only">Cari riwayat</label>
            <div class="relative max-w-3xl">
                <input id="historySearch" type="search" data-search-target="#historyTable" data-search-rows=".search-row" placeholder="Cari nama akun atau buku..." class="search-input w-full rounded-2xl border border-slate-200 bg-slate-50 pr-12 pl-4 py-3 text-sm text-slate-900 outline-none focus:border-blue-400 focus:ring-2 focus:ring-blue-100" />
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

        <div id="historyTable" class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[11px] uppercase tracking-[0.2em] text-slate-400">
                        <th class="px-5 py-4">Buku</th>
                        <th class="px-5 py-4">Nama Peminjam</th>
                        <th class="px-5 py-4 text-center">Hari</th>
                        <th class="px-5 py-4">Tanggal Pinjam</th>
                        <th class="px-5 py-4">Tanggal Kembali</th>
                        <th class="px-5 py-4">Biaya</th>
                        <th class="px-5 py-4 text-center">Aksi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100 bg-white max-h-96 overflow-y-auto">
                    @forelse ($histories as $history)
                        <tr class="search-row hover:bg-slate-50 transition" data-search-key="{{ mb_strtolower(($history->borrower_name ?? '').' '.($history->book->judul ?? '').' '.($history->book->penulis ?? '')) }}">
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <img src="{{ $history->book && $history->book->cover ? Storage::url($history->book->cover) : 'https://via.placeholder.com/40x60?text=No+Cover' }}" alt="{{ $history->book->judul ?? 'Buku' }}" class="w-10 h-14 rounded-lg object-cover shadow-sm">
                                    <div class="min-w-0">
                                        <p class="font-semibold text-slate-900 truncate">{{ $history->book->judul ?? 'Buku' }}</p>
                                        <p class="text-sm text-slate-500 truncate">{{ $history->book->penulis ?? '-' }}</p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-medium text-slate-900">{{ $history->borrower_name }}</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <span class="inline-flex items-center rounded-full bg-blue-100 px-2.5 py-1 text-xs font-semibold text-blue-800">{{ $history->borrow_days }} hari</span>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm text-slate-900">{{ $history->picked_up_at ? $history->picked_up_at->translatedFormat('d M Y H:i') : '-' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="text-sm text-slate-900">{{ $history->returned_at ? $history->returned_at->translatedFormat('d M Y H:i') : '-' }}</p>
                            </td>
                            <td class="px-5 py-4">
                                <p class="font-semibold text-slate-900">Rp {{ number_format($history->total_cost) }}</p>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <form method="POST" action="{{ route('borrow.history.delete', $history) }}" class="inline">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="inline-flex items-center gap-1 rounded-lg bg-rose-100 px-3 py-1.5 text-xs font-semibold text-rose-700 transition hover:bg-rose-200" onclick="return confirm('Apakah Anda yakin ingin menghapus riwayat ini?')">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"></path>
                                        </svg>
                                        Hapus
                                    </button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="7" class="px-5 py-12 text-center text-slate-500">
                                <svg class="w-12 h-12 mx-auto mb-4 text-slate-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                </svg>
                                <p class="text-lg font-medium text-slate-900 mb-1">Belum ada riwayat peminjaman</p>
                                <p class="text-sm">Riwayat peminjaman yang telah selesai akan muncul di sini.</p>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection