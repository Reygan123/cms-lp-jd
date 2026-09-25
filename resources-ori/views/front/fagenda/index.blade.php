@extends('layouts.frontapp', ['title' => 'Agenda'])
@section('content')
@include('front.component.breadcrumb')
<section class="section-xl">
    <div class="container">

        <div class="appointment_box">
            @if(count($agendas) > 0)
            @foreach ($agendas as $agenda)
            <div class="row align-items-center">
                <div class="col-lg-3">
                    <img src="{{ asset('storage/agendas/'.$agenda->image) }}" alt="{{ $agenda->title }}"
                        class="img-fluid image-rounded img-thumbnail">
                </div>
                <div class="col-lg-6">
                    <h6 class="mt-2">{{ $agenda->title }}</h5>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-calendar-range" viewBox="0 0 16 16">
                            <path d="M9 7a1 1 0 0 1 1-1h5v2h-5a1 1 0 0 1-1-1M1 9h4a1 1 0 0 1 0 2H1z" />
                            <path
                                d="M3.5 0a.5.5 0 0 1 .5.5V1h8V.5a.5.5 0 0 1 1 0V1h1a2 2 0 0 1 2 2v11a2 2 0 0 1-2 2H2a2 2 0 0 1-2-2V3a2 2 0 0 1 2-2h1V.5a.5.5 0 0 1 .5-.5M1 4v10a1 1 0 0 0 1 1h12a1 1 0 0 0 1-1V4z" />
                        </svg> {{ date('d F Y', strtotime($agenda->start_date)) }} - <svg
                            xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-clock" viewBox="0 0 16 16">
                            <path
                                d="M8 0a8 8 0 0 1 8 8 8 8 0 0 1-8 8 8 8 0 0 1-8-8 8 8 0 0 1 8-8zm0 1a7 7 0 0 0-7 7 7 7 0 0 0 7 7 7 7 0 0 0 7-7 7 7 0 0 0-7-7zm.5 4.5a.5.5 0 0 1 1 0V8h1.5a.5.5 0 0 1 0 1H9.5a.5.5 0 0 1-.5-.5V5.5z" />
                        </svg> {{ date('H.i A', strtotime($agenda->start_time)) }} <br>
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor"
                            class="bi bi-geo-alt" viewBox="0 0 16 16">
                            <path
                                d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                            <path d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                        </svg> {{ $agenda->location }}
                </div>
                <div class="col-lg-3">
                    <a class="btn btn-outline-dark mt-2" href="{{route('agenda.agenda.show',$agenda->slug)}}">
                        Selengkapnya <i class="pbmit-base-icon-angle-double-right"></i>
                    </a>
                </div>
            </div>
            @if(count($agendas) > 1)
            <hr>
            @endif
            @endforeach

            <div class="mt-4">
                {{ $agendas->links() }}
            </div>
            @else
            <p style="text-align:center;">Tidak ada agenda mendatang!</p>
            @endif
        </div>
    </div>
</section>
<!-- <section class="pd_top_90 pd_bottom_90">
    <div class="container">
        <div class="row">
            <div class="content-area col-lg-8 col-md-12 col-sm-12 col-xs-12">
                @if(count($agendas) > 0)
                @foreach ($agendas as $index => $agenda)
                <div class="row mt-4">
                    <div class="col-5 col-lg-2 date">
                        <h1>{{date('d', strtotime($agenda->start_date))}}</h1>
                        <h6>{{date('F Y', strtotime($agenda->start_date))}}</h6>
                    </div>
                    <div class="col-7 col-md-6 col-lg-3 agenda_bg"
                        style="background-image: url('{{asset('storage/agendas/'.$agenda->image)}}');">
                        <a href="{{route('agenda.agenda.show',$agenda->slug)}}">
                     <img src="" alt="{{$agenda->title}}" class="img-event">
                  </a>
                    </div>
                    <div class="col-12 col-lg-7 details">
                        <div class="pd_top_20"></div>
                        <a href="{{route('agenda.agenda.show',$agenda->slug)}}">
                            <h3>{{$agenda->title}}</h3>
                        </a>
                        {!! \Illuminate\Support\Str::limit($agenda->content, 200) !!}


                        <div class="mr_bottom_20">
                            <div class="info">
                                <i class="fa fa-clock-o"></i>
                                <span>mulai pukul {{ date('H.i A', strtotime($agenda->start_time)) }}</span>
                            </div>
                            <div class="info ml-5">
                                <i class="fa fa-map-marker"></i>
                                <span>{{ $agenda->location }}</span>
                            </div>
                        </div>
                        <a class="theme-btn three" href="{{route('agenda.agenda.show',$agenda->slug)}}">Selengkapnya<i
                                class="flaticon-next"></i></a>
                    </div>
                </div>
                @endforeach
                @else
                <p style="text-align:center;">Tidak ada agenda mendatang!</p>
                @endif

            </div>
            <aside id="secondary" class="widget-area all_side_bar col-lg-4 col-md-12 col-sm-12">
                <div class="side_bar">
                    <div class="pd_top_90"></div>
                    <div class="widgets_grid_box">
                        <h2 class="widget-title">Artikel & Berita Terkini</h2>
                        <div class="widget_post_box">
                            @foreach($posts as $p)
                            <div class="blog_in clearfix image_in">
                                <div class="image">
                                    <img decoding="async" src="{{asset('storage/posts/'.$p->image)}}" alt="img">
                                </div>
                                <div class="content_inner">
                                    <p class="post-date"><span
                                            class="icon-calendar"></span>{{date('l, d F Y', strtotime($p->pub_date))}}
                                    </p>
                                    <h3><a href="blog-single.html">{{$p->title}}</a></h3>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div class="widgets_grid_box">
                        @include('front.component.banner')
                    </div>
                    <div class="pd_bottom_70"></div>
                </div>
            </aside>
        </div>
    </div>
</section> -->

@endsection