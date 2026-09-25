@extends('layouts.frontapp', ['title' => $agenda->title])

@section('content')
@foreach($header as $item)
<div class="breadcrub-style-1 section">
    <div class="row d-flex align-items-center">
        <div class="col-12 col-md-8 bg-img  bg-color-1"></div>
        <div class="d-none d-md-block col-4 bg-color bg-img" style="background-image: url('{{asset('storage/headers/'.$item->image)}}');"></div>
    </div>
    <div class="heading text-center">
        <h1>{{$item->title}}</h1>
        <div class="breadcrub-style">
            <a href="{{route('home')}}">Home</a>
            <span class="arrow"> > </span> <a href="#" class="active">{{$item->title}}</a>
        </div>
    </div>
</div>
@endforeach

<section class="pbt-100">
    <div class="container">

        <div class="row ">

            <div class="col-sm-8">
                <h3 class="mb-30">{{$agenda->title}}</h3>
                <div class="row agenda-block mb-30">
                    <div class="col-sm-6">
                        <h5>Mulai:</h5>
                        <p><b>{{date('l, d F Y', strtotime($agenda->start_date))}}<br>
                                {{ date('H.i A', strtotime($agenda->start_time)) }}</b></p>
                    </div>
                    <div class="col-sm-6">
                        <h5>Selesai:</h5>
                        <p><b>{{date('l, d F Y', strtotime($agenda->end_date))}}<br>
                                {{ date('H.i A', strtotime($agenda->end_time)) }}</b></p>
                    </div>
                    <div class="col-sm-12">
                        <h5>Lokasi:</h5>
                        <p><b>{{ $agenda->location }}</b></p>
                    </div>

                </div>
                <img src="{{asset('storage/agendas/'.$agenda->image)}}" class="img-event" alt="{{$agenda->title}}">
                <div class="mt-10 mb-20">
                    {!!$agenda->content!!}
                </div>
            </div>
            <div class="col-lg-4">
                <h5 class="sidebar-title margin-top-20">Agenda Mendatang</h5>
                  <ul>
                     @foreach($agendas as $agenda)
                     <li class="flex"><i class="flaticon-next"></i><a href="{{route('agenda.agenda.show',$agenda->slug)}}"><b>{{$agenda->title}}</b>
                     <br>
                     {{date('d F Y', strtotime($agenda->start_date))}}&nbsp;|&nbsp;{{ date('H.i A', strtotime($agenda->start_time)) }}</a>
                    
                    </li>
                     @endforeach
                  </ul>
                  
                  <div class="margin-top-20">
                     @foreach ($banners as $banner)
                     <a href="{{route('home')}}/{{$banner->link}}">
                        <div class="bd-blog-details-thumb">
                           <img src="{{asset('storage/identities/'.$banner->image)}}" alt="" class="img-fluid">
                        </div>
                     </a>
                     @endforeach
                  </div>

                </div>
            </div>
        </div>
    </div>
</section>




@endsection