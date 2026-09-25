<section>
    <div class="container">
        <div class="row g-0 align-items-center">
            <div class="col-md-12 col-xl-6">
                <div class="about-one_img"
                    style="background-image: url(<?php echo e(asset('storage/programs/' . $program->image1)); ?>)">
                    <div class="about-one_fidbox">
                        <div class="pbminfotech-ele-fid-style-2">
                            <div class="pbmit-fld-contents">
                                <div class="pbmit-fld-wrap">
                                    <h4 class="pbmit-fid-inner">
                                        <span class="pbmit-fid-before"></span>
                                        <span class="pbmit-number-rotate numinate" data-appear-animation="animateDigits"
                                            data-from="0" data-to="<?php echo e($program->class_size); ?>" data-interval="5"
                                            data-before="" data-before-style="" data-after=""
                                            data-after-style=""><?php echo e($program->class_size); ?></span>
                                        <span class="pbmit-fid"><sup>+</sup></span>
                                    </h4>
                                    <div class="pbmit-fid-sub">
                                        <div class="pbmit-heading-desc">Pengguna Aktif</div>
                                    </div>
                                </div>
                            </div>
                            <div class="pbmit-sticky-corner  pbmit-bottom-left-corner">
                                <svg width="30" height="30" viewBox="0 0 30 30"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30 30V0C30 16 16 30 0 30H30Z"></path>
                                </svg>
                            </div>
                            <div class="pbmit-sticky-corner pbmit-top-right-corner">
                                <svg width="30" height="30" viewBox="0 0 30 30"
                                    xmlns="http://www.w3.org/2000/svg">
                                    <path d="M30 30V0C30 16 16 30 0 30H30Z"></path>
                                </svg>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-xl-6">
                <div class="about-one-rightbox">
                    <div class="pbmit-heading-subheading animation-style3">
                        <h4 class="pbmit-subtitle"><?php echo e($program->name); ?></h4>
                        <h2 class="pbmit-title"><?php echo e($program->title1); ?></h2>
                        <div class="pbmit-heading-desc">
                            <?php echo $program->description1; ?>

                        </div>
                    </div>
                    <div class="pbminfotech-box-author row align-items-center">
                        <div class="col-md-4 col-sm-3 col-5">
                            <div class="pbminfotech-box-img">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="<?php echo e(asset('storage/ourteams/' . $program->ourteam->image)); ?>"
                                            class="img-fluid team-program" alt="<?php echo e($program->ourteam->name); ?>">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-8 col-sm-9 col-7">
                            <div class="pbmit-auther-content mx-2">
                                <h6 class="pbminfotech-box-title"><?php echo e($program->ourteam->name); ?></h6>
                                <div class="pbminfotech-testimonial-detail">Penanggung Jawab</div>
                            </div>
                        </div>

                    </div>
                    <div class="pbmit-button">
                        <div class="about-one_btn">
                            <div class="row align-items-center">
                                <?php if($program->id_yt): ?>
                                    <div class="col-sm-5 text-center mt-4">
                                        <div class="pbmit-btn-box">
                                            <a href="https://www.youtube.com/watch?v=<?php echo e($program->id_yt); ?>"
                                                class="pbmin-lightbox-video lightbox-video-btn-headline transform-left transform-delay-3">
                                                <span>
                                                    <i class="pbmit-base-icon-play-button-1"></i>
                                                </span>
                                                <u>Watch our video</u>
                                            </a>
                                        </div>
                                    </div>
                                <?php endif; ?>

                                <div class="col-sm-4 text-center mt-4">
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
                                                    <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75"
                                                        transform="translate(-0.29 -0.29)" fill="none" stroke="#000"
                                                        stroke-width="2"></path>
                                                    <path d="M22.34,1,1,22.34" transform="translate(-0.29 -0.29)"
                                                        fill="none" stroke="#000" stroke-width="2"></path>
                                                </svg>
                                            </span>
                                            <span class="pbmit-button-text"><?php echo e($linkdaftars[0]->linktext); ?></span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>

                    </div>


                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/program/headline.blade.php ENDPATH**/ ?>