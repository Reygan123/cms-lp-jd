@extends('layouts.frontapp' , ['title' => 'Karir'])
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
        <div class="col-sm-9">
        <br>
        <br>
            <p class="text-left">
                SMA PASUNDAN 3 BANDUNG sangat menyambut baik para pendidik dan tenaga kependidikan yang berkualitas dan berpengalaman untuk mengaplikasikan keilmuannya, mencari tantangan baru, dan bermanfaat bagi peningkatan kualitas generasi penerus bangsa di masa yang akan datang. Calon pendidik di sekolah kami akan diseleksi dalam empat bidang: praktek pengajaran berkualitas tinggi; 
                inovasi dalam pembelajaran dan pengembangan kurikulum; hubungan dengan siswa, staff, dan orang tua; serta kontribusi terhadap sekolah.
            </p>
            <p class="text-left">
            SMA PASUNDAN 3 BANDUNG berkomitmen untuk menjaga kualitas pelayanan pendidikan dengan baik. Oleh karena itu, pelaksanaan seleksi dalam perekrutan dan pemeriksaan latar belakang pengajar akan kami lakukan sebelum adanya pengangkatan.
            </p>
            <p class="text-left">
            Bagi yang berminat dan memiliki kualifikasi yang disyaratkan, silahkan kirimkan lamaran lengkap beserta dokumen pendukung yang releven ke email kami :
            </p>
                <br>
                <br>
            <a href="#" class="btn btn-salaam"><strong>Contact Email:hrd@smapasundan3bandung.sch.id/smapasundan3bdg@ymail.com</strong></a>
        </div>
        <div class="col-sm-3">
            @include('front.component.pendaftaran_menu')
        </div>
    </div>
</div>

@endsection