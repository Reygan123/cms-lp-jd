<div class="side_bar" data-wow-duration="1s" data-wow-delay=".3s">
    <div class="widgets_grid_box pd_top_50">
        <h2 class="widget-title">Pendaftaran Siswa Baru</h2>
    </div>
    <div class="tabs_all_box  tabs_all_box_start type_one menu-pendaftaran">
        <div class="tab_over_all_box">
            <div class="tabs_header clearfix pendaftaran">
                <ul class="showcase_tabs_btns nav-pills nav   clearfix">
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}/pendaftaran">PPDB {{$identities[0]->year}}</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}/prosedur">Prosedur Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}/investasi">Investasi Pendidikan</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="@foreach($linkdaftars as $ld){{$ld->link}}@endforeach">Formulir Pendaftaran</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}/tanggal-penting">Tanggal Penting</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="{{route('home')}}/faq">FAQ</a>
                    </li>
                </ul>
                <div class="toll_free">
                    <a href="tel:+6282117319090"> <i class="icon-phone-call"></i>Call For Free
                        Consultation</a>
                </div>
            </div>
        </div>
    </div>
</div>