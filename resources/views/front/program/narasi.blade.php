<section class="pbmit-sticky-section">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-lg-6 ">
                <div class="pbmit-sticky-col">
                    <div class="pbmit-ele-header-area">
                        <div class="pbmit-heading-subheading">
                            <h4 class="pbmit-subtitle">Supporting</h4>
                            <div class="row">
                                @if ($program->dukungans->count() == 1)
                                    <div class="col-12">
                                        @foreach ($program->dukungans as $dukungan)
                                            <div class="image-container mt-4">
                                                <img src="{{ asset('storage/dukungans/' . $dukungan->image) }}"
                                                    class="img-fluid img-thumbnail image-rounded h-250" alt="Gambar">
                                                <div class="text-overlay">
                                                    <a class="button is-play pbmin-lightbox-video"
                                                        href="https://www.youtube.com/watch?v={{ $dukungan->id_yt }}">
                                                        <div class="button-outer-circle has-scale-animation"></div>
                                                        <div
                                                            class="button-outer-circle has-scale-animation has-delay-short">
                                                        </div>
                                                        <div class="button-icon is-play">
                                                            <svg height="100%" width="100%" fill="#3030f8">
                                                                <polygon class="triangle" points="5,0 30,15 5,30"
                                                                    viewBox="0 0 30 15">
                                                                </polygon>
                                                                <path class="path" d="M5,0 L30,15 L5,30z" fill="none"
                                                                    stroke="#3030f8" stroke-width="1"></path>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-2 mx-4">{{ $identities[0]->name }} menurut {{ $dukungan->jabatan }}</div>
                                        @endforeach
                                    </div>
                                @else
                                    @foreach ($program->dukungans as $dukungan)
                                        <div class="col-md-6">
                                            <div class="image-container mt-4">
                                                <img src="{{ asset('storage/dukungans/' . $dukungan->image) }}"
                                                    class="img-fluid img-thumbnail image-rounded" alt="Gambar">
                                                <div class="text-overlay">
                                                    <a class="button is-play pbmin-lightbox-video"
                                                        href="https://www.youtube.com/watch?v={{ $dukungan->id_yt }}">
                                                        <div class="button-outer-circle has-scale-animation"></div>
                                                        <div
                                                            class="button-outer-circle has-scale-animation has-delay-short">
                                                        </div>
                                                        <div class="button-icon is-play">
                                                            <svg height="100%" width="100%" fill="#3030f8">
                                                                <polygon class="triangle" points="5,0 30,15 5,30"
                                                                    viewBox="0 0 30 15">
                                                                </polygon>
                                                                <path class="path" d="M5,0 L30,15 L5,30z" fill="none"
                                                                    stroke="#3030f8" stroke-width="1"></path>
                                                            </svg>
                                                        </div>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="mt-2 mx-4">{{ $dukungan->jabatan }}</div>
    
                                        </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                        <div class="row align-items-center">
                            <div class="col-sm-5 mt-2 text-center">
                                <a class="pbmit-btn pbmit-btn-white" href="{{ $linkdaftars[0]->link }}">
                                    <span class="pbmit-button-content-wrapper">
                                        <span class="pbmit-button-icon pbmit-align-icon-right">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="22.76" height="22.76" viewBox="0 0 22.76 22.76">
                                                <title>black-arrow</title>
                                                <path d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                                <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                                <path d="M22.34,1,1,22.34" transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2"></path>
                                            </svg>
                                        </span>
                                        <span class="pbmit-button-text">{{ $linkdaftars[0]->linktext }}</span>
                                    </span>
                                </a>
                            </div>
                            <div class="col-sm-5 mt-2 text-center">
                                <a class="pbmit-btn pbmit-btn-blackish" href="https://wa.me/+62{{ $identities[0]->phone }}?text={{ $welcomechats[0]->greating }}">
                                    <span class="pbmit-button-content-wrapper">
                                        <span class="pbmit-button-icon pbmit-align-icon-right">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </span>
                                        <span class="pbmit-button-text">Contact Us</span>
                                    </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-12 col-lg-6 ">
                <div class="pbmit-servicebox-right">
                    <div data-bs-spy="scroll" class="scrollspy-example-2 card-bg-white p-5" tabindex="0">
                        <h4 class="mb-4">{{ $program->title2 }}</h4>
                        {!! $program->description2 !!}
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>
