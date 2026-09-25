<section class="project-section bg_dark_3 pt-5 pb-5">
    <div class="pt-5 mb-5 text-light text-center">
        <h2 class="text-light">Alasan Memilih Program {{$program->name}}</h2>
        <h4 class="text-light">{{ $identities[0]->name }}</h4>
    </div>
    <div class="pt-3">
        <div class="row justify-content-center">
            @foreach ($unggulans as $u)
                
            <div class="col-xl-4 col-lg-6 col-md-6 col-sm-12 col-xs-12 mt-4">
               <div class="icon_box_all style_five dark_color_one">
                  <div class="icon_content">
                     <div class="">
                        <img src="{{asset('storage/unggulans/'.$u->image)}}" alt="" class="author-thumb">
                     </div>
                     <small>{{ $loop->iteration }}</small>
                     <div class="text_box mt-4">
                        <h2>{{ $u->title }}</h2>
                     </div>
                     <div class="hover_content">
                        <div class="content">
                           <div class="inner">
                            {!! $u->description !!}
                           </div>
                        </div>
                     </div>
                  </div>
               </div>
            </div>
            @endforeach

         </div>
    </div>
</section>

<section class="creote-icon-box">
    
 </section>
