@extends('layouts.frontapp', ['title' => 'Keunggulan'])
@section('content')
@include('front.component.breadcrumb')

<div id="content" class="site-content ">
   <div class="container">
      <div class="row default_row">
         <div class="full_width_box">
            <!--===============spacing==============-->
            <div class="pd_top_80"></div>
            <!--===============spacing==============-->
            <section class="service-section">
               <div class="row">
                  @foreach ($unggulans as $q)
                  <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mr_top_80">
                     <div class="service_box style_three dark_color">
                        <div class="service_content">
                           <div class="content_inner">
                              <span class="icon-play"><i></i></span>
                              <small class="nom">{{ $loop->iteration }}</small>
                              <h2><a href="#">{{$q->title}}</a></h2>
                              <div>{!!$q->description!!}</div>
                              <img src="{{asset('storage/unggulans/'.$q->image)}}" alt="" class="mr_top_20 rounded">
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>
            </section>
         </div>
      </div>
   </div>
</div>
<div class="pd_top_80"></div>




@endsection