@extends('layouts.frontapp', ['title' => $facility->title])
@section('content')
    @include('front.assessment.title')
    <section class="site_content service_details">
        <div class="container">
            <div class="row">
                <div class="col-lg-9 service-right-col">
                    @include('front.assessment.isi')
                    @include('front.assessment.benefit')
                </div>
                <div class="col-lg-3 service-left-col sidebar">
                    @include('front.assessment.side')

                </div>
            </div>
        </div>
    </section>
    
@endsection
