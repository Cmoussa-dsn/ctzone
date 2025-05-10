<!DOCTYPE html>
<html lang="<?php echo e(str_replace('_', '-', app()->getLocale())); ?>" class="h-full bg-gray-100">
    <head>
        <meta charset="utf-8">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">

        <title><?php echo e(config('app.name', 'CT ZONE')); ?></title>

        <!-- Fonts -->
        <link rel="preconnect" href="https://fonts.bunny.net">
        <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />
        <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
        
        <!-- Font Awesome -->
        <script src="https://kit.fontawesome.com/9d214354b3.js" crossorigin="anonymous"></script>
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

        <!-- Tailwind CSS -->
        <script src="https://cdn.tailwindcss.com"></script>

        <style>
            body {
                font-family: 'Poppins', sans-serif;
                background-image: url("<?php echo e(asset('images/pc-backg.webp')); ?>");
                background-size: cover;
                background-position: center;
                background-repeat: no-repeat;
                background-attachment: fixed;
                min-height: 100vh;
            }
            
            .auth-card {
                backdrop-filter: blur(10px);
                background-color: rgba(255, 255, 255, 0.9);
            }
        </style>
    </head>
    <body class="h-full">
        <div class="font-sans text-gray-900 antialiased min-h-screen flex flex-col justify-center">
            <div class="absolute top-6 left-6">
                <a href="/" class="flex items-center text-white">
                    <i class="fas fa-arrow-left mr-2"></i>
                    <span>Back to Home</span>
                </a>
            </div>
            <?php echo e($slot); ?>

            
            <div class="mt-8 text-center text-white">
                <p>&copy; <?php echo e(date('Y')); ?> CT ZONE. All rights reserved.</p>
            </div>
        </div>
        
        <!-- AI Chatbot -->
        <?php echo $__env->make('components.chatbot', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?>
        
        <!-- Chatbot JS -->
        <script src="<?php echo e(asset('js/chatbot.js')); ?>"></script>
    </body>
</html>
<?php /**PATH C:\Users\charb\Downloads\modern_ct_zone (2)\modern_ct_zone\resources\views/layouts/guest.blade.php ENDPATH**/ ?>