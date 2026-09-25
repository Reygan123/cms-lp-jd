<section class="project-section bg_dark_3">
   <div class="pt-5 mb-5 text-light text-center">
      @foreach($identities as $q)
      <h2 class="text-light">Alasan Memilih {{$q->name}} </h2>
      {!!$q->description!!}
      @endforeach
   </div>
   <div class="container-fluid pd_zero">
      <div class="row">
         <div class="col-lg-12">
            <div class="project_caro_section  style_two light_color">
               <div class="swiper-container" data-swiper='{
                  "autoplay": {
                     "delay": 6000
                  },
                  "freeMode": false,
                  "loop": true,
                  "speed": 1000,
                  "centeredSlides": true,
                  "slidesPerView": 3,
                  "spaceBetween": 30,
                  "pagination": {
                     "el": ".swiper-pagination",
                     "clickable": true
                  },
                     
                  "breakpoints": {
                     "1200": {
                        "slidesPerView": 5
                     },
                     "1024": {
                        "slidesPerView": 3 
                     },
                     "768": {
                        "slidesPerView": 2 
                     },
                     "576": {
                        "slidesPerView": 1 
                     },
                     "0": {
                        "slidesPerView": 1 
                     }
                  }
                  }'>
                  <div class="swiper-wrapper">
                     @foreach($unggulans as $u)
                     <div class="swiper-slide">
                        <div class="project_post style_seven">
                           <div class="image_box">
                              <img src="{{asset('storage/unggulans/'.$u->image)}}" class="img-fluid" alt="img">
                           </div>
                           <div class="content_box ">
                              <h2 class="title_pro"><a href="#" rel="bookmark">{{$u->title}}</a></h2>
                              <p>{{$u->title}}</p>
                              <div class="image_zoom_box ">
                                 <a href="{{ route('front.unggulan.index') }}" ><span class="fa fa-plus zoom_icon"></span></a>
                              </div>
                           </div>
                           <div class="overlay ">
                              <div class="text ">
                                 <h2 class="title_pro"><a href="#" rel="bookmark">{{$u->title}}</a></h2>
                                 <p class="short_desc">{!! strlen($u->description) > 80 ? substr($u->description,0,80)."..." : $u->description !!}</p>
                                 <a href="{{ route('front.unggulan.index') }}" class="read_more tp_five ">Selengkapnya</a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                     @foreach($unggulans as $u)
                     <div class="swiper-slide">
                        <div class="project_post style_seven">
                           <div class="image_box">
                              <img src="{{asset('storage/unggulans/'.$u->image)}}" class="img-fluid" alt="img">
                           </div>
                           <div class="content_box ">
                              <h2 class="title_pro"><a href="#" rel="bookmark">{{$u->title}}</a></h2>
                              <p>{{$u->title}}</p>
                              <div class="image_zoom_box ">
                                 <a href="{{ route('front.unggulan.index') }}" ><span class="fa fa-plus zoom_icon"></span></a>
                              </div>
                           </div>
                           <div class="overlay ">
                              <div class="text ">
                                 <h2 class="title_pro"><a href="#" rel="bookmark">{{$u->title}}</a></h2>
                                 <p class="short_desc">{!! strlen($u->description) > 80 ? substr($u->description,0,80)."..." : $u->description !!}</p>
                                 <a href="{{ route('front.unggulan.index') }}" class="read_more tp_five ">Selengkapnya</a>
                              </div>
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
                  <div class="p_pagination mb-5">
                     <div class="swiper-pagination"></div>
                  </div>
               </div>

            </div>
         </div>
      </div>
   </div>
</section>

