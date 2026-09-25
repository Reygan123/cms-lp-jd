@extends('layouts.frontapp', ['title' => 'Pendaftaran'])

@section('content')
<section class="about-section">
   <!--===============spacing==============-->
   <div class="pd_top_90"></div>
   <!--===============spacing==============-->
   <div class="container">
      <div class="row align-items-center">
         <div class="col-xl-6 col-lg-12 ">
            <div class="about_content position-relative z_99">
               @foreach($pendaftarans as $p)
               <h5>{{$p->subtitle}}</h5>
               <h1 class="fw-bold">{{$p->title}}</h1>
               <div class="mt-4 mb-4">
                  {!!$p->description!!}
               </div>
               <div class="mt-4">
                  <div class="theme_btn_all color_one">
                     <a href="{{$sidebanners[0]->link}}" target="_blank" rel="nofollow" class="theme-btn five">Daftar Sekarang<i class="icon-right-arrow"></i></a>
                  </div>
                  </a>
               </div>
               @endforeach
            </div>
         </div>
         @foreach($abouts as $a)
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
               </div>
            </div>
            <!--===============spacing==============-->
            <div class="pd_bottom_20"></div>
            <!--===============spacing==============-->
         </div>
         @endforeach
      </div>
   </div>
   <!--===============spacing==============-->
   <div class="pd_bottom_70"></div>
   <!--===============spacing==============-->
</section>
<!-- Features Section -->
@include('front.component.why')


@include('front.component.hprogram')

@include('front.component.testimony')
<section class="testimonial-section">
   <!--===============spacing==============-->
   <div class="pd_bottom_80"></div>
   <!--===============spacing==============-->
   <div class="container">
      <div class="row">
         <div class="col-lg-12">
            <div class="title_all_box style_one text-center dark_color">
               <div class="title_sections ">
                  @foreach($pendaftarans as $p)
                  {!!$p->text_investasi!!}
                  @endforeach
               </div>
               <!--===============spacing==============-->
               <div class="pd_bottom_15"></div>
               <!--===============spacing==============-->
            </div>
         </div>
      </div>

      <div class="row">
         <div class="col-lg-1"></div>
         <div class="col-lg-10">
            <div class="testimonial_sec position-relative style_v2_one">
               <div class="swiper-container" data-swiper='{
                              "autoplay": {
                                "delay": 6000
                              },
                              "freeMode": false,
                              "loop": true,
                              "speed": 1000,
                              "centeredSlides": false,
                              "slidesPerView": 1,
                              "spaceBetween": 10,
                              "pagination": {
                                "el": ".swiper-pagination",
                                "clickable": true
                              },
                              "navigation": {
                                 "nextEl": ".next-single-one",
                                 "prevEl": ".prev-single-one"
                               },
                              "breakpoints": {
                                 "1200": {
                                    "slidesPerView": 1
                                 },
                                 "1024": {
                                  "slidesPerView": 1 
                                 },
                                "768": {
                                  "slidesPerView": 1 
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
                     @foreach ($programhome as $ph)
                     <div class="swiper-slide">
                        <div class="testimonial_box clearfix">
                           <div class="image">
                              <img src="{{asset('storage/programs/'.$ph->image)}}" alt="image">
                           </div>
                           <div class="authour_details">
                              <h5 class="time mb-4">{{$ph->name}}</h5>
                              {!!$ph->investasi!!}
                           </div>
                        </div>
                     </div>
                     @endforeach
                  </div>
               </div>
               <div class="arrows">
                  <div class="prev-single-one"></div>
                  <div class="next-single-one"></div>
               </div>
            </div>
         </div>
         <div class="col-lg-1"></div>
      </div>
   </div>
   <!--===============spacing==============-->
   <div class="pd_bottom_80"></div>
   <!--===============spacing==============-->
</section>


@endsection