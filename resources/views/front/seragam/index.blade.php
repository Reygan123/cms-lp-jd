@extends('layouts.frontapp' , ['title' => 'Seragam Sekolah'])
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
        <div class="col-sm-9 p-4">
            <div class="row">
            @foreach($seragams as $seragam)
                <div class="col-sm-4 p-4">
                <img src="{{asset('storage/seragams/'.$seragam->image)}}" class="rounded" style="height:200px;width:250px">
                    <br>
                    <h4 class="text-center">{{$seragam -> name}}</h4>
                </div>
            @endforeach
            </div>
        </div>
        <div class="col-sm-3">
            @include('front.component.kesiswaan_menu')
        </div>
    </div>
</div>
@endsection