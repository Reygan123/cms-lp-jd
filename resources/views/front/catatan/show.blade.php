@extends('layouts.frontapp', ['title' => $catatan->title])

@section('content')
@foreach($header as $item)
<div class="breadcrub-style-1 section">
   <div class="row d-flex align-items-center">
      <div class="col-12 col-md-8 bg-img  bg-color-1"></div>
      <div class="d-none d-md-block col-4 bg-color bg-img" style="background-image: url('{{asset('storage/headers/'.$item->image)}}');"></div>
   </div>
   <div class="heading text-center">
      <h1>{{$item->title}}</h1>
      <div class="breadcrub-style">
         <a href="{{route('home')}}">Home</a>
         <span class="arrow"> > </span> <a href="#" class="active">{{$item->title}}</a>
      </div>
   </div>
</div>
@endforeach
<section class="blog-detail margin-top-100">

   <div class="media-grid">
      <div class="row">
         <div class="col-12 img"><img src="{{asset('storage/catatans/'.$catatan->image)}}" alt="{{$catatan->title}}" class="img-fluid"></div>
      </div>
   </div>
   <div class="blog-contents">
      <div class="container">
         <div class="blog-text">
         <div class="heading">
                     <h2>{{$catatan->title}}</h2>
                  </div>
            <div class="row">
               <div class="col-sm-8">
                  
                  {!!$catatan->description!!}
               </div>
               <div class="col-sm-4">
                  <h5 class="sidebar-title">Catatan Lainnya</h5>
                  <ul>
                     @foreach($catatans as $catataning)
                     <li class="flex"><i class="flaticon-next"></i><a href="{{route('catatan.catatan.show',$catataning->slug)}}">{{$catataning->title}}</a></li>
                     @endforeach
                  </ul>

               </div>
            </div>

         </div>
      </div>
   </div>
</section>

@endsection