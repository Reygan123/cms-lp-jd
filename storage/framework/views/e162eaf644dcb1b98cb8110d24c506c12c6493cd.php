<section class="section-xl">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle blackish-color">Why <?php echo e($program->name); ?>!</h4>
            <h2 class="pbmit-title">Alasan Harus Menggunakan <br> <?php echo e($program->name); ?></h2>
        </div>
        <div class="pbmit-tab pbmit-tab-style-3">
            <ul class="nav nav-tabs" role="tablist">
      
                <?php $__currentLoopData = $unggulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $unggulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li class="nav-item" role="presentation">
                        <a class="nav-link <?php echo e($index === 0 ? 'active' : ''); ?>" data-bs-toggle="tab"
                            href="#tab-<?php echo e($unggulan->id); ?>" aria-selected="<?php echo e($index === 0 ? 'true' : 'false'); ?>"
                            role="tab" tabindex="<?php echo e($index === 0 ? '' : '-1'); ?>">
                            <span><?php echo e($unggulan->title); ?></span>
                            <i class="pbmit-base-icon-black-arrow-1"></i>
                        </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </ul>
            <div class="tab-content">
                <?php $__currentLoopData = $unggulans; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $index => $unggulan): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="tab-pane <?php echo e($index === 0 ? 'show active' : ''); ?>" id="tab-<?php echo e($unggulan->id); ?>" role="tabpanel">
                    <div class="pbmit-column-inner">
                        <div class="row">
                            <div class="col-md-12 col-xl-6 pbmit-tab-img">
                                <img src="<?php echo e(asset('storage/unggulans/' . $unggulan->image)); ?>" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-12 col-xl-6 pbmit-tab-list">
                                <h2><?php echo e($unggulan->title); ?></h2>
                                <div class="list-endar">
                                    <?php echo $unggulan->description; ?>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/program/why.blade.php ENDPATH**/ ?>