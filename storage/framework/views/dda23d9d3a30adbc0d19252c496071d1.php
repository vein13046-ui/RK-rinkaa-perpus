<?php $__env->startSection('page-title', 'Status Peminjaman'); ?>
<?php $__env->startSection('page-description', 'Kelola permintaan peminjaman, pengambilan, dan pengembalian buku.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->has('borrow_action')): ?>
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                <?php echo e($errors->first('borrow_action')); ?>

            </div>
        <?php endif; ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-6 gap-5">
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Pending</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['pending'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-amber-600">Menunggu</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Approved</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['approved'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600">Siap</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Diambil</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['picked_up'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">Aktif</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Return Pending</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['return_pending'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-violet-600">Cek</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Returned</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['returned'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-sky-600">Selesai</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 border border-slate-100 shadow-lg shadow-slate-200/60">
                <p class="text-sm font-semibold text-slate-500">Cancelled</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['cancelled'] ?? 0)); ?></span>
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
                        <?php $__empty_1 = true; $__currentLoopData = $borrows; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $borrow): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900"><?php echo e($borrow->borrower_name); ?></div>
                                    <div class="text-xs text-slate-500 mt-1"><?php echo e($borrow->user->email ?? '-'); ?></div>
                                </td>
                                <td class="px-5 py-4">
                                    <div class="font-semibold text-slate-900"><?php echo e($borrow->book->judul ?? '-'); ?></div>
                                    <div class="text-xs text-slate-500 mt-1"><?php echo e($borrow->book->penulis ?? '-'); ?></div>
                                </td>
                                <td class="px-5 py-4 text-center font-semibold text-slate-800"><?php echo e($borrow->borrow_days); ?></td>
                                <td class="px-5 py-4 text-center">
                                    <span class="inline-flex items-center rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.18em]
                                        <?php echo e($borrow->status === 'pending' ? 'bg-amber-100 text-amber-700' : ''); ?>

                                        <?php echo e($borrow->status === 'approved' ? 'bg-emerald-100 text-emerald-700' : ''); ?>

                                        <?php echo e($borrow->status === 'picked_up' ? 'bg-blue-100 text-blue-700' : ''); ?>

                                        <?php echo e($borrow->status === 'return_pending' ? 'bg-violet-100 text-violet-700' : ''); ?>

                                        <?php echo e($borrow->status === 'returned' ? 'bg-sky-100 text-sky-700' : ''); ?>

                                        <?php echo e($borrow->status === 'cancelled' ? 'bg-rose-100 text-rose-700' : ''); ?>

                                        <?php echo e($borrow->status === 'rejected' ? 'bg-slate-100 text-slate-600' : ''); ?>">
                                        <?php echo e($borrow->status_label); ?>

                                    </span>
                                </td>
                                <td class="px-5 py-4 text-center text-slate-600">
                                    <div><?php echo e(optional($borrow->created_at)->translatedFormat('d M Y')); ?></div>
                                    <?php if($borrow->pickup_deadline): ?>
                                        <div class="mt-1 text-xs text-amber-600">Ambil: <?php echo e($borrow->pickup_deadline->translatedFormat('d M Y H:i')); ?></div>
                                    <?php endif; ?>
                                    <?php if($borrow->due_date): ?>
                                        <div class="mt-1 text-xs text-slate-400">Jatuh tempo: <?php echo e($borrow->due_date->translatedFormat('d M Y')); ?></div>
                                    <?php endif; ?>
                                </td>
                                <td class="px-5 py-4 text-center">
                                    <div class="flex flex-wrap items-center justify-center gap-2">
                                        <?php if($borrow->status === 'pending'): ?>
                                            <form action="<?php echo e(route('admin.borrow.approve', $borrow)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-emerald-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-emerald-700">
                                                    Konfirmasi
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.borrow.reject', $borrow)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Tolak
                                                </button>
                                            </form>
                                        <?php elseif($borrow->status === 'return_pending'): ?>
                                            <form action="<?php echo e(route('admin.borrow.return', $borrow)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl bg-blue-600 px-4 py-2.5 text-sm font-semibold text-white transition hover:bg-blue-700">
                                                    Setujui Kembali
                                                </button>
                                            </form>
                                            <form action="<?php echo e(route('admin.borrow.return.reject', $borrow)); ?>" method="POST">
                                                <?php echo csrf_field(); ?>
                                                <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2.5 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                                    Tolak Kembali
                                                </button>
                                            </form>
                                        <?php elseif($borrow->status === 'approved'): ?>
                                            <span class="text-xs font-semibold text-emerald-600">Menunggu user mengambil</span>
                                        <?php elseif($borrow->status === 'picked_up'): ?>
                                            <span class="text-xs font-semibold text-blue-600">Sedang dipinjam</span>
                                        <?php else: ?>
                                            <span class="text-xs font-semibold text-slate-400">Tidak ada aksi</span>
                                        <?php endif; ?>
                                    </div>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                                    Belum ada data peminjaman.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($borrows->hasPages()): ?>
                <div class="mt-8 flex justify-center">
                    <?php echo e($borrows->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/books_admin/status_peminjaman_buku_clean.blade.php ENDPATH**/ ?>