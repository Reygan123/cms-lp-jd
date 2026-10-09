<section class="section-md service-ten-bg pbmit-bg-color-global pbmit-extend-animation mt-5" style="clip-path: inset(0% 2.2125% round 13.275px);">
    <div class="container">
        <div class="row service_details ">
            <div class="col-md-4 pbmit-service-feature-image visi-image">
                <img src="<?php echo e(asset('storage/identities/' . $visis[0]->image)); ?>" alt="" class="img-fluid w-100 mt-5 ">
                <div class="pbmit-ihbox-style-15">
                    <div class="pbmit-ihbox-box"> 
                        <div class="pbmit-icon-wrap d-flex align-items-center">
                            <div class="pbmit-ihbox-icon">
                                <div class="pbmit-ihbox-icon-wrapper">
                                    <h3 class="text-center"><?php echo e(strip_tags($visis[0]->title)); ?></h3>
                                </div>
                            </div>
                        </div>
                        <h5 class="pbmit-element-title-endar"><?php echo e(strip_tags($visis[0]->visi)); ?></h5>
                    </div>
                    <div class="pbmit-ihbox-btn">
                        <a href="#">
                            <span class="pbmit-button-text">Read More</span>
                            <span class="pbmit-button-icon-wrapper">
                                <span class="pbmit-button-icon">
                                    <i class="pbmit-base-icon-black-arrow-1"></i>
                                </span>
                            </span>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col-md-8 pbmit-team-single">
                <div class="comment-respond">
                    <div class="pbmit-ihbox-style-16">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper">
                                <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                    <i class="pbmit-xcare-icon pbmit-xcare-icon-team"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <h2 class="pbmit-title"><?php echo e($misis[0]->title); ?></h2>
                        </div>
                    </div>
                    <div class="mt-5 list-endar"><?php echo $misis[0]->misi; ?></div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/about/visi.blade.php ENDPATH**/ ?>