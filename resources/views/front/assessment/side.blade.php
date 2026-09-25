<aside class="service-sidebar">
    <aside class="widget post-list">
        <h2 class="widget-title">Our Service</h2>
        <div class="all-post-list">
            <ul>
                @foreach ($programs as $program)
                    <li><a href="{{ route('front.program.show', $program->slug) }}"> {{ $program->name }} </a></li>
                @endforeach
                @foreach ($facilities as $facility)
                    <li
                        class="post-{{ url()->current() == route('front.assessment.show', $facility->slug) ? 'active' : '' }}">
                        <a href="{{ route('front.assessment.show', $facility->slug) }}"> {{ e($facility->title) }} </a>
                    </li>
                @endforeach



            </ul>
        </div>
    </aside>
    <aside class="widget pbmit-service-ad">
        <div class="textwidget">
            <div class="pbmit-service-ads">
                <h5 class="pbmit-ads-subheding">Our Newsletter</h5>
                <h4 class="pbmit-ads-subtitle">Ready to check?</h4>
                <h3 class="pbmit-ads-title">Sign up now!</h3>
                <div class="pbmit-ads-desc">
                    <i class="pbmit-base-icon-phone-call-1 text-white"></i><a class="text-white" href="tel:+62{{ $identities[0]->phone }}">+62-{{ str_replace('+62', '0', substr($identities[0]->phone, 0, 3)) }}-
                        {{ substr($identities[0]->phone, 3, 4) }}-
                        {{ substr($identities[0]->phone, 7) }}</a>
                </div>
                <a class="pbmit-btn" href="{{ $linkdaftars[0]->link }}">
                    <span class="pbmit-button-content-wrapper">
                        <span class="pbmit-button-icon pbmit-align-icon-right">
                            <svg xmlns="http://www.w3.org/2000/svg" width="22.76" height="22.76"
                                viewBox="0 0 22.76 22.76">
                                <title>black-arrow</title>
                                <path
                                    d="M22.34,1A14.67,14.67,0,0,1,12,5.3,14.6,14.6,0,0,1,6.08,4.06,14.68,14.68,0,0,1,1.59,1"
                                    transform="translate(-0.29 -0.29)" fill="none" stroke="#000" stroke-width="2">
                                </path>
                                <path d="M22.34,1a14.67,14.67,0,0,0,0,20.75" transform="translate(-0.29 -0.29)"
                                    fill="none" stroke="#000" stroke-width="2"></path>
                                <path d="M22.34,1,1,22.34" transform="translate(-0.29 -0.29)" fill="none"
                                    stroke="#000" stroke-width="2"></path>
                            </svg>
                        </span>
                        <span class="pbmit-button-text">{{ $linkdaftars[0]->linktext }}</span>
                    </span>
                </a>
            </div>
        </div>
    </aside>
    {{-- <aside class="widget">
        <h2 class="widget-title">Company profile</h2>
        <div class="textwidget">
            <div class="download">
                <div class="item-download">
                    <a href="#" target="_blank" rel="noopener noreferrer">
                        <span class="pbmit-download-content">
                            <i class="pbmit-base-icon-pdf-file-format-symbol-1"></i> Download Pdf File
                        </span>
                        <span class="pbmit-download-item">
                            <i class="pbminfotech-base-icons pbmit-righticon pbmit-base-icon-download"></i>
                        </span>
                    </a>
                </div>
                <div class="item-download">
                    <a href="#" target="_blank" rel="noopener noreferrer">
                        <span class="pbmit-download-content">
                            <i class="pbmit-base-icon-doc-file-format"></i> Download Word File
                        </span>
                        <span class="pbmit-download-item">
                            <i class="pbminfotech-base-icons pbmit-righticon pbmit-base-icon-download"></i>
                        </span>
                    </a>
                </div>
            </div>
        </div>
    </aside> --}}
</aside>
