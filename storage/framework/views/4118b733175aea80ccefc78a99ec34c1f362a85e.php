<div class="footer">
    <div class="copyright">
        <p>&copy; 2012-<?php echo date("Y"); ?>
    <?php $__currentLoopData = $identities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($i->name); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </p>
    </div>
</div>
<?php /**PATH C:\Users\Reygan Fadhilah\Downloads\cms-lp-jd-main\cms-lp-jd-main\resources\views/layouts/footer.blade.php ENDPATH**/ ?>