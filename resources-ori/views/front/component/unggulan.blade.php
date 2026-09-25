
    <div class="container-fluid">
        <div class="why-title">
            <h2 class="section-title">Alasan Memilih AIS</h2>
            <p class="animated text-why" data-animation="fadeInUpBig" data-animation-deupdate.homelay="600">“Tiada suatu pemberian yang lebih utama dari orang tua kepada anaknya selain pendidikan yang baik.” (HR. Al Hakim: 7679).</p>
        </div>
        <div class="row">
            @foreach($unggulans as $unggulan)
            <div class="col-md-3 col-sm-6 mb-20 scroll-element js-scroll fade-in-bottom" data-bg-cover="" data-padding-pos="all" data-has-bg-color="false" data-bg-color="" data-bg-opacity="1" data-hover-bg="" data-hover-bg-opacity="1" data-animation="" data-delay="0">
                <div class="column-inner">
                    <div class="wrapper">
                        <div class="oranges-flip-box" data-min-height="400" data-flip-direction="horizontal-to-left" data-h_text_align="left" data-v_text_align="center">
                            <div class="flip-box-front" data-bg-overlay="true" data-text-color="light" style="background-image:url({{asset('/storage/unggulans/'.$unggulan->image)}}); min-height: 400px; height: auto;">
                            <a href="{{$unggulan->link}}">
                                <div class="inner"><i class="icon-default-style fa fa-book1" data-color="accent-color" style="font-size: 60px!important; line-height: 60px!important;text-transform: uppercase;"></i>{{$unggulan->title}}</div></a>
                            </div>
                            <div class="flip-box-back" data-bg-overlay="" data-text-color="dark" style="background-color: rgb(255, 255, 255); min-height: 400px; height: auto;">
                                <div class="inner"><span style="color: orange">///</span>&nbsp;<span style="color: #000000;"><a style="text-decoration: none; color: #000000; text-transform: uppercase;" href="{{$unggulan->link}}">{{$unggulan->title}}</a></span>&nbsp;<span style="color: orange">///</span>
                                    <p>{!! $unggulan->description !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>                        
    </div>
