<div class="testimonial_sec style_one">
    <div class="before_title">Testimonies</div>
    <h2>Kata Mereka</h2>
    <div class="swiper-container mt-4" data-swiper='{
       "loop": true,
       "autoplay": {
       "delay": 7000
       },
       "speed": 1000,
       "centeredSlides": false,
       "slidesPerView": 1,
       "spaceBetween": 30,
       "navigation": {
       "nextEl": ".next-single-one",
       "prevEl": ".prev-single-one"
       },
       "pagination": {
       "el": ".number-pagination",
       "type": "fraction"
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
       }
       }
    }'>
       <div class="swiper-wrapper">
        @foreach($testimonies as $testi)
        
          <div class="swiper-slide">
             <div class="testimonial_box">
                <div class="rating">
                    <i class="icon-quote"></i>
                </div>
                <div class="authour_details  image_yes ">
                   <div class="image">
                      <img src="{{asset('storage/testimonies/'.$testi->image)}}" alt="{{ $testi->name }}" />
                   </div>
                   <div class="details">
                      <h2>{{ $testi->name }}</h2>
                      <span>{{ $testi->title }}</span>
                   </div>
                </div>
                <div class="comment">

                   {!! $testi->description !!}
                </div>
             </div>
          </div>
          @endforeach
       
       </div>
       <div class="arrows">
          <div class="prev-single-one"></div>
          <div class="next-single-one"></div>
       </div>
       <div class="num_pagination">
          <div class="number-pagination">
       
          </div>
       </div>
       
    </div>
 </div>