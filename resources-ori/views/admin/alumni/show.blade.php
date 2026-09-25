@extends('layouts.app', ['title' => $alumni->name])

@section('content')

<section class="mt-4">
    <div class="container">
        <div class="float-end flex">
            <a href="{{ route('admin.alumni.edit', $alumni->id) }}" class="bg-indigo-600 px-2 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
            <a href="{{route('admin.alumni.index')}}" class="bg-red-600 px-2 py-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg></a>
        </div>
        <h2 class="mt-4 mb-4 fw-600 text-center">DATA ANGGOTA ALUMNI</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('storage/alumnis/'.$alumni->image)}}" alt="" class="img-thumbnail admin-edit-image">
                <h5 class="mt-4 mb-4">DATA ALUMNI SEKOLAH</h5>
                <table class="table table-striped mt-4">
                    <tr>
                        <td scope="col">Nama Lengkap</td>
                        <td scope="col">: {{$alumni->name}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Nomor 
                            {{$alumni->no_kk}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Email</td>
                        <td scope="col">: {{$alumni->email}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Nomor Telepon</td>
                        <td scope="col">: {{$alumni->no_hp}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Alamat</td>
                        <td scope="col"> : {!!$alumni->alamat!!}</td>
                    </tr>
                    
                    <tr>
                        <td scope="col">Tanggal Daftar</td>
                        <td scope="col">: {{ date('d M Y', strtotime($alumni->created_at)) }}</td>
                    </tr>
                </table>
            </div>
        </div>
    </div>
</section>
@endsection