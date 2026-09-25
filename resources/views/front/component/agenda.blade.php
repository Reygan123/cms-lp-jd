<section class="events-section1 section pbt-100">
    <div class="pd_top_75"></div>
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title_all_box style_three text-center dark_color">
                    <div class="title_sections three">
                        <div class="before_title">Upcoming Events</div>
                        <h2>Agenda Mendatang</h2>
                    </div>
                    <!--===============spacing==============-->
                    <div class="mr_bottom_25"></div>
                    <!--===============spacing==============-->
                </div>
            </div>
        </div>
        @if(count($agendas) > 0)
        @foreach ($agendas as $index => $agenda)
        <div class="row align-items-center event-item-style-1 {{ $index % 2 == 0 ? 'odd-event' : 'even-event' }}">
            <div class="col-4 col-sm-4 date">
                <h1>{{date('d', strtotime($agenda->start_date))}}</h1>
                <div>{{date('M Y', strtotime($agenda->start_date))}}</div>
            </div>

            <div class="col-8 col-sm-8 details">
                <a href="{{route('agenda.agenda.show',$agenda->slug)}}">
                    <h3>{{$agenda->title}}</h3>
                </a>

                <div class="mr_bottom_20">
                    <div class="info">
                        <i class="fa fa-clock-o"></i>
                        <span>Mulai pukul {{ date('H.i A', strtotime($agenda->start_time)) }}</span>
                    </div>
                    <div class="info ml-5">
                        <i class="fa fa-map-marker"></i>
                        <span>{{ $agenda->location }}</span>
                    </div>
                </div>
            </div>
        </div>
        @endforeach
        @else
        <p style="text-align:center;">Tidak ada agenda mendatang!</p>
        @endif

    </div>
    <div class="view-more text-center">
        <a href="{{route('home')}}/agenda">View all</a>
    </div>
</section>