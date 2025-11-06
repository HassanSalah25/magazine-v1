@extends("front.$version.layout")
@section('html_class')
    agntix-light
@endsection
@section('pagename')
    -
    @if (empty($category))
        {{__('All')}}
    @else
        {{$category->name}}
    @endif
    {{ __('Services') }}
@endsection

@section('meta-keywords', "$be->services_meta_keywords")
@section('meta-description', "$be->services_meta_description")

@section('content')

  @if(isset($category))
      <!-- hero area start -->
      <div class="ar-hero-area p-relative pt-190 pb-100" data-background="{{ asset('front/assets/img/team/team-bg.png') }}">
          <div class="tp-career-shape-1">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 84 84" fill="none">
                <path d="M36.3761 0.5993C40.3065 8.98556 47.3237 34.898 32.8824 44.3691C25.3614 49.0997 9.4871 52.826 1.7513 31.3747C-1.16691 23.2826 5.38982 15.9009 20.5227 20.0332C29.2536 22.4173 50.3517 27.8744 60.9 44.2751C66.4672 52.9311 71.833 71.0287 69.4175 82.9721M69.4175 82.9721C70.1596 77.2054 74.079 66.0171 83.8204 67.3978M69.4175 82.9721C69.8033 79.1875 67.076 70.1737 53.0797 64.3958M49.1371 20.8349C52.611 22.1801 63.742 28.4916 67.9921 39.9344" stroke="#030303" stroke-width="1.5" />
            </svg>
        </span>
          </div>

          <div class="container container-1230">
              <div class="row justify-content-center">
                  <div class="col-xl-12">
                      <div class="ar-hero-title-box service-5-heading tp_fade_anim mb-80" data-delay=".3">
                          <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                        <span class="tp-section-subtitle pre tp_fade_anim">
                            {{ convertUtf8($bs->service_title) }}
                        </span>
                              <div class="ar-about-us-4-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                      <rect y="4" width="80" height="1" fill="#111013" />
                                      <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                  </svg>
                              </div>
                          </div>
                          <h3 class="tp-career-title">
                              {{ isset($category) ? convertUtf8($category->name) : __('All Services') }}
                              <span class="shape-1">
                            <img src="{{ isset($category) && $category->shape_image ? asset('assets/front/img/service_category_icons/' . $category->shape_image) : ($bs->service_shape_image ? asset('assets/front/img/services/' . $bs->service_shape_image) : asset('front/assets/img/about-us/about-us-4/about-us-4-shape-1.png')) }}" alt="shape">
                        </span>
                          </h3>
                      </div>
                  </div>
              </div>

              {{-- Optional: Could replace or translate this paragraph if dynamic --}}
              <div class="row">
                  <div class="col-lg-4"></div>
                  <div class="col-lg-8">
                      <div class="tp-service-5-text tp_fade_anim" data-delay=".5">
                          <p>
                              {{ $bs->service_subtitle ? convertUtf8($bs->service_subtitle) : __('This section explores a common challenge developers face such as cross-platform compatibility, performance optimization, and user experience.') }}
                          </p>
                      </div>
                      @if(isset($category))
                          <div class="tp-service-5-list tp_fade_anim" data-delay=".7">
                              <ul>
                                  @foreach($category->services as $service)
                                      <li><a href="{{ route('front.servicedetails', $service->slug) }}">+ {{ $service->title }}</a></li>
                                  @endforeach
                              </ul>
                          </div>
                      @endif
                  </div>
              </div>
          </div>
      </div>
      <!-- hero area end -->

      <!-- banner area start -->
      <div class="tp-service-4-banner-area p-relative">
          <div class="ar-banner-wrap ar-about-us-4">
              <img class="w-100"
                   src="{{ asset('assets/front/img/service_category_icons/' . $category->image) }}"
                   alt="{{ $category->name ?? 'Service Category Banner' }}"
                   data-speed=".8">
          </div>
      </div>
      <!-- banner area end -->

      <!-- service process area start -->
      <div class="tp-service-4-process-ptb pt-140 pb-140">
          <div class="container container-1230">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="ar-hero-title-box tp_fade_anim" data-delay=".3">
                          <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                        <span class="tp-section-subtitle pre tp_fade_anim">
                            {{ $category->name ?? __('Service Category') }}
                        </span>
                              <div class="ar-about-us-4-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                      <rect y="4" width="80" height="1" fill="#111013" />
                                      <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                  </svg>
                              </div>
                          </div>
                          <h3 class="tp-career-title fs-60 pb-40">
                              {{ $category->caption ?? __('We think out of the box and follow the working process') }}
                          </h3>
                      </div>
                  </div>
              </div>

              <div class="row">
                  {{-- Process List --}}
                  <div class="col-lg-4">
                      <div class="tp-service-4-process-wrap">
                          @php
                              $steps = explode(',', $category->process_list);
                          @endphp

                          @foreach($steps as $index => $step)
                              <div class="tp-service-4-process-list">
                                  <span>{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                  <p>{{ trim($step) }}</p>
                              </div>
                          @endforeach
                      </div>
                  </div>

                  {{-- Image + Video --}}
                  <div class="col-lg-8">
                      <div class="tp-service-4-process-wrapper pl-70 p-relative">
                          @if (!empty($category->short_text))
                              <p class="pl-200 mb-50">
                                  {{ $category->short_text }}
                              </p>
                          @endif

                          <div class="tp-service-4-process-thumb fix">
                              <div class="tp_img_reveal">
                                  <img src="{{ asset('assets/front/img/service_category_icons/' . ($category->second_image ?? 'default.jpg')) }}"
                                       alt="Process Image">
                              </div>
                          </div>

                          <!-- @if (!empty($category->video_link))
                              <div class="tp-service-4-process-video">
                                  <a class="popup-video dgm-testimonial-playbtn" href="{{ $category->video_link }}" target="_blank">
                                <span>
                                    <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M20 12L0.5 23.2583V0.74167L20 12Z" fill="currentcolor" />
                                    </svg>
                                </span>
                                  </a>
                              </div>
                          @endif -->
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- service process area end -->

      <!-- benefits area start -->
      <div class="tp-benefits-ptb pb-100">
          <div class="container container-1230">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="tp-benefits-heading tp_fade_anim" data-delay=".3">
                          <div class="tp-benefits-heading tp_fade_anim" data-delay=".3">
                            <div style="margin-left:15px;">
                                {!! $category->content !!}
                            </div>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- benefits area end -->

      <!-- features area start -->
      <div class="tp-service-5-features-ptb p-relative">
          <div class="container container-1550">
              <!-- <div class="tp-service-4-process-video service-5-pos">
                  <a class="popup-video dgm-testimonial-playbtn" href="{{ $category->video_link }}">
                      <span>{{ __('Play Video') }}</span>
                  </a>
              </div> -->
              <div class="row">
                  <div class="col-lg-12">
                      <div class="tp-service-5-feature-wrap p-relative">
                          <!-- add here video link iframe-->
                           @if (!empty($category->video_link))
                                {!! $category->video_link !!}
                           @endif

                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- features area end -->

      <!-- price area start -->
      <div class="app-price-area p-relative pb-130 mt-100">
          <div class="container container-1230">
              <div class="row">
                  <div class="col-lg-12">
                      <div class="tp-service-5-price-heading d-flex align-items-start tp_fade_anim pb-70">
                          <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                              <span class="tp-section-subtitle pre">{{ __('pricing plans') }}</span>
                              <div class="ar-about-us-4-icon">
                                  <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                      <rect y="4" width="80" height="1" fill="#111013" />
                                      <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                  </svg>
                              </div>
                          </div>
                          <h3 class="tp-career-title fs-60 pb-40">{{ __('Profitable') }} <br>
                              {{ __('pricing plans') }}</h3>
                      </div>
                  </div>
              </div>
              
              <div class="app-price-box app-price-inner-style">
                  <div class="row">
                      @foreach($packages as $key => $package)
                          <div class="col-xl-4 col-lg-6 col-md-6">
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
                                                          <a href="{{route('front.packageorder.index',$package->id)}}" class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Extend')}}</a>
                                                      @else
                                                          <a href="{{route('front.packageorder.index',$package->id)}}" class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Change')}}</a>
                                                      @endif
                                                  @elseif ($activeSub->count() == 0)
                                                      <a href="{{route('front.packageorder.index',$package->id)}}" class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                  @endif
                                              @endauth

                                              @guest
                                                  <a href="{{route('front.packageorder.index',$package->id)}}" class="{{ $key == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                              @endguest
                                          @else
                                              @if ($package->order_status != 0)
                                                  @php
                                                      if($package->order_status == 1) {
                                                          $link = route('front.packageorder.index', $package->id);
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
          </div>
      </div>
      <!-- price area end -->


  @else
      <!-- hero area start -->
      <div class="studio-hero-area p-relative fix pb-80">
          <div class="content z-index-2 d-none d-md-block">
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
              <div class="content__img">
                  <div class="content__img-inner" style="background-image:url({{ asset('front/assets/img/seo_Icon.png') }})"></div>
              </div>
          </div>
          <div class="container container-1830">
              <div class="studio-hero-bg">
                  <div class="row">
                      <div class="col-xl-12">
                          <div class="studio-hero-info z-index-5 d-flex justify-content-md-between justify-content-center align-items-center">
                              @php $mail = isset(explode(',', $bex->contact_mails)[0]) ? explode(',', $bex->contact_mails)[0] : ''; @endphp
                              @php $phone = isset(explode(',', $bex->contact_numbers)[0]) ? explode(',', $bex->contact_numbers)[0] : '' ; @endphp
                              <a class="text-black" href="mailto:{{ $mail }}">{{ $mail }}</a>
                              <span class="text-black">{{ __('Motion design Studio') }}</span>
                              <a class="text-black" href="tel:{{ $phone }}">{{ $phone }}</a>
                          </div>
                      </div>
                  </div>
                  <div class="row">
                      <div class="col-xl-12">
                          <div class="studio-hero-content text-center tp-text-perspective" data-delay=".5" data-fade-from="top" data-ease="bounce">
                              <h2 class="studio-hero-title fs-400">{{ __('All Services') }}</h2>
                          </div>
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- hero area end -->


      <!-- banner area start -->
      <div class="studio-hero-banner-area pb-100">
{{--          <div class="studio-hero-banner mb-20">--}}
{{--              <img class="w-100" data-speed=".8" src="{{ asset('front/assets/img/home-06/banner.jpg') }}" alt="">--}}
{{--          </div>--}}
          <div class="container container-1830">
              <div class="row">
                  <div class="col-xl-12">
                      <div class="studio-hero-banner-text d-flex justify-content-start justify-content-md-between align-items-center">
                          @php
                              $text = explode(' ', __('A collective of the best independent premium publishers'));
                          @endphp
                          @foreach($text as $word)
                                <span>{{ $word }}</span>
                          @endforeach
                      </div>
                  </div>
              </div>
          </div>
      </div>
      <!-- banner area end -->

      <!-- inner service area -->
      <div class="tp-inner-service-area pt-120 pb-120">
          <div class="container container-1830">
              <div class="row">
                  <div class="col-lg-3">
                      <div class="inner-service-1-left">
                          <span>{{ __('All Services') }}</span>
                          <ul>
                              @foreach($scategories as $scategory)
                                  <li>
                                      <a href="{{ route('front.services', $scategory->slug) }}">
                                          <span>{{ $loop->iteration }}. {{ $scategory->name }}</span>
                                      </a>
                                  </li>
                              @endforeach
                          </ul>
                      </div>
                  </div>
                  <div class="col-lg-9">
                      @foreach($scategories as $scategory)
                          <div class="tp-inner-service-item mb-200">
                              <div class="inner-service-1-right">
                                  <div class="row">
                                      <div class="col-xl-4">
                                          <div class="inner-service-1-number">
                                              <h1 class="purecounter" data-purecounter-duration=".2" data-purecounter-end="{{ $loop->iteration }}">0</h1>
                                          </div>
                                      </div>
                                      <div class="col-xl-8">
                                          <div class="inner-service-1-text">
                                              <span>{{ $scategory->name }}</span>
                                              <p>
                                                  {{ $scategory->short_text ?? __('This section explores a common challenge developers face such as cross-platform compatibility, performance optimization, and user experience.') }}
                                              </p>
                                              <a href="{{ route('front.services', $scategory->slug) }}" class="btn btn-sm btn-dark mt-3">
                                                  {{ __('Learn More') }} <i class="fa fa-arrow-right ms-1"></i>
                                              </a>

                                          </div>
                                          <div class="inner-service-1-category">
                                              @foreach($scategory->services as $service)
                                                  <a href="{{ route('front.servicedetails', $service->slug) }}" class="inner-service-1-category-item d-flex justify-content-between align-items-center">
                                                      <span>{{ $service->title }}</span>
                                                      <i>
                                                          <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                              <path d="M1 9L9 1M9 1H1M9 1V9" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                          </svg>
                                                      </i>
                                                  </a>
                                              @endforeach
                                         </div>
                                      </div>
                                  </div>
                              </div>
                              <div class="row gx-10">
                                  <div class="inner-service-1-thumb-text">
                                      <span>{{ __('(Our recent Digital work)') }}</span>
                                  </div>
                                  @foreach($scategory->portfolios->take(2) as $portfolio)
                                      <div class="col-xl-6">
                                          <div class="inner-service-1-thumb tp--hover-item">
                                              <div class=" tp--hover-img" data-displacement="{{ asset('assets/front/img/portfolios/featured/' . $portfolio->image) }}" data-intensity="0.6" data-speedin="1" data-speedout="1">
                                                  <img class="w-100" src="assets/img/inner-service/service-3.jpg" alt="">
                                              </div>
                                          </div>
                                      </div>
                                  @endforeach
                              </div>
                          </div>

                     @endforeach
                  </div>
              </div>
          </div>
      </div>
      <!-- inner service area -->

  @endif
@endsection
