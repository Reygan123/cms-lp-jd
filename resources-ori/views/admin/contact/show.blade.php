@extends('layouts.app', ['title' => 'Pesan Dari : '.$contact->name])

@section('content')

<section class="mt-4">
    <div class="container">
        <div class="float-end flex">
            <a href="{{route('admin.contact.index')}}" class="bg-red-600 px-2 py-2 rounded shadow-sm text-xs text-white focus:outline-none"><svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="w-6 h-6"><path stroke-linecap="round" stroke-linejoin="round" d="M9 15L3 9m0 0l6-6M3 9h12a6 6 0 010 12h-3" /></svg></a>
        </div>
        <div class="row">
            <h5>Pengirim:</h5>
            <div class="col-md-6">
                <table class="table table-striped mt-4">
                    <tr>
                        <td scope="col">Nama Lengkap</td>
                        <td scope="col">: <b>{{$contact->name}}</b></td>
                    </tr>
                    <tr>
                        <td scope="col">Telepon</td>
                        <td scope="col">: <b>{{$contact->phone}}</b></td>
                    </tr>
                    <tr>
                        <td scope="col">Email</td>
                        <td scope="col">: <b>{{$contact->email}}</b></td>
                    </tr>
                    
                </table>
            </div>
            <h5>Isi Pesan:</h5>
            <div class="">{!! $contact->message !!}</div>
        </div>
    </div>
</section>

@endsection