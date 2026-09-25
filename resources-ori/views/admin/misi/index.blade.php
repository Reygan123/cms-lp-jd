@extends('layouts.app', ['title' => 'Misi'])
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
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