<section class="section-xl pbminfotech-ele-ptable-style-1">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle blackish-color">My Price</h4>
            <h2 class="pbmit-title">Investasi {{ $program->name }}</h2>
        </div>
        <div class="pbmit-ptable-cols row">
            @foreach ($pricings as $price)
                <div class="pbmit-ptable-col col-lg-4 col-md-6 col-sm-12">
                    <div class="pbmit-pricing-table-box">
                        <div class="pbmit-head-wrap">
                            <div class="pbminfotech-ptable-desc">{{ $program->name }}</div>
                            <h3 class="pbminfotech-ptable-heading">{{ $price->title }}</h3>
                            <div class="pbminfotech-sep mt-4"></div>
                            @if($price->diskon)
                                <span style="text-decoration: line-through; color: red;">
                                    Rp.{{ formatRupiah($price->price) }}k
                                </span>(Disc. {{ $price->diskon }}%)
                                @endif
                            <div class="pbmit-price-wrapper">
                                <div class="pbmit-ptable-icon">
                                    <div class="pbmit-ptable-icon-wrapper"></div>
                                </div>
                                
                                <div class="pbmit-ptable-price-w">
                                    @if ($price->diskon)
                                        
                                    <div class="pbminfotech-ptable-symbol">Rp</div>
                                    <div class="pbminfotech-ptable-price">{{ formatRupiah($price->price - $price->price * ($price->diskon / 100)) }}k</div>
                                    @else
                                    <div class="pbminfotech-ptable-symbol">Rp</div>
                                    <div class="pbminfotech-ptable-price">{{ formatRupiah($price->price) }}k</div>
                                    @endif
                                </div>
                                <div class="pbminfotech-ptable-frequency">/ siswa</div>
                            </div>
                        </div>
                        <div class="pbmit-ptable-inner">
                            <div class="pbmit-ptable-lines-w list-endar">
                                {!! $price->description !!}
                            </div>
                            <div class="pbminfotech-ptable-btn">
                                <div class="pbmit-button">
                                    <a href="{{ $linkdaftars[0]->link }}">
                                        <span class="pbmit-button-text">{{ $linkdaftars[0]->linktext }}</span>
                                        <span class="pbmit-button-icon-wrapper">
                                            <span class="pbmit-button-icon">
                                                <i class="pbmit-base-icon-black-arrow-1"></i>
                                            </span>
                                        </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="pbmit-feature-wrap"></div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
