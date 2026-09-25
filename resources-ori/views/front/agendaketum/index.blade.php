@extends('layouts.frontapp', ['title' => 'Agenda'])
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
<section class="events-section1 section pbt-100">
   <div class="container">
      <h2 class="margin-bottom-50">Upcoming Events</h2>
      @if(count($agendas) > 0)
      @foreach ($agendas as $index => $agenda)
      <div class="row event-item-style-1 {{ $index % 2 == 0 ? 'odd-event' : 'even-event' }}">
         <div class="col-5 col-lg-2 date">
            <h1>{{date('d', strtotime($agenda->start_date))}}</h1>
            <h5>{{date('F Y', strtotime($agenda->start_date))}}</h5>
         </div>
         <div class="col-7 col-md-6 col-lg-3 media">
            <a href="{{route('agenda.agenda.show',$agenda->slug)}}">
               <img src="{{asset('storage/agendas/'.$agenda->image)}}" alt="{{$agenda->title}}" class="img-event">
            </a>
         </div>
         <div class="col-12 col-lg-7 details">
            <a href="{{route('agenda.agenda.show',$agenda->slug)}}">
               <h3>{{$agenda->title}}</h3>
            </a>
            <div>{!! \Illuminate\Support\Str::limit($agenda->content, 200) !!}</div>


            <div class="d-flex align-items-center event-infos">
               <div class="info">
                  <i class="fas fa-clock"></i>
                  <span>{{ date('H.i A', strtotime($agenda->start_time)) }}</span>
               </div>
               <div class="info ml-5">
                  <i class="fas fa-map-marker-alt"></i>
                  <span>{{ $agenda->location }}</span>
               </div>
            </div>
            <a class="large-btn left-btn" href="{{route('agenda.agenda.show',$agenda->slug)}}">Selengkapnya<i class="flaticon-next"></i></a>
         </div>
      </div>
      @endforeach
      @else
      <p style="text-align:center;">Tidak ada agenda mendatang!</p>
      @endif

   </div>
</section>

@endsection