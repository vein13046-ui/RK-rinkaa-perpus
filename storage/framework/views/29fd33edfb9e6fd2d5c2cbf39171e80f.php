<?php $__env->startSection('page-title', 'Dashboard Pengguna'); ?>
<?php $__env->startSection('page-description', 'Tampilan pengguna yang ringkas, informatif, dan mudah dipahami.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <?php echo $__env->make('components.app-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>

        <div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-5">
            <div class="rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/60 border border-slate-100">
                <p class="text-sm font-semibold text-slate-500">Total Buku</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['bookCount'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-blue-600">Koleksi</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/60 border border-slate-100">
                <p class="text-sm font-semibold text-slate-500">Stok Tersedia</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['stockCount'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-emerald-600">Aktif</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/60 border border-slate-100">
                <p class="text-sm font-semibold text-slate-500">Buku Tersedia</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['availableCount'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-indigo-600">Siap</span>
                </div>
            </div>
            <div class="rounded-3xl bg-white p-6 shadow-lg shadow-slate-200/60 border border-slate-100">
                <p class="text-sm font-semibold text-slate-500">Kategori</p>
                <div class="mt-3 flex items-end justify-between">
                    <span class="text-3xl font-black text-slate-900"><?php echo e(number_format($stats['categoryCount'] ?? 0)); ?></span>
                    <span class="text-xs font-bold uppercase tracking-[0.2em] text-violet-600">Ragam</span>
                </div>
            </div>
        </div>

        <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
            <div class="xl:col-span-2 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
                <div class="flex items-center justify-between gap-4 mb-6">
                    <div>
                        <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Sorotan</p>
                        <h4 class="text-2xl font-black text-slate-900 mt-2">Buku Terbaru</h4>
                    </div>
                    <a href="<?php echo e(route('user.books')); ?>" class="text-sm font-semibold text-blue-700 hover:text-blue-800">Lihat semua</a>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                    <?php $__empty_1 = true; $__currentLoopData = $featuredBooks; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="rounded-3xl border border-slate-100 bg-slate-50/80 p-4 flex gap-4">
                            <div class="w-20 h-28 rounded-2xl overflow-hidden bg-white shadow-sm shrink-0">
                                <?php if($book->cover): ?>
                                    <img src="<?php echo e(Storage::url($book->cover)); ?>" alt="<?php echo e($book->judul); ?>" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-slate-100 text-slate-400">
                                        <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <div class="min-w-0">
                                <span class="inline-flex px-2.5 py-1 rounded-full bg-blue-100 text-blue-700 text-[10px] font-bold uppercase tracking-[0.18em]"><?php echo e($book->kategori); ?></span>
                                <h5 class="mt-3 text-base font-bold text-slate-900 leading-snug"><?php echo e($book->judul); ?></h5>
                                <p class="mt-1 text-sm text-slate-500"><?php echo e($book->penulis); ?></p>
                                <p class="mt-4 text-xs text-slate-400"><?php echo e($book->penerbit ?? 'Penerbit tidak tersedia'); ?> • <?php echo e($book->tahun_terbit); ?></p>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full rounded-3xl border border-dashed border-slate-200 bg-slate-50 p-10 text-center text-slate-500">
                            Belum ada buku terbaru yang ditampilkan.
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
                <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Akses Cepat</p>
                <h4 class="text-2xl font-black text-slate-900 mt-2 mb-6">Menu Buku</h4>

                <div class="space-y-3">
                    <a href="<?php echo e(route('user.books')); ?>" class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-4 text-slate-700 hover:border-blue-200 hover:bg-blue-50 transition">
                        <span class="w-10 h-10 rounded-xl bg-blue-600 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold">Daftar Buku</p>
                            <p class="text-sm text-slate-500">Jelajahi koleksi lengkap</p>
                        </div>
                    </a>
                    <a href="<?php echo e(route('profile')); ?>" class="flex items-center gap-3 rounded-2xl border border-slate-200 px-4 py-4 text-slate-700 hover:border-blue-200 hover:bg-blue-50 transition">
                        <span class="w-10 h-10 rounded-xl bg-slate-900 text-white flex items-center justify-center">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                            </svg>
                        </span>
                        <div>
                            <p class="font-semibold">Profil Saya</p>
                            <p class="text-sm text-slate-500">Lihat data akun</p>
                        </div>
                    </a>
                </div>
            </div>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/dashboard_user_clean.blade.php ENDPATH**/ ?>