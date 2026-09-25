<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.component.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="section-lgx pbmit-blog-column-three">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 blog-right-col">
                <div class="row pbmit-element-posts-wrapper">
                    <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $a): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <article class="pbmit-blog-style-1 col-md-6">
                        <div class="post-item">
                            <div class="pbminfotech-box-content">
                                <div class="pbmit-featured-container">
                                    <div class="pbmit-featured-img-wrapper">
                                        <div class="pbmit-featured-wrapper">
                                            <img src="<?php echo e(asset('/storage/posts/'.$a->image)); ?>" class="img-fluid" alt="<?php echo e($a->title); ?>">
                                        </div>
                                    </div>
                                    <a class="pbmit-blog-btn" href="<?php echo e(route('post.post.show',$a->slug)); ?>">
                                        <span class="pbmit-button-icon-wrapper">
                                            <span class="pbmit-button-icon">
                                                <i class="pbmit-base-icon-black-arrow-1"></i>
                                            </span>
                                        </span>
                                    </a>
                                    <div class="pbmit-meta-cat-wrapper pbmit-meta-line">
                                        <div class="pbmit-meta-category">
                                            <a href="<?php echo e(route('post.post.index',['category'=>$a->category->slug])); ?>"
                                                rel="category tag"><?php echo e($a->category->name); ?></a>
                                        </div>
                                    </div>
                                    <a class="pbmit-link" href="<?php echo e(route('post.post.show',$a->slug)); ?>"></a>
                                </div>
                                <div class="pbmit-category-date-wraper d-flex align-items-center">
                                    <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                                        <div class="pbmit-meta-date">
                                            <span class="pbmit-post-date">
                                                <i
                                                    class="pbmit-base-icon-calendar-3"></i><?php echo e(date('d M Y', strtotime($a->pub_date))); ?>

                                            </span>
                                        </div>
                                    </div>
                                    <div class="pbmit-meta-author pbmit-meta-line">
                                        <span class="pbmit-post-author">
                                            <i class="pbmit-base-icon-user-3"></i><?php echo e($a->user->name); ?>

                                        </span>
                                    </div>
                                </div>
                                <div class="pbmit-content-wrapper">
                                    <h3 class="pbmit-post-title">
                                        <a href="<?php echo e(route('post.post.show',$a->slug)); ?>"><?php echo e($a->title); ?></a>
                                    </h3>
                                </div>
                            </div>
                        </div>
                    </article>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

                </div>
                <nav aria-label="Page navigation">
                    <ul class="pagination justify-content-center">
                        <?php echo e($posts->links()); ?>

                    </ul>
                </nav>
            </div>
            <div class="col-lg-3 blog-left-col">
                <aside class="sidebar">
                    <aside class="widget widget-search">
                        <h2 class="widget-title">Search</h2>
                        <form class="search-form">
                            <input type="search" name="q" value="<?php echo e(request()->query('q')); ?>"
                                placeholder="Key Words here" required="">
                            <i class="fa fa-search"></i>
                            <button type="submit" class="search-submit"></button>
                        </form>
                    </aside>
                    <aside class="widget widget-categories">
                        <h2 class="widget-title">Categories</h2>
                        <ul>
                           <li>
                           <span class="pbmit-cat-li">
                                    <a href="<?php echo e(route('post.post.index')); ?>">All</a>
                                </span>
                           </li>
                           <?php $__currentLoopData = $categories; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $category): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li>
                                <span class="pbmit-cat-li">
                                    <a href="<?php echo e(route('post.post.index',['category'=>$category->slug])); ?>"><?php echo e($category->name); ?></a>
                                </span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </aside>
                    <aside class="widget widget-recent-post">
                        <h2 class="widget-title">Agenda Terdekat </h2>
                        <ul class="recent-post-list">
                            <?php $__currentLoopData = $agendas; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $agenda): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="<?php echo e(route('agenda.agenda.show',$agenda->slug)); ?>">
                                    <img src="<?php echo e(asset('storage/agendas/'.$agenda->image)); ?>" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="<?php echo e(route('agenda.agenda.show',$agenda->slug)); ?>"><?php echo e(date('d M Y', strtotime($agenda->start_date))); ?></a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="<?php echo e(route('agenda.agenda.show',$agenda->slug)); ?>"><?php echo e($agenda->title); ?></a>
                                    </span>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </aside>
                    <div class="mt-4">
                        <?php echo $__env->make('front.component.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                </aside>
            </div>
        </div>
    </div>
</section>



<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontapp', ['title' => 'Berita Terkini'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/fpost/index.blade.php ENDPATH**/ ?>