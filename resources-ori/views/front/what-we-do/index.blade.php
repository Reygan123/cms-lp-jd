@extends('layouts.frontapp', ['title' => 'Program HIPMI Kota Cimahi'])
@section('content')
@foreach($headersambutan as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
@endforeach
<div class="container">
    @include('front.component.profile_menu')
</div>
<section class="mt-100 mb-50">
    <div class="container">
        @foreach ($openings as $o)
            <div class="row align-items-center">
            <div class="col-sm-6 scroll-element js-scroll slide-left">
                <h1 class="t-purple mb-50">{{ $o->title}}</h1>
                {!! $o->description !!}
            </div>
            <div class="col-sm-6 scroll-element js-scroll slide-right">
                <img src="{{asset('storage/openings/'.$o->image)}}" alt="" class="thumbnails profile-image img-misi img-fit">
            </div>
        </div>
        @endforeach
    </div>
</section>
<section class="mt-50 mb-100">
    <div class="container">
            <div class="row align-items-center">
            @foreach ($wwds as $wwd)
                <div class="col-sm-6 p-4 mt-10 scroll-element js-scroll fade-in-bottom">
                    <img src="{{asset('storage/wwds/'.$wwd->image)}}" alt="" class="img-whatwedo">
                    <h4 class="t-purple mt-20 fw-600">{{$wwd->category}}</h4>
                    {{$wwd->title}}
                    <div class="mt-10"><a href="{{route('front.what-we-do.show',$wwd->slug)}}" class="btn btn-salaam">Read More</a></div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>
@endsection