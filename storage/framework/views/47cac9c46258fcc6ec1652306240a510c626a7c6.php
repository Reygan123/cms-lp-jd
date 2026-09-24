<?php $__env->startSection('content'); ?>
<div class="flex justify-center items-center h-screen bg-gray-300 px-6">
    <div class="p-6 max-w-sm w-full bg-white shadow-md rounded-md">
        <div class="flex justify-center items-center">
            <span class="text-gray-700 font-semibold text-2xl">RESET PASSWORD</span>
        </div>
        <?php if(session('status')): ?>
        <div class="bg-green-500 p-3 rounded-md shadow-sm mt-3">
            <?php echo e(session('status')); ?>

        </div>
        <?php endif; ?>
        <form class="mt-4" action="<?php echo e(route('password.email')); ?>" method="POST">
            <?php echo csrf_field(); ?>
            <label class="block">
                <span class="text-gray-700 text-sm">Email</span>
                <input type="email" name="email" value="<?php echo e(old('email')); ?>"
                    class="form-input mt-1 block w-full rounded-md focus:border-indigo-600" placeholder="Alamat Email">
                <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                <div class="inline-flex max-w-sm w-full bg-red-200 shadow-sm rounded-md overflow-hidden mt-2">
                    <div class="px-4 py-2">
                        <p class="text-gray-600 text-sm"><?php echo e($message); ?></p>
                    </div>
                </div>
                <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
            </label>

            <div class="mt-6">
                <button type="submit"
                    class="py-2 px-4 text-center bg-indigo-600 rounded-md w-full text-white text-sm hover:bg-indigo-500 focus:outline-none">
                    SEND PASSWORD RESET LINK
                </button>
            </div>
        </form>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.auth', ['title' => 'Forgot Password - Admin'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/auth/forgot-password.blade.php ENDPATH**/ ?>