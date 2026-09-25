@extends('layouts.frontapp', ['title' => 'Tentang Kami'])

@section('content')
    @include('front.component.breadcrumb')
    @include('front.component.value')
    @include('front.about.about')
    @include('front.component.data')
    @include('front.about.visi')
    @include('front.ourteam.leader')
    @include('front.component.testimony')
@endsection
