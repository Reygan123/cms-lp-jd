<div class="pendaftaran_menu mt-20 mb-20">
    <h5>Kesiswaan</h5>
    <ul class="pendaftaran_menu_list">
        <li class="{{ (request()->is('gambaran')) ? 'active' : '' }}"><a href="{{route('home')}}/gambaran">Gambaran Kegiatan Harian</a></li>
        <hr>
        <li class="{{ (request()->is('seragam')) ? 'active' : '' }}"><a href="{{route('home')}}/seragam">Seragam Sekolah</a></li>
        <hr>
        <li class="{{ (request()->is('kegiatan-osis')) ? 'active' : '' }}"><a href="{{route('home')}}/kegiatan-osis">Kegiatan Osis</a></li>
        <hr>
        <li class="{{ (request()->is('eskul')) ? 'active' : '' }}"><a href="{{route('home')}}/eskul">Kegiatan Extrakurikuler</a></li>
        <hr>
        <li class="{{ (request()->is('alumni')) ? 'active' : '' }}"><a href="{{route('home')}}/alumni">Alumni</a></li>
        <hr>
        </ul>
</div>
<div class="mt-4">
@foreach ($sidebanners as $z)
<a href="{{$z->link}}"><img src="{{asset('storage/identities/'.$z->image)}}" alt=""></a>
@endforeach
</div>