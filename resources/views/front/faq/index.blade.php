@extends('layouts.frontapp' , ['title' => 'FAQ'])
@section('content')
@include('front.component.breadcrumb')
<div id="content" class="site-content ">
   <section class="faqs-section mr_top_100 mr_bottom_100">
      <div class="container">
         <div class="row">
            <div class="col-sm-8">
               <h2 class="text-center margin-bottom-70 mb-4">Pertanyaan Sering Diajukan</h2>
               <div class="pd_top_90"></div>
               <div class="faq_section type_two">
                  <div class="block_faq">
                     <div class="accordion">

                        <dl>
                           @foreach($faq as $faqs)
                           <dt class="faq_header {{ $loop->first ? 'active' : '' }}">
                              {{$faqs->title}}<span class="icon-play"></span>
                           </dt>
                           <dd class="accordion-content hide" style="{{ $loop->first ? 'display:block;' : '' }}">
                              {!!$faqs->description!!}
                           </dd>
                           @endforeach

                        </dl>
                     </div>
                  </div>
               </div>

            </div>
            <div class="col-md-4">
               <div class="side_bar">
               @include('front.component.pendaftaran_menu')
               @include('front.component.banner')
               </div>
            </div>
         </div>
      </div>
   </section>
</div>
@endsection