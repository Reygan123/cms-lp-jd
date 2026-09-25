@extends('layouts.frontapp', ['title' => 'Rencana Strategis'])

@section('content')
@foreach($headerenstra as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
@endforeach
<section class="postlist">
<div class="container">
        <div class="row">
            <div class="col-sm-9 p-4">
                <span>Strategi yang diterapkan oleh SMA PASUNDAN 3 BANDUNG dalam rangka pelaksanaan visi dan misi SMA Pasundan 3 Bandung : </span>
                <hr>
                @foreach($renstra as $item)
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                      <h2 class="accordion-header" id="flush-heading{{$item->id}}">
                        <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse" data-bs-target="#flush-collapse{{$item->id}}" aria-expanded="false" aria-controls="flush-collapse{{$item->id}}"> 
                        <b>
                         {{$item -> title}}
                        </b>    
                        </button>
                      </h2>
                     <div id="flush-collapse{{$item->id}}" class="accordion-collapse collapse" aria-labelledby="flush-heading{{$item->id}}" data-bs-parent="#accordionFlushExample">
                        <div class="accordion-body">{!! $item -> description !!}</div>
                    </div>
                        </div>
                            </div>
                            @endforeach
                                </div>
                                   
                
             <div class="col-sm-3">@include('front.component.profile_menu')</div>
        </div>
</div>
</section>
@endsection