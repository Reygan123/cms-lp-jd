<div class="bd-blog-sidebar mb-50 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="bd-blog-latest">
                           <?php $__currentLoopData = $banners; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $banner): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                              <a href="<?php $__currentLoopData = $linkdaftars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ld): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?><?php echo e($ld->link); ?><?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>">
                                 <div class="bd-blog-details-thumb">
                                    <img src="<?php echo e(asset('storage/identities/'.$banner->image)); ?>" alt="" class="img-fluid">
                                 </div>
                              </a>
                           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                     </div><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/banner.blade.php ENDPATH**/ ?>