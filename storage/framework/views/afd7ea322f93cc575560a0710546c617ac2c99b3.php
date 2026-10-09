<section class="section">
    <div class="container">
        <div class="pbmit-heading-subheading">
            <h5 class=""><?php echo e($titles[0]->title); ?> <?php echo e($facility->title); ?></h5>
        </div>
        <div class="row">
            <?php $__currentLoopData = $benefits; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $benefit): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <div class="col-lg-4 col-sm-6">
                <article class="pbmit-miconheading-style-18 swiper-slide">
                    <div class="pbmit-ihbox-style-18">
                        <div class="pbmit-ihbox-headingicon">
                            <div class="pbmit-icon-wrap">
                                <div class="pbmit-ihbox-wrapper">
                                    <div class="pbmit-ihbox-icon-type-image">
                                        <img src="<?php echo e(asset('storage/benefits/' . $benefit->image)); ?>" alt="<?php echo e($benefit->title); ?>" class="w-100">
                                    </div>
                                </div>
                                <div class="pbmit-ihbox-box-number"></div>
                            </div>
                            <div class="pbmit-ihbox-contents">
                                <h2 class="pbmit-element-title">
                                    <?php echo e($benefit->title); ?>

                                </h2>
                                <div class="pbmit-heading-desc"><?php echo $benefit->description; ?></div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/assessment/benefit.blade.php ENDPATH**/ ?>