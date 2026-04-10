<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'RinKa Perpus')); ?> - <?php echo $__env->yieldContent('title', 'Masuk'); ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
    <style>
        body {
            font-family: 'Inter', sans-serif;
            background:
                radial-gradient(circle at top left, rgba(37, 99, 235, 0.22), transparent 28%),
                radial-gradient(circle at bottom right, rgba(15, 23, 42, 0.86), transparent 34%),
                linear-gradient(180deg, #0f172a 0%, #172554 55%, #e2e8f0 100%);
        }
    </style>
</head>
<body class="min-h-screen text-slate-700 antialiased">
    <div class="absolute inset-0 overflow-hidden pointer-events-none">
        <div class="absolute -top-24 left-1/4 h-64 w-64 rounded-full bg-blue-400/20 blur-3xl"></div>
        <div class="absolute bottom-0 right-0 h-80 w-80 rounded-full bg-indigo-300/20 blur-3xl"></div>
    </div>

    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/layouts/app.blade.php ENDPATH**/ ?>