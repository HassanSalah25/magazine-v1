@extends("front.$version.layout")

@section('pagename')
- {{__('Packages')}}
@endsection

@section('meta-keywords', "$be->packages_meta_keywords")
@section('meta-description', "$be->packages_meta_description")


@section('breadcrumb-title', $be->pricing_title)
@section('breadcrumb-subtitle', $be->pricing_subtitle)
@section('breadcrumb-link', __('Packages'))


@section('content')
<!-- hero area start -->
<div class="ar-hero-area p-relative" data-background="assets/img/team/team-bg.png">
    <div class="tp-career-shape-1">
        <span><svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 84 84" fill="none">
                <path d="M36.3761 0.5993C40.3065 8.98556 47.3237 34.898 32.8824 44.3691C25.3614 49.0997 9.4871 52.826 1.7513 31.3747C-1.16691 23.2826 5.38982 15.9009 20.5227 20.0332C29.2536 22.4173 50.3517 27.8744 60.9 44.2751C66.4672 52.9311 71.833 71.0287 69.4175 82.9721M69.4175 82.9721C70.1596 77.2054 74.079 66.0171 83.8204 67.3978M69.4175 82.9721C69.8033 79.1875 67.076 70.1737 53.0797 64.3958M49.1371 20.8349C52.611 22.1801 63.742 28.4916 67.9921 39.9344" stroke="#030303" stroke-width="1.5" />
            </svg></span>
    </div>
    <div class="container container-1230">
        <div class="ar-about-us-4-hero-ptb">
            <div class="row justify-content-center">
                <div class="col-xl-12">
                    <div class="ar-hero-title-box tp_fade_anim" data-delay=".3">
                        <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                            <span class="tp-section-subtitle pre tp_fade_anim">{{__('Packages')}}</span>
                            <div class="ar-about-us-4-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                    <rect y="4" width="80" height="1" fill="#111013" />
                                    <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="tp-career-title pb-30">{{$be->pricing_title}} <span class="shape-1"><img src="assets/img/about-us/about-us-4/about-us-4-shape-1.png" alt=""></span></h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4"></div>
                <div class="col-lg-8">
                    <div class="tp-faq-text tp_fade_anim">
                        <p>{{$be->pricing_subtitle}}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- hero area end -->

<!-- price area start -->
<div class="app-price-area p-relative pb-130">
    <div class="container container-1230">
        @if (count($categories) > 0 && $bex->package_category_status == 1)
        <div class="row align-items-end">
            <div class="col-lg-12">
                <div class="app-price-tab-wrap mb-30 tp_fade_anim" data-delay=".7">
                    <div class="ai-price-tab tp-marker-tab d-inline-flex justify-content-center p-relative">
                        <ul class="nav nav-tab filter-btn" id="myTab" role="tablist">
                            <li class="nav-items" role="presentation" data-filter="*">
                                <button class="nav-links active" type="button">{{__('All')}}</button>
                            </li>
                            @foreach ($categories as $category)
                                @php
                                    $filterValue = "." . Str::slug($category->name);
                                @endphp
                                <li class="nav-items" role="presentation" data-filter="{{ $filterValue }}">
                                    <button class="nav-links" type="button">{{ $category->name }}</button>
                                </li>
                            @endforeach
                        </ul>
                        <span id="lineMarker"></span>
                    </div>
                </div>
            </div>
        </div>
        @endif
        
        <div class="app-price-box app-price-inner-style">
            <!-- Section 1: Packages with show only in home -->
            @if (count($homeOnlyPackages) > 0)
                <div class="package-section mb-80">
                    <div class="row mb-40">
                        <div class="col-12">
                            <h3 class="section-title text-center">{{ __('Bundle Packages') }}</h3>
                            <p class="section-subtitle text-center">{{ __('Packages that are shown only on the home page') }}</p>
                        </div>
                    </div>
                    <div class="row" id="masonry-home-packages">
                        @foreach ($homeOnlyPackages as $key => $package)
                            @php
                                $packageCategory = $package->packageCategory()->first();
                                if (!empty($packageCategory)) {
                                    $categoryName = Str::slug($packageCategory->name);
                                } else {
                                    $categoryName = "";
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 package-column {{ $categoryName }}">
                                <div class="crp-price-item {{ $key == 1 ? 'active' : '' }}">
                                    <div class="crp-price-head">
                                        <span>{{convertUtf8($package->title)}}</span>
                                        <h4>
                                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{(int)$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                            @if ($bex->recurring_billing == 1)
                                                <i>/ {{$package->duration == 'quarterly' ? __('quarter') : __('year')}}</i>
                                            @endif
                                        </h4>
                                        <p>{{convertUtf8($package->subtitle)}}</p>
                                    </div>
                                    <div class="crp-price-list">
                                        <ul>
                                            @php
                                                // Extract content from <li> tags
                                                $features = [];
                                                if (!empty($package->description)) {
                                                    $dom = new DOMDocument();
                                                    libxml_use_internal_errors(true);
                                                    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $package->description);
                                                    libxml_clear_errors();
                                                    
                                                    $liElements = $dom->getElementsByTagName('li');
                                                    foreach ($liElements as $li) {
                                                        $text = trim($li->textContent);
                                                        if (!empty($text)) {
                                                            $features[] = $text;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($features as $feature)
                                                <li>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                                            <path d="M1 5.6941C1 5.6941 2.6 6.60188 3.4 7.93242C3.4 7.93242 5.8 2.70967 9 0.96875" stroke="#21212D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                    {{trim($feature)}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="app-price-btn-box">
                                        <div class="animated-border-box {{ $key == 1 ? 'radius-style-2' : '' }} w-100">
                                            @if ($bex->recurring_billing == 1)
                                                @auth
                                                    @if ($activeSub->count() > 0 && empty($activeSub->first()->next_package_id))
                                                        @if ($activeSub->first()->current_package_id == $package->id)
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Extend')}}</a>
                                                        @else
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Change')}}</a>
                                                        @endif
                                                    @elseif ($activeSub->count() == 0)
                                                        <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                @endguest
                                            @else
                                                @if ($package->order_status != 0)
                                                    @php
                                                        if($package->order_status == 1) {
                                                            $link = '#';
                                                        } elseif ($package->order_status == 2) {
                                                            $link = $package->link;
                                                        }
                                                    @endphp
                                                    <a href="{{ $link }}" @if($package->order_status == 2) target="_blank" @endif class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Place Order')}}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif

            <!-- Section 2: Packages with scategories -->
            @if (count($scategoryPackages) > 0)
                @php
                    // Group packages by scategory
                    $scategoryGroups = $scategoryPackages->groupBy('serviceable_id');
                @endphp
                
                @foreach ($scategoryGroups as $scategoryId => $packages)
                    @php
                        $scategory = $packages->first()->serviceable;
                    @endphp
                    <div class="package-section mb-80">
                        <div class="row mb-40">
                            <div class="col-12">
                                <h3 class="section-title text-center">{{ $scategory->name ?? __('Service Category Packages') }}</h3>
                                <p class="section-subtitle text-center">{{ __('Packages related to') }} {{ $scategory->name ?? __('service categories') }}</p>
                            </div>
                        </div>
                        <div class="row" id="masonry-scategory-packages-{{ $scategoryId }}">
                            @foreach ($packages as $key => $package)
                            @php
                                $packageCategory = $package->packageCategory()->first();
                                if (!empty($packageCategory)) {
                                    $categoryName = Str::slug($packageCategory->name);
                                } else {
                                    $categoryName = "";
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 package-column {{ $categoryName }}">
                                <div class="crp-price-item {{ $key == 1 ? 'active' : '' }}">
                                    <div class="crp-price-head">
                                        <span>{{convertUtf8($package->title)}}</span>
                                        <h4>
                                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{(int)$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                            @if ($bex->recurring_billing == 1)
                                                <i>/ {{$package->duration == 'quarterly' ? __('quarter') : __('year')}}</i>
                                            @endif
                                        </h4>
                                        <p>{{convertUtf8($package->subtitle)}}</p>
                                    </div>
                                    <div class="crp-price-list">
                                        <ul>
                                            @php
                                                // Extract content from <li> tags
                                                $features = [];
                                                if (!empty($package->description)) {
                                                    $dom = new DOMDocument();
                                                    libxml_use_internal_errors(true);
                                                    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $package->description);
                                                    libxml_clear_errors();
                                                    
                                                    $liElements = $dom->getElementsByTagName('li');
                                                    foreach ($liElements as $li) {
                                                        $text = trim($li->textContent);
                                                        if (!empty($text)) {
                                                            $features[] = $text;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($features as $feature)
                                                <li>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                                            <path d="M1 5.6941C1 5.6941 2.6 6.60188 3.4 7.93242C3.4 7.93242 5.8 2.70967 9 0.96875" stroke="#21212D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                    {{trim($feature)}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="app-price-btn-box">
                                        <div class="animated-border-box {{ $key == 1 ? 'radius-style-2' : '' }} w-100">
                                            @if ($bex->recurring_billing == 1)
                                                @auth
                                                    @if ($activeSub->count() > 0 && empty($activeSub->first()->next_package_id))
                                                        @if ($activeSub->first()->current_package_id == $package->id)
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Extend')}}</a>
                                                        @else
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Change')}}</a>
                                                        @endif
                                                    @elseif ($activeSub->count() == 0)
                                                        <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                @endguest
                                            @else
                                                @if ($package->order_status != 0)
                                                    @php
                                                        if($package->order_status == 1) {
                                                            $link = '#';
                                                        } elseif ($package->order_status == 2) {
                                                            $link = $package->link;
                                                        }
                                                    @endphp
                                                    <a href="{{ $link }}" @if($package->order_status == 2) target="_blank" @endif class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Place Order')}}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Section 3: Packages with services -->
            @if (count($servicePackages) > 0)
                @php
                    // Group packages by service
                    $serviceGroups = $servicePackages->groupBy('serviceable_id');
                @endphp
                
                @foreach ($serviceGroups as $serviceId => $packages)
                    @php
                        $service = $packages->first()->serviceable;
                    @endphp
                    <div class="package-section mb-80">
                        <div class="row mb-40">
                            <div class="col-12">
                                <h3 class="section-title text-center">{{ $service->title ?? __('Service Packages') }}</h3>
                                <p class="section-subtitle text-center">{{ __('Packages related to') }} {{ $service->title ?? __('specific services') }}</p>
                            </div>
                        </div>
                        <div class="row" id="masonry-service-packages-{{ $serviceId }}">
                            @foreach ($packages as $key => $package)
                            @php
                                $packageCategory = $package->packageCategory()->first();
                                if (!empty($packageCategory)) {
                                    $categoryName = Str::slug($packageCategory->name);
                                } else {
                                    $categoryName = "";
                                }
                            @endphp

                            <div class="col-xl-4 col-lg-6 col-md-6 package-column {{ $categoryName }}">
                                <div class="crp-price-item {{ $key == 1 ? 'active' : '' }}">
                                    <div class="crp-price-head">
                                        <span>{{convertUtf8($package->title)}}</span>
                                        <h4>
                                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{(int)$package->price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                            @if ($bex->recurring_billing == 1)
                                                <i>/ {{$package->duration == 'quarterly' ? __('quarter') : __('year')}}</i>
                                            @endif
                                        </h4>
                                        <p>{{convertUtf8($package->subtitle)}}</p>
                                    </div>
                                    <div class="crp-price-list">
                                        <ul>
                                            @php
                                                // Extract content from <li> tags
                                                $features = [];
                                                if (!empty($package->description)) {
                                                    $dom = new DOMDocument();
                                                    libxml_use_internal_errors(true);
                                                    $dom->loadHTML('<?xml encoding="utf-8" ?>' . $package->description);
                                                    libxml_clear_errors();
                                                    
                                                    $liElements = $dom->getElementsByTagName('li');
                                                    foreach ($liElements as $li) {
                                                        $text = trim($li->textContent);
                                                        if (!empty($text)) {
                                                            $features[] = $text;
                                                        }
                                                    }
                                                }
                                            @endphp
                                            @foreach($features as $feature)
                                                <li>
                                                    <span>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="10" height="9" viewBox="0 0 10 9" fill="none">
                                                            <path d="M1 5.6941C1 5.6941 2.6 6.60188 3.4 7.93242C3.4 7.93242 5.8 2.70967 9 0.96875" stroke="#21212D" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                                    {{trim($feature)}}
                                                </li>
                                            @endforeach
                                        </ul>
                                    </div>
                                    <div class="app-price-btn-box">
                                        <div class="animated-border-box {{ $key == 1 ? 'radius-style-2' : '' }} w-100">
                                            @if ($bex->recurring_billing == 1)
                                                @auth
                                                    @if ($activeSub->count() > 0 && empty($activeSub->first()->next_package_id))
                                                        @if ($activeSub->first()->current_package_id == $package->id)
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Extend')}}</a>
                                                        @else
                                                            <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Change')}}</a>
                                                        @endif
                                                    @elseif ($activeSub->count() == 0)
                                                        <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                    @endif
                                                @endauth

                                                @guest
                                                    <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                @endguest
                                            @else
                                                @if ($package->order_status != 0)
                                                    @php
                                                        if($package->order_status == 1) {
                                                            $link = '#';
                                                        } elseif ($package->order_status == 2) {
                                                            $link = $package->link;
                                                        }
                                                    @endphp
                                                    <a href="{{ $link }}" @if($package->order_status == 2) target="_blank" @endif class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Place Order')}}</a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                @endforeach
            @endif

            <!-- Show message if no packages found -->
            @if (count($homeOnlyPackages) == 0 && count($scategoryPackages) == 0 && count($servicePackages) == 0)
                <div class="col-12">
                    <h3 class="text-center">{{ __('No Package Found!') }}</h3>
                </div>
            @endif
        </div>
    </div>
</div>
<!-- price area end -->
@endsection

@section('scripts')
<style>
.section-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #111013;
    margin-bottom: 1rem;
}

.section-subtitle {
    font-size: 1.1rem;
    color: #666;
    margin-bottom: 0;
}

.package-section {
    margin-bottom: 5rem;
}

.package-section:last-child {
    margin-bottom: 0;
}
</style>

<script>
  $(document).ready(function() {
    // Initialize isotope for all package grids
    $('[id^="masonry-"]').each(function() {
      var $grid = $(this);
      if ($grid.find('.package-column').length > 0) {
        $grid.isotope({
          itemSelector: '.package-column',
          percentPosition: true,
          masonry: {
            columnWidth: 0
          }
        });
      }
    });

    // Filter functionality for category packages (if filter exists)
    if ($('.filter-btn').length > 0) {
      $('.filter-btn').on('click', 'li', function () {
        var filterValue = $(this).attr('data-filter');
        
        // Apply filter to all package sections
        $('[id^="masonry-"]').each(function() {
          var $grid = $(this);
          if ($grid.length > 0) {
            $grid.isotope({
              filter: filterValue
            });
          }
        });
        
        // Update active class on buttons
        $('.filter-btn .nav-links').removeClass('active');
        $(this).find('.nav-links').addClass('active');
      });
    }

    // Tab functionality for monthly/yearly toggle (if needed)
    $('.nav-tab button').on('click', function() {
      $(this).siblings().removeClass('active');
      $(this).addClass('active');
    });
  });
</script>
@endsection
