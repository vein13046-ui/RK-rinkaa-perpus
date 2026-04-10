<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Buku - Sistem Perpustakaan</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #F8FAFC;
        }
        ::-webkit-scrollbar {
            width: 6px;
        }
        ::-webkit-scrollbar-track { background: #f1f1f1; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 10px; }
    </style>
</head>
<body class="text-slate-700 min-h-screen">
    <!-- Header -->
    <header class="bg-white border-b border-slate-200 px-4 md:px-8 py-4">
        <div class="max-w-6xl mx-auto flex items-center justify-between">
            <div class="flex items-center gap-4">
                <a href="<?php echo e(route('dashboard.user')); ?>" class="p-2 hover:bg-slate-100 rounded-xl transition-all">
                    <svg class="w-6 h-6 text-slate-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                </a>
                <div>
                    <h1 class="text-2xl font-bold text-slate-800">Daftar Buku</h1>
                    <p class="text-sm text-slate-600"><?php echo e($books->total()); ?> Buku Tersedia</p>
                </div>
            </div>
            <div class="flex items-center gap-4">
                <!-- Profile quick access -->
                <div class="flex items-center gap-3 p-2 rounded-lg hover:bg-slate-100 transition-all">
                    <div class="w-10 h-10 rounded-full overflow-hidden shadow-md ring-2 ring-slate-200">
                        <img src="<?php echo e(Auth::user()->profilePhotoUrl()); ?>" alt="<?php echo e(Auth::user()->name); ?>" class="w-full h-full object-cover">
                    </div>
                    <div class="hidden sm:block min-w-0">
                        <p class="text-sm font-semibold text-slate-800 truncate"><?php echo e(Auth::user()->name); ?></p>
                        <p class="text-xs text-slate-400"><?php echo e(Auth::user()->role); ?></p>
                    </div>
                </div>
            </div>
        </div>
    </header>

    <!-- Main Content -->
    <main class="p-4 md:p-8">
        <div class="max-w-6xl mx-auto">
            <div class="bg-white rounded-3xl shadow-2xl border border-slate-200 p-8 mb-8">
                <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
                    <div>
                        <h2 class="text-3xl font-bold bg-gradient-to-r from-indigo-600 to-blue-600 bg-clip-text text-transparent mb-2">Koleksi Buku</h2>
                        <p class="text-slate-600">Jelajahi dan pinjam buku favoritmu dengan mudah</p>
                    </div>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-12">
                    <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                        <div class="group relative bg-white rounded-3xl shadow-lg border border-slate-100 overflow-hidden hover:shadow-2xl hover:-translate-y-2 transition-all duration-500 hover:border-indigo-200">
                            
                            <div class="h-64 bg-gradient-to-br from-slate-50 to-slate-100 overflow-hidden relative">
                                <?php if($book->cover): ?>
                                    <img src="<?php echo e(Storage::url($book->cover)); ?>" alt="<?php echo e($book->judul); ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                                <?php else: ?>
                                    <div class="w-full h-full flex items-center justify-center bg-gradient-to-br from-gray-100 to-gray-200">
                                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                        </svg>
                                    </div>
                                <?php endif; ?>
                                
                                <div class="absolute top-4 right-4 space-y-1">
                                    <span class="inline-flex items-center gap-1 px-2.5 py-1 bg-white/90 backdrop-blur-sm text-xs font-bold text-emerald-600 rounded-full shadow-lg border">
                                        <svg class="w-3 h-3" fill="currentColor" viewBox="0 0 20 20">
                                            <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm1-12a1 1 0 10-2 0v4a1 1 0 00.293.707l2.828 2.829a1 1 0 101.415-1.415L11 9.586V6z"></path>
                                        </svg>
                                        <?php echo e($book->stok); ?>

                                    </span>
                                </div>
                            </div>

                            
                            <div class="p-6">
                                <div class="mb-3">
                                    <span class="inline-flex px-2.5 py-1 bg-indigo-100 text-indigo-700 text-xs font-semibold rounded-full uppercase tracking-wide"><?php echo e($book->kategori); ?></span>
                                </div>
                                <h3 class="font-bold text-lg leading-tight line-clamp-2 text-slate-800 group-hover:text-indigo-700 mb-2 transition-colors"><?php echo e($book->judul); ?></h3>
                                <p class="text-slate-600 font-medium mb-1"><?php echo e($book->penulis); ?></p>
                                <p class="text-sm text-slate-500 mb-4"><?php echo e($book->penerbit ?? 'Independen'); ?> • <?php echo e($book->tahun_terbit); ?></p>

                                
                                <div class="flex items-center justify-between">
                                    <span class="text-xs text-slate-400 font-medium">Stok <?php echo e($book->stok); ?></span>
                                    <button class="group/btn flex items-center gap-2 px-6 py-2.5 bg-gradient-to-r from-indigo-500 to-blue-600 hover:from-indigo-600 hover:to-blue-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-300 text-sm">
                                        <svg class="w-4 h-4 group-hover/btn:rotate-12 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7h12m0 0l-4-4m4 4l-4 4m0 6H4"></path>
                                        </svg>
                                        Pinjam
                                    </button>
                                </div>
                            </div>
                        </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                        <div class="col-span-full text-center py-24">
                            <div class="w-28 h-28 bg-gradient-to-br from-slate-100 to-slate-200 rounded-3xl flex items-center justify-center mx-auto mb-8 shadow-xl">
                                <svg class="w-16 h-16 text-slate-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                                </svg>
                            </div>
                            <h3 class="text-2xl font-bold text-slate-800 mb-4">Koleksi kosong</h3>
                            <p class="text-lg text-slate-500 mb-8 max-w-md mx-auto">Buku akan muncul di sini setelah admin menambahkannya.</p>
                            <a href="<?php echo e(route('dashboard.user')); ?>" class="inline-flex items-center gap-2 px-6 py-3 bg-indigo-600 hover:bg-indigo-700 text-white font-semibold rounded-2xl shadow-lg hover:shadow-xl transition-all">
                                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"></path>
                                </svg>
                                Kembali ke Dashboard
                            </a>
                        </div>
                    <?php endif; ?>
                </div>

                
                <?php if($books->hasPages()): ?>
                    <div class="flex justify-center">
                        <?php echo e($books->links()); ?>

                    </div>
                <?php endif; ?>
            </div>
        </div>
    </main>
</body>
</html>
<?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/book_user/daftar_buku_user.blade.php ENDPATH**/ ?>