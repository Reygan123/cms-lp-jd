@extends('layouts.frontapp', ['title' => 'Partner'])

@section('content')
@include('front.component.breadcrumb')

<section class="pd_top_90">
    <div class="container">
        @foreach ($partners as $partner)
        <a href="{{ $partner->web }}">
            <div class="project-wrapper grid-item project_category-coaching">
                <div class="project_box style_three clearfix">
                    <div class="row">
                        <div class="col-3"><img src="{{asset('storage/partners/'.$partner->image)}}" alt=""></div>
                        <div class="col-9">
                            <h6>{{ $partner->name }}</h6>
                            <div class="pd_top_30 mr_bottom_50">{!! $partner->program_desc !!}</div>
                        </div>
                    </div>
                </div>
            </div>
        </a>
        @endforeach
    </div>
</section>
@endsection