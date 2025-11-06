@php
    $googleAdsService = app(\App\Services\GoogleAdsService::class);
    $currentLang = session()->has('lang') ? 
        \App\Models\Language::where('code', session()->get('lang'))->first() : 
        \App\Models\Language::where('is_default', 1)->first();
@endphp

@if(isset($googleAdsPartners) && $googleAdsPartners->count() > 0)
    @foreach($googleAdsPartners as $partner)
        @if($partner->google_ads_script)
            <div class="google-ads-container" data-placement="{{$partner->google_ads_placement}}">
                {!! $partner->google_ads_script !!}
            </div>
        @endif
    @endforeach
@endif

{{-- Additional Google Ads for specific placements --}}
@if(isset($placement))
    {!! $googleAdsService->renderAdsForPlacement($placement, $currentLang->id) !!}
@endif
