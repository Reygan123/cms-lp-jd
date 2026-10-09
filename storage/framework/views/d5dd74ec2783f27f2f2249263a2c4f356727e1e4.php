<section class="section-xl">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle">Our Leaders</h4>
            <h2 class="pbmit-title">Dewan Pembina</h2>
        </div>
        <div class="row justify-content-center pbmit-element-posts-wrapper">
            <?php $__currentLoopData = $penasehats; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="pbmit-team-style-1 col-md-6 col-lg-3">
                <div class="pbminfotech-post-item">
                    <div class="pbmit-featured-wrap">
                        <div class="pbmit-featured-img-wrapper">
                            <div class="pbmit-featured-wrapper">
                                <img src="<?php echo e(asset('storage/ourteams/'.$p->image)); ?>" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="pbmit-team-btn">
                            <a class="pbmit-team-text" href="#">
                                <i class="pbmit-base-icon-share-1"></i>
                            </a>
                            <div class="pbminfotech-box-social-links">
                                <ul class="pbmit-social-links pbmit-team-social-links">
                                    <li class="pbmit-social-li pbmit-social-facebook">
                                        <a href="https://www.facebook.com/<?php echo e(strip_tags($p->fb)); ?>" title="Facebook" target="_blank">
                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                        </a>
                                    </li>
                                    
                                    <li class="pbmit-social-li pbmit-social-instagram">
                                        <a href="https://www.instagram.com/<?php echo e(strip_tags($p->ig)); ?>" title="Instagram" target="_blank">
                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-youtube">
                                        <a href="https://www.youtube.com/<?php echo e(strip_tags($p->yt)); ?>" title="Youtube" target="_blank">
                                            <span><i class="pbmit-base-icon-youtube-play"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-twitter">
                                        <a href="https://www.tiktok.com/<?php echo e(strip_tags($p->tt)); ?>" title="Tiktok" target="_blank">
                                            <span><i class="fa-brands fa-tiktok"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pbminfotech-box-content">
                        <div class="pbminfotech-box-content-inner">
                            <div class="pbminfotech-box-team-position"><?php echo e(strip_tags($p->title)); ?></div>
                            <h3 class="pbmit-team-title">
                                <a href="team-single-detail.html"><?php echo e(strip_tags($p->name)); ?></a>
                            </h3>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
        <hr>
        <div class="mt-5">
            <div class="pbmit-heading-subheading text-center">
                <h4 class="pbmit-subtitle">Our Leaders</h4>
                <h2 class="pbmit-title">Dewan Pakar</h2>
            </div>
            <div class="row justify-content-center pbmit-element-posts-wrapper">
                <?php $__currentLoopData = $pakars; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $pakar): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="pbmit-team-style-1 col-md-6 col-lg-3">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-featured-wrap">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="<?php echo e(asset('storage/ourteams/'.$pakar->image)); ?>" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="pbmit-team-btn">
                                <a class="pbmit-team-text" href="#">
                                    <i class="pbmit-base-icon-share-1"></i>
                                </a>
                                <div class="pbminfotech-box-social-links">
                                    <ul class="pbmit-social-links pbmit-team-social-links">
                                        <li class="pbmit-social-li pbmit-social-facebook">
                                            <a href="https://www.facebook.com/<?php echo e(strip_tags($pakar->fb)); ?>" title="Facebook" target="_blank">
                                                <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                            </a>
                                        </li>
                                        
                                        <li class="pbmit-social-li pbmit-social-instagram">
                                            <a href="https://www.instagram.com/<?php echo e(strip_tags($pakar->ig)); ?>" title="Instagram" target="_blank">
                                                <span><i class="pbmit-base-icon-instagram"></i></span>
                                            </a>
                                        </li>
                                        <li class="pbmit-social-li pbmit-social-youtube">
                                            <a href="https://www.youtube.com/<?php echo e(strip_tags($pakar->yt)); ?>" title="Youtube" target="_blank">
                                                <span><i class="pbmit-base-icon-youtube-play"></i></span>
                                            </a>
                                        </li>
                                        <li class="pbmit-social-li pbmit-social-twitter">
                                            <a href="https://www.tiktok.com/<?php echo e(strip_tags($pakar->tt)); ?>" title="Tiktok" target="_blank">
                                                <span><i class="fa-brands fa-tiktok"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pbminfotech-box-content">
                            <div class="pbminfotech-box-content-inner">
                                <!-- <div class="pbminfotech-box-team-position"><?php echo e(strip_tags($pakar->title)); ?></div> -->
                                <h3 class="pbmit-team-title">
                                    <a href="team-single-detail.html"><?php echo e(strip_tags($pakar->name)); ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
        <div class="mt-5">
            <div class="pbmit-heading-subheading text-center">
                <h4 class="pbmit-subtitle">Our Leaders</h4>
                <h2 class="pbmit-title">Dewan Direksi</h2>
            </div>
            <div class="row justify-content-center pbmit-element-posts-wrapper">
                <?php $__currentLoopData = $direkturs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $d): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <article class="pbmit-team-style-1 col-md-6 col-lg-3">
                    <div class="pbminfotech-post-item">
                        <div class="pbmit-featured-wrap">
                            <div class="pbmit-featured-img-wrapper">
                                <div class="pbmit-featured-wrapper">
                                    <img src="<?php echo e(asset('storage/ourteams/'.$d->image)); ?>" class="img-fluid" alt="">
                                </div>
                            </div>
                            <div class="pbmit-team-btn">
                                <a class="pbmit-team-text" href="#">
                                    <i class="pbmit-base-icon-share-1"></i>
                                </a>
                                <div class="pbminfotech-box-social-links">
                                    <ul class="pbmit-social-links pbmit-team-social-links">
                                        <li class="pbmit-social-li pbmit-social-facebook">
                                            <a href="https://www.facebook.com/<?php echo e(strip_tags($d->fb)); ?>" title="Facebook" target="_blank">
                                                <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                            </a>
                                        </li>
                                        
                                        <li class="pbmit-social-li pbmit-social-instagram">
                                            <a href="https://www.instagram.com/<?php echo e(strip_tags($d->ig)); ?>" title="Instagram" target="_blank">
                                                <span><i class="pbmit-base-icon-instagram"></i></span>
                                            </a>
                                        </li>
                                        <li class="pbmit-social-li pbmit-social-youtube">
                                            <a href="https://www.youtube.com/<?php echo e(strip_tags($d->yt)); ?>" title="Youtube" target="_blank">
                                                <span><i class="pbmit-base-icon-youtube-play"></i></span>
                                            </a>
                                        </li>
                                        <li class="pbmit-social-li pbmit-social-twitter">
                                            <a href="https://www.tiktok.com/<?php echo e(strip_tags($d->tt)); ?>" title="Tiktok" target="_blank">
                                                <span><i class="fa-brands fa-tiktok"></i></span>
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div class="pbminfotech-box-content">
                            <div class="pbminfotech-box-content-inner">
                                <div class="pbminfotech-box-team-position"><?php echo e(strip_tags($d->title)); ?></div>
                                <h3 class="pbmit-team-title">
                                    <a href="team-single-detail.html"><?php echo e(strip_tags($d->name)); ?></a>
                                </h3>
                            </div>
                        </div>
                    </div>
                </article>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
            </div>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/ourteam/leader.blade.php ENDPATH**/ ?>