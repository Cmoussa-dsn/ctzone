<?php if (isset($component)) { $__componentOriginal69dc84650370d1d4dc1b42d016d7226b = $component; } ?>
<?php if (isset($attributes)) { $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b = $attributes; } ?>
<?php $component = App\View\Components\GuestLayout::resolve([] + (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag ? $attributes->all() : [])); ?>
<?php $component->withName('guest-layout'); ?>
<?php if ($component->shouldRender()): ?>
<?php $__env->startComponent($component->resolveView(), $component->data()); ?>
<?php if (isset($attributes) && $attributes instanceof Illuminate\View\ComponentAttributeBag): ?>
<?php $attributes = $attributes->except(\App\View\Components\GuestLayout::ignoredParameterNames()); ?>
<?php endif; ?>
<?php $component->withAttributes([]); ?>
    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-6 sm:pt-0 relative overflow-hidden">
        <div class="absolute inset-0 bg-gradient-animation"></div>
        <div class="absolute inset-0 z-0">
            <div class="geometric-shapes"></div>
        </div>
        
        <div class="w-full sm:max-w-md mt-6 px-6 py-8 bg-white/95 backdrop-blur-sm shadow-xl overflow-hidden sm:rounded-2xl z-10 border border-white/20">
            <div class="flex justify-center mb-6">
                <img src="<?php echo e(asset('images/loginlogo.png')); ?>" alt="CT ZONE" class="h-16">
            </div>
            
            <h2 class="text-2xl font-bold text-center text-gray-900 mb-6">Welcome Back</h2>
            
            <!-- Session Status -->
            <?php if(session('status')): ?>
                <div class="mb-4 font-medium text-sm text-green-600">
                    <?php echo e(session('status')); ?>

                </div>
            <?php endif; ?>

            <!-- Validation Errors -->
            <?php if($errors->any()): ?>
                <div class="mb-4 bg-red-100 border-l-4 border-red-500 text-red-700 p-4 rounded-lg">
                    <div class="font-medium"><?php echo e(__('Whoops! Something went wrong.')); ?></div>

                    <ul class="mt-3 list-disc list-inside text-sm">
                        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li><?php echo e($error); ?></li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </ul>
                </div>
            <?php endif; ?>

            <form method="POST" action="<?php echo e(route('login')); ?>">
                <?php echo csrf_field(); ?>

                <!-- Email Address -->
                <div class="mb-5">
                    <label for="email" class="block text-sm font-medium text-gray-700 mb-1">Email</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-400"></i>
                        </div>
                        <input id="email" type="email" name="email" value="<?php echo e(old('email')); ?>" required autofocus 
                            class="appearance-none block w-full pl-10 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-5">
                    <label for="password" class="block text-sm font-medium text-gray-700 mb-1">Password</label>
                    <div class="relative">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-400"></i>
                        </div>
                        <input id="password" type="password" name="password" required 
                            class="appearance-none block w-full pl-10 px-3 py-2.5 border border-gray-300 rounded-lg shadow-sm placeholder-gray-400 focus:outline-none focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm">
                    </div>
                </div>

                <!-- Remember Me -->
                <div class="flex items-center justify-between mt-5">
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" 
                            class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Remember me</label>
                    </div>

                    <?php if(Route::has('password.request')): ?>
                        <a class="text-sm text-indigo-600 hover:text-indigo-500 font-medium" href="<?php echo e(route('password.request')); ?>">
                            Forgot password?
                        </a>
                    <?php endif; ?>
                </div>

                <div class="mt-6">
                    <button type="submit" class="w-full flex justify-center py-2.5 px-4 border border-transparent rounded-lg shadow-sm text-sm font-medium text-white bg-indigo-600 hover:bg-indigo-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        Login
                    </button>
                </div>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-gray-600">
                    Don't have an account?
                    <a href="<?php echo e(route('register')); ?>" class="font-medium text-indigo-600 hover:text-indigo-500 ml-1">
                        Sign up
                    </a>
                </p>
            </div>
        </div>
    </div>
    
    <style>
        .bg-gradient-animation {
            background: linear-gradient(-45deg, #3b82f6, #4f46e5, #6366f1, #8b5cf6);
            background-size: 400% 400%;
            animation: gradient 15s ease infinite;
        }
        
        @keyframes gradient {
            0% {
                background-position: 0% 50%;
            }
            50% {
                background-position: 100% 50%;
            }
            100% {
                background-position: 0% 50%;
            }
        }
        
        .geometric-shapes {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            overflow: hidden;
        }
        
        .geometric-shapes::before {
            content: '';
            position: absolute;
            height: 200px;
            width: 200px;
            background: rgba(255, 255, 255, 0.08);
            left: 50%;
            transform: rotate(45deg);
            border-radius: 30px;
            animation: float 8s ease-in-out infinite;
        }
        
        .geometric-shapes::after {
            content: '';
            position: absolute;
            height: 300px;
            width: 300px;
            background: rgba(255, 255, 255, 0.08);
            left: 20%;
            top: 20%;
            transform: rotate(20deg);
            border-radius: 40px;
            animation: float 9s ease-in-out infinite 1s alternate;
        }
        
        @keyframes float {
            0% {
                transform: translatey(0px) rotate(45deg);
            }
            50% {
                transform: translatey(-30px) rotate(45deg);
            }
            100% {
                transform: translatey(0px) rotate(45deg);
            }
        }
    </style>
 <?php echo $__env->renderComponent(); ?>
<?php endif; ?>
<?php if (isset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $attributes = $__attributesOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__attributesOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php if (isset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b)): ?>
<?php $component = $__componentOriginal69dc84650370d1d4dc1b42d016d7226b; ?>
<?php unset($__componentOriginal69dc84650370d1d4dc1b42d016d7226b); ?>
<?php endif; ?>
<?php /**PATH C:\Users\charb\Downloads\modern_ct_zone\resources\views/auth/login.blade.php ENDPATH**/ ?>