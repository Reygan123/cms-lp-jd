@foreach($abouts as $a)
   <section class="about-section">
      <!--===============spacing==============-->
      <div class="pd_top_90"></div>
      <!--===============spacing==============-->
      <div class="container">
         <div class="row align-items-center">
            <div class="col-xl-6 col-lg-12 ">
               <div class="about_content position-relative z_99">
                  <div class="title_all_box style_one text-left  dark_color">
                     <div class="title_sections">
                        <h2>{{$identities[0]->name}}</h2>
                     </div>
                  </div>
                  <!--===============spacing==============-->
                  <div class="pd_bottom_15"></div>
                  <!--===============spacing==============-->
                  <div class="extra_content image_with_content dark_color">
                     <div class="simple_image">
                        <img src="{{asset('storage/identities/'.$identities[0]->favicon)}}" alt="img">
                        <h2> Sejak tahun 2000, <br> Berkontribusi Di Kota Bandung.</h2>
                     </div>
                  </div>
                  <!--===============spacing==============-->
                  <div class="pd_bottom_20"></div>
                  <!--===============spacing==============-->
                  <div class="description_box">
                     {!!$a->description!!}
                  </div>
                  <div class="row mr_top_20 mr_bottom_20">
                     @foreach ($svgs as $svg)
                     <div class="col-sm-4">
                        <div class="style_one count-box">
                           <div class="link_content_bx">
                              <h3><span class="count-text" data-speed="1500" data-stop='{{ number_format($svg->nilai, 0, ".", ",") }}'></span>
                                 <small>+</small>
                              </h3>
                              <h6>{{$svg->name}}</h6>

                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>

               </div>
               <!--===============spacing==============-->
               <div class="pd_bottom_20"></div>
               <!--===============spacing==============-->
               <div class="theme_btn_all color_one">
                  <a href="{{route('home')}}/tentangkami" target="_blank" rel="nofollow" class="theme-btn five">Selengkapnya<i class="icon-right-arrow"></i></a>
               </div>
            </div>
            <div class="col-xl-6 col-lg-12">
               <div class="image_boxes style_two">
                  <img src="assets/images/shape-1.png" class="background_image" alt="image">
                  <div class="image one">
                     <img src="{{asset('/storage/identities/'.$a->image)}}" class="img-fluid" alt="image">
                  </div>
                  <div class="image two">
                     @foreach($misis as $ms)
                     <img src="{{asset('/storage/identities/'.$ms->image)}}" class="img-fluid" alt="image">
                     @endforeach
                     @foreach($videoprofiles as $vp)
                     <div class="video_box">
                        <a href="https://www.youtube.com/watch?v={{$vp->videoprofile}}" class="lightbox-image"><i class="icon-play"></i></a>
                     </div>
                     @endforeach
                  </div>
                  <div class="authour_quotes">
                     <i class="icon-quote"></i>
                     <h6>{{$a->subtitle}}</h6>
                     @foreach($sambutans as $s)
                     <p>/ {{$s->name}}</p>
                     @endforeach
                  </div>
               </div>

            </div>
         </div>
      </div>
      <!--===============spacing==============-->
      <div class="pd_bottom_70"></div>
      <!--===============spacing==============-->
   </section>
   @endforeach