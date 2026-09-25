@section('content')
    @extends('layouts.frontapp', ['title' => 'Home'])
    <div id="content" class="site-content ">
        @include('front.component.slider')
        @include('front.component.value')
        @include('front.frontpage.about')
        @include('front.frontpage.services')
        @include('front.frontpage.blog')
       
        {{-- @include('front.component.hprogram')
        @include('front.component.habout')

        @include('front.component.why')
        <div class="pd_top_90"></div>
        <div class="row">
            <div class="col-lg-12">
                <div class="title_all_box style_three text-center dark_color">
                    <div class="title_sections three">
                        <div class="before_title">Prestasi</div>
                        <h2>Prestasi</h2>
                    </div>
                    <div class="mr_bottom_25"></div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6">@include('front.component.legal')</div>
            <div class="col-md-6">@include('front.component.hprestasi')</div>
        </div>
        <div class="row">
            <div class="col-md-6">
                @include('front.component.agenda')
            </div>
            <div class="col-md-6">
                @include('front.component.testimony')
            </div>
        </div>
        @include('front.component.hsupport')
        @include('front.component.hblog') --}}

    </div>
@endsection
