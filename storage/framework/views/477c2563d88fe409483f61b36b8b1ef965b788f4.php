<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.component.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<div id="content" class="site-content ">
    <div class="container">
        <div class="row default_row">
            <div class="full_width_box">
                <!--===============spacing==============-->
                <div class="pd_top_80"></div>
                <!--===============spacing==============-->
                <section class="service-section">
                    <div class="row">
                        <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4">
                            <div class="service_box style_one dark_color">
                                <div class="service_content">
                                    <div class="image  image_fit">
                                        <img src="<?php echo e(asset('/storage/facilities/'.$f->image)); ?>" class="img-fluid" alt="Service Image">
                                    </div>
                                    <div class="content_inner">
                                        <h2><a href="#"><?php echo e($f->title); ?></a></h2>
                                        <?php echo $f->description; ?>

                                    </div>
                                </div>
                            </div>
                        </div>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    </div>
                </section>
                <!--===============spacing==============-->
                <div class="pd_top_80"></div>
                <!--===============spacing==============-->
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontapp' , ['title' => 'Fasilitas'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/assessment/index.blade.php ENDPATH**/ ?>