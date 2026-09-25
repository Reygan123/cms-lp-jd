@extends('layouts.frontapp', ['title' => 'Sambutan '.$s->title])

@section('content')
@include('front.component.breadcrumb')
<div id="content" class="site-content ">
   @foreach($sambutans as $s)
   <section class="service-icon-section bg_light_1">
      <!--===============spacing==============-->
      <div class="pd_top_90"></div>
      <!--===============spacing==============-->
      <div class="container">
         <div class="row">

            <div class="col-xl-4 col-lg-4 col-md-12 col-sm-12 col-xs-12">
               <div class="">
                  <img src="{{asset('/storage/identities/'.$s->image)}}" class="img-rounded" alt="image">
               </div>
               <!--===============spacing==============-->
               <div class="pd_bottom_20"></div>
               <!--===============spacing==============-->
               <div class="icon_box_all style_three">
                  <div class="icon_content ">
                     <div class="icon">
                        <span class=" icon-airplay"></span>
                     </div>
                     <div class="txt_content">
                        <h3><a href="#" target="_blank" rel="nofollow">{{$s->name}}</a></h3>
                        {!!$s->title!!}
                     </div>
                  </div>
               </div>
            </div>
            <div class="col-xl-8 col-lg-8 col-md-12 col-sm-12 col-xs-12 mt-4 mt-lg-0 mt-xl-0">
               <div class="icon_box_all style_three">
                  <div class="icon_content ">
                     <div class="icon">
                        <span class=" icon-file1"></span>
                     </div>
                     <div class="pd_bottom_20"></div>
                     <div class="txt_content">
                        <div class="text-left">
                           @if ($s->video)
                           <iframe width="100%" height="450" src="https://www.youtube.com/embed/{{$s->video}}" title="Sambutan" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
                           @else
                              {!! $s->description !!}
                           @endif
                        </div>
                     </div>
                  </div>
               </div>
            </div>


         </div>
      </div>
      <!--===============spacing==============-->
      <div class="pd_top_90"></div>
      <!--===============spacing==============-->
   </section>
   @endforeach
</div>


@endsection