@extends('layouts.app', ['title' => 'Visi'])

@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
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
    </div>
  </div>
</div>

@endsection