<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <?php $__currentLoopData = $identities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $q): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
    <link rel="shortcut icon" type="image/jpg" href="<?php echo e(asset('storage/identities/'.$q->favicon)); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title); ?> - <?php echo e($q->name); ?></title>
    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
    <!-- css -->


    
    <link rel="stylesheet" href="<?php echo e(asset('admin/vendor/dropify/dist/css/dropify.min.css')); ?>">
    <link href="<?php echo e(asset('admin/vendor/jqvmap/css/jqvmap.min.css')); ?>" rel="stylesheet">
    <link rel="stylesheet" href="<?php echo e(asset('admin/vendor/bootstrap-daterangepicker/daterangepicker.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('admin/vendor/jquery-steps/css/jquery.steps.css')); ?>">

    <link rel="stylesheet" type="text/css" href="<?php echo e(asset('assets/css/font-icons.min.css')); ?>">
    <link href="<?php echo e(asset('admin/css/style.css')); ?>" rel="stylesheet">
    <link href="<?php echo e(asset('admin/css/endar.css')); ?>" rel="stylesheet">

    

    <!-- js -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/gh/alpinejs/alpine@v2.8.1/dist/alpine.min.js" defer></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.ckeditor.com/ckeditor5/37.0.1/classic/ckeditor.js"></script>
    <!-- <script src="https://cdn.ckeditor.com/ckeditor5/super-build/latest/ckeditor.js"></script> -->
</head>

<body>
    <div id="preloader">
        <div class="spinner">
            <div class="spinner-a"></div>
            <div class="spinner-b"></div>
        </div>
    </div>

    <div id="main-wrapper">
        <div class="nav-header">
            <a href="<?php echo e(route('home')); ?>" class="brand-logo">
                <span class="logo-abbr"><?php echo e(asset('storage/identities/' . $identities[0]->favicon)); ?></span>
                <span class="logo-compact"><img src="<?php echo e(asset('storage/identities/' .$identities[0]->logo)); ?>"
                        alt="<?php echo e($identities[0]->name); ?>" class="logo"></span>
                <span class="brand-title"><img src="<?php echo e(asset('storage/identities/' .$identities[0]->logo)); ?>"
                        alt="<?php echo e($identities[0]->name); ?>"></span>
            </a>

            <div class="nav-control wave-effect wave-effect-x">
                <div class="hamburger">
                    <span class="toggle-icon"><i class="icon-menu"></i></span>
                </div>
            </div>
        </div>

        <?php echo $__env->make('layouts.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <?php echo $__env->make('layouts.nav', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
        <div class="content-body">
            <?php echo $__env->yieldContent('content'); ?>
        </div>
        <?php echo $__env->make('layouts.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>



    </div>

    

    
    

    <script src="<?php echo e(asset('vendor/fontawesome/all.min.js')); ?>"></script>

    <!-- Required vendors -->
    <script src="<?php echo e(asset('admin/vendor/jquery/jquery.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/vendor/bootstrap/dist/js/bootstrap.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/vendor/jquery-slimscroll/jquery.slimscroll.min.js')); ?>"></script>
    <!-- Here is navigation script -->
    <script src="<?php echo e(asset('admin/vendor/quixnav/quixnav.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/quixnav-init.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/custom.min.js')); ?>"></script>
    <!--removeIf(production)-->
    <!-- Demo scripts -->
    <script src="<?php echo e(asset('admin/js/styleSwitcher.js')); ?>"></script>
    <!--endRemoveIf(production)-->


    <!-- Daterange picker library -->
    <script src="<?php echo e(asset('admin/vendor/moment/moment.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/vendor/bootstrap-daterangepicker/daterangepicker.js')); ?>"></script>


    <!-- Vectormap -->
    <script src="<?php echo e(asset('admin/vendor/jqvmap/js/jquery.vmap.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/vendor/jqvmap/js/jquery.vmap.world.js')); ?>"></script>

    <!-- Dropify -->
    <script src="<?php echo e(asset('admin/vendor/dropify/dist/js/dropify.min.js')); ?>"></script>
    <!-- Dropify init -->
    <script src="<?php echo e(asset('admin/js/plugins-init/dropify-init.js')); ?>"></script>

    <!-- daterangepicker init -->
    <!-- <script src="./js/plugins-init/card-headerdatepicker-init.js"></script> -->


    <script src="<?php echo e(asset('admin/vendor/chart.js/Chart.bundle.min.js')); ?>"></script>
    <script src="<?php echo e(asset('admin/js/dashboard/dashboard-1.js')); ?>"></script>

    <script src="<?php echo e(asset('assets/js/custom.js')); ?>"></script>

    

    <script>
        <?php if(session()->has('success')): ?>

        Swal.fire({
            icon: 'success',
            title: 'BERHASIL!',
            text: '<?php echo e(session('success')); ?>',
            showConfirmButton: false,
            timer: 3000
        })

        <?php elseif(session()->has('error')): ?>

        Swal.fire({
            icon: 'error',
            text: 'GAGAL!',
            title: '<?php echo e(session('error')); ?>',
            showConfirmButton: false,
            timer: 3000
        })

        <?php endif; ?>
    </script>
</body>
</html><?php /**PATH /var/www/cms.jatidiri.app/resources/views/layouts/app.blade.php ENDPATH**/ ?>