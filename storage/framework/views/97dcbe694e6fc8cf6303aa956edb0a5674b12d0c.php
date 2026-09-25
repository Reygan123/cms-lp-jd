<div class="pbmit-slider-area pbmit-slider-two">
   <div class="swiper-slider" data-autoplay="false" data-loop="true" data-dots="true" data-arrows="false"
       data-columns="1" data-margin="0" data-effect="fade">
       <div class="swiper-wrapper">
        <?php $__currentLoopData = $sliders; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $slider): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
           <div class="swiper-slide">
               <div class="pbmit-slider-item">
                   <div class="pbmit-slider-bg"
                       style="background-image: url(<?php echo e(asset('storage/sliders/' . $slider->image)); ?>); height: 100vh; border-radius: 20px;"></div>
                   <div class="container">
                       <div class="row">
                           <div class="col-md-12">
                               <div class="pbmit-slider-content">
                                   <h5 class="pbmit-sub-title transform-top transform-delay-1"><?php echo e(strip_tags($identities[0]->name)); ?></h5>
                                   <h2 class="pbmit-title transform-right transform-delay-2 mt-4"><?php echo e(strip_tags($slider->title)); ?></h2>
                                   <p class="pbmit-desc transform-right transform-delay-2"><?php echo e(strip_tags($slider->description)); ?></p>
                                   <div class="pbmit-button transform-bottom transform-delay-3">
                                       <a class="pbmit-btn pbmit-btn-white" href="<?php echo e(strip_tags($slider->link)); ?>">
                                           <span class="pbmit-button-content-wrapper">
                                               <span class="pbmit-button-icon pbmit-align-icon-right">
                                                   <svg xmlns="http://www.w3.org/2000/svg" width="22.76"
                                                       height="22.76" viewBox="0 0 22.76 22.76">
                                                       <title>black-arrow</title>
                                                       <path
                                                           d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1"
                                                           transform="translate(-0.29 -0.29)" fill="none"
                                                           stroke="#000" stroke-width="2"></path>
                                                       <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75"
                                                           transform="translate(-0.29 -0.29)" fill="none"
                                                           stroke="#000" stroke-width="2"></path>
                                                       <path d="M22.34,1,1,22.34"
                                                           transform="translate(-0.29 -0.29)" fill="none"
                                                           stroke="#000" stroke-width="2"></path>
                                                   </svg>
                                               </span>
                                               <span class="pbmit-button-text"><?php echo e(strip_tags($slider->button)); ?></span>
                                           </span>
                                       </a>
                                   </div>
                               </div>
                           </div>
                       </div>
                   </div>
               </div>
           </div>
           <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
       </div>
   </div>
</div>
</header><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/slider.blade.php ENDPATH**/ ?>