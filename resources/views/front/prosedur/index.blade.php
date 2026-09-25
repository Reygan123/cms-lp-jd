@extends('layouts.frontapp', ['title' => 'Prosedur Pendaftaran'])

@section('content')
@include('front.component.breadcrumb')
<section class="pbt-100 mt-5 mb-5">
    <div class="container">
        <div class="row mt-100">
            <div class="col-md-8">
            @foreach ($prosedur as $p)
            <h3 class="text-center"><strong>{{$p->title}}</strong></h3>
                @foreach ($identities as $i)
                <h4 class="text-center margin-bottom-40"><strong> {{$i->name}} </strong></h4>
                @endforeach
                <div class="mr_top_50 content-web">
                  {!!$p->content!!}
                </div>
                @endforeach
            </div>
            <div class="col-md-4">
                    @include('front.component.pendaftaran_menu')
                    @include('front.component.banner')
            </div>
        </div>
    </div>
</section>
@endsection