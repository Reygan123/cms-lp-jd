<div class="footer-top-section pbmit-bg-color-blackish">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-md-8 pbmit-col_1">
                <ul class="pbmit-icon-list-items pbmit-inline-items">
                    <li class="pbmit-icon-list-item pbmit-inline-item">
                        <a href="<?php echo e(route('home')); ?>/about-us">
                            <span class="pbmit-icon-list-text">About Us</span>
                        </a>
                    </li>
                    <li class="pbmit-icon-list-item pbmit-inline-item">
                        <a href="<?php echo e(route('home')); ?>/ourteam">
                            <span class="pbmit-icon-list-text">Our Team</span>
                        </a>
                    </li>
                    <li class="pbmit-icon-list-item pbmit-inline-item">
                        <a href="#">
                            <span class="pbmit-icon-list-text">Join Us</span>
                        </a>
                    </li>
                    <li class="pbmit-icon-list-item pbmit-inline-item">
                        <a href="#">
                            <span class="pbmit-icon-list-text">Success Story</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="col-md-2 pbmit-col_2">
                <div class="pbmit-ihbox-style-13">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper">
                                <a href="tel:+62<?php echo e($identities[0]->phone); ?>">
                                    <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                        <i class="pbmit-xcare-icon pbmit-xcare-icon-phone-call"></i>
                                    </div>
                                </a>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <a href="tel:+62<?php echo e($identities[0]->phone); ?>">
                                <h2 class="pbmit-element-title">
                                    +62 <?php echo e(str_replace('+62', '0', substr($identities[0]->phone, 0, 3))); ?>-
                                    <?php echo e(substr($identities[0]->phone, 3, 4)); ?>-
                                    <?php echo e(substr($identities[0]->phone, 7)); ?></span>
                                </h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-2 pbmit-col_3">
                <div class="pbmit-ihbox-style-13">
                    <div class="pbmit-ihbox-box">
                        <div class="pbmit-ihbox-icon">
                            <div class="pbmit-ihbox-icon-wrapper">
                                <div class="pbmit-icon-wrapper pbmit-icon-type-icon">
                                    <i class="pbmit-xcare-icon pbmit-xcare-icon-email"></i>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-ihbox-contents">
                            <a href="mailto:<?php echo e($identities[0]->email); ?>">
                                <h2 class="pbmit-element-title"><?php echo e($identities[0]->email); ?></h2>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<footer class="site-footer">
    <div class="pbmit-footer-big-area-wrapper">
        <div class="footer-wrap pbmit-footer-big-area">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-xl-4"></div>
                    <div class="col-md-12 col-xl-8 pbmit-footer-right">
                        <h3 class="pbmit-title"><?php echo e($abouts[0]->subtitle); ?></h3>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="pbmit-footer-widget-area">
        <div class="container">
            <div class="row">
                <div class="pbmit-footer-widget-col-1 col-md-6 col-lg-3">
                    <aside class="widget widget_text">
                        <div class="textwidget">
                            <div class="pbmit-footer-logo">
                                <img src="<?php echo e(asset('storage/identities/' . $identities[0]->logo)); ?>"
                                    alt="<?php echo e($identities[0]->name); ?>">
                            </div>
                            <div class="pbmit-footer-text">
                                <?php echo e(strip_tags($visis[0]->visi)); ?>

                            </div>
                            <ul class="pbmit-social-links">
                                <li class="pbmit-social-li pbmit-social-facebook">
                                    <a title="Facebook" href="https://www.facebook.com/" target="_blank" rel="noopener">
                                        <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-twitter">
                                    <a title="Twitter" href="https://www.twitter.com/" target="_blank" rel="noopener">
                                        <span><i class="pbmit-base-icon-twitter-2"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-linkedin">
                                    <a title="LinkedIn" href="https://www.linkedin.com/" target="_blank" rel="noopener">
                                        <span><i class="pbmit-base-icon-linkedin-in"></i></span>
                                    </a>
                                </li>
                                <li class="pbmit-social-li pbmit-social-instagram">
                                    <a title="Instagram" href="https://www.instagram.com/" target="_blank"
                                        rel="noopener">
                                        <span><i class="pbmit-base-icon-instagram"></i></span>
                                    </a>
                                </li>
                            </ul>
                        </div>
                    </aside>
                </div>
                <div class="pbmit-footer-widget-col-2 col-md-6 col-lg-3">
                    <div class="widget">
                        <h6 class="widget-title1">Program Packages</h6>
                        <div class="textwidget">
                            <ul>
                                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <li><a href="<?php echo e(route('front.program.show', $p->slug)); ?>"><?php echo e($p->name); ?></a>
                                    </li>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </ul>
                        </div>
                    </div>
                </div>
                <div class="pbmit-footer-widget-col-3 col-md-6 col-lg-3">
                    <div class="widget">
                        <h6 class="widget-title1">Our Services</h6>
                        <div class="pbmit-timelist-wrapper">
                            <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li><a href="<?php echo e(route('front.assessment.show', $fac->slug)); ?>"><?php echo e($fac->title); ?></a>
                                </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    </div>
                </div>
                <div class="pbmit-footer-widget-col-4 col-md-6 col-lg-3">
                    <aside class="widget">
                        <h6 class="widget-title1">Our address</h6>
                        <div class="pbmit-contact-widget-line pbmit-contact-widget-address">
                            <?php echo $identities[0]->address; ?>

                        </div>
                    </aside>
                </div>
            </div>
        </div>
    </div>
    <div class="pbmit-footer-text-area">
        <div class="container">
            <div class="pbmit-footer-text-inner">
                <div class="row">
                    
                </div>
            </div>
        </div>
    </div>
</footer>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/footer.blade.php ENDPATH**/ ?>