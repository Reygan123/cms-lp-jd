@extends('layouts.frontapp' , ['title' => 'Bantuan Keuangan'])
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
                <p class="text-left">Kami berkomitmen untuk mendidik murid yang memenuhi syarat akademik untuk menuntaskan pendidikannya di SMA Pasundan 3 Bandung
                 tanpa memandang status sosial – ekonomi mereka. Kami berusaha menjalin kerjasama 
                    baik dengan pemerintah maupun swasta untuk memberikan beasiswa baik melalui jalur prestatif maupun bantuan murid kurang mampu.
                </p>
                <p class="text-left">Untuk informasi lebih lengkap mengenai program bantuan keuangan ini, Anda dapat berkonsultasi langsung dengan ketua tim bantuan keuangan sekolah, Bapak Hendra, Telepon: 0853-2221-7795 ,  Email: hendra@smapasundan3bandung.sch.id</p>
                <p class="text-left">Berikut adalah jalur beasiswa yang dapat diakses oleh para murid :</p>
            <table class="aligncenter table table-bordered">
                <thead class="rounded">
                <tr style="background-color:blue;color:#a3a3a3;vertical-align:middle">
                    <th width="25%"><h5 class="text-center"><strong> Lembaga Pemberi Bantuan </strong></h5></th>
                    <th width="25%"><h5 class="text-center"><strong> Kategori </strong></h5> </th>
                    <th width="25%"><h5 class="text-center"><strong> Peruntukkan</strong></h5></th>
                    <th width="25%"><h5 class="text-center"><strong> Waktu Pendaftaran </strong></h5> </th>
                </tr>
                </thead>
                <tbody>
                <tr style="height: 60px; vertical-align: top;">
                    <td width="25%"> Yayasan Amal Abadi Beasiswa Orbit Hasri Ainun Habibie</td>
                    <td width="25%"> Beasiswa Prestatif</td>
                    <td width="25%">Murid dari keluarga kurang sejahtera</td>
                    <td width="25%"></td>
                </tr>
                <tr style="height: 60px; vertical-align: top;">
                    <td width="25%"> Panti Yatim Indonesia</td>
                    <td width="25%"> Bantuan Sosial</td>
                    <td width="25%">Murid dengan latar belakang yatim atau duafa</td>
                    <td width="25%"></td>
                </tr>
<tr style="height: 60px; vertical-align: top;">
<td width="25%"> Rumah Zakat</td>
<td width="25%"> Beasiswa Prestatif</td>
<td width="25%"> Murid dari keluarga kurang mampu</td>
<td width="25%"></td>
</tr>
<tr style="height: 60px; vertical-align: top;">
<td width="25%"> Kemendikbud RI, Kemenag RI, dan Kemensos RI</td>
<td width="25%"> Program Indonesia Pintar</td>
<td width="25%"> Murid dari keluarga kurang mampu</td>
<td width="25%"></td>
</tr>
            </tbody>
            </table>
            </div>
            <div class="col-sm-3">
                @include('front.component.pendaftaran_menu')
            </div>
        </div>

    </div>

@endsection