<div class="footer">
    <div class="copyright">
        <p>&copy; 2012-<?php echo date("Y"); ?>
    <?php $__currentLoopData = $identities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $i): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <?php echo e($i->name); ?>

    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?> </p>
    </div>
</div>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/layouts/footer.blade.php ENDPATH**/ ?>