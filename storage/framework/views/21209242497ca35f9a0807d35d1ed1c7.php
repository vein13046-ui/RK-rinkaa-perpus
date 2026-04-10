<?php $__env->startSection('page-title', 'Dashboard Admin'); ?>
<?php $__env->startSection('page-description', 'Ringkasan koleksi, stok, dan aktivitas perpustakaan.'); ?>

<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('admin.dashboard_content_clean', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.panel', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/dashboard.blade.php ENDPATH**/ ?>