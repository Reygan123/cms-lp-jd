@extends('layouts.frontapp', ['title' => 'Prestasi'])

@section('content')
@include('front.component.breadcrumb')

<div id="content" class="site-content ">
   <div class="container">
      <div class="row default_row">
         <div class="full_width_box">
            <!--===============spacing==============-->
            <div class="pd_top_70"></div>
            <!--===============spacing==============-->
            <section class="tabs_all_box tabs_all_box_start type_two">
               <div class="tab_over_all_box">
                  <div class="tabs_header clearfix">
                     <ul class="showcase_tabs_btns nav-pills nav clearfix">
                        @foreach($prestasiimage->unique('categoriprestasi.name') as $pi)
                        <li class="nav-item">
                           <a class="s_tab_btn nav-link active" data-tab="#{{ $pi->categoriprestasi ? $pi->categoriprestasi->slug : 'N/A' }}">{{ $loop->iteration }}.{{ $pi->categoriprestasi ? $pi->categoriprestasi->name : 'N/A' }}</a>
                        </li>
                        @endforeach
                     </ul>
                  </div>
                  <div class="s_tab_wrapper">
                     <div class="s_tabs_content">
                        @foreach($prestasiimage->unique('categoriprestasi.name') as $pi)
                        <div class="s_tab fade @if($loop->first) active-tab show @endif" id="{{ $pi->categoriprestasi ? $pi->categoriprestasi->slug : 'N/A' }}">
                           <div class="tab_content one">
                              <div class="row">

                                 <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12">
                                    <div class="content_bx">
                                       <ul>
                                          @foreach($pi->categoriprestasi->prestasis->sortByDesc('created_at') as $prestasi)
                                          <li><b>{{ $prestasi->title }}</b></li>
                                          <p>{{$prestasi->name}}</p>
                                          @endforeach
                                          </ul>
                                    </div>
                                 </div>
                                 <div class="col-xl-6 col-lg-6 col-md-12 col-sm-12 col-xs-12 mb-5 mb-lg-0 mb-xl-0">
                                    <div class="image">
                                       <div class="row">
                                          @foreach($pi->categoriprestasi->prestasis->sortByDesc('created_at') as $prestasi)
                                          <div class="col-6">
                                             <img src="{{asset('/storage/prestasis/'.$prestasi->image)}}" alt="img" class="mr_top_20 rounded_radius">
                                          </div>
                                          @endforeach
                                       </div>
                                    </div>
                                 </div>
                              </div>
                           </div>
                        </div>
                        @endforeach
                     </div>
                  </div>
               </div>
            </section>
            <!--===============spacing==============-->
            <div class="pd_top_70"></div>
            <!--===============spacing==============-->
         </div>
      </div>
   </div>
</div>

@endsection