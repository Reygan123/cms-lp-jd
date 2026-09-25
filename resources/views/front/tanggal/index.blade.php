@extends('layouts.frontapp', ['title' => 'Tanggal Penting'])
@section('content')
@include('front.component.breadcrumb')
<section>
    <div class="container mt-5 mb-5">
        <div class="row mt-100">
            <div class="col-md-8">
                <h3 class="text-center"><strong>List Tanggal Penting</strong></h3>

                <table class="table table-striped mt-100">
                    <thead>
                        <tr>
                            <th scope="col">Tanggal</th>
                            <th scope="col">Detail</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($tanggal as $tgl)
                        <tr>
                            <td>{{ date('d M Y', strtotime($tgl->date)) }}</td>
                            <td>{{ $tgl->title }}<br>{!!$tgl->description!!}</td>
                        </tr>
                        @empty
                        <div class="bg-red-500 text-white text-center p-3 rounded-sm shadow-md">
                            Data Belum Tersedia!
                        </div>
                        @endforelse
                    </tbody>
                </table>
                
            </div>
            <div class="col-md-4">
                    @include('front.component.pendaftaran_menu')
                    @include('front.component.banner')
            </div>
            
        </div>
    </div>
</section>
@endsection