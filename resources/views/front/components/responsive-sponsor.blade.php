@php
    $imageData = $partner->getResponsiveImageData();
@endphp

<div class="sponsor-item">
    <a href="{{$partner->url}}" target="_blank">
        <picture>
            <!-- Mobile Image -->
            @if($imageData['mobile']['src'])
                <source media="(max-width: 768px)" srcset="{{$imageData['mobile']['src']}}">
            @endif
            
            <!-- Desktop Image (fallback) -->
            <img data-src="{{$imageData['desktop']['src']}}" 
                 class="lazy" 
                 alt="{{$imageData['desktop']['alt']}}"
                 title="{{$partner->name}}">
        </picture>
    </a>
    
    @if($partner->description)
        <div class="sponsor-description">
            <p class="small text-muted">{{$partner->description}}</p>
        </div>
    @endif
</div>
