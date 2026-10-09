<div class="pbmit-header-overlay">
    <div class="container-fluid">
        <div class="pbmit-header-content d-flex justify-content-between align-items-center">
            <div class="site-branding">
                <h1 class="site-title">
                    <a href="<?php echo e(route('home')); ?>">
                        <img class="logo-img" src="<?php echo e(asset('storage/identities/' . $identities[0]->logo)); ?>"
                            alt="<?php echo e($identities[0]->name); ?>">
                    </a>
                </h1>
            </div>
            <div class="site-navigation">
                <nav class="main-menu navbar-expand-xl navbar-light">
                    <div class="navbar-header">
                        <!-- Toggle Button -->
                        <button class="navbar-toggler" type="button">
                            <i class="pbmit-base-icon-menu-1"></i>
                        </button>
                    </div>
                    <div class="pbmit-mobile-menu-bg"></div>
                    <div class="collapse navbar-collapse clearfix show" id="pbmit-menu">
                        <div class="pbmit-menu-wrap">
                            <span class="closepanel">
                                <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="20.163"
                                    height="20.163" viewBox="0 0 26.163 26.163">
                                    <rect width="36" height="1" transform="translate(0.707) rotate(45)">
                                    </rect>
                                    <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)">
                                    </rect>
                                </svg>
                            </span>
                            <ul class="navigation clearfix">
                                <li class="dropdown active">
                                    <a href="<?php echo e(route('home')); ?>">Home</a>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Profile</a>
                                    <ul>
                                        <li><a href="<?php echo e(route('home')); ?>/about-us">About Us</a></li>
                                        
                                        <li><a href="<?php echo e(route('home')); ?>/ourteam">Our Team</a></li>
                                        <li><a href="<?php echo e(route('home')); ?>/member">Join Us</a></li>
                                    </ul>
                                </li>
                                <li class="dropdown">
                                    <a href="#">Services</a>
                                    <ul>
                                        <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a
                                                    href="<?php echo e(route('front.program.show', $p->slug)); ?>"><?php echo e($p->name); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                        <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $fac): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                            <li><a
                                                    href="<?php echo e(route('front.assessment.show', $fac->slug)); ?>"><?php echo e($fac->title); ?></a>
                                            </li>
                                        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                    </ul>
                                </li>
                                
                                <li class="dropdown">
                                    <a href="#">Blog & Events</a>
                                    <ul>
                                        <li><a href="<?php echo e(route('home')); ?>/post">Blog</a></li>
                                        <li><a href="<?php echo e(route('home')); ?>/agenda">Events</a></li>
                                    </ul>
                                </li>
                                <li><a href="<?php echo e(route('home')); ?>/contact">Contact Us</a></li>
                            </ul>
                        </div>
                    </div>
                </nav>
            </div>
            <div class="pbmit-right-box d-flex align-items-center">
                <div class="pbmit-button-box">
                    <div class="pbmit-header-button">
                        <a href="tel:+62<?php echo e($identities[0]->phone); ?>">
                            <span class="pbmit-header-button-text-1">+62
                                <?php echo e(str_replace('+62', '0', substr($identities[0]->phone, 0, 3))); ?>-
                                <?php echo e(substr($identities[0]->phone, 3, 4)); ?>-
                                <?php echo e(substr($identities[0]->phone, 7)); ?></span>
                            <span class="pbmit-header-button-text-2">+62
                                <?php echo e(str_replace('+62', '0', substr($identities[0]->phone, 0, 3))); ?>-
                                <?php echo e(substr($identities[0]->phone, 3, 4)); ?>-
                                <?php echo e(substr($identities[0]->phone, 7)); ?></span>
                        </a>
                    </div>
                </div>
                <div class="pbmit-header-search-btn">
                    <a href="#" title="Search">
                        <i class="pbmit-base-icon-search-1"></i>
                    </a>
                </div>
                <div class="pbmit-button-box-second">
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
                    <div class="pbmit-sticky-corner  pbmit-top-left-corner">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill=""
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M30 30V0C30 16 16 30 0 30H30Z" fill="red"></path>
                        </svg>
                    </div>
                    <div class="pbmit-sticky-corner pbmit-bottom-right-corner">
                        <svg width="30" height="30" viewBox="0 0 30 30" fill="none"
                            xmlns="http://www.w3.org/2000/svg">
                            <path d="M30 30V0C30 16 16 30 0 30H30Z" fill="red"></path>
                        </svg>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/component/header.blade.php ENDPATH**/ ?>