
<?php $__env->startSection('content'); ?>
    <?php echo $__env->make('front.assessment.title', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
    <section class="site_content service_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 service-right-col">
                    <?php echo $__env->make('front.assessment.isi', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    <?php echo $__env->make('front.assessment.benefit', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                </div>
                <div class="col-lg-3 service-left-col sidebar">
                    <?php echo $__env->make('front.assessment.side', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

                </div>
            </div>
        </div>
    </section>
    
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontapp', ['title' => $facility->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/assessment/show.blade.php ENDPATH**/ ?>