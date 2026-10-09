<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.component.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
<section class="section-lgx pbmit-sortable-yes pbmit-blog-column-three">
    <div class="container">
        <div class="pbmit-sortable-list">
            <ul class="pbmit-sortable-list-ul">
               <li><a href="#" class="pbmit-sortable-link pbmit-selected" data-sortby="*">All</a></li>
               <li><a href="#3" class="pbmit-sortable-link" data-sortby="3">Psikolog</a></li>
               <li><a href="#4" class="pbmit-sortable-link" data-sortby="4">Konselor</a></li>
               <li><a href="#5" class="pbmit-sortable-link" data-sortby="5">Peer Counselor</a></li>
            </ul>
        </div>
        <div class="pbmit-element-posts-wrapper row multi-columns-row">
            <?php $__currentLoopData = $ourteams; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ot): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
            <article class="pbmit-team-style-1 col-md-6 col-lg-3 <?php echo e($ot->ot_id); ?>">
                <div class="pbminfotech-post-item">
                    <div class="pbmit-featured-wrap">
                        <div class="pbmit-featured-img-wrapper">
                            <div class="pbmit-featured-wrapper">
                                <img src="<?php echo e(asset('storage/ourteams/'.$ot->image)); ?>" class="img-fluid" alt="">
                            </div>
                        </div>
                        <div class="pbmit-team-btn">
                            <a class="pbmit-team-text" href="#">
                                <i class="pbmit-base-icon-share-1"></i>
                            </a>
                            <div class="pbminfotech-box-social-links">
                                <ul class="pbmit-social-links pbmit-team-social-links">
                                    <li class="pbmit-social-li pbmit-social-facebook">
                                        <a href="https://www.facebook.com/<?php echo e(strip_tags($ot->fb)); ?>" title="Facebook" target="_blank">
                                            <span><i class="pbmit-base-icon-facebook-f"></i></span>
                                        </a>
                                    </li>
                                    
                                    <li class="pbmit-social-li pbmit-social-instagram">
                                        <a href="https://www.instagram.com/<?php echo e(strip_tags($ot->ig)); ?>" title="Instagram" target="_blank">
                                            <span><i class="pbmit-base-icon-instagram"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-youtube">
                                        <a href="https://www.youtube.com/<?php echo e(strip_tags($ot->yt)); ?>" title="Youtube" target="_blank">
                                            <span><i class="pbmit-base-icon-youtube-play"></i></span>
                                        </a>
                                    </li>
                                    <li class="pbmit-social-li pbmit-social-twitter">
                                        <a href="https://www.tiktok.com/<?php echo e(strip_tags($ot->tt)); ?>" title="Tiktok" target="_blank">
                                            <span><i class="fa-brands fa-tiktok"></i></span>
                                        </a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                    <div class="pbminfotech-box-content">
                        <div class="pbminfotech-box-content-inner">
                            <div class="pbminfotech-box-team-position"><?php echo e(strip_tags($ot->title)); ?></div>
                            <h3 class="pbmit-team-title">
                                <a href=""><?php echo e(strip_tags($ot->name)); ?></a>
                            </h3>
                        </div>
                    </div>
                </div>
            </article>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.frontapp', ['title' => 'Our Psychologist & Counselor'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/ourteam/index.blade.php ENDPATH**/ ?>