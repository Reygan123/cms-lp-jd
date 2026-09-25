@extends('layouts.frontapp', ['title' => 'Catatan Ketua Umum'])

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

<div class="blogs-area-section margin-top-100">
   <div class="container-fluid">
      <div class="page-nav-section section hide-md-and-down">
         <div class="container">
            <ul class="d-flex align-items-center justify-content-center">
            <li>Cari Catatan Di Sini: </li>
               <li class="d-flex align-items-center search-input-group">
                  <form action="{{ route('catatan.catatan.index') }}" method="GET">
                     <input type="text" name="q" value="{{ request()->query('q') }}" placeholder="Type something to search" />
                  </form>
                  <i class="flaticon-search"></i>
               </li>
            </ul>
         </div>
      </div>
      <div class="row">
         @foreach($catatans as $a)
         <div class="col-12 col-lg-6 blog-content">
            <!-- 2 column blog -->
            <div class="row blog blog-sum-item-style-1">
               <div class="col-12 col-md-7 media">
                  <img src="{{asset('/storage/catatans/'.$a->image)}}" alt="blog img" class="img-fluid" />
               </div>
               <div class="col-12 col-md-5 content">
                  <h4>{{$a->title}}</h4>
                  <div>{!! strlen($a->description) > 200 ? substr($a->description, 0, 200) . '...' : $a->description !!}</div>
                  <a class="small-btn" href="{{route('catatan.catatan.show',$a->slug)}}">Read it</a>
               </div>
            </div>
         </div>
         @endforeach
      </div>
   </div>
</div>
<div class="margin-bottom-50">
   <div class="pagination-style-1">
      @if ($catatans->hasPages())
      <a class="prev" role="button" data-slide="prev" href="{{ $catatans->previousPageUrl() }}">
         <i class="flaticon-back"></i>
      </a>
      <div class="page-num">
         <a class="current">{{ $catatans->currentPage() }}</a>
         <a class="total">{{ $catatans->lastPage() }}</a>
      </div>
      <a class="next" role="button" data-slide="next" href="{{ $catatans->nextPageUrl() }}">
         <i class="flaticon-next"></i>
      </a>
      @endif
   </div>
</div>



@endsection