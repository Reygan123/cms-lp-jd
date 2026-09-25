@extends('layouts.frontapp' , ['title' => 'Investasi Pendidikan'])
@section('content')
@include('front.component.breadcrumb')
<div class="container mt-5">
    <div class="row mt-100">
        <div class="col-md-8">
            @foreach ($identities as $i)
            <h3 class="text-center"><strong> Investasi Pendidikan </strong></h3>
            <h3 class="text-center"><strong> {{$i->name}} </strong></h3>
            <h3 class="text-center text-blue mb-5"><strong>Tahun Ajaran {{$i->year}} </strong> </h3>
            @endforeach
            <div class="mt-100">
                @foreach ($investasi as $inv)
                <div class="block-investasi mb-5">
                    <div class="investasi-title-{{($loop->iteration - 1) % 3 + 1}}"><h4><i class="fa fa-square"></i>&nbsp;&nbsp;{{$inv->name}}</h4></div>
                    <div class="mt-10">
                        {!! $inv->investasi!!}
                    </div>
                </div>
                <div class="margin-bottom-30"></div>
                @endforeach
            </div>
        </div>
        <div class="col-md-4">
                 @include('front.component.pendaftaran_menu')
                 @include('front.component.banner')
        </div>
        
    </div>
</div>

@endsection