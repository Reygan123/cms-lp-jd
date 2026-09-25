<section class="section">
    <div class="container">
        <div class="pbmit-heading-subheading">
            <h5 class="">{{ $titles[0]->title }} {{ $facility->title }}</h5>
        </div>
        <div class="row">
            @foreach($benefits as $benefit)
            <div class="col-lg-4 col-sm-6">
                <article class="pbmit-miconheading-style-18 swiper-slide">
                    <div class="pbmit-ihbox-style-18">
                        <div class="pbmit-ihbox-headingicon">
                            <div class="pbmit-icon-wrap">
                                <div class="pbmit-ihbox-wrapper">
                                    <div class="pbmit-ihbox-icon-type-image">
                                        <img src="{{ asset('storage/benefits/' . $benefit->image) }}" alt="{{ $benefit->title }}" class="w-100">
                                    </div>
                                </div>
                                <div class="pbmit-ihbox-box-number"></div>
                            </div>
                            <div class="pbmit-ihbox-contents">
                                <h2 class="pbmit-element-title">
                                    {{ $benefit->title }}
                                </h2>
                                <div class="pbmit-heading-desc">{!! $benefit->description !!}</div>
                            </div>
                        </div>
                    </div>
                </article>
            </div>
            @endforeach
        </div>
    </div>
</section>
