<section>
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="col-md-12 col-xl-6">
                <div class="about-us-left_box">
                    <div class="about-us_img1 pbmit-animation-style4">
                        <img src="<?php echo e(asset('storage/identities/' . $abouts[0]->image1)); ?>" class="img-fluid" alt="">
                    </div>
                    <div class="about-us_img2 pbmit-animation-style3">
                        <div class="image-container">
                            <img src="<?php echo e(asset('storage/identities/' . $abouts[0]->image2)); ?>" class="img-fluid"
                                alt="Gambar">
                            <div class="text-overlay">
                                <a class="button is-play pbmin-lightbox-video" href="https://www.youtube.com/watch?v=<?php echo e($abouts[0]->video); ?>">
                                    <div class="button-outer-circle has-scale-animation"></div>
                                    <div class="button-outer-circle has-scale-animation has-delay-short"></div>
                                    <div class="button-icon is-play">
                                        <svg height="100%" width="100%" fill="#3030f8">
                                            <polygon class="triangle" points="5,0 30,15 5,30" viewBox="0 0 30 15">
                                            </polygon>
                                            <path class="path" d="M5,0 L30,15 L5,30z" fill="none" stroke="#3030f8"
                                                stroke-width="1"></path>
                                        </svg>
                                    </div>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-6">
                <div class="about-us-right_box">
                    <div class="pbmit-heading-subheading">
                        <h4 class="pbmit-subtitle"><?php echo e($abouts[0]->title); ?></h4>
                        <h2 class="pbmit-title"><?php echo e($identities[0]->name); ?></h2>
                        <div class="pbmit-heading-desc">
                            <?php echo $abouts[0]->content; ?>

                        </div>
                    </div>
                    <a class="pbmit-btn" href="<?php echo e($linkdaftars[0]->link); ?>">
                        <span class="pbmit-button-content-wrapper">
                            <span class="pbmit-button-icon pbmit-align-icon-right">
                                <svg xmlns="http://www.w3.org/2000/svg" width="22.76" height="22.76"
                                    viewBox="0 0 22.76 22.76">
                                    <title>black-arrow</title>
                                    <path
                                        d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1"
                                        transform="translate(-0.29 -0.29)" fill="none" stroke="#000"
                                        stroke-width="2"></path>
                                    <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75" transform="translate(-0.29 -0.29)"
                                        fill="none" stroke="#000" stroke-width="2"></path>
                                    <path d="M22.34,1,1,22.34" transform="translate(-0.29 -0.29)" fill="none"
                                        stroke="#000" stroke-width="2"></path>
                                </svg>
                            </span>
                            <span class="pbmit-button-text"><?php echo e($linkdaftars[0]->linktext); ?></span>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </div>
</section><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/about/about.blade.php ENDPATH**/ ?>