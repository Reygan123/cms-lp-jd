@extends('layouts.frontapp', ['title' => 'Kontak'])

@section('content')
@include('front.component.breadcrumb')

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
										<div class="pbmit-heading-desc"><a href="mailto:{{$identities[0]->email}}" class="__cf_email__" data-cfemail="abc5c486d9cedbc7d2ebdbc9c6c2c5cdc485c8c4c6">{{$identities[0]->email}}</a> </div>
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
										<div class="pbmit-heading-desc"><a href="tel:+62{{$identities[0]->phone}}">+62
											{{ str_replace('+62', '0', substr($identities[0]->phone, 0, 3)) }}-
											{{ substr($identities[0]->phone, 3, 4) }}-
											{{ substr($identities[0]->phone, 7) }}</a> 
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
										<div class="pbmit-heading-desc">{!!$identities[0]->address!!}</div>
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
										@foreach($programs as $p)
                    <option value="{{$p->name}}">{{$p->name}}</option>
                    @endforeach
					@foreach($facilities as $f)
                    <option value="{{$f->title}}">{{$f->title}}</option>
                    @endforeach
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
    var phoneNumber = '+62{{$identities[0]->phone}}';

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




@endsection