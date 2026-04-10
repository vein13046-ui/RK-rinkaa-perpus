<?php $__env->startSection('page-title', 'Daftar Buku'); ?>
<?php $__env->startSection('page-description', 'Pilih buku, lalu ajukan peminjaman dengan sistem pending.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->has('borrow_request')): ?>
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                <?php echo e($errors->first('borrow_request')); ?>

            </div>
        <?php endif; ?>

        <div class="rounded-[1.75rem] bg-white border border-slate-100 shadow-lg shadow-slate-200/50 p-5 sm:p-6">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Koleksi</p>
                    <h3 class="mt-2 text-2xl sm:text-3xl font-black text-slate-900">Daftar Buku Tersedia</h3>
                    <p class="mt-3 max-w-2xl text-sm sm:text-base text-slate-600"><?php echo e($books->total()); ?> buku tersedia. Admin punya waktu 8 jam untuk konfirmasi ambil buku setelah approve.</p>
                </div>
                <a href="<?php echo e(route('borrow.user.index')); ?>" class="inline-flex items-center gap-2 rounded-2xl bg-slate-900 px-4 py-3 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    Lihat Status Peminjaman
                </a>
            </div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-3 2xl:grid-cols-4 gap-4">
            <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                <?php
                    $activeBorrow = $activeBorrowMap[$book->id] ?? null;
                ?>

                <article class="group overflow-hidden rounded-[1.5rem] border border-slate-100 bg-white shadow-md shadow-slate-200/40 transition hover:-translate-y-1 hover:shadow-xl">
                    <div class="relative h-56 sm:h-60 bg-slate-100">
                        <?php if($book->cover): ?>
                            <img src="<?php echo e(Storage::url($book->cover)); ?>" alt="<?php echo e($book->judul); ?>" class="h-full w-full object-cover transition duration-500 group-hover:scale-105">
                        <?php else: ?>
                            <div class="flex h-full items-center justify-center bg-gradient-to-br from-slate-100 to-slate-200 text-slate-400">
                                <svg class="w-16 h-16" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                        <?php endif; ?>

                        <div class="absolute right-3 top-3">
                            <span class="inline-flex items-center rounded-full bg-white/90 px-2.5 py-1 text-[11px] font-bold text-slate-700 shadow-sm">
                                Stok <?php echo e($book->stok); ?>

                            </span>
                        </div>

                        <?php if($activeBorrow): ?>
                            <div class="absolute left-3 top-3">
                                <span class="inline-flex items-center rounded-full bg-slate-900/90 px-2.5 py-1 text-[11px] font-bold text-white shadow-sm">
                                    <?php echo e($activeBorrow->status_label); ?>

                                </span>
                            </div>
                        <?php endif; ?>
                    </div>

                    <div class="p-4 sm:p-5">
                        <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.16em] text-blue-700"><?php echo e($book->kategori); ?></span>
                        <h4 class="mt-2.5 text-base sm:text-lg font-black leading-tight text-slate-900"><?php echo e($book->judul); ?></h4>
                        <p class="mt-1.5 text-sm font-medium text-slate-600"><?php echo e($book->penulis); ?></p>
                        <p class="mt-2.5 text-xs sm:text-sm text-slate-500"><?php echo e($book->penerbit ?? 'Penerbit tidak tersedia'); ?> - <?php echo e($book->tahun_terbit); ?></p>

                        <div class="mt-4 flex items-center justify-between gap-3">
                            <span class="text-[11px] font-medium text-slate-400">Stok <?php echo e($book->stok); ?></span>

                            <?php if($activeBorrow && $activeBorrow->status === 'approved'): ?>
                                <button
                                    type="button"
                                    class="borrow-open inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-blue-200 transition hover:from-indigo-600 hover:to-blue-700"
                                    data-action="<?php echo e(route('borrow.pickup', $activeBorrow)); ?>"
                                    data-title="<?php echo e($book->judul); ?>"
                                    data-author="<?php echo e($book->penulis); ?>"
                                    data-category="<?php echo e($book->kategori); ?>"
                                    data-cover="<?php echo e($book->cover ? Storage::url($book->cover) : ''); ?>"
                                    data-fetch-url="<?php echo e(route('borrow.pickup.data', $activeBorrow)); ?>"
                                    data-code="<?php echo e($activeBorrow->pickup_code); ?>"
                                    data-deadline="<?php echo e(optional($activeBorrow->pickup_deadline)->translatedFormat('d M Y H:i')); ?>"
                                >
                                    Ambil Buku
                                </button>
                            <?php elseif($activeBorrow && $activeBorrow->status === 'picked_up'): ?>
                                <form action="<?php echo e(route('borrow.request-return', $activeBorrow)); ?>" method="POST">
                                    <?php echo csrf_field(); ?>
                                    <button type="submit" class="inline-flex items-center gap-2 rounded-xl bg-slate-900 px-4 py-2 text-xs font-semibold text-white transition hover:bg-slate-800">
                                        Kembalikan Buku
                                    </button>
                                </form>
                            <?php elseif($activeBorrow && $activeBorrow->status === 'return_pending'): ?>
                                <span class="inline-flex items-center rounded-xl bg-amber-100 px-3 py-2 text-[11px] font-semibold text-amber-700">
                                    Menunggu konfirmasi kembali
                                </span>
                            <?php elseif($activeBorrow && $activeBorrow->status === 'pending'): ?>
                                <span class="inline-flex items-center rounded-xl bg-amber-100 px-3 py-2 text-[11px] font-semibold text-amber-700">
                                    Menunggu admin
                                </span>
                            <?php elseif($activeBorrow && $activeBorrow->status === 'cancelled'): ?>
                                <span class="inline-flex items-center rounded-xl bg-rose-100 px-3 py-2 text-[11px] font-semibold text-rose-700">
                                    Dibatalkan
                                </span>
                            <?php elseif($book->stok > 0): ?>
                                <button
                                    type="button"
                                    class="borrow-start inline-flex items-center gap-2 rounded-xl bg-gradient-to-r from-indigo-500 to-blue-600 px-4 py-2 text-xs font-semibold text-white shadow-md shadow-blue-200 transition hover:from-indigo-600 hover:to-blue-700"
                                    data-action="<?php echo e(route('borrow.store', $book)); ?>"
                                    data-title="<?php echo e($book->judul); ?>"
                                    data-author="<?php echo e($book->penulis); ?>"
                                    data-category="<?php echo e($book->kategori); ?>"
                                    data-cover="<?php echo e($book->cover ? Storage::url($book->cover) : ''); ?>"
                                >
                                    Pinjam
                                </button>
                            <?php else: ?>
                                <button type="button" disabled class="inline-flex items-center gap-2 rounded-xl bg-slate-200 px-4 py-2 text-xs font-semibold text-slate-500 cursor-not-allowed">
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                <div class="col-span-full rounded-[2rem] border border-dashed border-slate-200 bg-white p-12 text-center text-slate-500">
                    Belum ada buku yang tersedia.
                </div>
            <?php endif; ?>
        </div>

        <?php if($books->hasPages()): ?>
            <div class="flex justify-center">
                <?php echo e($books->links()); ?>

            </div>
        <?php endif; ?>
    </div>

    <div id="borrowModal" class="fixed inset-0 z-50 hidden items-center justify-center bg-slate-950/60 px-4 py-6">
        <div class="w-full max-w-2xl overflow-hidden rounded-[2rem] bg-white shadow-2xl shadow-slate-900/20">
            <div class="flex items-start justify-between gap-4 border-b border-slate-100 p-6 sm:p-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Form Peminjaman</p>
                    <h3 class="mt-2 text-2xl font-black text-slate-900">Konfirmasi Pinjam Buku</h3>
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
                        <?php echo csrf_field(); ?>
                        <input type="hidden" name="pickup_code" id="pickupCodeInput">
                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Nama Peminjam</label>
                            <input type="text" name="borrower_name" value="<?php echo e(Auth::user()->name); ?>" required class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                        </div>

                        <div>
                            <label class="mb-2 block text-sm font-semibold text-slate-700">Lama Peminjaman</label>
                            <select name="borrow_days" required class="w-full rounded-2xl border border-slate-200 px-4 py-3.5 text-slate-900 outline-none transition focus:border-blue-400 focus:ring-4 focus:ring-blue-100">
                                <option value="">Pilih hari</option>
                                <option value="1">1 Hari</option>
                                <option value="2">2 Hari</option>
                                <option value="3">3 Hari</option>
                            </select>
                            <p class="mt-2 text-xs text-slate-500">Maksimal 3 hari.</p>
                        </div>

                        <label class="flex items-start gap-3 rounded-2xl border border-slate-200 bg-slate-50 p-4 text-sm text-slate-600">
                            <input type="checkbox" name="damage_agreement" value="1" required class="mt-1 h-4 w-4 rounded border-slate-300 text-blue-600 focus:ring-blue-500">
                            <span>Saya menyetujui bahwa jika buku hilang atau rusak, saya siap mengganti rugi sesuai ketentuan yang berlaku.</span>
                        </label>

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
                                Konfirmasi
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
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
                    pickupPanel.classList.remove('hidden');
                    pickupCodeInput.value = data.code || button.dataset.code || '';
                    pickupCodeLabel.textContent = data.code || button.dataset.code || '';
                    buildBarcode(data.code || button.dataset.code || '');
                } else {
                    pickupPanel.classList.add('hidden');
                    pickupCodeInput.value = '';
                    pickupCodeLabel.textContent = '';
                    pickupBarcode.innerHTML = '';
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
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/book_user/daftar_buku_user_borrow_clean.blade.php ENDPATH**/ ?>