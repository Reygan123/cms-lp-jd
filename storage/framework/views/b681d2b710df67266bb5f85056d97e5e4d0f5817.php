<?php $__env->startSection('content'); ?>
<?php echo $__env->make('front.component.breadcrumb', \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?>

<div class="page-content contact_us">  

			<!-- Ihbox -->
			<section class="section-xl">
				<div class="container">
					<div class="row">
						<div class="col-md-6 col-xl-4">
							<div class="pbmit-ihbox-style-15">
								<div class="pbmit-ihbox-box">
									<div class="pbmit-icon-wrap d-flex align-items-center">
										<div class="pbmit-ihbox-icon">
											<div class="pbmit-ihbox-icon-wrapper">
												<div class="pbmit-icon-wrapper pbmit-icon-type-icon">
													<i class="pbmit-xcare-icon pbmit-xcare-icon-email"></i>
												</div>
											</div>
										</div>
									</div>
									<h2 class="pbmit-element-title">Mail us 24/7</h2>
									<div class="pbmit-content-wrapper">
										<div class="pbmit-heading-desc"><a href="mailto:<?php echo e($identities[0]->email); ?>" class="__cf_email__" data-cfemail="abc5c486d9cedbc7d2ebdbc9c6c2c5cdc485c8c4c6"><?php echo e($identities[0]->email); ?></a> </div>
									</div>
								</div>
								<div class="pbmit-ihbox-btn">
									<a href="#">
										<span class="pbmit-button-text">Read More</span>
										<span class="pbmit-button-icon-wrapper">
											<span class="pbmit-button-icon">
												<i class="pbmit-base-icon-black-arrow-1"></i>
											</span>
										</span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-6 col-xl-4">
							<div class="pbmit-ihbox-style-15">
								<div class="pbmit-ihbox-box">
									<div class="pbmit-icon-wrap d-flex align-items-center">
										<div class="pbmit-ihbox-icon">
											<div class="pbmit-ihbox-icon-wrapper">
												<div class="pbmit-icon-wrapper pbmit-icon-type-icon">
													<i class="pbmit-xcare-icon pbmit-xcare-icon-phone-call"></i>
												</div>
											</div>
										</div>
									</div>
									<h2 class="pbmit-element-title">Call us</h2>
									<div class="pbmit-content-wrapper">
										<div class="pbmit-heading-desc"><a href="tel:+62<?php echo e($identities[0]->phone); ?>">+62
											<?php echo e(str_replace('+62', '0', substr($identities[0]->phone, 0, 3))); ?>-
											<?php echo e(substr($identities[0]->phone, 3, 4)); ?>-
											<?php echo e(substr($identities[0]->phone, 7)); ?></a> 
										</div>
									</div>
								</div>
								<div class="pbmit-ihbox-btn">
									<a href="#">
										<span class="pbmit-button-text">Read More</span>
										<span class="pbmit-button-icon-wrapper">
											<span class="pbmit-button-icon">
												<i class="pbmit-base-icon-black-arrow-1"></i>
											</span>
										</span>
									</a>
								</div>
							</div>
						</div>
						<div class="col-md-12 col-xl-4">
							<div class="pbmit-ihbox-style-15">
								<div class="pbmit-ihbox-box">
									<div class="pbmit-icon-wrap d-flex align-items-center">
										<div class="pbmit-ihbox-icon">
											<div class="pbmit-ihbox-icon-wrapper">
												<div class="pbmit-icon-wrapper pbmit-icon-type-icon">
													<i class="pbmit-xcare-icon pbmit-xcare-icon-placeholder"></i>
												</div>
											</div>
										</div>
									</div>
									<h2 class="pbmit-element-title">Our Locations</h2>
									<div class="pbmit-content-wrapper">
										<div class="pbmit-heading-desc"><?php echo $identities[0]->address; ?></div>
									</div>
								</div>
								<div class="pbmit-ihbox-btn">
									<a href="#">
										<span class="pbmit-button-text">Read More</span>
										<span class="pbmit-button-icon-wrapper">
											<span class="pbmit-button-icon">
												<i class="pbmit-base-icon-black-arrow-1"></i>
											</span>
										</span>
									</a>
								</div>
							</div>
						</div>
					</div>
				</div>
			</section>
			<!-- Ihbox End -->

			<section class="">
				<div class="container">
					<div class="appointment_box">
						<h4 class="text-center mb-3">Kirim Pesan</h4>
						<form id="whatsapp-form">
							<div class="row">
								<div class="col-md-6">
									<input type="text" id="senderName" class="form-control" placeholder="Nama Lengkap" name="senderName" required>
								</div>
								<div class="col-md-6">
									<select id="educationLevel" name="educationLevel" class="form-select form-control" aria-label="Default select example">
										<option value="Choose Department">Pilih Program:</option>
										<?php $__currentLoopData = $programs; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $p): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($p->name); ?>"><?php echo e($p->name); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
					<?php $__currentLoopData = $facilities; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $f): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <option value="<?php echo e($f->title); ?>"><?php echo e($f->title); ?></option>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
									</select>
								</div>
								
								<div class="col-md-12">
									<textarea id="message" name="message" cols="40" rows="10" class="form-control" placeholder="Isi pesan ...." required></textarea>
								</div>
								<div class="col-md-12">
									<button class="pbmit-btn" type="button" onclick="sendMessage()">
										<span class="pbmit-button-text">Submit Now</span>
										<span class="pbmit-button-icon-wrapper">
											<span class="pbmit-button-icon">
												<i class="pbmit-base-icon-black-arrow-1"></i>
											</span>
										</span>
									</button>
								</div>
							</div>
						</form>
					</div>
				</div>
			</section>

		</div>

<div class="mt-5"></div>





<script>
  function sendMessage() {
    var senderName = document.getElementById('senderName').value;
    var educationLevel = document.getElementById('educationLevel').value;
    var message = document.getElementById('message').value;
    var phoneNumber = '+62<?php echo e($identities[0]->phone); ?>';

    if (senderName && educationLevel && message) {
      // Membuat pesan dengan informasi yang diisi oleh pengguna
      var fullMessage = 'Nama Pengirim: ' + senderName +
        '\nProgram: ' + educationLevel +
        '\nPesan: ' + message;

      // Menggunakan format URL WhatsApp untuk mengirim pesan
      var whatsappUrl = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(fullMessage);
      window.location.href = whatsappUrl;
    } else {
      alert('Mohon isi semua kolom terlebih dahulu.');
    }
  }
</script>




<?php $__env->stopSection(); ?>
<?php echo $__env->make('layouts.frontapp', ['title' => 'Kontak'], \Illuminate\Support\Arr::except(get_defined_vars(), ['__data', '__path']))->render(); ?><?php /**PATH /var/www/cms.jatidiri.app/resources/views/front/contact/index.blade.php ENDPATH**/ ?>