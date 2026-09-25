@extends('layouts.app', ['title' => $about->title])

@section('content')
{{-- <main class="flex-1 overflow-x-hidden overflow-y-auto bg-gray-300">
    <div class="container mx-auto py-8 ">
      <div class="bg-white rounded-md shadow-md p-6">
        @foreach ($abouts as $about)
          <div class="row align-items-center">
            <div class="col-md-5">
              <img src="{{asset('storage/identities/'.$about->image)}}" alt="{{$about->title}}" class="thumbnails">
            </div>
            <div class="col-md-7">

              <h3>{{$about->title}}</h3>
              <h5>{{$about->subtitle}}</h5>
              {!! $about->description !!}
            </div>
          <div>
            <hr>
              {!! $about->content !!}
            </div>
            <div class="flex mx-10 my-4 justify-end">
              <a href="{{ route('admin.about.edit', $about->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
            </div>
          </div>
        @endforeach
      </div>
      <div class="bg-white rounded-md shadow-md p-6 mt-4">
          @foreach ($videoprofiles as $videoprofile)
          <h5 class="text-grey my-4">Video Profil</h5>
          <div class="row">
            <div class="">
            <iframe id="ais" width="100%" height="350px" src="https://www.youtube-nocookie.com/embed/{{$videoprofile->videoprofile}}" title="YouTube video player" frameborder="5" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; " allowfullscreen></iframe>
            </div>
            <div class="flex mx-10 my-4 justify-end">
              <a href="{{ route('admin.videoprofile.edit', $videoprofile->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
            </div>
          </div>
          @endforeach
      </div>
      <div class="bg-white rounded-md shadow-md p-6 mt-4">     
        @foreach ($visi as $item)
          <h5 class="text-grey my-4">{{$item->title}}</h5>
            <div class="row">
              <div class="col-md-7">
                
                {!! $item ->visi !!}
              </div>
              <div class="col-md-5">
                <img src="{{asset('storage/identities/'.$item->image)}}" alt="{{$item->title}}" class="thubnails">
              </div>
              <div class="flex mx-10 my-4 justify-end">
                <a href="{{ route('admin.visi.edit', $item->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
              </div>
            </div>
        @endforeach
      </div> 
      <div class="bg-white rounded-md shadow-md p-6 mt-4"> 
        @foreach ($misis as $misi)
          <h5 class="text-grey my-4">{{$misi->title}}</h5>
          <div class="row">
            <div class="col-md-7">
              {!! $misi ->misi !!}
            </div>
            <div class="col-md-5">
              <img src="{{asset('storage/identities/'.$misi->image)}}" alt="{{$misi->title}}" class="thubnails">
            </div>
          </div>
          <div class="flex mx-10 my-4 justify-end">
              <a href="{{ route('admin.misi.edit', $misi->id) }}" class="flex align-items-start bg-indigo-600 px-4 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg><h6 class="mx-2">Edit</h6></a>
            </div>
          @endforeach 
      </div>
    </div>
</main> --}}
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <h4 class="card-title mb-4">Tentang {{$identities[0]->name}}</h4>
          @foreach($abouts as $about)
          <div class="row">
            <div class="col-md-7">
              <h4>{{$about->title}}</h4>
              <img src="{{ asset('storage/identities/' . $about->image1) }}" alt="{{$about->title}}" class="admin-edit-image">
              <div class="mt-4">{!!$about->content!!}</div>

            </div>
            <div class="col-md-5">
              <h4>{{$about->subtitle}}</h4>
              <img src="{{ asset('storage/identities/' . $about->image2) }}" alt="{{$about->title}}" class="admin-edit-image">
              <div class="mt-4">{!!$about->description!!}</div>
              <iframe width="100%" height="315" src="https://www.youtube.com/embed/{{$about->video}}?si=0qu36tY5tiajVPa1" title="YouTube video player" frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" allowfullscreen></iframe>
            </div>
          </div>
          <div class="btn-left mt-4">
            <div class="flex">
              <a href="{{ route('admin.about.edit', $about->id) }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          @foreach($visis as $visi)
          <div class="row align-items-center">
            <div class="col-md-4">
              <img src="{{ asset('storage/identities/' . $visi->image) }}" alt="{{$visi->title}}" class="admin-edit-image">
            </div>
            <div class="col-md-8">
              <h4 class="card-title mb-4">{{$visi->title}}</h4>
              <p class="m-0 subtitle">{{$visi->subtitle}}</p>
              <div class="mt-4">{!!$visi->visi!!}</div>
            </div>

            <div class="btn-left mt-4 mx-4">
              <div class="flex">
                <a href="{{ route('admin.visi.edit', $visi->id) }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
      <div class="card">
        <div class="card-body">
          @foreach($misis as $misi)
          <div class="row">
            <div class="col-md-8">
              <h4 class="card-title mb-4">{{$misi->title}}</h4>
              <p class="m-0 subtitle">{{$misi->subtitle}}</p>
              <div class="mt-4">{!!$misi->misi!!}</div>

            </div>
            <div class="col-md-4">
              <img src="{{ asset('storage/identities/' . $misi->image) }}" alt="{{$misi->title}}" class="admin-edit-image">
            </div>
            <div class="btn-left mt-4">
              <div class="flex">
                <a href="{{ route('admin.misi.edit', $misi->id) }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
              </div>
            </div>
          </div>
          @endforeach
        </div>
      </div>
    </div>
  </div>
</div>
@endsection