@extends('layouts.frontapp', ['title' => 'Legalitas & Sertfikat'])

@section('content')
@include('front.component.breadcrumb')
<div id="content" class="site-content ">
    <section class="project_all filt_style_two filter_enabled">
        <!--===============spacing==============-->
        <div class="pd_top_90"></div>
        <div class="container">
            <div class="project_container clearfix">
                <div class="row clearfix">
                    @foreach($legals as $legal)
                    <div class="project-wrapper grid-item col-lg-12 col-md-12 col-sm-12 col-xs-12 project_category-coaching">
                        <div class="project_box style_three clearfix">
                            <div class="content_inner">
                                <h2>{{$legal->title}}</h2>
                                <p class="short_desc mr_top_30">{!!$legal->description!!}</p>
                            </div>
                            <img src="{{asset('storage/identities/'.$legal->image)}}" alt="">
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>
</div>


@endsection