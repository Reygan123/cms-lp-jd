<section class="section-lg">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle blackish-color">Our Clients</h4>
            <h2 class="pbmit-title">Pengguna <?php echo e($program->name); ?></h2>
        </div>
        <div class="swiper-slider" dir="rtl" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="false"
            data-columns="6" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $porto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="swiper-slide">
                        <article class="pbmit-client-style-1">
                            <div class="pbmit-border-wrapper">
                                <div class="pbmit-client-wrapper ">
                                    <h4 class="pbmit-hide"><?php echo e($porto->title); ?></h4>
                                    <div class="image-container mt-4">
                                        <img src="<?php echo e(asset('storage/portofolios/' . $porto->logo)); ?>"
                                            class="img-fluid img-thumbnail image-rounded" alt="Gambar">
                                        <?php if($porto->yt_id): ?>
                                        <div class="text-overlay">
                                            <a class="button is-play pbmin-lightbox-video"
                                                href="https://www.youtube.com/watch?v=<?php echo e($porto->yt_id); ?>">
                                                <div class="button-outer-circle has-scale-animation"></div>
                                                <div class="button-outer-circle has-scale-animation has-delay-short">
                                                </div>
                                                <div class="button-icon is-play">
                                                    <svg height="100%" width="100%" fill="#3030f8">
                                                        <polygon class="triangle" points="5,0 30,15 5,30"
                                                            viewBox="0 0 30 15">
                                                        </polygon>
                                                        <path class="path" d="M5,0 L30,15 L5,30z" fill="none"
                                                            stroke="#3030f8" stroke-width="1"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </article>
                    </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="swiper-slider slider-10" data-autoplay="true" data-loop="true" data-dots="false" data-arrows="false" data-columns="6" data-margin="30" data-effect="slide">
            <div class="swiper-wrapper">
                <?php $__currentLoopData = $portfolios; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $porto): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="swiper-slide">
                    <article class="pbmit-client-style-1">
                        <div class="pbmit-border-wrapper">
                            <div class="pbmit-client-wrapper">
                                <h4 class="pbmit-hide"><?php echo e($porto->title); ?></h4>
                                <div class="image-container mt-4">
                                    <img src="<?php echo e(asset('storage/portofolios/' . $porto->logo)); ?>" class="img-fluid img-thumbnail image-rounded" alt="Gambar">
                                    <?php if($porto->yt_id): ?>
                                    <div class="text-overlay">
                                        <a class="button is-play pbmin-lightbox-video" href="https://www.youtube.com/watch?v=<?php echo e($porto->yt_id); ?>">
                                            <div class="button-outer-circle has-scale-animation"></div>
                                            <div class="button-outer-circle has-scale-animation has-delay-short"></div>
                                            <div class="button-icon is-play">
                                                <svg height="100%" width="100%" fill="#3030f8">
                                                    <polygon class="triangle" points="5,0 30,15 5,30" viewBox="0 0 30 15"></polygon>
                                                    <path class="path" d="M5,0 L30,15 L5,30z" fill="none" stroke="#3030f8" stroke-width="1"></path>
                                                </svg>
                                            </div>
                                        </a>
                                    </div>
                                    <?php endif; ?>
                                </div>
                            </div>
                        </div>
                    </article>
                </div>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/client.blade.php ENDPATH**/ ?>