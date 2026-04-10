<?php $__env->startSection('page-title', 'Katalog Buku - Admin'); ?>

<?php $__env->startSection('content'); ?>

<div class="min-h-screen bg-white py-12">
    <div class="max-w-7xl mx-auto px-6 lg:px-8">
        
        <div class="flex flex-col md:flex-row md:items-end justify-between gap-6 mb-16">
            <div class="space-y-1">
                <h1 class="text-4xl font-extrabold text-slate-900 tracking-tight">
                    Katalog <span class="text-blue-600">Buku</span>
                </h1>
Manajemen inventaris koleksi perpustakaan RinKa Perpus.
            </div>
            
            <a href="<?php echo e(route('admin.books.create')); ?>" class="group inline-flex items-center gap-2 text-blue-600 hover:text-blue-700 font-bold text-sm tracking-tight transition-all">
                <div class="p-2 bg-blue-50 group-hover:bg-blue-100 rounded-full transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"></path>
                    </svg>
                </div>
                Tambah Koleksi Baru
            </a>
        </div>

        <?php if(session('success')): ?>
            <div class="flex items-center gap-3 text-emerald-700 mb-10 p-4 border-l-4 border-emerald-500 bg-emerald-50/30">
                <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
                </svg>
                <span class="text-sm font-semibold tracking-wide"><?php echo e(session('success')); ?></span>
            </div>
        <?php endif; ?>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="border-b border-slate-200">
                        <th class="pb-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Info Buku</th>
                        <th class="px-6 pb-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em]">Detail & Kategori</th>
                        <th class="px-6 pb-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Tahun</th>
                        <th class="px-6 pb-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-center">Stok</th>
                        <th class="pb-5 text-[10px] font-black text-slate-400 uppercase tracking-[0.2em] text-right">Opsi</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <tr class="group hover:bg-slate-50/50 transition-colors">
                            <td class="py-8 pr-4">
                                <div class="relative w-16 h-24 bg-slate-100 rounded-md overflow-hidden ring-1 ring-slate-200 shadow-sm transition-transform group-hover:scale-[1.02]">
                                    <?php if($book->cover): ?>
                                        <img src="<?php echo e(Storage::url($book->cover)); ?>" alt="<?php echo e($book->judul); ?>" class="w-full h-full object-cover">
                                    <?php else: ?>
                                        <div class="flex items-center justify-center h-full bg-slate-50">
                                            <svg class="w-8 h-8 text-slate-200" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                            </svg>
                                        </div>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-6 py-8 align-top">
                                <div class="max-w-xs">
                                    <h3 class="text-lg font-bold text-slate-900 leading-tight group-hover:text-blue-600 transition-colors uppercase tracking-tight">
                                        <?php echo e($book->judul); ?>

                                    </h3>
                                    <div class="flex flex-wrap items-center gap-x-3 gap-y-1 mt-2">
                                        <span class="text-sm font-semibold text-slate-500"><?php echo e($book->penulis); ?></span>
                                        <span class="px-2 py-0.5 text-[9px] font-black bg-blue-50 text-blue-600 rounded uppercase tracking-widest ring-1 ring-blue-100">
                                            <?php echo e($book->kategori); ?>

                                        </span>
                                    </div>
                                    <?php if($book->penerbit): ?>
                                        <p class="text-[11px] text-slate-400 mt-4 font-medium italic border-l border-slate-200 pl-2">
                                            <?php echo e($book->penerbit); ?>

                                        </p>
                                    <?php endif; ?>
                                </div>
                            </td>

                            <td class="px-6 py-8 text-center align-top pt-10">
                                <span class="text-sm font-bold text-slate-700 tracking-tighter"><?php echo e($book->tahun_terbit); ?></span>
                            </td>

                            <td class="px-6 py-8 align-top pt-10">
                                <div class="flex flex-col items-center gap-1">
                                    <span class="text-base font-black <?php echo e($book->stok > 0 ? 'text-slate-900' : 'text-rose-600'); ?>">
                                        <?php echo e($book->stok); ?>

                                    </span>
                                    <div class="flex items-center gap-1.5">
                                        <span class="h-1 w-1 rounded-full <?php echo e($book->stok > 0 ? 'bg-emerald-500' : 'bg-rose-500'); ?>"></span>
                                        <span class="text-[9px] font-bold uppercase tracking-[0.15em] text-slate-400">
                                            <?php echo e($book->stok > 0 ? 'In Stock' : 'Empty'); ?>

                                        </span>
                                    </div>
                                </div>
                            </td>

                            <td class="py-8 text-right align-top pt-10">
                                <div class="flex items-center justify-end gap-6">
                                    <a href="#" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-blue-600 transition-all">
                                        Edit
                                    </a>
                                    
                                    <form action="#" method="POST" onsubmit="return confirm('Hapus data buku?');" class="inline">
                                        <?php echo csrf_field(); ?> <?php echo method_field('DELETE'); ?>
                                        <button type="submit" class="text-[10px] font-black uppercase tracking-widest text-slate-400 hover:text-rose-600 transition-all">
                                            Hapus
                                        </button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <tr>
                            <td colspan="5" class="py-32 text-center">
                                <div class="space-y-4">
                                    <p class="text-slate-300 font-bold text-xl tracking-tight uppercase">Database Kosong</p>
                                    <a href="<?php echo e(route('admin.books.create')); ?>" class="text-blue-600 text-xs font-black uppercase tracking-widest hover:underline decoration-2 underline-offset-8 transition-all">
                                        Mulai Input Koleksi Baru →
                                    </a>
                                </div>
                            </td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>

        <?php if($books->hasPages()): ?>
            <div class="mt-20 pt-10 border-t border-slate-100 flex justify-center">
                <div class="px-4 py-2 bg-white rounded-full ring-1 ring-slate-100 shadow-sm">
                    <?php echo e($books->links()); ?>

                </div>
            </div>
        <?php endif; ?>

    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('dashboard', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/books_admin/data_buku.blade.php ENDPATH**/ ?>