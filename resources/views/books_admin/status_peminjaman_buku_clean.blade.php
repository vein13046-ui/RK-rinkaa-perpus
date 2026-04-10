@extends('layouts.panel')

@section('page-title', 'Status Peminjaman')
@section('page-description', 'Kelola permintaan peminjaman, pengambilan, dan pengembalian buku.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('borrow_action'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                {{ $errors->first('borrow_action') }}
            </div>
        @endif

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-5">
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Pending</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['pending'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600">Menunggu</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Approved</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['approved'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600">Siap</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Diambil</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['picked_up'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">Aktif</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Return Pending</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['return_pending'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-violet-600">Cek</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Returned</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['returned'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-sky-600">Selesai</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Cancelled</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900">{{ number_format($stats['cancelled'] ?? 0) }}</span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-rose-600">Auto</span>
                </div>
            </div>
        </div>

        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6 mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Permintaan Masuk</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Data Peminjaman Buku</h3>
                    <p class="mt-3 text-slate-600">Approve untuk memberi waktu 8 jam ambil buku. Pengembalian juga menunggu persetujuan admin.</p>
                </div>
            </div>

            <div class="overflow-hidden rounded-[1.5rem] border border-slate-100">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-5 py-4">Peminjam</th>
                            <th class="px-5 py-4">Buku</th>
                            <th class="px-5 py-4 text-center">Hari</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-center">Tanggal</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        @forelse ($borrows as $borrow)
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900">{{ $borrow->borrower_name }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $borrow->user->email ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900">{{ $borrow->book->judul ?? '-' }}</div>
                                    <div class="text-xs text-slate-500 mt-1">{{ $borrow->book->penulis ?? '-' }}</div>
                                </td>
                                <td class="px-5 py-4 text-center font-semibold text-slate-800">{{ $borrow->borrow_days }}</td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.18em]
                                        {{ $borrow->status === 'pending' ? 'bg-amber-100 text-amber-700' : '' }}
                                        {{ $borrow->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : '' }}
                                        {{ $borrow->status === 'picked_up' ? 'bg-blue-100 text-blue-700' : '' }}
                                        {{ $borrow->status === 'return_pending' ? 'bg-violet-100 text-violet-700' : '' }}
                                        {{ $borrow->status === 'returned' ? 'bg-sky-100 text-sky-700' : '' }}
                                        {{ $borrow->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : '' }}
                                        {{ $borrow->status === 'rejected' ? 'bg-slate-100 text-slate-600' : '' }}">
                                        {{ $borrow->status_label }}
                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center text-slate-600">
                                    <div>{{ optional($borrow->created_at)->translatedFormat('d M Y') }}</div>
                                    @if ($borrow->pickup_deadline)
                                        <div class="mt-1 text-xs text-amber-600">Ambil: {{ $borrow->pickup_deadline->translatedFormat('d M Y H:i') }}</div>
                                    @endif
                                    @if ($borrow->due_date)
                                        <div class="mt-1 text-xs text-slate-400">Jatuh tempo: {{ $borrow->due_date->translatedFormat('d M Y') }}</div>
                                    @endif
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        @if ($borrow->status === 'pending')
                                            <form action="{{ route('admin.borrow.approve', $borrow) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.borrow.reject', $borrow) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Tolak
                                                </button>
                                            </form>
                                        @elseif ($borrow->status === 'return_pending')
                                            <form action="{{ route('admin.borrow.return', $borrow) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                                    Setujui Kembali
                                                </button>
                                            </form>
                                            <form action="{{ route('admin.borrow.return.reject', $borrow) }}" method="POST">
                                                @csrf
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Tolak Kembali
                                                </button>
                                            </form>
                                        @elseif ($borrow->status === 'approved')
                                            <span class="text-xs font-semibold text-emerald-600">Menunggu user mengambil</span>
                                        @elseif ($borrow->status === 'picked_up')
                                            <span class="text-xs font-semibold text-blue-600">Sedang dipinjam</span>
                                        @else
                                            <span class="text-xs font-semibold text-slate-400">Tidak ada aksi</span>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            </div>

            @if ($borrows->hasPages())
                <div class="mt-8 flex justify-center">
                    {{ $borrows->links() }}
                </div>
            @endif
        </div>
    </div>
@endsection
