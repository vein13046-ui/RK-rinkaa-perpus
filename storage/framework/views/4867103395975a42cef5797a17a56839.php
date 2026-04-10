<?php $__env->startSection('page-title', 'Profil Akun'); ?>
<?php $__env->startSection('page-description', 'Kelola identitas akun dengan tampilan yang bersih dan fokus.'); ?>

<?php $__env->startSection('content'); ?>
    <div class="grid grid-cols-1 xl:grid-cols-3 gap-6">
        <div class="rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-8">
            <div class="text-center">
                <div class="w-36 h-36 mx-auto rounded-[2rem] overflow-hidden ring-8 ring-slate-100 shadow-lg">
                    <img src="<?php echo e($user->profilePhotoUrl()); ?>" alt="Foto Profil <?php echo e($user->name); ?>" class="w-full h-full object-cover">
                </div>
                <h3 class="mt-6 text-3xl font-black text-slate-900"><?php echo e($user->name); ?></h3>
                <p class="mt-2 text-slate-500"><?php echo e($user->email); ?></p>
                <span class="inline-flex mt-4 px-4 py-2 rounded-full bg-blue-100 text-blue-700 font-semibold capitalize"><?php echo e($user->role); ?></span>
            </div>

            <div class="mt-8 grid grid-cols-2 gap-4">
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Status</p>
                    <p class="mt-2 font-semibold text-slate-900">Aktif</p>
                </div>
                <div class="rounded-2xl bg-slate-50 p-4">
                    <p class="text-xs font-bold uppercase tracking-[0.2em] text-slate-400">Akun</p>
                    <p class="mt-2 font-semibold text-slate-900">Terverifikasi</p>
                </div>
            </div>
        </div>

        <div class="xl:col-span-2 rounded-[2rem] bg-white border border-slate-100 shadow-xl shadow-slate-200/60 p-8 sm:p-10">
            <?php if(session('success')): ?>
                <div class="mb-6 rounded-2xl border border-emerald-200 bg-emerald-50 px-5 py-4 text-emerald-800">
                    <?php echo e(session('success')); ?>

                </div>
            <?php endif; ?>

            <div class="flex items-start justify-between gap-4 mb-8">
                <div>
                    <p class="text-xs font-bold uppercase tracking-[0.24em] text-slate-400">Pengaturan Profil</p>
                    <h3 class="mt-2 text-2xl sm:text-3xl font-black text-slate-900">Informasi Profil</h3>
                </div>
                <div class="hidden sm:flex items-center gap-2 rounded-full bg-slate-50 px-4 py-2 text-sm font-semibold text-slate-600">
                    <span class="w-2.5 h-2.5 rounded-full bg-emerald-500"></span>
                    Tampilan bersih
                </div>
            </div>

            <?php if(($user->role ?? 'user') === 'admin'): ?>
                <div class="rounded-3xl border border-amber-200 bg-amber-50 p-6 text-amber-900">
                    <p class="font-bold">Foto profil admin dikunci</p>
                    <p class="mt-2 text-sm leading-relaxed">Admin hanya dapat melihat profil. Foto profil tidak bisa diubah dari halaman ini.</p>
                </div>
            <?php else: ?>
                <form action="<?php echo e(route('profile.update')); ?>" method="POST" enctype="multipart/form-data" class="space-y-6">
                    <?php echo csrf_field(); ?>
                    <div class="rounded-3xl border border-dashed border-slate-200 bg-slate-50/70 p-6 sm:p-8">
                        <label class="block text-sm font-semibold text-slate-700 mb-3">Unggah foto profil baru</label>
                        <input type="file" name="profile_photo" id="photoInput" accept="*/*" class="hidden" required>
                        <label for="photoInput" class="flex cursor-pointer flex-col items-center justify-center rounded-3xl border border-slate-200 bg-white px-6 py-12 text-center transition hover:border-blue-300 hover:shadow-md">
                            <div class="w-16 h-16 rounded-2xl bg-blue-50 text-blue-600 flex items-center justify-center mb-4">
                                <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path>
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                </svg>
                            </div>
                            <p class="text-lg font-bold text-slate-900">Klik untuk pilih file</p>
                            <p class="mt-2 text-sm text-slate-500">Semua format file kecuali MP4, maksimal 100 MB</p>
                        </label>
                        <?php $__errorArgs = ['profile_photo'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <p class="mt-4 text-sm font-medium text-rose-600"><?php echo e($message); ?></p>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                    </div>

                    <button type="submit" class="inline-flex w-full items-center justify-center gap-2 rounded-2xl bg-slate-900 px-6 py-4 font-semibold text-white transition hover:bg-slate-800">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                        </svg>
                        Simpan Profil
                    </button>
                </form>
            <?php endif; ?>
        </div>
    </div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/profile.blade.php ENDPATH**/ ?>