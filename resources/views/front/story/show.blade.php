@extends('layouts.frontapp', ['title' => $story->title])

@section('content')
@foreach($header as $item)
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
        <div class="row">
            <div class="col-sm-8">
                <h5 class="t-purple text-center">Kisah Sukses {{$story->company_name}}</h5>
                <h3 class="py-20 ml-20 font-bold mb-50 text-center">{{$story->title}}</h3>
                {!!$story->description!!}
                <h6 class="fw-600 mt-50 mb-30">Simak kisah {{$story->owner}} dalam membangun bisnisnya:</h6>
                <iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$story->video}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
            <div class="col-sm-4">
                <div class="bg-gray-200 rounded-lg px-4 py-4">
                    <div class="mb-20"><h5 class="fw-600">{{$story->company_name}}</h5></div>
                    <div>Owner: {{$story->owner}}</div>
                    <div><i class="fa-regular fa-location-dot"></i> {{$story->location}}</div>
                    <div><i class="fa-regular fa-globe"></i> {{$story->web}}</div>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection