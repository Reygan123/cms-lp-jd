@extends('layouts.frontapp' , ['title' => 'Alumni'])
@section('content')
@foreach($header as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
@endforeach
<div class="container">
    <div class="row">
        <div class="col-sm-9">
                @foreach($alumnis as $alumni)
                <div class="row">
                    <div class="col-sm-4 p-4">
                        <img src="{{asset('/storage/alumnis/'.$alumni->image)}}" alt="{{$alumni->title}}" class="img-news">
                    </div>
                    <div class="col-sm-8 p-4 list-page">
                        <h4>{{$alumni->name}}</h4>
                        <div>{{date('l, d F Y', strtotime($alumni->updated_at))}}</div>
                        <p>{!! Str::limit($alumni->description, 200) !!}</p>
                        <a href="{{ route('front.alumni.show', ['alumnus' => $alumni]) }}" class="btn btn-salaam">Selengkapnya >></a>
                    </div>                
                </div>
                <hr>
                @endforeach
        </div>
        <div class="col-sm-3">
            @include('front.component.kesiswaan_menu')
        </div>
    </div>
</div>
@endsection