<section class="section-xl pbmit-blog-column-three">
  <div class="container">
    <div class="position-relative">
      <div class="pbmit-heading-subheading animation-style2">
        <h4 class="pbmit-subtitle">our blogs</h4>
        <h2 class="pbmit-title">Latest posts & articles</h2>
      </div>
      <div class="blog-swiper_arrow swiper-btn-custom d-flex flex-row-reverse"></div>
    </div>
    <div class="swiper-slider" data-arrows-class="blog-swiper_arrow" data-autoplay="false" data-loop="true" data-dots="false" data-arrows="true" data-columns="3" data-margin="30" data-effect="slide">
      <div class="swiper-wrapper">
        <!-- Slide1 -->
        @foreach($posts as $a)
        <div class="swiper-slide">
          <article class="pbmit-blog-style-1">
            <div class="post-item">
              <div class="pbminfotech-box-content">
                <div class="pbmit-featured-container">
                  <div class="pbmit-featured-img-wrapper">
                    <div class="pbmit-featured-wrapper">
                      <img src="{{asset('/storage/posts/'.$a->image)}}" class="img-fluid" alt="{{$a->title}}">
                    </div>
                  </div>
                  <a class="pbmit-blog-btn" href="{{route('post.post.show',$a->slug)}}">
                    <span class="pbmit-button-icon-wrapper">
                      <span class="pbmit-button-icon">
                        <i class="pbmit-base-icon-black-arrow-1"></i>
                      </span>
                    </span>
                  </a>
                  <div class="pbmit-meta-cat-wrapper pbmit-meta-line">
                    <div class="pbmit-meta-category">
                      <a href="{{route('post.post.index',['category'=>$a->category->slug])}}" rel="category tag">{{ $a->category->name }}</a>
                    </div>
                  </div>
                  <a class="pbmit-link" href="blog-details.html"></a>
                </div>
                <div class="pbmit-category-date-wraper d-flex align-items-center">
                  <div class="pbmit-meta-date-wrapper pbmit-meta-line">
                    <div class="pbmit-meta-date">
                      <span class="pbmit-post-date">
                        <i class="pbmit-base-icon-calendar-3"></i>{{date('d M Y', strtotime($a->pub_date))}}
                      </span>
                    </div>
                  </div>
                  <div class="pbmit-meta-author pbmit-meta-line">
                    <span class="pbmit-post-author">
                      <i class="pbmit-base-icon-user-3"></i>{{$a->user->name}}
                    </span>
                  </div>
                </div>
                <div class="pbmit-content-wrapper">
                  <h3 class="pbmit-post-title">
                    <a href="{{route('post.post.show',$a->slug)}}">{{$a->title}}</a>
                  </h3>
                </div>
              </div>
            </div>
          </article>
        </div>
        @endforeach
      </div>
    </div>
  </div>
</section>