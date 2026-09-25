<section class="section-xl pbminfotech-ele-ptable-style-1">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle blackish-color">My Price</h4>
            <h2 class="pbmit-title">Investasi <?php echo e($program->name); ?></h2>
        </div>
        <div class="pbmit-ptable-cols row">
            <?php $__currentLoopData = $pricings; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $price): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                <div class="pbmit-ptable-col col-lg-4 col-md-6 col-sm-12">
                    <div class="pbmit-pricing-table-box">
                        <div class="pbmit-head-wrap">
                            <div class="pbminfotech-ptable-desc"><?php echo e($program->name); ?></div>
                            <h3 class="pbminfotech-ptable-heading"><?php echo e($price->title); ?></h3>
                            <div class="pbminfotech-sep mt-4"></div>
                            <?php if($price->diskon): ?>
                                <span style="text-decoration: line-through; color: red;">
                                    Rp.<?php echo e(formatRupiah($price->price)); ?>k
                                </span>(Disc. <?php echo e($price->diskon); ?>%)
                                <?php endif; ?>
                            <div class="pbmit-price-wrapper">
                                <div class="pbmit-ptable-icon">
                                    <div class="pbmit-ptable-icon-wrapper"></div>
                                </div>
                                
                                <div class="pbmit-ptable-price-w">
                                    <?php if($price->diskon): ?>
                                        
                                    <div class="pbminfotech-ptable-symbol">Rp</div>
                                    <div class="pbminfotech-ptable-price"><?php echo e(formatRupiah($price->price - $price->price * ($price->diskon / 100))); ?>k</div>
                                    <?php else: ?>
                                    <div class="pbminfotech-ptable-symbol">Rp</div>
                                    <div class="pbminfotech-ptable-price"><?php echo e(formatRupiah($price->price)); ?>k</div>
                                    <?php endif; ?>
                                </div>
                                <div class="pbminfotech-ptable-frequency">/ siswa</div>
                            </div>
                        </div>
                        <div class="pbmit-ptable-inner">
                            <div class="pbmit-ptable-lines-w list-endar">
                                <?php echo $price->description; ?>

                            </div>
                            <div class="pbminfotech-ptable-btn">
                                <div class="pbmit-button">
                                    <a href="<?php echo e($linkdaftars[0]->link); ?>">
                                        <span class="pbmit-button-text"><?php echo e($linkdaftars[0]->linktext); ?></span>
                                        <span class="pbmit-button-icon-wrapper">
                                            <span class="pbmit-button-icon">
                                                <i class="pbmit-base-icon-black-arrow-1"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-feature-wrap"></div>
                    </div>
                </div>
            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
        </div>
    </div>
</section>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/program/pricing.blade.php ENDPATH**/ ?>