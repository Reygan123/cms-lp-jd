<div class="pbmit-title-bar-wrapper mt-4" style="background-image: url(<?php echo e(asset('storage/headers/' . e($headers[0]->image))); ?>)">
    <div class="container">
        <div class="pbmit-title-bar-content">
            <div class="pbmit-title-bar-content-inner bottom-10">
                <div class="pbmit-tbar mt-5">
                    <div class="pbmit-tbar-inner container">
                        <h1 class="pbmit-tbar-title"> <?php echo e(e($facility->title)); ?></h1>
                    </div>
                </div>
                <div class="pbmit-breadcrumb">
                    <div class="pbmit-breadcrumb-inner">
                        <span>
                            <a title="" href="<?php echo e(route('home')); ?>" class="home"><span><?php echo e(e($identities[0]->name)); ?></span></a>
                        </span>
                        <span class="sep">
                            <i class="pbmit-base-icon-angle-double-right"></i>
                        </span>
                        <span><span class="post-root post post-post current-item"> <?php echo e(e($facility->title)); ?></span></span>
                    </div>
                </div>
            </div>
        </div> 
    </div> 
</div><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/assessment/title.blade.php ENDPATH**/ ?>