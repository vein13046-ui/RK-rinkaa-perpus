<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
    <!-- Promotional Ad Banner -->
    <?php echo $__env->make('components.ad-banner', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
    
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 lg:gap-12 mt-4">
        <!-- Welcome & Quick Actions -->
        <div class="bg-white/80 backdrop-blur-sm rounded-3xl shadow-xl border border-slate-200/50 p-8 lg:p-10">
            <div class="flex items-center gap-4 mb-8">
                <div class="p-3 bg-gradient-to-br from-blue-500 to-blue-600 text-white rounded-2xl shadow-lg">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"></path>
                    </svg>
                </div>
                <div>
                    <h2 class="text-3xl font-bold text-slate-800">Dashboard Admin</h2>
                    <p class="text-slate-600 mt-1">Kelola perpustakaan digital dengan efisien</p>
                </div>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                <a href="<?php echo e(route('admin.books.index')); ?>" class="group bg-gradient-to-r from-blue-500 to-blue-600 hover:from-blue-600 hover:to-blue-700 text-white p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-blue-500/20">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-90 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"></path>
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Data Buku</h3>
                    <p class="text-blue-100">Kelola koleksi buku</p>
                </a>
                <a href="<?php echo e(route('admin.books.create')); ?>" class="group bg-gradient-to-r from-emerald-500 to-emerald-600 hover:from-emerald-600 hover:to-emerald-700 text-white p-6 rounded-2xl text-center transition-all duration-300 hover:shadow-xl hover:scale-[1.02] border border-emerald-500/20">
                    <svg class="w-12 h-12 mx-auto mb-4 opacity-90 group-hover:scale-110 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"></path>
                    </svg>
                    <h3 class="text-xl font-bold mb-2">Tambah Buku</h3>
                    <p class="text-emerald-100">Tambah buku baru</p>
                </a>
            </div>
        </div>
        
        <!-- Stats Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            <div class="bg-gradient-to-br from-indigo-50 to-blue-50 p-8 rounded-3xl shadow-xl border border-indigo-100">
                <h3 class="text-2xl font-bold text-slate-800 mb-6 flex items-center gap-3">
                    Statistik Utama
                    <span class="px-3 py-1 bg-indigo-100 text-indigo-700 text-sm font-semibold rounded-full">Live</span>
                </h3>
                <div class="space-y-4">
                    <div class="flex justify-between items-end">
                        <div>
                            <p class="text-slate-500 text-sm font-medium">Total Buku</p>
                            <p class="text-3xl font-bold text-slate-900"><?php echo e(rand(2450,3500)); ?><span class="text-xl text-emerald-600 ml-1">+12%</span></p>
                        </div>
                        <div class="p-4 bg-white/50 backdrop-blur-sm rounded-2xl text-indigo-600 font-bold text-2xl"><?php echo e(rand(100,500)); ?> Baru</div>
                    </div>
                    <div class="h-2 bg-slate-200 rounded-full overflow-hidden">
                        <div class="h-full bg-gradient-to-r from-indigo-500 to-blue-500 rounded-full w-<?php echo e(rand(60,85)); ?>%" style="width: <?php echo e(rand(60,85)); ?>%;"></div>
                    </div>
                </div>
            </div>
            
            <div class="bg-gradient-to-br from-emerald-50 to-teal-50 p-8 rounded-3xl shadow-xl border border-emerald-100">
                <h3 class="text-2xl font-bold text-slate-800 mb-6">Ringkasan Aktivitas</h3>
                <div class="space-y-4 text-sm">
                    <div class="flex justify-between py-2 border-b border-emerald-100 last:border-b-0">
                        <span>Anggota Aktif</span>
                        <span class="font-bold text-emerald-700"><?php echo e(rand(250,800)); ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-emerald-100 last:border-b-0">
                        <span>Peminjaman Hari Ini</span>
                        <span class="font-bold text-emerald-700"><?php echo e(rand(25,75)); ?></span>
                    </div>
                    <div class="flex justify-between py-2 border-b border-emerald-100 last:border-b-0">
                        <span>Terlambat</span>
                        <span class="font-bold text-orange-600"><?php echo e(rand(0,8)); ?></span>
                    </div>
                    <div class="flex justify-between py-2">
                        <span>Total Riwayat</span>
                        <span class="font-bold text-slate-800"><?php echo e(rand(5000,15000)); ?></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/admin/dashboard_content.blade.php ENDPATH**/ ?>