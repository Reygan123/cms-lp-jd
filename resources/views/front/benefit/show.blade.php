@extends('layouts.frontapp', ['title' => $benefit->name])

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
<section>
    <div class="container mt-100">
        <div class="row">
            <div class="col-sm-8">
                <h2 class="t-purple">{{$benefit->name}}</h2>
                <div class="mt-50">
                    {!! $benefit->content !!}
                </div>
            </div>
            <div class="col-sm-4">
                <div class="bg-gray-200 rounded-lg px-4 py-4">
                    @foreach($header as $item)
                    <h4 class="mt-20 mb-20">{{$item->title}}</h4>
                    @endforeach
                    <ul>
                        @foreach($benefits as $q)
                        <li><a href="{{route('front.benefit.show',$q->slug)}}"><h6 class="t-purple">{{$q->name}}</h6></a></li>
                        @endforeach
                    </ul>
                </div>
                
            </div>
        </div>
    </div>
</section>

@endsection