<div class="pbmit-service-feature-image">
    <img src="{{ asset('storage/facilities/' . e($facility->image)) }}" class="img-fluid w-100" alt="">
</div>
<div class="pbmit-entry-content">
    <div class="pbmit-service_content">
        <div class="pbmit-heading animation-style2">
            <h3 class="pbmit-title mb-3">{{ $facility->title }}</h3>
        </div>
        <div class="list-endar">
            {!! $facility->description !!}
        </div>
  
    </div>
    
</div>