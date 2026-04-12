@extends('layouts.panel')

@section('page-title', 'Daftar Buku')
@section('page-description', 'Pilih buku, lalu ajukan peminjaman dengan sistem pending.')

@section('content')
    <div class="space-y-6">
        @if (session('success'))
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                {{ session('success') }}
            </div>
        @endif

        @if ($errors->has('borrow_request'))
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                {{ $errors->first('borrow_request') }}
            </div>
        @endif

        <div class="rounded-[1.75rem] bg-white border border-slate-100 shadow-lg shadow-slate-200/50 p-5 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Koleksi</p>
                    <h3 class="mt-2 text-2xl sm:text-3xl font-black text-slate-900">Daftar Buku Tersedia</h3>
                    <p class="mt-3 max-w-2xl text-sm sm:text-base text-slate-600">{{ $books->total() }} buku tersedia. Admin punya waktu 8 jam untuk konfirmasi ambil buku setelah approve.</p>
                </div>
                <a href="{{ route('borrow.user.index') }}" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Status Peminjaman
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-3 sm:gap-4">
            @forelse ($books as $book)
                @php
                    $activeBorrow = $activeBorrowMap[$book->id] ?? null;
                @endphp

                <article class="group overflow-hidden rounded-[1.25rem] border border-slate-100 bg-white shadow-sm shadow-slate-200/40 transition hover:-translate-y-0.5 hover:shadow-lg">
                    <div class="relative h-44 sm:h-48 bg-slate-100">
                        @if ($book->cover)
                            <img src="{{ Storage::url($book->cover) }}" alt="{{ $book->judul }}" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        @else
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        @endif

                        <div class="absolute right-2.5 top-2.5">
                            <span class="inline-flex items-center rounded-full bg-white/90 px-2 py-1 text-[10px] font-bold text-slate-700 shadow-sm">
                                Stok {{ $book->stok }}
                            </span>
                        </div>

                        @if ($activeBorrow)
                            <div class="absolute left-2.5 top-2.5">
                                <span class="inline-flex items-center rounded-full bg-slate-900/90 px-2 py-1 text-[10px] font-bold text-white shadow-sm">
                                    {{ $activeBorrow->status_label }}
                                </span>
                            </div>
                        @endif
                    </div>

                    <div class="p-3.5 sm:p-4">
                        <span class="inline-flex rounded-full bg-blue-100 px-2 py-1 text-[9px] font-bold uppercase tracking-[0.14em] text-blue-700">{{ $book->kategori }}</span>
                        <h4 class="mt-2 text-sm sm:text-base font-black leading-tight text-slate-900">{{ $book->judul }}</h4>
                        <p class="mt-1 text-xs sm:text-sm font-medium text-slate-600">{{ $book->penulis }}</p>
                        <p class="mt-2 text-xs text-slate-500">{{ $book->penerbit ?? 'Penerbit tidak tersedia' }} - {{ $book->tahun_terbit }}</p>

                        <div class="mt-3 flex items-center justify-between gap-2">
                            <span class="text-[10px] font-medium text-slate-400">Stok {{ $book->stok }}</span>

                            @if ($activeBorrow && $activeBorrow->status === 'approved')
                                <button
                                    type="button"
                                    class="borrow-open inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-indigo-500 to-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm shadow-blue-200 transition hover:from-indigo-600 hover:to-blue-700"
                                    data-action="{{ route('borrow.pickup', $activeBorrow) }}"
                                    data-title="{{ $book->judul }}"
                                    data-author="{{ $book->penulis }}"
                                    data-category="{{ $book->kategori }}"
                                    data-cover="{{ $book->cover ? Storage::url($book->cover) : '' }}"
                                    data-fetch-url="{{ route('borrow.pickup.data', $activeBorrow) }}"
                                    data-code="{{ $activeBorrow->pickup_code }}"
                                    data-deadline="{{ optional($activeBorrow->pickup_deadline)->translatedFormat('d M Y H:i') }}"
                                >
                                    Ambil Buku
                                </button>
                            @elseif ($activeBorrow && $activeBorrow->status === 'picked_up')
                                <form action="{{ route('borrow.request-return', $activeBorrow) }}" method="POST">
                                    @csrf
                                    <button type="submit" class="inline-flex items-center gap-1.5 rounded-lg bg-slate-900 px-3 py-1.5 text-[11px] font-semibold text-white transition hover:bg-slate-800">
                                        Kembalikan Buku
                                    </button>
                                </form>
                            @elseif ($activeBorrow && $activeBorrow->status === 'return_pending')
                                <span class="inline-flex items-center rounded-lg bg-amber-100 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700">
                                    Menunggu konfirmasi kembali
                                </span>
                            @elseif ($activeBorrow && $activeBorrow->status === 'pending')
                                <span class="inline-flex items-center rounded-lg bg-amber-100 px-2.5 py-1.5 text-[10px] font-semibold text-amber-700">
                                    Menunggu admin
                                </span>
                            @elseif ($activeBorrow && $activeBorrow->status === 'cancelled')
                                <span class="inline-flex items-center rounded-lg bg-rose-100 px-2.5 py-1.5 text-[10px] font-semibold text-rose-700">
                                    Dibatalkan
                                </span>
                            @elseif ($book->stok > 0)
                                <button
                                    type="button"
                                    class="borrow-start inline-flex items-center gap-1.5 rounded-lg bg-gradient-to-r from-indigo-500 to-blue-600 px-3 py-1.5 text-[11px] font-semibold text-white shadow-sm shadow-blue-200 transition hover:from-indigo-600 hover:to-blue-700"
                                    data-action="{{ route('borrow.store', $book) }}"
                                    data-title="{{ $book->judul }}"
                                    data-author="{{ $book->penulis }}"
                                    data-category="{{ $book->kategori }}"
                                    data-cover="{{ $book->cover ? Storage::url($book->cover) : '' }}"
                                >
                                    Pinjam
                                </button>
                            @else
                                <button type="button" disabled class="inline-flex items-center gap-1.5 rounded-lg bg-slate-200 px-3 py-1.5 text-[11px] font-semibold text-slate-500 cursor-not-allowed">
                                    Stok Habis
                                </button>
                            @endif
                        </div>
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

    <div id="borrowModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 px-3 py-4 sm:px-4 sm:py-6">
        <div class="w-full max-w-xl sm:max-w-2xl overflow-hidden rounded-[1.5rem] bg-white shadow-2xl shadow-slate-900/20 max-h-[90vh]">
            <div class="max-h-[90vh] overflow-y-auto">
                <div class="flex items-start justify-between gap-3 border-b border-slate-100 p-4 sm:p-5">
                    <div>
                        <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Form Peminjaman</p>
                        <h3 class="mt-1.5 text-xl sm:text-2xl font-black text-slate-900">Konfirmasi Pinjam Buku</h3>
                    </div>
                    <button type="button" id="borrowClose" class="rounded-xl border border-slate-200 p-2 text-slate-500 transition hover:bg-slate-50 hover:text-slate-700">
                        <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                        </svg>
                    </button>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2">
                    <div class="bg-slate-50 p-4 sm:p-5">
                        <div class="overflow-hidden rounded-[1.1rem] border border-slate-200 bg-white shadow-sm">
                            <img id="borrowCover" src="" alt="Cover Buku" class="hidden h-44 sm:h-52 w-full object-cover">
                            <div id="borrowCoverFallback" class="flex h-44 sm:h-52 items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <svg class="w-12 h-12" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        </div>

                        <div class="mt-4">
                            <p class="text-[10px] font-bold uppercase tracking-[0.18em] text-slate-400">Buku Dipilih</p>
                            <h4 id="borrowTitle" class="mt-1.5 text-lg sm:text-xl font-black text-slate-900"></h4>
                            <p id="borrowMeta" class="mt-1.5 text-sm text-slate-500"></p>
                            <p id="borrowDeadline" class="mt-1.5 text-sm font-semibold text-amber-700"></p>
                        </div>

                        <div class="mt-4 rounded-2xl border border-amber-200 bg-amber-50 p-4 text-xs sm:text-sm text-amber-900">
                            Jika buku hilang atau rusak, peminjam siap mengganti rugi sesuai biaya yang ditetapkan.
                        </div>
                    </div>

                    <div class="p-4 sm:p-5">
                        <form id="borrowForm" method="POST" class="space-y-4">
                            @csrf
                            <input type="hidden" name="pickup_code" id="pickupCodeInput">

                            <div id="borrowConfigFields" class="space-y-4">
                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Nama Peminjam</label>
                                    <input id="borrowerNameInput" type="text" name="borrower_name" data-default="{{ Auth::user()->name }}" value="{{ Auth::user()->name }}" required class="w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Lama Peminjaman</label>
                                    <select id="borrowDaysInput" name="borrow_days" required class="w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                        <option value="">Pilih hari</option>
                                        <option value="1">1 Hari</option>
                                        <option value="2">2 Hari</option>
                                        <option value="3">3 Hari</option>
                                    </select>
                                    <p class="mt-1.5 text-[11px] text-slate-500">Biaya sewa Rp3.000 per hari (maksimal 3 hari).</p>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Metode Pembayaran</label>
                                    <select id="paymentMethodInput" name="payment_method" required class="w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                        <option value="cash">Cash</option>
                                    </select>
                                </div>

                                <div>
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Metode Pengambilan</label>
                                    <select id="pickupMethodInput" name="pickup_method" required class="w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                        <option value="self_pickup">Diambil ke tempat</option>
                                        <option value="delivery">Diantar</option>
                                    </select>
                                </div>

                                <div id="deliveryDistanceWrap" class="hidden">
                                    <label class="mb-1.5 block text-sm font-semibold text-slate-700">Jarak Antar (meter)</label>
                                    <input id="deliveryDistanceInput" type="number" name="delivery_distance_meters" min="1" step="1" class="w-full rounded-xl border border-slate-200 px-3.5 py-3 text-sm text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100" placeholder="Contoh: 350">
                                    <p class="mt-1.5 text-[11px] text-slate-500">Tarif antar Rp500 per 100 meter.</p>
                                </div>

                                <div id="borrowCostCard" class="rounded-xl border border-slate-200 bg-slate-50 p-3.5">
                                    <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Estimasi Biaya</p>
                                    <div class="mt-2 space-y-1.5 text-sm text-slate-700">
                                        <div class="flex items-center justify-between">
                                            <span>Biaya sewa</span>
                                            <span id="dailyCostLabel" class="font-semibold">Rp0</span>
                                        </div>
                                        <div class="flex items-center justify-between">
                                            <span>Biaya antar</span>
                                            <span id="deliveryCostLabel" class="font-semibold">Rp0</span>
                                        </div>
                                    </div>
                                    <div class="mt-3 border-t border-slate-200 pt-2.5 flex items-center justify-between">
                                        <span class="text-sm font-bold text-slate-800">Total</span>
                                        <span id="totalCostLabel" class="text-base font-black text-slate-900">Rp0</span>
                                    </div>
                                </div>

                                <label class="flex items-start gap-2.5 rounded-xl border border-slate-200 bg-slate-50 p-3 text-xs sm:text-sm text-slate-600">
                                    <input id="damageAgreementInput" type="checkbox" name="damage_agreement" value="1" required class="mt-0.5 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                                    <span>Saya menyetujui bahwa jika buku hilang atau rusak, saya siap mengganti rugi sesuai ketentuan yang berlaku.</span>
                                </label>
                            </div>

                            <div id="pickupPanel" class="hidden rounded-2xl border border-slate-200 bg-white p-4">
                                <p class="text-[10px] font-bold uppercase tracking-[0.2em] text-slate-400">Kode Pickup</p>
                                <div id="pickupBarcode" class="mt-3 flex items-end gap-1 h-20"></div>
                                <div id="pickupCodeLabel" class="mt-3 rounded-xl bg-slate-950 px-3 py-2.5 text-center font-mono text-base font-bold tracking-[0.24em] text-white"></div>
                                <p class="mt-2 text-[11px] text-slate-500">Kode berubah otomatis setiap 20 menit.</p>
                            </div>

                            <div class="flex flex-col sm:flex-row gap-2.5 pt-1">
                                <button type="button" id="borrowCancel" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl border border-slate-200 bg-white px-4 py-3 text-sm font-semibold text-slate-700 transition hover:bg-slate-50">
                                    Batal
                                </button>
                                <button type="submit" id="borrowSubmitBtn" class="inline-flex flex-1 items-center justify-center gap-2 rounded-xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                                    Konfirmasi Pinjam
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>
        const DAILY_RATE = 3000;
        const DELIVERY_RATE_PER_100M = 500;
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
        const borrowConfigFields = document.getElementById('borrowConfigFields');
        const borrowerNameInput = document.getElementById('borrowerNameInput');
        const borrowDaysInput = document.getElementById('borrowDaysInput');
        const paymentMethodInput = document.getElementById('paymentMethodInput');
        const pickupMethodInput = document.getElementById('pickupMethodInput');
        const deliveryDistanceWrap = document.getElementById('deliveryDistanceWrap');
        const deliveryDistanceInput = document.getElementById('deliveryDistanceInput');
        const damageAgreementInput = document.getElementById('damageAgreementInput');
        const dailyCostLabel = document.getElementById('dailyCostLabel');
        const deliveryCostLabel = document.getElementById('deliveryCostLabel');
        const totalCostLabel = document.getElementById('totalCostLabel');
        const borrowSubmitBtn = document.getElementById('borrowSubmitBtn');

        function formatRupiah(value) {
            const amount = Number.isFinite(value) ? value : 0;
            return 'Rp' + new Intl.NumberFormat('id-ID').format(amount);
        }

        function toggleDeliveryDistanceField() {
            if (!pickupMethodInput || !deliveryDistanceWrap || !deliveryDistanceInput) {
                return;
            }

            const isDelivery = pickupMethodInput.value === 'delivery';
            deliveryDistanceWrap.classList.toggle('hidden', !isDelivery);
            deliveryDistanceInput.required = isDelivery && !borrowConfigFields.classList.contains('hidden');

            if (!isDelivery) {
                deliveryDistanceInput.value = '';
            }
        }

        function updateBorrowCostCard() {
            const borrowDays = parseInt((borrowDaysInput && borrowDaysInput.value) ? borrowDaysInput.value : '0', 10) || 0;
            const rentalCost = borrowDays * DAILY_RATE;
            const isDelivery = pickupMethodInput && pickupMethodInput.value === 'delivery';
            const distanceMeters = parseInt((deliveryDistanceInput && deliveryDistanceInput.value) ? deliveryDistanceInput.value : '0', 10) || 0;
            const deliveryCost = isDelivery ? Math.ceil(distanceMeters / 100) * DELIVERY_RATE_PER_100M : 0;
            const totalCost = rentalCost + deliveryCost;

            if (dailyCostLabel) {
                dailyCostLabel.textContent = formatRupiah(rentalCost);
            }
            if (deliveryCostLabel) {
                deliveryCostLabel.textContent = formatRupiah(deliveryCost);
            }
            if (totalCostLabel) {
                totalCostLabel.textContent = formatRupiah(totalCost);
            }
        }

        function setBorrowFieldsRequired(isRequired) {
            if (borrowerNameInput) {
                borrowerNameInput.required = isRequired;
            }
            if (borrowDaysInput) {
                borrowDaysInput.required = isRequired;
            }
            if (paymentMethodInput) {
                paymentMethodInput.required = isRequired;
            }
            if (pickupMethodInput) {
                pickupMethodInput.required = isRequired;
            }
            if (damageAgreementInput) {
                damageAgreementInput.required = isRequired;
            }

            toggleDeliveryDistanceField();

            if (!isRequired && deliveryDistanceInput) {
                deliveryDistanceInput.required = false;
            }
        }

        function resetBorrowConfig() {
            if (borrowerNameInput) {
                borrowerNameInput.value = borrowerNameInput.dataset.default || '';
            }
            if (borrowDaysInput) {
                borrowDaysInput.value = '';
            }
            if (paymentMethodInput) {
                paymentMethodInput.value = 'cash';
            }
            if (pickupMethodInput) {
                pickupMethodInput.value = 'self_pickup';
            }
            if (deliveryDistanceInput) {
                deliveryDistanceInput.value = '';
            }
            if (damageAgreementInput) {
                damageAgreementInput.checked = false;
            }

            toggleDeliveryDistanceField();
            updateBorrowCostCard();
        }

        function setBorrowMode(isPickup) {
            if (!borrowConfigFields || !pickupPanel) {
                return;
            }

            borrowConfigFields.classList.toggle('hidden', isPickup);
            pickupPanel.classList.toggle('hidden', !isPickup);
            setBorrowFieldsRequired(!isPickup);

            if (borrowSubmitBtn) {
                borrowSubmitBtn.textContent = isPickup ? 'Konfirmasi Ambil' : 'Konfirmasi Pinjam';
            }
        }

        function buildBarcode(code) {
            if (!pickupBarcode) {
                return;
            }

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

        async function openBorrowModal(button, isPickup = false) {
            borrowForm.action = button.dataset.action;
            borrowModal.classList.remove('hidden');
            borrowModal.classList.add('flex');

            if (isPickup) {
                setBorrowMode(true);
            } else {
                setBorrowMode(false);
                resetBorrowConfig();
                pickupCodeInput.value = '';
                pickupCodeLabel.textContent = '';
                pickupBarcode.innerHTML = '';
            }

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

                if (isPickup) {
                    pickupCodeInput.value = data.code || button.dataset.code || '';
                    pickupCodeLabel.textContent = data.code || button.dataset.code || '';
                    buildBarcode(data.code || button.dataset.code || '');
                }
            };

            if (isPickup && button.dataset.fetchUrl) {
                try {
                    const response = await fetch(button.dataset.fetchUrl, {
                        headers: {
                            'X-Requested-With': 'XMLHttpRequest',
                            'Accept': 'application/json'
                        }
                    });

                    if (response.ok) {
                        applyData(await response.json());
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

        document.querySelectorAll('.borrow-start').forEach(function (button) {
            button.addEventListener('click', function () {
                openBorrowModal(button, false);
            });
        });

        document.querySelectorAll('.borrow-open').forEach(function (button) {
            button.addEventListener('click', function () {
                openBorrowModal(button, true);
            });
        });

        if (pickupMethodInput) {
            pickupMethodInput.addEventListener('change', function () {
                toggleDeliveryDistanceField();
                updateBorrowCostCard();
            });
        }

        if (borrowDaysInput) {
            borrowDaysInput.addEventListener('change', updateBorrowCostCard);
        }

        if (deliveryDistanceInput) {
            deliveryDistanceInput.addEventListener('input', updateBorrowCostCard);
        }

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
