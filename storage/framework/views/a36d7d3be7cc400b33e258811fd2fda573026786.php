<section class="section-md pbmit-bg-color-global pbmit-extend-animation pbmit-extend-animation service-three_bg mt-5">
    <div class="service-three-bg-overlay"></div>
    <div class="container">
        <div class="pbmit-heading-subheading text-white">
            <h4 class="pbmit-subtitle">Fitur <?php echo e($program->name); ?></h4>
            <h2 class="pbmit-title">Assessments Diagnostic</h2>
        </div>
        <div class="pbmit-element-service-style-5">
            <div class="pbmit-main-hover-slider d-flex align-items-center">
                <div class="swiper-hover-slide-images col-md-5 col-lg-5">
                    <div class="swiper pbmit-hover-image">
                        <div class="swiper-wrapper">
                            <!-- Slide1 -->
                            <?php $__currentLoopData = $program->facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <div class="swiper-slide">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="<?php echo e(asset('storage/facilities/' . $facility->image)); ?>" class="img-fluid" alt="">
                                    </div>
                                </div>
                                <span class="pbmit-service-icon elementor-icon">
                                    <i aria-hidden="true" class="pbmit-xcare-icon <?php echo e($facility->id); ?>"></i>
                                </span>
                            </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="swiper-hover-slide-nav col-md-7 col-lg-7">
                    <ul class="pbmit-hover-inner">
                        <?php $__currentLoopData = $program->facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="pbmit-title-data-hover" data-text="Dental Care">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="<?php echo e(asset('storage/facilities/' . $facility->image)); ?>" class="img-fluid" alt="">
                                    </div>
                                    <span class="pbmit-service-icon elementor-icon">
                                        <i aria-hidden="true" class="pbmit-xcare-icon pbmit-xcare-icon-gesundheit-1"></i>
                                    </span>
                                </div>
                                <div class="pbmit-text-content d-flex align-items-center">
                                    <span class="pbminfotech-box-number">0<?php echo e($loop->iteration); ?></span>
                                    <a class="pbmit-title-inner" href="">
                                        <span><?php echo e($facility->title); ?></span>
                                        <div class="small-text"><?php echo e($facility->subtitle); ?></div>
                                    </a>
                                    <div class="pbmit-service-btn">
                                        <a href="">
                                            <span class="pbmit-button-icon-wrapper">
                                                <span class="pbmit-button-icon">
                                                    <i class="pbmit-base-icon-black-arrow-1"></i>
                                                </span>
                                            </span>
                                        </a>
                                    </div>
                                </div>
                                <a class="pbmit-link" href="<?php echo e(route('front.assessment.show', $facility->slug)); ?>"></a>
                            </div>
                        </li>
                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        <li>
                            <div class="row align-items-center">
                                <div class="col-sm-4 mt-2 text-center">
                                    <a class="pbmit-btn pbmit-btn-white" href="<?php echo e($linkdaftars[0]->link); ?>">
                                        <span class="pbmit-button-content-wrapper">
                                            <span class="pbmit-button-icon pbmit-align-icon-right">
                                                <svg xmlns="http://www.w3.org/2000/svg" width="22.76" height="22.76" viewBox="0 0 22.76 22.76">
                                                    <title>black-arrow</title>
                                                    <path d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                                    <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                                    <path d="M22.34,1,1,22.34" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                                </svg>
                                            </span>
                                            <span class="pbmit-button-text"><?php echo e($linkdaftars[0]->linktext); ?></span>
                                        </span>
                                    </a>
                                </div>
                                <div class="col-sm-4 mt-2 text-center">
                                    <a class="pbmit-btn pbmit-btn-blackish" href="https://wa.me/+62<?php echo e($identities[0]->phone); ?>?text=<?php echo e($welcomechats[0]->greating); ?>">
                                        <span class="pbmit-button-content-wrapper">
                                            <span class="pbmit-button-icon pbmit-align-icon-right">
                                                <i class="fa-brands fa-whatsapp"></i>
                                            </span>
                                            <span class="pbmit-button-text">Contact Us</span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </li>
                    </ul>
                    
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mt-4">
                <div class="card-bg-white">
                    <div class="row">
                        <div class="col-sm-4 pbmit-service-feature-image visi-image">
                            <img src="<?php echo e(asset('storage/programs/' . $program->image3)); ?>"
                                alt="" class="img-fluid w-100 image-rounded">
                        </div>
                        <div class="col-sm-8">
                            <h5><?php echo e($program->title3); ?></h5>
                            <div class="list-endar mt-4">
                                <?php echo $program->description3; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mt-4">
                <div class="card-bg-white">
                    <div class="row">
                        <div class="col-sm-4 pbmit-service-feature-image visi-image">
                            <img src="<?php echo e(asset('storage/programs/' . $program->image4)); ?>"
                                alt="" class="img-fluid w-100 image-rounded">
                        </div>
                        <div class="col-sm-8">
                            <h5><?php echo e($program->title4); ?></h5>
                            <div class="list-endar mt-4">
                                <?php echo $program->description4; ?>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/program/fitur.blade.php ENDPATH**/ ?>