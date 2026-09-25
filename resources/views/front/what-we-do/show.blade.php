@extends('layouts.frontapp', ['title' => $wwd->title])

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
<section>
    <div class="container mt-100">
        <h5 class="t-purple text-center">{{$wwd->category}}</h5>
        <h3 class="py-20 ml-20 font-bold mb-50 text-center">{{$wwd->title}}</h3>
        <div class="row">
            <div class="col-sm-8">
                <img src="{{asset('storage/wwds/'.$wwd->image)}}" class="content-detail-image" alt="{{$wwd->title}}">
                <div class="mt-50 mb-50">
                {!!$wwd->description!!}

                </div>
            </div>
            <div class="col-sm-4">
                <div class="bg-gray-200 rounded-lg px-4 py-4">
                    @foreach($headersambutan as $item)
                    <h4 class="mt-20 mb-20">{{$item->title}}</h4>
                    @endforeach
                    <ul>
                        @foreach($wwds as $q)
                        <li><a href="{{route('front.what-we-do.show',$q->slug)}}"><h6 class="t-purple">{{$q->title}}</h6></a></li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection