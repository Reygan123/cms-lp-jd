<section class="service-section bg_light_1">
    <!--===============spacing==============-->
    <div class="pd_top_80"></div>
    <!--===============spacing==============-->
    <div class="container">
        <div class="row">
            <div class="col-lg-12">
                <div class="title_all_box style_five text-center dark_color">
                    <div class="title_sections five">
                        <div class="before_title">Our Programs</div>
                        <h2>Program Pendidikan</h2>
                    </div>
                    <!--===============spacing==============-->
                    <div class="pd_bottom_15"></div>
                    <!--===============spacing==============-->
                </div>
            </div>
        </div>
        <div class="row gutter_30px">
            <div class="col-lg-12">
                <div class="service_section grid_all three_column  news_wrapper_grid dark_color">
                    <div class="grid_show_case grid_layout clearfix">
                        @foreach($programs as $p)
                        <div class="grid_box _card">
                            <div class="service_post style_five">
                                <div class="image_box">
                                    <img loading="lazy" width="500" height="500" src="{{ asset('storage/programs/' . $p->image1) }}" alt="img">
                                    <div class="gradient"></div>
                                </div>
                                <div class="content_box">
                                    <h2 class="title_service"><a href="{{route('front.program.show',$p->slug)}}" rel="bookmark">{{$p->name}}</a></h2>
                                    <p class="short_desc">{{$p->link_program}}
                                    </p>
                                    <a class="read_more" href="{{route('front.program.show',$p->slug)}}"> <i class="icon-right-arrow-long"></i>Selengkapnya</a>
                                </div>
                                <div class="icon_box">
                                    <span class="icon icon-thumbs-up icons"></span>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

        </div>
    </div>
    <!--===============spacing==============-->
    <div class="pd_bottom_70"></div>
    <!--===============spacing==============-->
</section>