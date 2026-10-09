<aside class="service-sidebar">
    <aside class="widget post-list">
        <h2 class="widget-title">Our Service</h2>
        <div class="all-post-list">
            <ul>
                <?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $program): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li><a href="<?php echo e(route('front.program.show', $program->slug)); ?>"> <?php echo e($program->name); ?> </a></li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <li
                        class="post-<?php echo e(url()->current() == route('front.assessment.show', $facility->slug) ? 'active' : ''); ?>">
                        <a href="<?php echo e(route('front.assessment.show', $facility->slug)); ?>"> <?php echo e(e($facility->title)); ?> </a>
                    </li>
                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>



            </ul>
        </div>
    </aside>
    <aside class="widget pbmit-service-ad">
        <div class="textwidget">
            <div class="pbmit-service-ads">
                <h5 class="pbmit-ads-subheding">Our Newsletter</h5>
                <h4 class="pbmit-ads-subtitle">Ready to check?</h4>
                <h3 class="pbmit-ads-title">Sign up now!</h3>
                <div class="pbmit-ads-desc">
                    <i class="pbmit-base-icon-phone-call-1 text-white"></i><a class="text-white" href="tel:+62<?php echo e($identities[0]->phone); ?>">+62-<?php echo e(str_replace('+62', '0', substr($identities[0]->phone, 0, 3))); ?>-
                        <?php echo e(substr($identities[0]->phone, 3, 4)); ?>-
                        <?php echo e(substr($identities[0]->phone, 7)); ?></a>
                </div>
                <a class="pbmit-btn" href="<?php echo e($linkdaftars[0]->link); ?>">
                    <span class="pbmit-button-content-wrapper">
                        <span class="pbmit-button-icon pbmit-align-icon-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.76" height="22.76"
                                viewBox="0 0 22.76 22.76">
                                <title>black-arrow</title>
                                <path
                                    d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1"
                                    transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2">
                                </path>
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
    </aside>
    
</aside>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/assessment/side.blade.php ENDPATH**/ ?>