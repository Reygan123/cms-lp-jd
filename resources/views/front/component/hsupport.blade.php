<section class="client_logo_carousel type_two">
<div class="pd_top_90"></div>
    <div class="swiper-container" data-swiper='{
                              "loop": true,
                              "autoplay": {
                                "delay": 5000
                              },
                              "speed": 1000,
                              "centeredSlides": false,
                              "slidesPerView": 4,
                              "spaceBetween": 30,
                              "pagination": {
                                "el": ".swiper-pagination",
                                "clickable": true
                              },
                              "navigation": {
                                "nextEl": ".swiper-button-next",
                                "prevEl": ".swiper-button-prev"
                              },
                              "breakpoints": {
                                 "1200": {
                                    "slidesPerView": 4
                                 },
                                 "1024": {
                                  "slidesPerView": 4
                                 },
                                "768": {
                                  "slidesPerView": 3 
                                },
                                "576": {
                                  "slidesPerView": 2 
                                },
                                "0": {
                                 "slidesPerView": 1 
                               }
                              }
                            }'>
        <div class="swiper-wrapper">
            @foreach($partners as $partner)
            <div class="swiper-slide">
                <div class="image">
                    <img src="{{asset('storage/partners/'.$partner->image)}}" alt="clients-logo" class="img-fluid" />
                </div>
            </div>
            @endforeach
        </div>
        <div class="p_pagination">
            <div class="swiper-pagination"></div>
        </div>

    </div>
</section>