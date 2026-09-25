@extends('layouts.frontapp', ['title' => 'Artikel'])

@section('content')
@include('front.component.breadcrumb')


<div id="content" class="site-content ">
   <div class="auto-container">
      <div class="row default_row">
         <div id="primary" class="content-area  col-lg-8 col-md-12 col-sm-12 col-xs-12">

            <section class="blog_post_section one_column style_two">
               <!--===============spacing==============-->
               <div class="pd_top_90"></div>
               <!--===============spacing==============-->
               <div class="grid_show_case grid_layout clearfix">
                  @foreach($posts as $a)
                  <div class="grid_box _card">
                     <div class="news_box default_style list_view has_images">
                        <div class="image img_hover-1">
                           <img width="750" height="420" src="{{asset('/storage/posts/'.$a->image)}}" class="img-fluid" alt="img">
                           <a href="{{route('artikel.artikel.show',$a->slug)}}" class="categories">
                              <!-- <i class="icon-folder"></i>Coaching -->
                           </a>
                        </div>
                        <div class="content_box">
                           <div class="date">
                              <span class="date_in_number">{{date('l, d F Y', strtotime($a->pub_date))}}</span>
                           </div>
                           <div class="source">
                              <h2 class="title"><a href="{{route('artikel.artikel.show',$a->slug)}}" rel="bookmark">{{$a->title}}</a></h2>
                              <div class="short_desc">{!!$a->description!!}</div>
                              <a href="{{route('artikel.artikel.show',$a->slug)}}" class="theme-btn three">Read More</a>
                           </div>
                        </div>
                     </div>
                  </div>
                  @endforeach
               </div>

               <div class="row">
                  <div class="col-lg-12">
                     <nav aria-label="Page navigation example">
                        <ul class="pagination text-center">
                           @if ($posts->hasPages())
                           {{ $posts->links() }}
                           @endif
                        </ul>
                     </nav>
                  </div>
               </div>
               <!--===============spacing==============-->
               <div class="pd_bottom_70"></div>
               <!--===============spacing==============-->
            </section>

         </div>
         <aside id="secondary" class="widget-area all_side_bar col-lg-4 col-md-12 col-sm-12">
            <div class="side_bar">
               <!--===============spacing==============-->
               <div class="pd_top_90"></div>
               <!--===============spacing==============-->
               <div class="widgets_grid_box">
                  <h2 class="widget-title">Cari Berita Di Sini</h2>
                  <form role="search" method="get" action="{{ route('post.post.index') }}">
                     <div class="wp-block-search__inside-wrapper">
                        <input type="search" name="q" value="{{ request()->query('q') }}" placeholder="Key Words here" required="">
                        <i class="fa fa-search"></i>
                     </div>
                  </form>
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