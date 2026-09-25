<div class="modal_popup one">
    <div class="modal-popup-inner">
        <div class="close-modal"><i class="fa fa-times"></i></div>
        <div class="modal_box">
            <div class="row">
                <div class="col-lg-5 col-md-12 form_inner">
                    <div class="form_content">


                        <form id="whatsapp-form">
                            <label for="senderName">Nama Pengirim:</label>
                            <input class="help-block with-errors" type="text" id="senderName" name="senderName" placeholder="Masukkan nama pengirim">
          
                            <label for="educationLevel">Jenjang Pendidikan:</label>
                            <select id="educationLevel" name="educationLevel">
                              @foreach($programs as $p)
                              <option value="{{$p->name}}">{{$p->name}}</option>
                              @endforeach
                            </select>
          
                            <label for="message">Pesan:</label>
                            <textarea id="message" name="message" placeholder="Tulis pesan Anda"></textarea>
                            <div class="form-group mg_top apbtn">
                              <button class="theme-btn one" type="button" onclick="sendMessage()">Kirim Pesan</button>
                            </div>
                          </form>

                    </div>
                </div>
                <div class="col-lg-7 col-md-12 about_company_inner">
                    <div class="abt_content">
                        <div class="logo">
                            <a href="{{route('home')}}" class="logo_mid">
                                <img src="{{ asset('storage/identities/' . $identities[0]->logo) }}" alt="{{$identities[0]->name}}" class="logo_default">
                             </a>
                        </div>
                        <div class="text">
                            {!! $visis[0]->visi!!}</>
                            <a href="#">Read More</a>
                         </div>
                        
                        <div class="post_contet_modal">
                            <h2> Our Programs</h2>
                            <div class="post_enable">
                                @foreach($programs as $p)
                                <div class="modal_post_grid">
                                    <a href="{{route('front.program.show',$p->slug)}}">
                                        <img width="852" height="812" src="{{ asset('storage/programs/' . $p->image1) }}" class="main_img wp-post-image" alt="img" />
                                    </a>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="copright">
                            &copy; 2009-<?php echo date("Y"); ?> <a href="{{route('home')}}" rel="nofollow">{{$identities[0]->name}}</a> | Developed by: <a target="_blank" href="https://hexagon.co.id/">Hexagon Inc.</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
    function sendMessage() {
      var senderName = document.getElementById('senderName').value;
      var educationLevel = document.getElementById('educationLevel').value;
      var message = document.getElementById('message').value;
      var phoneNumber = '+62{{$identities[0]->phone}}';
  
      if (senderName && educationLevel && message) {
        // Membuat pesan dengan informasi yang diisi oleh pengguna
        var fullMessage = 'Nama Pengirim: ' + senderName +
          '\nJenjang Pendidikan: ' + educationLevel +
          '\nPesan: ' + message;
  
        // Menggunakan format URL WhatsApp untuk mengirim pesan
        var whatsappUrl = 'https://wa.me/' + phoneNumber + '?text=' + encodeURIComponent(fullMessage);
        window.location.href = whatsappUrl;
      } else {
        alert('Mohon isi semua kolom terlebih dahulu.');
      }
    }
  </script>