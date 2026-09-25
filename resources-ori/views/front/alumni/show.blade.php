@extends('layouts.frontapp' , ['title' => 'Alumni'])
@section('content')
@foreach($header as $item)
<section class="header-page" style="background-image:url({{asset('storage/headers/'.$item->image)}});">
    <div class="container">
        <h1 class="center-text fw-600 lt-2 mb-10">{{$item->title}}</h1>
    </div>
</section>
@endforeach
<div class="container">
    <div class="row">
    <h2 class="mt-4 mb-4 fw-600 text-center">DATA ANGGOTA ALUMNI</h2>
        <div class="row">
            <div class="col-sm-9">
                <div class="row">
                    <div class="col">
                    <img src="{{asset('storage/alumnis/'.$alumnis->image)}}" alt="" class="img-thumbnail admin-edit-image">
                    <h5 class="mt-4 mb-4">DATA ALUMNI SEKOLAH</h5>
                     <table class="table table-striped mt-4">
                    <tr>
                        <td scope="col">Nama Lengkap</td>
                        <td scope="col">: {{$alumnis->name}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Email</td>
                        <td scope="col">: {{$alumnis->email}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Nomor Telepon</td>
                        <td scope="col">: {{$alumnis->no_hp}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Alamat</td>
                        <td scope="col"> : {!!$alumnis->alamat!!}</td>
                    </tr>
                    
                    <tr>
                        <td scope="col">Tanggal Daftar</td>
                        <td scope="col">: {{ date('d M Y', strtotime($alumnis->created_at)) }}</td>
                    </tr>
                  </table>
                </div>
            </div>
        </div>
    <div class="col-sm-3">
        @include('front.component.kesiswaan_menu')
    </div>
</div>
</div>
</div>
@endsection