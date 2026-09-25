@extends('layouts.frontapp', ['title' => 'Manfaat Menjadi Anggota HIPMI'])
@section('content')
@foreach($header as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
<div class="container">
    @include('front.component.impact_menu')
</div>

<section class="mt-50 mb-100">
    <div class="container">
        <h2 class="text-center uppercase mt-50 mb-100">{{$item->title}}</h2>
@endforeach

            <div class="row success-story">
            @foreach ($benefits as $q)
                <div class="col-sm-6 col-md-4 p-4 mt-10 scroll-element js-scroll fade-in-bottom benefit">
                    <a href="{{route('front.benefit.show',$q->slug)}}">
                        <img src="{{asset('storage/benefits/'.$q->image)}}" alt="" class="img-icon mt-50">
                        <h4 class=" mt-30 fw-600 ">{{$q->name}}</h4>
                    
                        <div class="mb-50">{!! Str::limit($q->description, 200) !!}</div>
                        </a>
                </div>
            @endforeach
            </div>
        </div>
    </div>
</section>
@endsection