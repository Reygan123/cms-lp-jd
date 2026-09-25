<section class="section-xl pbmit-bg-color-global pbmit-extend-animation tab_section">
				<div class="container">
					<div class="pbmit-heading-subheading text-white text-center">
						<h4 class="pbmit-subtitle">our Services</h4>
						<h2 class="pbmit-title">Layanan {{$identities[0]->name}}</h2>
					</div>
					<div class="pbmit-tab">
						<ul class="nav nav-tabs" role="tablist">
                            @foreach ($programhome as $ph)
                                <li class="nav-item" role="presentation">
                                    <a class="nav-link {{ $loop->first ? 'active' : '' }}" data-bs-toggle="tab" href="#tab-{{ $loop->index + 1 }}" aria-selected="{{ $loop->first ? 'true' : 'false' }}" role="tab"> 
                                        <span>{{ $ph->name }}</span>
                                    </a>	
                                </li>
                                
                            @endforeach
							
						</ul>
						<div class="tab-content">
                            @foreach ($programhome as $ph)
                                <div class="tab-pane {{ $loop->first ? 'show active' : '' }}" id="tab-{{ $loop->index + 1 }}" role="tabpanel">
                                    <div class="pbmit-column-inner">
                                        <div class="row g-0 align-items-center">
                                            <div class="col-md-12 col-xl-6 pbmit-tab-img">
                                                <img src="{{ asset('storage/programs/' . $ph->image1) }}" class="img-fluid" alt="">
                                            </div>
                                            <div class="col-md-12 col-xl-6 pbmit-tab-list">
                                                <h2>{{ $ph->name }}</h2>	
                                                <div>{!! $ph->description1 !!}</div>
                                                <ul class="list-group list-group-borderless">
                                                    @foreach ($ph->facilities as $facility)
                                                    <a href="{{ route('front.assessment.show', $facility->slug) }}">
                                                    <li class="list-group-item">
                                                        
                                                            <span class="pbmit-icon-list-icon">
                                                                <i aria-hidden="true" class="ti-check"></i>
                                                            </span>
                                                            <span class="pbmit-icon-list-text">{{ $facility->title }}</span>
                                                        
                                                        
                                                    </li>
                                                </a>
                                                    @endforeach
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                            @endforeach
							
						</div>
					</div>
				</div>
			</section>