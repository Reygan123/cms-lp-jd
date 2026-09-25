<section class="section-xl pbmit-bg-color-global pbmit-extend-animation tab_section">
				<div class="container">
					<div class="pbmit-heading-subheading text-white text-center">
						<h4 class="pbmit-subtitle">our Services</h4>
						<h2 class="pbmit-title">Layanan <?php echo e($identities[0]->name); ?></h2>
					</div>
					<div class="pbmit-tab">
						<ul class="nav nav-tabs" role="tablist">
                            <?php $__currentLoopData = $programhome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link <?php echo e($loop->first ? 'active' : ''); ?>" data-bs-toggle="tab" href="#tab-<?php echo e($loop->index + 1); ?>" aria-selected="<?php echo e($loop->first ? 'true' : 'false'); ?>" role="tab"> 
                                        <span><?php echo e($ph->name); ?></span>
                                    </a>	
                                </li>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
						</ul>
						<div class="tab-content">
                            <?php $__currentLoopData = $programhome; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $ph): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="tab-pane <?php echo e($loop->first ? 'show active' : ''); ?>" id="tab-<?php echo e($loop->index + 1); ?>" role="tabpanel">
                                    <div class="pbmit-column-inner">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-12 col-xl-6 pbmit-tab-img">
                                                <img src="<?php echo e(asset('storage/programs/' . $ph->image1)); ?>" class="img-fluid" alt="">
                                            </div>
                                            <div class="col-md-12 col-xl-6 pbmit-tab-list">
                                                <h2><?php echo e($ph->name); ?></h2>	
                                                <div><?php echo $ph->description1; ?></div>
                                                <ul class="list-group list-group-borderless">
                                                    <?php $__currentLoopData = $ph->facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $facility): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                                    <a href="<?php echo e(route('front.assessment.show', $facility->slug)); ?>">
                                                    <li class="list-group-item">
                                                        
                                                            <span class="pbmit-icon-list-icon">
                                                                <i aria-hidden="true" class="ti-check"></i>
                                                            </span>
                                                            <span class="pbmit-icon-list-text"><?php echo e($facility->title); ?></span>
                                                        
                                                        
                                                    </li>
                                                </a>
                                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
							
						</div>
					</div>
				</div>
			</section><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/frontpage/services.blade.php ENDPATH**/ ?>