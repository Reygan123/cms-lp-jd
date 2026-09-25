<div class="bd-blog-sidebar mb-50 wow fadeInRight" data-wow-duration="1s" data-wow-delay=".3s">
                        <div class="bd-blog-latest">
                           @foreach ($banners as $banner)
                              <a href="@foreach($linkdaftars as $ld){{$ld->link}}@endforeach">
                                 <div class="bd-blog-details-thumb">
                                    <img src="{{asset('storage/identities/'.$banner->image)}}" alt="" class="img-fluid">
                                 </div>
                              </a>
                           @endforeach
                        </div>
                     </div>