

<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.component.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<section class="site_content blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 blog-right-col">
                <div class="row">
                    <div class="col-md-12">
                        <article>
                            <div class="post blog-classic">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper">
                                        <img src="<?php echo e(asset('/storage/posts/'.$post->image)); ?>" class="img-fluid" alt="">
                                    </div>
                                    <span class="pbmit-meta pbmit-meta-cat">
                                        <a href="<?php echo e(route('post.post.index',['category'=>$post->category->slug])); ?>"
                                            rel="category tag"><?php echo e($post->category->name); ?></a>
                                    </span>
                                </div>
                                <div class="pbmit-blog-classic-inner">
                                    <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                        <span class="pbmit-meta pbmit-meta-date">
                                            <i class="pbmit-base-icon-calendar-3"></i>
                                            <time class="entry-date published"
                                                datetime="2023-08-29T09:05:54+00:00"><?php echo e(date('d M Y', strtotime($post->pub_date))); ?></time>
                                        </span>
                                        <span class="pbmit-meta pbmit-meta-author">
                                            <i class="pbmit-base-icon-user-3"></i>by
                                            <a class="pbmit-author-link"
                                                href="blog-details.html"><?php echo e($post->user->name); ?></a>
                                        </span>
                                    </div>
                                    <div class="pbmit-entry-content">
                                        <h2 class="pbmit-post-title"><?php echo e($post->title); ?></h2>
                                        <div class="list-endar"><?php echo $post->content; ?></p>
                                        </div>
                                    </div>
                                    <nav class="navigation post-navigation" aria-label="Posts">
                                        <div class="nav-links">
                                            <div class="nav-previous">
                                                <?php if($previousPost): ?>
                                                <a href="<?php echo e(route('post.post.show', $previousPost->slug)); ?>" rel="prev">
                                                    <span class="pbmit-post-nav-icon">
                                                        <i class="pbmit-base-icon-left-arrow-1"></i>
                                                        <span class="pbmit-post-nav-head">Previous Post</span>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title"><?php echo e($previousPost->title); ?></span>
                                                    </span>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                            <div class="nav-next">
                                                <?php if($nextPost): ?>
                                                <a href="<?php echo e(route('post.post.show', $nextPost->slug)); ?>" rel="next">
                                                    <span class="pbmit-post-nav-icon">
                                                        <span class="pbmit-post-nav-head">Next Post</span>
                                                        <i class="pbmit-base-icon-next"></i>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title"><?php echo e($nextPost->title); ?></span>
                                                    </span>
                                                </a>
                                                <?php endif; ?>
                                            </div>
                                        </div>
                                    </nav>
                        </article>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 blog-left-col">
                <aside class="sidebar">
                    <div class="mb-5">
                        <?php echo $__env->make('front.component.banner', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
                    </div>
                    <aside class="widget widget-recent-post">
                        <h2 class="widget-title">Blog Terkini </h2>
                        <ul class="recent-post-list">
                            <?php $__currentLoopData = $posts; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="<?php echo e(route('post.post.show',$p->slug)); ?>">
                                    <img src="<?php echo e(asset('storage/posts/'.$p->image)); ?>" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="<?php echo e(route('post.post.show',$p->slug)); ?>"><?php echo e(date('d M Y', strtotime($p->pub_date))); ?></a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="<?php echo e(route('post.post.show',$p->slug)); ?>"><?php echo e($p->title); ?></a>
                                    </span>
                                </div>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
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
                                    <a
                                        href="<?php echo e(route('post.post.index',['category'=>$category->slug])); ?>"><?php echo e($category->name); ?></a>
                                </span>
                            </li>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </ul>
                    </aside>


                    <aside class="widget widget-recent-post mt-4">
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
            </div>
        </div>
    </div>
</section>


<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontapp', ['title' => $post->title], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/fpost/show.blade.php ENDPATH**/ ?>