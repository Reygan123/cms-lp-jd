@extends('layouts.frontapp', ['title' => $agenda->title])

@section('content')
@include('front.component.breadcrumb')

<section class="site_content blog-details">
    <div class="container">
        <div class="row">
            <div class="col-lg-9 blog-right-col">
                <div class="row">
                    <div class="col-md-12">
                        <article>
                            <div class="post blog-classic">
                                <div class="pbmit-featured-img-wrapper">
                                    <div class="pbmit-featured-wrapper image-container">
                                        <img src="{{asset('/storage/agendas/'.$agenda->image)}}" class="img-fluid"
                                            alt="{{$agenda->title}}">
                                        @if($agenda->yt_link)
                                        <div class="text-overlay">
                                            <a class="button is-play pbmin-lightbox-video"
                                                href="https://www.youtube.com/watch?v={{ $agenda->yt_link }}">
                                                <div class="button-outer-circle has-scale-animation"></div>
                                                <div class="button-outer-circle has-scale-animation has-delay-short">
                                                </div>
                                                <div class="button-icon is-play">
                                                    <svg height="100%" width="100%" fill="#3030f8">
                                                        <polygon class="triangle" points="5,0 30,15 5,30"
                                                            viewBox="0 0 30 15">
                                                        </polygon>
                                                        <path class="path" d="M5,0 L30,15 L5,30z" fill="none"
                                                            stroke="#3030f8" stroke-width="1"></path>
                                                    </svg>
                                                </div>
                                            </a>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                                
                                <div class="pbmit-blog-classic-inner">

                                    <div class="pbmit-entry-content">
                                        <h2 class="pbmit-post-title">{{$agenda->title}}</h2>
                                        <div class="pbmit-blog-meta pbmit-blog-meta-top">
                                            <div class="row mt-4">
                                                <div class="col-sm-6">
                                                    <h6>Mulai:</h6>
                                                    <div>
                                                        <i class="pbmit-base-icon-calendar-3"></i>
                                                        {{date('l, d F Y', strtotime($agenda->start_date))}}
                                                    </div>
                                                    <div> <i class="fa-regular fa-clock"></i>
                                                        {{ date('H.i A', strtotime($agenda->start_time)) }}
                                                    </div>
                                                </div>
                                                <div class="col-sm-6">
                                                    <h6>Selesai:</h6>
                                                    <div>
                                                        <i class="pbmit-base-icon-calendar-3"></i>
                                                        {{date('l, d F Y', strtotime($agenda->end_date))}}
                                                    </div>
                                                    <div>
                                                        <i class="fa-regular fa-clock"></i>
                                                        {{ date('H.i A', strtotime($agenda->end_time)) }}
                                                    </div>
                                                </div>
                                            </div>
                                            <h6 class="mt-4">Lokasi:</h6>
                                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16"
                                                fill="currentColor" class="bi bi-geo-alt" viewBox="0 0 16 16">
                                                <path
                                                    d="M12.166 8.94c-.524 1.062-1.234 2.12-1.96 3.07A32 32 0 0 1 8 14.58a32 32 0 0 1-2.206-2.57c-.726-.95-1.436-2.008-1.96-3.07C3.304 7.867 3 6.862 3 6a5 5 0 0 1 10 0c0 .862-.305 1.867-.834 2.94M8 16s6-5.686 6-10A6 6 0 0 0 2 6c0 4.314 6 10 6 10" />
                                                <path
                                                    d="M8 8a2 2 0 1 1 0-4 2 2 0 0 1 0 4m0 1a3 3 0 1 0 0-6 3 3 0 0 0 0 6" />
                                            </svg> {{ $agenda->location }}
                                        </div>

                                        <div class="list-endar">{!!$agenda->content!!}</p>
                                        </div>
                                    </div>
                                    <nav class="navigation post-navigation" aria-label="Posts">
                                        <div class="nav-links">
                                            <div class="nav-previous">
                                                @if ($previousAgenda)
                                                <a href="{{ route('agenda.agenda.show', $previousAgenda->slug) }}"
                                                    rel="prev">
                                                    <span class="pbmit-post-nav-icon">
                                                        <i class="pbmit-base-icon-left-arrow-1"></i>
                                                        <span class="pbmit-post-nav-head">Previous Event</span>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title">{{ $previousAgenda->title }}</span>
                                                    </span>
                                                </a>
                                                @endif
                                            </div>
                                            <div class="nav-next">
                                                @if ($nextAgenda)
                                                <a href="{{ route('agenda.agenda.show', $nextAgenda->slug) }}"
                                                    rel="next">
                                                    <span class="pbmit-post-nav-icon">
                                                        <span class="pbmit-post-nav-head">Next Event</span>
                                                        <i class="pbmit-base-icon-next"></i>
                                                    </span>
                                                    <span class="pbmit-post-nav-wrapper">
                                                        <span
                                                            class="pbmit-post-nav nav-title">{{ $nextAgenda->title }}</span>
                                                    </span>
                                                </a>
                                                @endif
                                            </div>
                                        </div>
                                    </nav>
                        </article>

                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-3 blog-left-col">
                <aside class="sidebar">
                    <div class="mb-5">
                        @include('front.component.banner')
                    </div>
                    <aside class="widget widget-recent-post">
                        <h2 class="widget-title">Blog Terkini </h2>
                        <ul class="recent-post-list">
                            @foreach($posts as $p)
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="{{route('post.post.show',$p->slug)}}">
                                    <img src="{{asset('storage/posts/'.$p->image)}}" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="{{route('post.post.show',$p->slug)}}">{{date('d M Y', strtotime($p->pub_date))}}</a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="{{route('post.post.show',$p->slug)}}">{{$p->title}}</a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </aside>

                    <aside class="widget widget-recent-post mt-4">
                        <h2 class="widget-title">Agenda Terdekat </h2>
                        <ul class="recent-post-list">
                            @foreach($agendas as $agenda)
                            <li class="recent-post-list-li">
                                <a class="recent-post-thum" href="{{route('agenda.agenda.show',$agenda->slug)}}">
                                    <img src="{{asset('storage/agendas/'.$agenda->image)}}" class="img-fluid" alt="">
                                </a>
                                <div class="pbmit-rpw-content">
                                    <span class="pbmit-rpw-date">
                                        <a
                                            href="{{route('agenda.agenda.show',$agenda->slug)}}">{{date('d M Y', strtotime($agenda->start_date))}}</a>
                                    </span>
                                    <span class="pbmit-rpw-title">
                                        <a href="{{route('agenda.agenda.show',$agenda->slug)}}">{{$agenda->title}}</a>
                                    </span>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </aside>
            </div>
        </div>
    </div>
</section>

@endsection