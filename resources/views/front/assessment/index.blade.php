@extends('layouts.frontapp' , ['title' => 'Fasilitas'])
@section('content')
@include('front.component.breadcrumb')
<div id="content" class="site-content ">
    <div class="container">
        <div class="row default_row">
            <div class="full_width_box">
                <!--===============spacing==============-->
                <div class="pd_top_80"></div>
                <!--===============spacing==============-->
                <section class="service-section">
                    <div class="row">
                        @foreach($facilities as $f)
                        <div class="col-xl-4 col-lg-6 col-md-12 col-sm-12 col-xs-12 mt-4">
                            <div class="service_box style_one dark_color">
                                <div class="service_content">
                                    <div class="image  image_fit">
                                        <img src="{{asset('/storage/facilities/'.$f->image)}}" class="img-fluid" alt="Service Image">
                                    </div>
                                    <div class="content_inner">
                                        <h2><a href="#">{{$f->title}}</a></h2>
                                        {!!$f->description!!}
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </section>
                <!--===============spacing==============-->
                <div class="pd_top_80"></div>
                <!--===============spacing==============-->
            </div>
        </div>
    </div>
</div>
@endsection