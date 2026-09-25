<section class="section-xl">
    <div class="container">
        <div class="pbmit-heading-subheading text-center">
            <h4 class="pbmit-subtitle blackish-color">Why {{ $program->name }}!</h4>
            <h2 class="pbmit-title">Alasan Harus Menggunakan <br> {{ $program->name }}</h2>
        </div>
        <div class="pbmit-tab pbmit-tab-style-3">
            <ul class="nav nav-tabs" role="tablist">
      
                @foreach ($unggulans as $index => $unggulan)
                    <li class="nav-item" role="presentation">
                        <a class="nav-link {{ $index === 0 ? 'active' : '' }}" data-bs-toggle="tab"
                            href="#tab-{{ $unggulan->id }}" aria-selected="{{ $index === 0 ? 'true' : 'false' }}"
                            role="tab" tabindex="{{ $index === 0 ? '' : '-1' }}">
                            <span>{{ $unggulan->title }}</span>
                            <i class="pbmit-base-icon-black-arrow-1"></i>
                        </a>
                    </li>
                @endforeach
            </ul>
            <div class="tab-content">
                @foreach ($unggulans as $index => $unggulan)
                <div class="tab-pane {{ $index === 0 ? 'show active' : '' }}" id="tab-{{ $unggulan->id }}" role="tabpanel">
                    <div class="pbmit-column-inner">
                        <div class="row">
                            <div class="col-md-12 col-xl-6 pbmit-tab-img">
                                <img src="{{ asset('storage/unggulans/' . $unggulan->image) }}" class="img-fluid" alt="">
                            </div>
                            <div class="col-md-12 col-xl-6 pbmit-tab-list">
                                <h2>{{ $unggulan->title }}</h2>
                                <div class="list-endar">
                                    {!! $unggulan->description !!}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                @endforeach
                
            </div>
        </div>
    </div>
</section>
