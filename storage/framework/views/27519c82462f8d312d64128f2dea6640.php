<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?php echo e(config('app.name', 'Laravel')); ?> - <?php echo $__env->yieldContent('title', 'ECORP'); ?></title>
    
    
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="<?php echo e(asset('css/app.css')); ?>" rel="stylesheet">
    <style>
        /* Custom font-faces inline for immediate use */
@font-face {
            font-family: 'OpenSans';
            src: url('<?php echo e(asset('fonts/OpenSans-Regular.ttf')); ?>') format('truetype');
            font-weight: 400;
            font-display: swap;
        }
        @font-face {
            font-family: 'OpenSans';
            src: url('<?php echo e(asset('fonts/OpenSans-Bold.ttf')); ?>') format('truetype');
            font-weight: 700;
            font-display: swap;
        }
        .font-opensans { font-family: 'OpenSans', sans-serif !important; }
        .title-hero { 
            background: linear-gradient(to right, #f97316, #fb923c); 
            -webkit-background-clip: text; 
            background-clip: text; 
            color: transparent; 
            font-weight: bold;
            font-size: 2.5rem;
            text-align: center;
        }
        .auth-page {
            min-height: 100vh;
            background: linear-gradient(135deg, #553c9a 0%, #4c4198 50%, #3a3778 100%);
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 1rem;
        }
        .auth-card {
            width: 100%;
            max-width: 28rem;
            padding: 2.5rem;
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(255,255,255,0.2);
            border-radius: 1.5rem;
            box-shadow: 0 25px 45px rgba(0,0,0,0.1);
        }
        .input-field {
            width: 100%;
            padding: 0.75rem 1rem;
            background: rgba(255,255,255,0.2);
            border: 1px solid rgba(255,255,255,0.3);
            border-radius: 1rem;
            color: white;
            placeholder-color: rgba(255,255,255,0.7);
        }
        .input-field:focus {
            outline: none;
            ring: 2px solid #f97316;
            background: rgba(255,255,255,0.3);
        }
        .btn-primary {
            width: 100%;
            padding: 1rem;
            background: linear-gradient(to right, #f97316, #fb923c);
            border-radius: 1rem;
            color: white;
            font-weight: bold;
            font-size: 1.125rem;
            border: none;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(249,115,22,0.4);
        }
    </style>
</head>
<body class="font-sans antialiased bg-gradient-to-br from-purple-900 via-purple-800 to-indigo-900">
    <?php echo $__env->yieldContent('content'); ?>
</body>
</html>
<?php /**PATH C:\xampp8882\htdocs\perpustakaan\resources\views/layouts/app.blade.php ENDPATH**/ ?>