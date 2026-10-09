<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <link rel="shortcut icon" type="image/jpg" href="<?php echo e(asset('storage/identities/' . $identities[0]->favicon)); ?>" />
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <title><?php echo e($title); ?> - <?php echo e($identities[0]->name); ?></title>
    <meta name="description" content="<?php echo e($title); ?> : <?php echo strip_tags($identities[0]->description); ?>">


    <link rel='stylesheet'
        href='https://fonts.googleapis.com/css?family=Spartan%3A400%2C500%2C600%2C700%2C800%2C900%7CInter%3A300%2C400%2C500%2C600%2C700%2C800%2C900&amp;subset=latin%2Clatin-ext'
        type='text/css' media='all' />
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/bootstrap.min.css')); ?>">
    <!-- Fontawesome -->
    <link rel="stylesheet" href="<?php echo e(asset('vendor/fontawesome/all.min.css')); ?>">
    <!-- Flaticon -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/flaticon.css')); ?>">
    <!-- Base Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/pbminfotech-base-icons.css')); ?>">
    <!-- Themify Icons -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/themify-icons.css')); ?>">
    <!-- Slick -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/swiper.min.css')); ?>">
    <!-- Magnific -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/magnific-popup.css')); ?>">
    <!-- AOS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/aos.css')); ?>">
    <!-- Shortcode CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/shortcode.css')); ?>">
    <!-- Base CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/base.css')); ?>">
    <!-- Demo Base CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/demo-1.css')); ?>">
    <!-- Style CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/style.css')); ?>">
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/endar.css')); ?>">
    <!-- Responsive CSS -->
    <link rel="stylesheet" href="<?php echo e(asset('assets/css/responsive.css')); ?>">


    <?php echo $pixels[0]->pixel_code; ?>

    <?php echo $ganalytics[0]->ganalytics_code; ?>

</head>

<body>
    <div class="page-wrapper">
        <header class="site-header header-style-1">
            <?php echo $__env->make('front.component.header', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>
            
        <div class="page-content">
            <?php echo $__env->yieldContent('content'); ?>

        </div>
        <?php echo $__env->make('front.component.footer', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

    </div>
    <!-- Search Box Start Here -->
    <div class="pbmit-search-overlay">
        <div class="pbmit-icon-close">
            <svg class="qodef-svg--close qodef-m" xmlns="http://www.w3.org/2000/svg" width="28.163" height="28.163"
                viewBox="0 0 26.163 26.163">
                <rect width="36" height="1" transform="translate(0.707) rotate(45)"></rect>
                <rect width="36" height="1" transform="translate(0 25.456) rotate(-45)"></rect>
            </svg>
        </div>
        <div class="pbmit-search-outer">
            <form class="pbmit-site-searchform">
                <input type="search" class="form-control field searchform-s" name="s" placeholder="Search …">
                <button type="submit"></button>
            </form>
        </div>
    </div>
    <!-- Search Box End Here -->

    

    <!-- Scroll To Top -->
    <div class="pbmit-progress-wrap">
        <svg class="pbmit-progress-circle svg-content" width="100%" height="100%" viewBox="-1 -1 102 102">
            <path d="M50,1 a49,49 0 0,1 0,98 a49,49 0 0,1 0,-98"></path>
        </svg>
    </div>
    <!-- Scroll To Top End -->

    <script src="<?php echo e(asset('assets/js/jquery.min.js')); ?>"></script>
    <!-- Popper JS -->
    <script src="<?php echo e(asset('assets/js/popper.min.js')); ?>"></script>
    <!-- Bootstrap JS -->
    <script src="<?php echo e(asset('assets/js/bootstrap.min.js')); ?>"></script>
    <!-- jquery Waypoints JS -->
    <script src="<?php echo e(asset('assets/js/jquery.waypoints.min.js')); ?>"></script>
    <!-- jquery Appear JS -->
    <script src="<?php echo e(asset('assets/js/jquery.appear.js')); ?>"></script>
    <!-- Numinate JS -->
    <script src="<?php echo e(asset('assets/js/numinate.min.js')); ?>"></script>
    <!-- Slick JS -->
    <script src="<?php echo e(asset('assets/js/swiper.min.js')); ?>"></script>
    <!-- Magnific JS -->
    <script src="<?php echo e(asset('assets/js/jquery.magnific-popup.min.js')); ?>"></script>
    <!-- Circle Progress JS -->
    <script src="<?php echo e(asset('assets/js/circle-progress.js')); ?>"></script>
    <!-- countdown JS -->
    <script src="<?php echo e(asset('assets/js/jquery.countdown.min.js')); ?>"></script>
    <!-- AOS -->
    <script src="<?php echo e(asset('assets/js/aos.js')); ?>"></script>
    <!-- GSAP -->
    <script src='<?php echo e(asset('assets/js/gsap.js')); ?>'></script>
    <!-- Scroll Trigger -->
    <script src='<?php echo e(asset('assets/js/ScrollTrigger.js')); ?>'></script>
    <!-- Split Text -->
    <script src='<?php echo e(asset('assets/js/SplitText.js')); ?>'></script>
    <!-- Magnetic -->
    <script src='<?php echo e(asset('assets/js/magnetic.js')); ?>'></script>
    <!-- GSAP Animation -->
    <script src='<?php echo e(asset('assets/js/gsap-animation.js')); ?>'></script>
    <!-- Scripts JS -->
    <script src="<?php echo e(asset('assets/js/scripts.js')); ?>"></script>
    <script src="<?php echo e(asset('assets/js/endar.js')); ?>"></script>
    
    <script src="<?php echo e(asset('vendor/fontawesome/all.min.js')); ?>"></script>
    
    <script>
        (function() {
            function c() {
                var b = a.contentDocument || a.contentWindow.document;
                if (b) {
                    var d = b.createElement('script');
                    d.innerHTML =
                        "window.__CF$cv$params={r:'90afd7b2abcf0fa6',t:'MTczODM5MDkwMC4wMDAwMDA='};var a=document.createElement('script');a.nonce='';a.src='../cdn-cgi/challenge-platform/h/b/scripts/jsd/6682e961b853/maind41d.js';document.getElementsByTagName('head')[0].appendChild(a);";
                    b.getElementsByTagName('head')[0].appendChild(d)
                }
            }
            if (document.body) {
                var a = document.createElement('iframe');
                a.height = 1;
                a.width = 1;
                a.style.position = 'absolute';
                a.style.top = 0;
                a.style.left = 0;
                a.style.border = 'none';
                a.style.visibility = 'hidden';
                document.body.appendChild(a);
                if ('loading' !== document.readyState) c();
                else if (window.addEventListener) document.addEventListener('DOMContentLoaded', c);
                else {
                    var e = document.onreadystatechange || function() {};
                    document.onreadystatechange = function(b) {
                        e(b);
                        'loading' !== document.readyState && (document.onreadystatechange = e, c())
                    }
                }
            }
        })();
    </script>
    <script defer src="https://static.cloudflareinsights.com/beacon.min.js/vcd15cbe7772f49c399c6a5babf22c1241717689176015"
        integrity="sha512-ZpsOmlRQV6y907TI0dKBHq9Md29nnaEIPlkf84rnaERnq6zvWvPUqr2ft8M1aS28oN72PdrCzSjY4U6VaAw1EQ=="
        data-cf-beacon='{"rayId":"90afd7b2abcf0fa6","version":"2025.1.0","serverTiming":{"name":{"cfExtPri":true,"cfL4":true,"cfSpeedBrain":true,"cfCacheStatus":true}},"token":"125856bf84ab44059737e93b01aa0fef","b":1}'
        crossorigin="anonymous"></script>

</body>

</html>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/layouts/frontapp.blade.php ENDPATH**/ ?>