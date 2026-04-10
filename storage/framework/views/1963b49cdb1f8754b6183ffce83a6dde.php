<?php $__env->startSection('page-title', 'Katalog Buku'); ?>
<?php $__env->startSection('page-description', 'Tampilan katalog admin yang lebih bersih, rapi, dan mudah dipindai.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="space-y-6">
        <?php if(session('success')): ?>
            <div class="rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                <?php echo e(session('success')); ?>

            </div>
        <?php endif; ?>

        <?php if($errors->has('delete_book')): ?>
            <div class="rounded-2xl border border-rose-200 bg-rose-50 px-5 py-4 text-rose-800">
                <?php echo e($errors->first('delete_book')); ?>

            </div>
        <?php endif; ?>

        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-6 sm:p-8">
            <div class="flex flex-col lg:flex-row lg:items-end lg:justify-between gap-5 mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Data Buku</p>
                    <h3 class="mt-2 text-3xl font-black text-slate-900">Katalog Buku Admin</h3>
                    <p class="mt-3 text-slate-600">Kelola koleksi dengan tampilan yang lebih konsisten dan profesional.</p>
                </div>

                <a href="<?php echo e(route('admin.books.create')); ?>" class="inline-flex items-center justify-center gap-2 rounded-2xl bg-slate-900 px-5 py-3.5 text-sm font-semibold text-white transition hover:bg-slate-800">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    Tambah Buku
                </a>
            </div>

            <div class="overflow-hidden rounded-[1.5rem] border border-slate-100">
                <table class="w-full text-left">
                    <thead class="bg-slate-50">
                        <tr class="text-[11px] uppercase tracking-[0.2em] text-slate-400">
                            <th class="px-5 py-4">Cover</th>
                            <th class="px-5 py-4">Info Buku</th>
                            <th class="px-5 py-4 text-center">Tahun</th>
                            <th class="px-5 py-4 text-center">Stok</th>
                            <th class="px-5 py-4 text-center">Status</th>
                            <th class="px-5 py-4 text-center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-slate-100 bg-white">
                        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                            <tr class="hover:bg-slate-50/80 transition">
                                <td class="px-5 py-5 align-top">
                                    <div class="w-16 h-24 rounded-2xl overflow-hidden bg-slate-100 shadow-sm ring-1 ring-slate-100">
                                        <?php if($book->cover): ?>
                                            <img src="<?php echo e(Storage::url($book->cover)); ?>" alt="<?php echo e($book->judul); ?>" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <div class="w-full h-full flex items-center justify-center text-slate-300">
                                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                                </svg>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </td>

                                <td class="px-5 py-5 align-top">
                                    <div class="max-w-xl">
                                        <h4 class="text-lg font-bold text-slate-900 leading-tight"><?php echo e($book->judul); ?></h4>
                                        <p class="mt-2 text-sm font-medium text-slate-600"><?php echo e($book->penulis); ?></p>
                                        <div class="mt-3 flex flex-wrap items-center gap-2">
                                            <span class="inline-flex rounded-full bg-blue-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-blue-700"><?php echo e($book->kategori); ?></span>
                                            <?php if($book->penerbit): ?>
                                                <span class="inline-flex rounded-full bg-slate-100 px-2.5 py-1 text-[10px] font-bold uppercase tracking-[0.18em] text-slate-600"><?php echo e($book->penerbit); ?></span>
                                            <?php endif; ?>
                                        </div>
                                    </div>
                                </td>

                                <td class="px-5 py-5 text-center align-top">
                                    <span class="font-semibold text-slate-800"><?php echo e($book->tahun_terbit); ?></span>
                                </td>

                                <td class="px-5 py-5 text-center align-top">
                                    <span class="inline-flex items-center justify-center rounded-full px-3 py-1 text-sm font-black <?php echo e($book->stok > 0 ? 'bg-emerald-100 text-emerald-700' : 'bg-rose-100 text-rose-700'); ?>">
                                        <?php echo e($book->stok); ?>

                                    </span>
                                </td>

                                <td class="px-5 py-5 text-center align-top">
                                    <span class="inline-flex items-center gap-2 rounded-full px-3 py-1 text-xs font-bold uppercase tracking-[0.18em] <?php echo e($book->stok > 0 ? 'bg-emerald-50 text-emerald-700' : 'bg-rose-50 text-rose-700'); ?>">
                                        <span class="h-2 w-2 rounded-full <?php echo e($book->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500'); ?>"></span>
                                        <?php echo e($book->stok > 0 ? 'Tersedia' : 'Habis'); ?>

                                    </span>
                                </td>

                                <td class="px-5 py-5 text-center align-top">
                                    <form action="<?php echo e(route('admin.books.destroy', $book)); ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus buku ini?')">
                                        <?php echo csrf_field(); ?>
                                        <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="inline-flex items-center gap-2 rounded-2xl border border-rose-200 bg-white px-4 py-2 text-sm font-semibold text-rose-600 transition hover:bg-rose-50">
                                            Hapus
                                        </button>
                                    </form>
                                </td>
                            </tr>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                            <tr>
                                <td colspan="6" class="px-5 py-16 text-center text-slate-500">
                                    Belum ada buku di katalog.
                                </td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>

            <?php if($books->hasPages()): ?>
                <div class="mt-8 flex justify-center">
                    <?php echo e($books->links()); ?>

                </div>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/books_admin/data_buku_clean.blade.php ENDPATH**/ ?>