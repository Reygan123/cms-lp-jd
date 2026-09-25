


<div class="quixnav">
    <div class="quixnav-scroll">
        <ul class="metismenu" id="menu">
            <li class="nav-label">Navigation</li>
            <li><a href="<?php echo e(route('admin.dashboard.index')); ?>"><i class="mdi mdi-home"></i><span
                        class="nav-text">Home</span></a></li>


            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="mdi mdi-file-document-box"></i><span class="nav-text">Blog & Agenda</span></a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('admin.post.index')); ?>">Posts</a></li>
                    <li><a href="<?php echo e(route('admin.agenda.index')); ?>">Agenda</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i><span
                        class="nav-text">Services</span></a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('admin.service.index')); ?>">Services</a></li>
                    <li><a href="<?php echo e(route('admin.why-service.index')); ?>">Why</a></li>
                    <li><a href="<?php echo e(route('admin.alasan-service.index')); ?>">Alasan</a></li>
                    <li><a href="<?php echo e(route('admin.how-service.index',)); ?>">How</a></li>
                    <li><a href="<?php echo e(route('admin.bonus-service.index')); ?>">Bonus</a></li>
                    <li><a href="<?php echo e(route('admin.masalah-service.index')); ?>">Masalah</a></li>
                    <li><a href="<?php echo e(route('admin.activity.index')); ?>">Activity</a></li>
                    <li><a href="<?php echo e(route('admin.manfaat-service.index')); ?>">Manfaat</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i><span
                        class="nav-text">Features</span></a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('admin.program.index')); ?>">Programs</a></li>
                    <li><a href="<?php echo e(route('admin.unggulan.index')); ?>">Unggulan</a></li>
                    <li><a href="<?php echo e(route('admin.facility.index')); ?>">Assessments</a></li>
                    <li><a href="<?php echo e(route('admin.pricing.index')); ?>">Pricing</a></li>
                    <li><a href="<?php echo e(route('admin.benefit.index')); ?>">Benefits</a></li>
                    <li><a href="<?php echo e(route('admin.testimony.index')); ?>">Testimonies</a></li>
                    <li><a href="<?php echo e(route('admin.portofolio.index')); ?>">Portofolio</a></li>
                    <li><a href="<?php echo e(route('admin.dukungan.index')); ?>">Supports</a></li>
                    <li><a href="<?php echo e(route('admin.faq.index')); ?>">FAQs</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i class="mdi mdi-widgets"></i><span
                        class="nav-text">Profil</span></a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('admin.about.index')); ?>">About Us</a></li>
                    <li><a href="<?php echo e(route('admin.visi.index')); ?>">Visi</a></li>
                    <li><a href="<?php echo e(route('admin.usp.index')); ?>">Usp</a></li>
                    <li><a href="<?php echo e(route('admin.statistik.index')); ?>">Statistik</a></li>
                    <li><a href="<?php echo e(route('admin.ourteam.index')); ?>">Our Teams</a></li>
                    <li><a href="<?php echo e(route('admin.svg.edit', 1)); ?>">Data</a></li>
                    <li><a href="<?php echo e(route('admin.legal.index')); ?>">Legals Document</a></li>
                    <li><a href="<?php echo e(route('admin.partner.index')); ?>">Partners</a></li>
                </ul>
            </li>

            <li><a class="has-arrow" href="javascript:void()" aria-expanded="false"><i
                        class="mdi mdi-power-plug"></i><span class="nav-text">Setting</span></a>
                <ul aria-expanded="false">
                    <li><a href="<?php echo e(route('admin.identity.edit', 1)); ?>">Identity</a></li>
                    <li><a href="<?php echo e(route('admin.header.index')); ?>">Header</a></li>
                    <li><a href="<?php echo e(route('admin.sidebanner.edit', 1)); ?>">Side Banner</a></li>
                    <li><a href="<?php echo e(route('admin.slider.index')); ?>">Slider</a></li>
                    <li><a href="<?php echo e(route('admin.pixel.edit', 1)); ?>">Meta Pixel</a></li>
                    <li><a href="<?php echo e(route('admin.ganalytics.edit', 1)); ?>">Google Analytics</a></li>
                    <li><a href="<?php echo e(route('admin.welcomechat.edit', 1)); ?>">Welcome Chat</a></li>
                    <li><a href="<?php echo e(route('admin.profile.index')); ?>">User</a></li>
                </ul>
            </li>
        </ul>
    </div>
</div>
<?php /**PATH /var/www/cms.jatidiri.app/resources/views/layouts/nav.blade.php ENDPATH**/ ?>