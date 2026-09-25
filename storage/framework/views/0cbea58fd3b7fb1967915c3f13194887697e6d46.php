
   <section class="section-xl">
      <div class="container">
         <div class="position-relative">
            <div class="pbmit-heading-subheading animation-style2">
               <h4 class="pbmit-subtitle"><?php echo $juduls[0]->description; ?></h4>
               <h2 class="pbmit-title"><?php echo e($juduls[0]->title); ?></h2>
            </div>
            <div class="testimonial_arrow swiper-btn-custom d-flex flex-row-reverse"></div>
         </div>
         <div class="swiper-slider" data-arrows-class="testimonial_arrow" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="true" data-columns="3" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
               <?php $__currentLoopData = $testimonies; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $testi): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
               <div class="swiper-slide">
                  <article class="pbmit-testimonial-style-1">
                     <div class="pbminfotech-post-item">
                        <div class="pbmit-box-content-wrap">
                           <div class="pbminfotech-box-desc">
                              <blockquote class="pbminfotech-testimonial-text">
                                 <?php echo $testi->description; ?>

                              </blockquote>
                           </div>
                           <div class="pbminfotech-box-author d-flex align-items-center">
                              <div class="pbminfotech-box-img">
                                 <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                       <img src="<?php echo e(asset('/storage/testimonies/'.$testi->image)); ?>" class="" alt="<?php echo e($testi->name); ?>">
                                    </div>
                                 </div>
                              </div>
                              <div class="pbmit-auther-content">
                                 <h3 class="pbminfotech-box-title"><?php echo e($testi->name); ?></h3>
                                 <div class="pbminfotech-testimonial-detail"><?php echo e($testi->title); ?></div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </article>
               </div>
              <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
         </div>
      </div>
   </section><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/testimony.blade.php ENDPATH**/ ?>