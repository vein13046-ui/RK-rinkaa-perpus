@extends('layouts.panel')

@section('page-title', 'Status Peminjaman')
@section('page-description', 'Lihat status peminjaman, ambil buku, dan ajukan pengembalian.')

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

        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-6">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Riwayat</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Status Peminjaman Saya</h3>
                    <p class="mt-3 text-slate-600">Jika status sudah approved, buku harus diambil dalam 8 jam atau akan otomatis dibatalkan.</p>
                </div>
                <a href="{{ route('user.books') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    Kembali ke Daftar Buku
                </a>
            </div>
        </div>

        <div class="overflow-hidden rounded-[2rem] border border-slate-100 bg-white shadow-xl shadow-slate-200/60">
            <table class="w-full text-left">
                <thead class="bg-slate-50">
                    <tr class="text-[11px] uppercase tracking-[0.2em] text-slate-400">
                        <th class="px-5 py-4">Buku</th>
                        <th class="px-5 py-4">Nama Peminjam</th>
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
                                <div class="font-semibold text-slate-900">{{ $borrow->book->judul ?? '-' }}</div>
                                <div class="text-xs text-slate-500 mt-1">{{ $borrow->book->penulis ?? '-' }}</div>
                            </td>
                            <td class="px-5 py-4 text-slate-600">{{ $borrow->borrower_name }}</td>
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
                                @if ($borrow->status === 'approved' && $borrow->pickup_deadline)
                                    <div class="mt-2 text-xs font-semibold text-amber-700">
                                        Segera ambil sebelum {{ $borrow->pickup_deadline->translatedFormat('d M Y H:i') }}
                                    </div>
                                @endif
                                @if ($borrow->status === 'picked_up' && $borrow->due_date)
                                    <div class="mt-2 text-xs font-semibold text-slate-500">
                                        Jatuh tempo: {{ $borrow->due_date->translatedFormat('d M Y') }}
                                    </div>
                                @endif
                            </td>
                            <td class="px-5 py-4 text-center text-slate-600">
                                <div>{{ optional($borrow->created_at)->translatedFormat('d M Y') }}</div>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <div class="flex flex-wrap items-center justify-center gap-2">
                                    @if ($borrow->status === 'approved')
                                        <button
                                            type="button"
                                            class="borrow-open inline-flex items-center gap-2 rounded-2xl bg-gradient-to-r from-indigo-500 to-blue-600 px-4 py-2.5 text-sm font-semibold text-white shadow-lg shadow-blue-200 transition hover:from-indigo-600 hover:to-blue-700"
                                            data-action="{{ route('borrow.pickup', $borrow) }}"
                                            data-title="{{ $borrow->book->judul ?? '' }}"
                                            data-author="{{ $borrow->book->penulis ?? '' }}"
                                            data-category="{{ $borrow->book->kategori ?? '' }}"
                                            data-cover="{{ $borrow->book && $borrow->book->cover ? Storage::url($borrow->book->cover) : '' }}"
                                            data-fetch-url="{{ route('borrow.pickup.data', $borrow) }}"
                                            data-code="{{ $borrow->pickup_code }}"
                                            data-deadline="{{ optional($borrow->pickup_deadline)->translatedFormat('d M Y H:i') }}"
                                        >
                                            Ambil Buku
                                        </button>
                                    @elseif ($borrow->status === 'picked_up')
                                        <form action="{{ route('borrow.request-return', $borrow) }}" method="POST">
                                            @csrf
                                            <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                                Kembalikan Buku
                                            </button>
                                        </form>
                                    @elseif ($borrow->status === 'return_pending')
                                        <span class="text-xs font-semibold text-violet-600">Menunggu admin menyetujui pengembalian</span>
                                    @elseif ($borrow->status === 'cancelled')
                                        <span class="text-xs font-semibold text-rose-600">Dibatalkan otomatis karena lewat 8 jam</span>
                                    @elseif ($borrow->status === 'returned')
                                        <span class="text-xs font-semibold text-sky-600">Selesai</span>
                                    @else
                                        <span class="text-xs font-semibold text-slate-400">-</span>
                                    @endif
                                </div>
                            </td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                                Belum ada peminjaman buku.
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>

        @if ($borrows->hasPages())
            <div class="flex justify-center">
                {{ $borrows->links() }}
            </div>
        @endif
    </div>

    <div id="borrowModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 px-4 py-6">
        <div class="w-full max-w-2xl overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-6 sm:p-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Ambil Buku</p>
                    <h3 class="mt-2 text-2xl font-black text-slate-900">Tunjukkan Kode Pickup</h3>
                </div>
                <button type="button" id="borrowClose" class="rounded-2xl border border-slate-200 p-3 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                    </svg>
                </button>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2">
                <div class="bg-slate-50 p-6 sm:p-8">
                    <div class="overflow-hidden rounded-[1.5rem] border border-slate-200 bg-white shadow-sm">
                        <img id="borrowCover" src="" alt="Cover Buku" class="hidden h-72 w-full object-cover">
                        <div id="borrowCoverFallback" class="flex h-72 items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                            <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </div>
                    </div>

                    <div class="mt-5">
                        <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Buku Dipilih</p>
                        <h4 id="borrowTitle" class="mt-2 text-xl font-black text-slate-900"></h4>
                        <p id="borrowMeta" class="mt-2 text-sm text-slate-500"></p>
                        <p id="borrowDeadline" class="mt-2 text-sm font-semibold text-amber-700"></p>
                    </div>

                    <div class="mt-6 rounded-3xl border border-amber-200 bg-amber-50 p-5 text-sm text-amber-900">
                        Jika buku hilang atau rusak, peminjam siap mengganti rugi sesuai biaya yang ditetapkan.
                    </div>
                </div>

                <div class="p-6 sm:p-8">
                    <form id="borrowForm" method="POST" class="space-y-5">
                        @csrf
                        <input type="hidden" name="pickup_code" id="pickupCodeInput">

                        <div id="pickupPanel" class="hidden rounded-3xl border border-slate-200 bg-white p-5">
                            <p class="text-xs font-bold uppercase tracking-[0.22em] text-slate-400">Kode Pickup</p>
                            <div id="pickupBarcode" class="mt-4 flex items-end gap-1 h-24"></div>
                            <div id="pickupCodeLabel" class="mt-4 rounded-2xl bg-slate-950 px-4 py-3 text-center font-mono text-lg font-bold tracking-[0.3em] text-white"></div>
                            <p class="mt-3 text-xs text-slate-500">Kode berubah otomatis setiap 20 menit.</p>
                        </div>

                        <div class="flex flex-col sm:flex-row gap-3 pt-2">
                            <button type="button" id="borrowCancel" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl border border-slate-200 bg-white px-5 py-3.5 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                Batal
                            </button>
                            <button type="submit" class="inline-flex flex-1 items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                                Konfirmasi Ambil
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const borrowModal = document.getElementById('borrowModal');
        const borrowForm = document.getElementById('borrowForm');
        const borrowTitle = document.getElementById('borrowTitle');
        const borrowMeta = document.getElementById('borrowMeta');
        const borrowDeadline = document.getElementById('borrowDeadline');
        const borrowCover = document.getElementById('borrowCover');
        const borrowCoverFallback = document.getElementById('borrowCoverFallback');
        const borrowClose = document.getElementById('borrowClose');
        const borrowCancel = document.getElementById('borrowCancel');
        const pickupPanel = document.getElementById('pickupPanel');
        const pickupBarcode = document.getElementById('pickupBarcode');
        const pickupCodeLabel = document.getElementById('pickupCodeLabel');
        const pickupCodeInput = document.getElementById('pickupCodeInput');

        function buildBarcode(code) {
            pickupBarcode.innerHTML = '';
            const chars = (code || '').replace(/[^A-Z0-9]/gi, '').split('');

            chars.forEach(function (char, index) {
                const bar = document.createElement('div');
                const height = 32 + ((char.charCodeAt(0) + index * 7) % 58);
                const width = 2 + (char.charCodeAt(0) % 3);
                bar.style.height = height + 'px';
                bar.style.width = width + 'px';
                bar.className = 'rounded-full bg-slate-950';
                pickupBarcode.appendChild(bar);
            });
        }

        async function openBorrowModal(button) {
            borrowForm.action = button.dataset.action;
            borrowModal.classList.remove('hidden');
            borrowModal.classList.add('flex');

            const applyData = function (data) {
                borrowTitle.textContent = data.title || button.dataset.title || '';
                borrowMeta.textContent = [
                    data.author || button.dataset.author || '',
                    data.category || button.dataset.category || ''
                ].filter(Boolean).join(' - ');
                borrowDeadline.textContent = data.deadline ? ('Batas ambil: ' + data.deadline) : (button.dataset.deadline ? ('Batas ambil: ' + button.dataset.deadline) : '');

                const cover = data.cover || button.dataset.cover || '';
                if (cover) {
                    borrowCover.src = cover;
                    borrowCover.classList.remove('hidden');
                    borrowCoverFallback.classList.add('hidden');
                } else {
                    borrowCover.src = '';
                    borrowCover.classList.add('hidden');
                    borrowCoverFallback.classList.remove('hidden');
                }

                pickupPanel.classList.remove('hidden');
                pickupCodeInput.value = data.code || button.dataset.code || '';
                pickupCodeLabel.textContent = data.code || button.dataset.code || '';
                buildBarcode(data.code || button.dataset.code || '');
            };

            if (button.dataset.fetchUrl) {
                try {
                    const response = await fetch(button.dataset.fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        const data = await response.json();
                        applyData(data);
                        return;
                    }
                } catch (error) {
                    // fall back to dataset values below
                }
            }

            applyData({});
        }

        function closeBorrowModal() {
            borrowModal.classList.add('hidden');
            borrowModal.classList.remove('flex');
        }

        document.querySelectorAll('.borrow-open').forEach(function (button) {
            button.addEventListener('click', function () {
                openBorrowModal(button);
            });
        });

        if (borrowClose) {
            borrowClose.addEventListener('click', closeBorrowModal);
        }

        if (borrowCancel) {
            borrowCancel.addEventListener('click', closeBorrowModal);
        }

        if (borrowModal) {
            borrowModal.addEventListener('click', function (event) {
                if (event.target === borrowModal) {
                    closeBorrowModal();
                }
            });
        }

        document.addEventListener('keydown', function (event) {
            if (event.key === 'Escape' && borrowModal && !borrowModal.classList.contains('hidden')) {
                closeBorrowModal();
            }
        });
    </script>
@endpush
