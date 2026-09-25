@extends('layouts.frontapp', ['title' => $program->name])

@section('content')
@include('front.component.slider')
</header>
<div class="mt-5 mb-5"></div>
@include('front.program.headline')
@include('front.program.fitur')
@include('front.program.why')
@include('front.program.narasi')
@include('front.component.client')
@include('front.component.testimony')
@include('front.program.pricing')


   
@endsection
