@extends('layouts.frontapp', ['title' => $artikel->title])

@section('content')
@include('front.component.breadcrumb')
<div id="content" class="site-content ">
   <div class="auto-container">
      <div class="row default_row">
         <div id="primary" class="content-area service col-lg-8 col-md-12 col-sm-12 col-xs-12">
            <main id="main" class="site-main" role="main">
               <!--===============spacing==============-->
               <div class="pd_top_90"></div>
               <!--===============spacing==============-->
               <section class="blog_single_details_outer">
                  <div class="single_content_upper">
                     <div class="blog_feature_image">
                        <img src="{{asset('storage/posts/'.$artikel->image)}}" class="wp-post-image" alt="img">
                     </div>
                     <!--===============spacing==============-->
                     <div class="pd_bottom_20"></div>
                     <!--===============spacing==============-->
                     <div class="post_single_content">
                        <h5>{{$artikel->title}}</h5>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_25"></div>
                        <!--===============spacing==============-->
                        <div class="description_box">
                           {!!$artikel->content!!}
                        </div>
                        <!--===============spacing==============-->
                        <div class="pd_bottom_15"></div>
                        <!--===============spacing==============-->
                     </div>
                  </div>


               </section>
               <!--===============spacing==============-->
               <div class="pd_bottom_70"></div>
               <!--===============spacing==============-->
            </main>
         </div>
         <aside id="secondary" class="widget-area all_side_bar col-lg-4 col-md-12 col-sm-12">
            <div class="side_bar">
               <!--===============spacing==============-->
               <div class="pd_top_90"></div>
               <!--===============spacing==============-->
               <div class="widgets_grid_box">
                  <h2 class="widget-title">Artikel & Berita Terkini</h2>
                  <div class="widget_post_box">
                     @foreach($posts as $p)
                     <div class="blog_in clearfix image_in">
                        <div class="image">
                           <img decoding="async" src="{{asset('storage/posts/'.$p->image)}}" alt="img">
                        </div>
                        <div class="content_inner">
                           <p class="post-date"><span class="icon-calendar"></span>{{date('l, d F Y', strtotime($p->pub_date))}}</p>
                           <h3><a href="{{route('post.post.show',$p->slug)}}">{{$p->title}}</a></h3>
                        </div>
                     </div>
                     @endforeach


                  </div>
               </div>
               <div class="widgets_grid_box">
                  <h2 class="widget-title">Agenda Terdekat</h2>
                  @foreach($agendas as $agenda)
                  <div class="contact_box_content style_one">
                     <a href="{{route('agenda.agenda.show',$agenda->slug)}}" class="contact_box_inner icon_yes">
                        <div class="row align-items-center">
                           <div class="col-4 ">
                              <h2>{{date('d', strtotime($agenda->start_date))}}</h2>
                              <div>{{date('m-Y', strtotime($agenda->start_date))}}</div>
                           </div>
                           <div class="col-8">
                              <h6>{{$agenda->title}}</h6>
                              <div>{!!$agenda->location!!}</div>
                           </div>
                        </div>
                     </a>
                  </div>
                  @endforeach
               </div>


               <div class="widgets_grid_box">
                  @include('front.component.banner')
               </div>
               <!--===============spacing==============-->
               <div class="pd_bottom_70"></div>
               <!--===============spacing==============-->
            </div>
         </aside>
      </div>
   </div>
</div>


@endsection