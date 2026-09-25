@extends('layouts.app', ['title' => $formdaftar->name])

@section('content')

<section class="mt-4">
    <div class="container">
        <div class="float-end flex">
            <a href="{{ route('admin.formdaftar.edit', $formdaftar->id) }}" class="bg-indigo-600 px-2 py-2 mx-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6">  <path stroke-linecap="round" stroke-linejoin="round" d="M16.862 4.487l1.687-1.688a1.875 1.875 0 112.652 2.652L10.582 16.07a4.5 4.5 0 01-1.897 1.13L6 18l.8-2.685a4.5 4.5 0 011.13-1.897l8.932-8.931zm0 0L19.5 7.125M18 14v4.75A2.25 2.25 0 0115.75 21H5.25A2.25 2.25 0 013 18.75V8.25A2.25 2.25 0 015.25 6H10" /></svg></a>
            <a href="{{route('admin.formdaftar.index')}}" class="bg-red-600 px-2 py-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg></a>
        </div>
        <h2 class="mt-4 mb-4 fw-600 text-center">DATA ANGGOTA HIPMI KOTA CIMAHI</h2>
        <div class="row">
            <div class="col-md-6">
                <img src="{{asset('storage/formdaftars/'.$formdaftar->image)}}" alt="" class="img-thumbnail admin-edit-image">
                <h5 class="mt-4 mb-4">DATA PEMILIK USAHA</h5>
                <table class="table table-striped mt-4">
                    <tr>
                        <td scope="col">Nama Lengkap</td>
                        <td scope="col">: {{$formdaftar->name}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Nomor {{$formdaftar->tanda_pengenal}}</td>
                        <td scope="col">: {{$formdaftar->id_number}}</td>
                    </tr>
                    <tr>
                        <td scope="col">TTL</td>
                        <td scope="col">: {{$formdaftar->birth_place}}, {{$formdaftar->birth_date}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Nomor Telepon</td>
                        <td scope="col">: {{$formdaftar->phone}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Alamat</td>
                        <td scope="col">: {{$formdaftar->address}}</td>
                    </tr>
                    
                    <tr>
                        <td scope="col">Tanggal Daftar</td>
                        <td scope="col">: {{ date('d M Y', strtotime($formdaftar->created_at)) }}</td>
                    </tr>
                </table>
            </div>
            <div class="col-md-6 ">
            <h5 class="mt-4 mb-4">DATA PERUSAHAAN</h5>

            <table class="table table-striped mt-5">
                <tr>
                    <td scope="col">Nama Perusahaan</td>
                    <td scope="col">: {{$formdaftar->nama_perusahaan}}</td>
                </tr>
                <tr>
                    <td scope="col">Kategori Usaha</td>
                    <td scope="col">: {{$formdaftar->category}}</td>
                </tr>
                <tr>
                    <td scope="col">Deskripsi Usaha</td>
                    <td scope="col">:</td>
                </tr>
                <tr><td>{!! $formdaftar->description !!}</td></tr>
                <tr>
                    <td scope="col">Nomor Telepon</td>
                    <td scope="col">: {{$formdaftar->phone_perusahaan}}</td>
                </tr>
                <tr>
                    <td scope="col">Alamat Email</td>
                    <td scope="col">: {{$formdaftar->email}}</td>
                </tr>
                <tr>
                    <td scope="col">Alamat Usaha</td>
                    <td scope="col">: {{$formdaftar->alamat_perusahaan}}</td>
                </tr>
                <tr>
                        <td scope="col">Kelurahan</td>
                        <td scope="col">: {{$formdaftar->desa->name}}</td>
                    </tr>
                    <tr>
                        <td scope="col">Kecamatan</td>
                        <td scope="col">: {{$formdaftar->kecamatan->name}}</td>
                    </tr>
                <tr>
                        <td scope="col">Provinsi - Kota</td>
                        <td scope="col">: Jawa Barat - Kota Cimahi</td>
                    </tr>
                   
                    
                </table>
            </div>
        </div>
    </div>
</section>

@endsection