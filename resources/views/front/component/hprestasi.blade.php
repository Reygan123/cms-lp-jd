<div class="container">
    <div class="row default_row">
        <div class="full_width_box">
            <!--===============spacing==============-->
            <div class="pd_top_30"></div>
            <!--===============spacing==============-->
            <section class="tabs_all_box tabs_all_box_start type_two">
                <div class="tab_over_all_box">
                    <div class="tabs_header clearfix">
                        <ul class="showcase_tabs_btns nav-pills nav clearfix">
                            @foreach($prestasiimage->unique('categoriprestasi.name') as $pi)
                            <li class="nav-item">
                                <a class="s_tab_btn nav-link active" data-tab="#{{ $pi->categoriprestasi ? $pi->categoriprestasi->slug : 'N/A' }}">{{ $loop->iteration }}.{{ $pi->categoriprestasi ? $pi->categoriprestasi->name : 'N/A' }}</a>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                    <div class="s_tab_wrapper">
                        <div class="s_tabs_content">
                            @foreach($prestasiimage->unique('categoriprestasi.name') as $pi)
                            <div class="s_tab fade @if($loop->first) active-tab show @endif" id="{{ $pi->categoriprestasi ? $pi->categoriprestasi->slug : 'N/A' }}">
                                <div class="tab_content one">
                                    <div class="content_bx">
                                        <ul>
                                            @php
                                            $no = 0;
                                            @endphp
                                            @foreach($pi->categoriprestasi->prestasis->sortByDesc('created_at') as $idx => $prestasi)
                                            @if($no < 10)
                                            @php
                                            $no++
                                            @endphp
                                            <li><b>{{ $prestasi->title }}</b></li>
                                            <p>{{$prestasi->name}}</p>
                                            @endif
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                             <div class="theme_btn_all color_one text-center">
                                 <a href="{{route('home')}}/prestasi" class="theme-btn five">View All <i class="icon-right-arrow"></i></a>
                             </div>
                        </div>
                    </div>
                </div>
            </section>
            <!--===============spacing==============-->
            <div class="pd_top_70"></div>
            <!--===============spacing==============-->
        </div>
    </div>
</div>
