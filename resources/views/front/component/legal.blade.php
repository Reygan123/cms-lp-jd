
<section class="testimonial-section">
   <!--===============spacing==============-->
   <div class="pd_top_75"></div>
   <!--===============spacing==============-->
   <div class="container">

      <div class="testimonial_sec light_color style_three">
         <div class="swiper-container" data-swiper='{
                        "autoplay": {
                          "delay": 6000
                        },
                        "freeMode": true,
                        "loop": true,
                        "speed": 1000,
                        "centeredSlides": true,
                        "slidesPerView": 1,
                        "spaceBetween": 10,
                        "pagination": {
                          "el": ".swiper-pagination",
                          "clickable": true
                        },
                        "navigation": {
                          "nextEl": ".next-single-one_three",
                          "prevEl": ".prev-single-one_three"
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
               @foreach($legals as $legal)
               <div class="swiper-slide">
                  <div class="testimonial_box1">
                     <img src="{{asset('storage/identities/'.$legal->image)}}" alt="">
                  </div>
               </div>
               @endforeach

            </div>

         </div>
         <div class="arrows">
            <div class="prev-single-one_three"></div>
            <div class="next-single-one_three"></div>
         </div>
      </div>
   </div>
   <!--===============spacing==============-->
   <div class="pd_bottom_55"></div>
   <!--===============spacing==============-->
</section>