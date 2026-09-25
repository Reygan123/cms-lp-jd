<?php if(session('success')): ?>
<div class="alert alert-success alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-check-circle mr-2"></i><?php echo e(session('success')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if(session('error')): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <i class="fa-solid fa-triangle-exclamation mr-2"></i><?php echo e(session('error')); ?>

    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>

<?php if($errors->any()): ?>
<div class="alert alert-danger alert-dismissible fade show" role="alert">
    <ul class="mb-0">
        <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <li><?php echo e($error); ?></li>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    </ul>
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
</div>
<?php endif; ?>
<?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/layouts/alert.blade.php ENDPATH**/ ?>