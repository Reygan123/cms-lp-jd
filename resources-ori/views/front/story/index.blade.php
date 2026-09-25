@extends('layouts.frontapp', ['title' => 'Success Story'])
@section('content')
@foreach($header as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
@endforeach
<div class="container">
    @include('front.component.impact_menu')
</div>
@foreach ($openingstories as $o)
<section class="mt-100 mb-50">
    <div class="container">
            <div class="row align-items-center">
            <div class="col-sm-6 scroll-element js-scroll slide-left">
                <h1 class="t-purple mb-50">{{ $o->title}}</h1>
                {!! $o->description !!}
            </div>
            <div class="col-sm-6 scroll-element js-scroll slide-right">
                <img src="{{asset('storage/stories/'.$o->image)}}" alt="" class="thumbnails profile-image img-misi img-fit">
            </div>
        </div>
    </div>
</section>
<section class="mt-50 mb-100 scroll-element js-scroll fade-in-bottom">
<iframe width="100%" height="400" src="https://www.youtube.com/embed/{{$o->video}}" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
</section>
@endforeach
<section class="mt-50 mb-100">
    <div class="container">
        <h3 class="text-center">LET'S CHECK THEIR SUCCESS STORY</h3>
            <div class="row align-items-center success-story">
            @foreach ($stories as $q)
                <div class="col-sm-6 p-4 mt-10 scroll-element js-scroll fade-in-bottom">
                    <a href="{{route('front.story.show',$q->slug)}}">
                        <img src="{{asset('storage/stories/'.$q->image)}}" alt="" class="img-whatwedo">
                        <h4 class=" mt-20 mb-20 fw-400">{{$q->title}}</h4>
                        <h5 class="t-purple">{{$q->company_name}}</h5>
                    </a>
                    <div class="mt-30">{!! Str::limit($q->description, 200) !!}</div>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>
@endsection