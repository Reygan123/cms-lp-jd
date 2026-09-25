@extends('layouts.app', ['title' => 'Register Link'])
@section('content')
<div class="container">
  <div class="row">
    <div class="col-lg-12">
      <div class="card">
        <div class="card-body">
          <div class="row">
            <div class="col-12">
              <h4 class="card-title mb-4">{{$linkdaftars[0]->linktext}}</h4>
              <p class="m-0 subtitle">{{$linkdaftars[0]->link}}</p>
            </div>
            <div class="btn-left mt-4">
              <div class="flex">
                <a href="{{ route('admin.linkdaftar.edit', $linkdaftars[0]->id) }}" class="btn btn-primary btn btn-rounded"><span class="btn-icon-left text-primary"><i class="fa-solid fa-pen-to-square"></i></span>Edit</a>
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</div>

@endsection