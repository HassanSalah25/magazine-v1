@extends('front.default.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")


@section('content')
    <!--   hero area start   -->
    @if ($bs->home_version == 'static')
        @include('front.default.partials.static')
    @elseif ($bs->home_version == 'slider')
        @includeif('front.default.partials.slider')
    @elseif ($bs->home_version == 'video')
        @includeif('front.default.partials.video')
    @elseif ($bs->home_version == 'particles')
        @includeif('front.default.partials.particles')
    @elseif ($bs->home_version == 'water')
        @includeif('front.default.partials.water')
    @elseif ($bs->home_version == 'parallax')
        @includeif('front.default.partials.parallax')
    @endif
    <!--   hero area end    -->

    <!-- about area start -->
    <div class="dgm-about-area pt-120 pb-120">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-6">
                    <div class="dgm-about-thumb-wrap p-relative">
                        <img class="tp_fade_anim" data-delay=".3" data-fade-from="left" src="{{ asset('assets/front/img/' . $bs->intro_bg) }}" alt="about">
                        <img class="dgm-about-thumb-1 tp_fade_anim" data-speed="1.1" data-delay=".5" style="transform: translate(127px, 35px) !important;" src="{{ asset('assets/front/img/' . $be->intro_bg2) }}" alt="about">
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="dgm-about-right">
                        <div class="dgm-about-title-box z-index-1 mb-35">
                            <span class="tp-section-subtitle subtitle-black mb-15 tp_fade_anim" data-delay=".3">{{ __('About our Agency') }}</span>
                            <h4 class="tp-section-title-grotesk tp_fade_anim" data-delay=".5">
                                     <span class="p-relative">
                                            {!! convertUtf8($bs->intro_section_title ?? 'Welcome to our website') !!}
                                            <span class="tp-section-title-shape">
                                                <svg width="280" height="15" viewBox="0 0 280 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M157.643 0.463566C152.553 0.665187 132.813 1.06843 113.879 1.37086C64.4049 2.12693 43.5474 2.7822 26.6628 3.94151C13.5027 4.8488 1.02542 6.15933 0.342587 6.71379C0.218435 6.8146 0.094283 8.07472 0.0322071 9.48606C-0.0919446 11.7543 0.094283 12.1575 1.45995 12.964C2.32901 13.4681 3.50846 13.9721 4.00506 14.1233C4.87413 14.3753 38.5193 12.8632 46.527 12.2079C50.0654 11.9559 159.009 10.847 185.577 10.7966C195.137 10.7966 217.36 11.099 234.927 11.5023C252.495 11.9055 268.386 12.1575 270.186 12.1071C274.656 12.0063 278.629 10.2421 278.815 8.32675C278.877 7.16743 278.691 6.96581 277.263 6.91541C275.711 6.865 275.711 6.8146 277.636 6.46176C280.305 5.95771 280.615 5.65528 279.063 4.94961C277.573 4.29435 277.325 3.43746 278.691 3.43746C279.187 3.43746 279.622 3.18544 279.622 2.93341C279.622 2.63098 279.312 2.42936 278.877 2.42936C278.505 2.42936 276.891 1.92531 275.339 1.32045L272.483 0.211542L219.719 0.161136C190.729 0.110732 162.795 0.261946 157.643 0.463566ZM200.475 2.47977C200.848 2.68139 204.572 2.88301 208.855 2.88301C213.139 2.93341 221.209 3.13503 226.857 3.38706C235.858 3.7903 234.865 3.8407 218.788 3.63908C208.731 3.53827 192.281 3.43746 182.225 3.43746C172.169 3.43746 164.099 3.33665 164.223 3.23584C164.409 3.08463 171.3 2.93341 179.556 2.88301C187.812 2.7822 194.888 2.58058 195.323 2.32855C196.254 1.87491 199.544 1.92531 200.475 2.47977ZM264.538 3.28625C263.296 3.38706 261.31 3.38706 260.192 3.28625C259.137 3.18544 260.192 3.08463 262.551 3.08463C264.972 3.08463 265.841 3.18544 264.538 3.28625ZM128.095 3.63908C127.971 3.73989 113.631 3.89111 96.1877 3.99192C78.8065 4.14313 68.8744 4.09273 74.1508 3.94151C85.2624 3.58868 128.467 3.33665 128.095 3.63908ZM159.009 3.73989C158.822 3.89111 158.264 3.94151 157.829 3.7903C157.332 3.63908 157.519 3.48787 158.202 3.48787C158.884 3.43746 159.257 3.58868 159.009 3.73989ZM268.759 7.01622C269.193 7.36905 267.393 7.46986 263.172 7.41946C259.758 7.31865 247.591 7.31865 236.169 7.36905C224.747 7.41946 213.822 7.36905 211.959 7.26824C206.435 6.91541 176.576 6.865 154.229 7.11703C131.261 7.41946 129.833 7.16743 150.815 6.51217C169.624 5.90731 267.952 6.36095 268.759 7.01622ZM118.845 7.52027C100.099 7.92351 80.7929 7.92351 85.3245 7.46986C87.1867 7.26824 98.7949 7.11703 111.086 7.11703C132.999 7.16743 133.185 7.16743 118.845 7.52027ZM200.786 7.97391C200.786 8.22594 200.351 8.32675 199.854 8.17553C199.358 7.97391 198.923 7.77229 198.923 7.67148C198.923 7.57067 199.358 7.46986 199.854 7.46986C200.351 7.46986 200.786 7.67148 200.786 7.97391ZM202.648 7.97391C202.648 8.22594 202.338 8.47796 201.965 8.47796C201.655 8.47796 201.531 8.22594 201.717 7.97391C201.903 7.67148 202.213 7.46986 202.4 7.46986C202.524 7.46986 202.648 7.67148 202.648 7.97391ZM207.304 7.97391C207.49 8.22594 207.242 8.47796 206.745 8.47796C206.186 8.47796 205.752 8.22594 205.752 7.97391C205.752 7.67148 206 7.46986 206.31 7.46986C206.683 7.46986 207.117 7.67148 207.304 7.97391ZM266.276 8.47796C267.393 8.8812 267.393 8.93161 265.965 8.8812C265.096 8.8812 263.606 8.67958 262.551 8.47796L260.689 8.07472H262.862C264.041 8.07472 265.593 8.22594 266.276 8.47796ZM122.694 8.8308C113.383 8.93161 98.2983 8.93161 89.1732 8.8308C80.048 8.78039 87.6833 8.72999 106.12 8.72999C124.556 8.72999 132.006 8.78039 122.694 8.8308ZM5.86734 10.4942C5.86734 10.7462 4.9362 10.9982 3.88091 10.9478C2.14279 10.9478 2.01864 10.847 3.07393 10.4942C4.81205 9.8893 5.86734 9.8893 5.86734 10.4942ZM15.7374 10.1917C15.6133 10.2925 13.3785 10.4942 10.8334 10.6454C7.79169 10.847 6.4881 10.7966 7.10886 10.4942C7.97792 10.0405 16.3582 9.73809 15.7374 10.1917ZM258.392 11.351C257.461 11.4519 255.785 11.4519 254.667 11.351C253.55 11.2502 254.295 11.1494 256.344 11.1494C258.392 11.1494 259.323 11.2502 258.392 11.351Z" fill="url(#paint0_linear_5012_164)" />
                                                    <defs>
                                                        <linearGradient id="paint0_linear_5012_164" x1="53.5" y1="18.1094" x2="56.4335" y2="31.6184" gradientUnits="userSpaceOnUse">
                                                            <stop offset="1" stop-color="#00a651" />
                                                            <stop offset="1" stop-color="#F7EF33" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                            </span>
                                        </span>
                            </h4>
                        </div>

                        <div class="dgm-about-content">
                            <div class="tp_fade_anim" data-delay=".3">
                                <p>{{ convertUtf8($bs->intro_section_text) }}</p>
                            </div>

                            @if (!empty($bs->intro_section_button_url) && !empty($bs->intro_section_button_text))
                                <div class="tp_fade_anim" data-delay=".5">
                                    <a class="tp-btn-yellow-green green-solid btn-60 mb-50" href="{{ $bs->intro_section_button_url }}" target="_blank">
                  <span>
                    <span class="text-1">{{ convertUtf8($bs->intro_section_button_text) }}</span>
                    <span class="text-2">{{ convertUtf8($bs->intro_section_button_text) }}</span>
                  </span>
                                        <i>
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 11L11 1M11 1H1M11 1V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                            <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 11L11 1M11 1H1M11 1V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </i>
                                    </a>
                                </div>
                            @endif
                            <div class="dgm-about-review-wrap tp_fade_anim" data-delay=".6">
                                <div class="dgm-about-review-box d-inline-flex align-items-center">
                                    <div class="dgm-about-review">
                                        <h4>{{ __('4.9') }}</h4>
                                        <span>(24  {{ __('review') }} )</span>
                                    </div>
                                    <div class="dgm-about-ratting">
                                        <h4>{{ __('Average Rating') }}</h4>
                                        <div class="dgm-about-ratting-icon">
                                            @for ($i = 0; $i < 5; $i++)
                                                <span>
                        <svg width="14" height="13" viewBox="0 0 14 13" fill="none" xmlns="http://www.w3.org/2000/svg">
                          <path d="M6.99993 0L8.98311 4.27038L13.6573 4.83688L10.2088 8.04262L11.1144 12.6631L6.99993 10.374L2.88543 12.6631L3.79106 8.04262L0.342529 4.83688L5.01674 4.27038L6.99993 0Z" fill="currentcolor" />
                        </svg>
                      </span>
                                            @endfor
                                        </div>
                                    </div>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->

    <!-- step area start -->
    @if ($bs->approach_section == 1)
        <div class="dgm-step-area pb-50">
            <div class="container container-1230">
                <div class="row align-items-end">
                    <!-- Left Title/CTA -->
                    <div class="col-xl-3 col-lg-4 col-md-6">
                        <div class="dgm-step-item p-relative dgm-step-space-1 mb-80">
                            <h4 class="dgm-step-title mb-25">{!! convertUtf8($bs->approach_title) !!}</h4>
                            @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                                <a class="tp-btn-yellow-green green-solid" href="{{ $bs->approach_button_url }}" target="_blank">
                                    <i>
                                        <!-- SVG icon -->
                                    </i>
                                    <span>
                                      <span class="text-1">{{ convertUtf8($bs->approach_button_text) }}</span>
                                      <span class="text-2">{{ convertUtf8($bs->approach_button_text) }}</span>
                                    </span>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right Steps -->
                    @foreach ($points as $key => $point)
                        <div class="col-xl-3 col-lg-4 col-md-6">
                            <div class="dgm-step-item p-relative dgm-step-space-1 mb-80">

                                <span class="dgm-step-number">0{{ $point->serial_number }}</span>
                                <h4 class="dgm-step-title-sm">{{ convertUtf8($point->title) }}</h4>
                                <p>
                                    @if (strlen($point->short_text) > 150)
                                        {{ mb_substr($point->short_text, 0, 150, 'utf-8') }}
                                        <span style="display:none;">{{ mb_substr($point->short_text, 150, null, 'utf-8') }}</span>
                                        <a href="#" class="see-more">{{ __('see more') }}...</a>
                                    @else
                                        {{ $point->short_text }}
                                    @endif
                                </p>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- step area end -->

    <!-- How We Do It section start -->
    {!! howWeDoItSection($currentLang, 'default') !!}
    <!-- How We Do It section end -->



    <!-- service area start -->
    @if ($bs->service_section == 1)
        <div class="dgm-service-area dgm-service-radius pt-120 black-bg-5 z-index-1">
            <div class="container container-1230">
                <div class="row">
                    <div class="col-xl-7">
                        <div class="dgm-service-title-box z-index-1 mb-60">
          <span class="tp-section-subtitle subtitle-grey mb-15 text-white tp_fade_anim" data-delay=".3">
            {{ convertUtf8($bs->service_section_title) }}
          </span>
                            <h4 class="tp-section-title-grotesk text-white tp_fade_anim" data-delay=".5">
                                <span class="p-relative">
                                {!! convertUtf8($bs->service_section_subtitle) !!}

                                            <span class="tp-section-title-shape">
                                                <svg width="231" height="15" viewBox="0 0 231 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M130.373 0.9726C126.192 1.17422 109.977 1.57746 94.4246 1.87989C53.7849 2.63597 36.6519 3.29123 22.7824 4.45055C11.9723 5.35784 1.72317 6.66837 1.16227 7.22282C1.06029 7.32363 0.958306 8.58376 0.907315 9.9951C0.805333 12.2633 0.958306 12.6666 2.08011 13.473C2.79398 13.9771 3.76281 14.4811 4.17073 14.6324C4.88461 14.8844 32.5217 13.3722 39.0995 12.717C42.006 12.4649 131.495 11.356 153.319 11.3056C161.172 11.3056 179.426 11.6081 193.857 12.0113C208.287 12.4145 221.341 12.6666 222.82 12.6162C226.491 12.5153 229.755 10.7512 229.907 8.83578C229.958 7.67647 229.805 7.47485 228.633 7.42444C227.358 7.37404 227.358 7.32363 228.939 6.9708C231.131 6.46675 231.386 6.16432 230.111 5.45865C228.888 4.80338 228.684 3.9465 229.805 3.9465C230.213 3.9465 230.57 3.69447 230.57 3.44245C230.57 3.14002 230.315 2.9384 229.958 2.9384C229.653 2.9384 228.327 2.43435 227.052 1.82949L224.706 0.720575L181.364 0.670169C157.551 0.619765 134.605 0.77098 130.373 0.9726ZM165.557 2.9888C165.863 3.19042 168.922 3.39204 172.441 3.39204C175.959 3.44245 182.588 3.64407 187.228 3.89609C194.622 4.29933 193.806 4.34974 180.599 4.14812C172.339 4.04731 158.826 3.9465 150.566 3.9465C142.305 3.9465 135.676 3.84569 135.778 3.74488C135.931 3.59366 141.591 3.44245 148.373 3.39204C155.155 3.29123 160.968 3.08961 161.325 2.83759C162.09 2.38394 164.792 2.43435 165.557 2.9888ZM218.18 3.79528C217.16 3.89609 215.528 3.89609 214.61 3.79528C213.743 3.69447 214.61 3.59366 216.548 3.59366C218.537 3.59366 219.25 3.69447 218.18 3.79528ZM106.102 4.14812C106 4.24893 94.2207 4.40014 79.8922 4.50095C65.6148 4.65217 57.4562 4.60176 61.7905 4.45055C70.9178 4.09771 106.407 3.84569 106.102 4.14812ZM131.495 4.24893C131.342 4.40014 130.883 4.45055 130.526 4.29933C130.118 4.14812 130.271 3.9969 130.832 3.9969C131.393 3.9465 131.699 4.09771 131.495 4.24893ZM221.647 7.52525C222.004 7.87809 220.525 7.9789 217.058 7.92849C214.253 7.82768 204.259 7.82768 194.877 7.87809C185.494 7.92849 176.52 7.87809 174.99 7.77728C170.452 7.42444 145.925 7.37404 127.569 7.62606C108.702 7.92849 107.529 7.67647 124.764 7.0212C140.214 6.41634 220.984 6.86999 221.647 7.52525ZM98.5039 8.0293C83.1047 8.43254 67.2465 8.43254 70.9688 7.9789C72.4985 7.77728 82.0338 7.62606 92.13 7.62606C110.13 7.67647 110.283 7.67647 98.5039 8.0293ZM165.812 8.48295C165.812 8.73497 165.455 8.83578 165.047 8.68457C164.639 8.48295 164.282 8.28133 164.282 8.18052C164.282 8.07971 164.639 7.9789 165.047 7.9789C165.455 7.9789 165.812 8.18052 165.812 8.48295ZM167.342 8.48295C167.342 8.73497 167.087 8.987 166.781 8.987C166.526 8.987 166.424 8.73497 166.577 8.48295C166.73 8.18052 166.985 7.9789 167.138 7.9789C167.24 7.9789 167.342 8.18052 167.342 8.48295ZM171.166 8.48295C171.319 8.73497 171.115 8.987 170.707 8.987C170.248 8.987 169.891 8.73497 169.891 8.48295C169.891 8.18052 170.095 7.9789 170.35 7.9789C170.656 7.9789 171.013 8.18052 171.166 8.48295ZM219.607 8.987C220.525 9.39024 220.525 9.44064 219.352 9.39024C218.638 9.39024 217.415 9.18862 216.548 8.987L215.018 8.58376H216.803C217.772 8.58376 219.046 8.73497 219.607 8.987ZM101.665 9.33983C94.0167 9.44064 81.6259 9.44064 74.1303 9.33983C66.6346 9.28943 72.9065 9.23902 88.0508 9.23902C103.195 9.23902 109.314 9.28943 101.665 9.33983ZM5.70046 11.0032C5.70046 11.2552 4.9356 11.5072 4.06875 11.4568C2.64101 11.4568 2.53902 11.356 3.40587 11.0032C4.83361 10.3983 5.70046 10.3983 5.70046 11.0032ZM13.808 10.7008C13.706 10.8016 11.8704 11.0032 9.77973 11.1544C7.28118 11.356 6.21037 11.3056 6.72028 11.0032C7.43415 10.5496 14.3179 10.2471 13.808 10.7008ZM213.131 11.8601C212.367 11.9609 210.99 11.9609 210.072 11.8601C209.154 11.7593 209.766 11.6585 211.449 11.6585C213.131 11.6585 213.896 11.7593 213.131 11.8601Z" fill="url(#paint0_linear_5012_165)" />
                                                    <defs>
                                                        <linearGradient id="paint0_linear_5012_165" x1="44.8273" y1="18.6184" x2="48.3226" y2="31.8404" gradientUnits="userSpaceOnUse">
                                                            <stop offset="1" stop-color="#00a651" />
                                                            <stop offset="1" stop-color="#F7EF33" />
                                                        </linearGradient>
                                                    </defs>
                                                </svg>
                                            </span>
                                        </span>
                            </h4>
                            <p class="dsic text-white">
                                {{ convertUtf8($bs->service_section_text ?? '') }}
                            </p>
                            @if (!empty($bs->service_section_button_url) && !empty($bs->service_section_button_text))
                                <a href="{{ $bs->service_section_button_url }}" class="tp-btn-yellow-green green-solid" target="_blank">
                                    <span class="text-1">{{ convertUtf8($bs->service_section_button_text) }}</span>
                                    <span class="text-2">{{ convertUtf8($bs->service_section_button_text) }}</span>
                                </a>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="dgm-service-wrap"   >
                    <div class="row">
                        <div class="col-xl-12">
                            @if (!serviceCategory())
                                @foreach ($services as $key => $service)
                                    <div class="dgm-service-item p-relative tp_fade_anim">
                                        <div class="dgm-service-bg">
                                            <img src="{{ asset('front/assets/img/home-03/service/service-bg.jpg') }}" alt="">
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-lg-5">
                                                <div class="dgm-service-content-left d-inline-flex align-items-center">
                                                    <span>0{{ $service->serial_number ?? $loop->iteration }}</span>
                                                    <h4 class="dgm-service-title-sm">
                                                        <a @if($service->details_page_status == 1) href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}" @else href="#" @endif>
                                                            {{ convertUtf8($service->title) }}
                                                        </a>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="dgm-service-content-right d-flex align-items-center justify-content-between">
                                                    <p>{{ Str::limit($service->summary, 150) }}</p>
                                                    <a class="dgm-service-link" href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">
                                                     <span>
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.880859 13L12.8809 1M12.8809 1H0.880859M12.8809 1V13" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                            <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                                <path d="M0.880859 13L12.8809 1M12.8809 1H0.880859M12.8809 1V13" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                            </svg>
                                                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @else
                                @foreach ($scategories as $scategory)
                                    <div class="dgm-service-item p-relative tp_fade_anim">
                                        <div class="dgm-service-bg">
                                            <img src="{{ asset('front/assets/img/home-03/service/service-bg.jpg') }}" alt="">
                                        </div>
                                        <div class="row align-items-center">
                                            <div class="col-lg-5">
                                                <div class="dgm-service-content-left d-inline-flex align-items-center">
                                                    <span>0{{ $loop->iteration }}</span>
                                                    <h4 class="dgm-service-title-sm">
                                                        <a href="{{ route('front.services', $scategory->slug) }}">{{ convertUtf8($scategory->name) }}</a>
                                                    </h4>
                                                </div>
                                            </div>
                                            <div class="col-lg-7">
                                                <div class="dgm-service-content-right d-flex align-items-center justify-content-between">
                                                    <p>{{ Str::limit($scategory->short_text, 150) }}</p>
                                                    <a class="dgm-service-link" href="{{ route('front.services', $scategory->slug) }}">
                        <span>
                          <!-- Double arrow icon -->
                          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.880859 13L12.8809 1M12.8809 1H0.880859M12.8809 1V13" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                          <svg width="14" height="14" viewBox="0 0 14 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                            <path d="M0.880859 13L12.8809 1M12.8809 1H0.880859M12.8809 1V13" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                          </svg>
                        </span>
                                                    </a>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- service area end -->

    <!-- comparison section start -->
    @if ($bex->comparison_section == 1)
        {!! comparisonSection($currentLang) !!}
    @endif
    <!-- comparison section end -->

    <!-- partner section start -->
    @if ($bs->partner_section == 1)
        <div class="tp-brand-area black-bg-5 pt-160 pb-200">
            <div class="tp-brand-wrapper green-regular-bg z-index-1">
                <div class="swiper-container tp-brand-active fix">
                    <div class="swiper-wrapper slide-transtion">
                        @foreach ($partners as $partner)
                            <div class="swiper-slide">
                                <div class="tp-brand-item" style="max-width: 100px;">
                                    <a href="{{ $partner->url }}" target="_blank">
                                        <img class="lazy" data-src="{{ asset('assets/front/img/partners/' . $partner->image) }}" alt="brand">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <div class="tp-brand-wrapper tp-brand-style-2 black-bg-6">
                <div class="swiper-container tp-brand-active fix" dir="rtl">
                    <div class="swiper-wrapper slide-transtion">
                        @foreach ($partners as $partner)
                            <div class="swiper-slide">
                                <div class="tp-brand-item" style="max-width: 100px;">
                                    <a href="{{ $partner->url }}" target="_blank">
                                        <img class="lazy" data-src="{{ asset('assets/front/img/partners/' . $partner->image) }}" alt="brand">
                                    </a>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- partner section end -->

    

    <!-- portfolio section start -->
    @if ($bs->portfolio_section == 1)
        <div class="dgm-project-area black-bg-5 pb-120 fix">
            <div class="container container-1330">
                <div class="dgm-project-top-wrap">
                    <div class="row align-items-end">
                        <div class="col-xl-4 col-lg-6">
                            <div class="dgm-project-title-box z-index-1 mb-30">
                                <h4 class="tp-section-title-grotesk text-white mb-0 tp_fade_anim">

                                    <span class="p-relative">
              {{ convertUtf8($bs->portfolio_section_title) }}
                  <span class="tp-section-title-shape d-none d-md-block">
                                                    <svg width="140" height="15" viewBox="0 0 140 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                        <path d="M78.8214 0.790959C76.2763 0.992579 66.4063 1.39582 56.9397 1.69825C32.2025 2.45433 21.7737 3.10959 13.3314 4.26891C6.75134 5.1762 0.512711 6.48673 0.171293 7.04118C0.109217 7.14199 0.0471415 8.40212 0.0161036 9.81346C-0.0459723 12.0817 0.0471415 12.4849 0.729976 13.2914C1.16451 13.7955 1.75423 14.2995 2.00253 14.4507C2.43706 14.7027 19.2596 13.1906 23.2635 12.5353C25.0327 12.2833 79.5043 11.1744 92.7885 11.124C97.5684 11.124 108.68 11.4264 117.464 11.8297C126.247 12.2329 134.193 12.4849 135.093 12.4345C137.328 12.3337 139.314 10.5695 139.408 8.65414C139.439 7.49482 139.345 7.29321 138.632 7.2428C137.856 7.1924 137.856 7.14199 138.818 6.78916C140.152 6.28511 140.308 5.98268 139.532 5.277C138.787 4.62174 138.663 3.76486 139.345 3.76486C139.594 3.76486 139.811 3.51283 139.811 3.2608C139.811 2.95837 139.656 2.75675 139.439 2.75675C139.252 2.75675 138.445 2.25271 137.669 1.64784L136.242 0.538934L109.859 0.488529C95.3647 0.438124 81.3976 0.589339 78.8214 0.790959ZM100.238 2.80716C100.424 3.00878 102.286 3.2104 104.428 3.2104C106.569 3.2608 110.604 3.46242 113.429 3.71445C117.929 4.11769 117.433 4.1681 109.394 3.96648C104.366 3.86567 96.1406 3.76486 91.1125 3.76486C86.0843 3.76486 82.0494 3.66405 82.1115 3.56324C82.2046 3.41202 85.6498 3.2608 89.7778 3.2104C93.9059 3.10959 97.4442 2.90797 97.6615 2.65594C98.127 2.2023 99.772 2.25271 100.238 2.80716ZM132.269 3.61364C131.648 3.71445 130.655 3.71445 130.096 3.61364C129.568 3.51283 130.096 3.41202 131.276 3.41202C132.486 3.41202 132.921 3.51283 132.269 3.61364ZM64.0474 3.96648C63.9853 4.06729 56.8155 4.2185 48.0939 4.31931C39.4033 4.47053 34.4372 4.42012 37.0754 4.26891C42.6312 3.91607 64.2336 3.66405 64.0474 3.96648ZM79.5043 4.06729C79.4112 4.2185 79.1318 4.26891 78.9146 4.11769C78.6662 3.96648 78.7594 3.81526 79.1008 3.81526C79.4422 3.76486 79.6284 3.91607 79.5043 4.06729ZM134.379 7.34361C134.597 7.69645 133.697 7.79726 131.586 7.74685C129.879 7.64604 123.795 7.64604 118.084 7.69645C112.373 7.74685 106.911 7.69645 105.98 7.59564C103.217 7.2428 88.288 7.1924 77.1143 7.44442C65.6303 7.74685 64.9164 7.49483 75.4073 6.83956C84.8118 6.2347 133.976 6.68835 134.379 7.34361ZM59.4227 7.84766C50.0493 8.2509 40.3965 8.2509 42.6622 7.79726C43.5934 7.59564 49.3975 7.44442 55.543 7.44442C66.4994 7.49483 66.5925 7.49483 59.4227 7.84766ZM100.393 8.30131C100.393 8.55333 100.176 8.65414 99.9272 8.50293C99.6789 8.30131 99.4617 8.09969 99.4617 7.99888C99.4617 7.89807 99.6789 7.79726 99.9272 7.79726C100.176 7.79726 100.393 7.99888 100.393 8.30131ZM101.324 8.30131C101.324 8.55333 101.169 8.80536 100.983 8.80536C100.827 8.80536 100.765 8.55333 100.858 8.30131C100.951 7.99888 101.107 7.79726 101.2 7.79726C101.262 7.79726 101.324 7.99888 101.324 8.30131ZM103.652 8.30131C103.745 8.55333 103.621 8.80536 103.372 8.80536C103.093 8.80536 102.876 8.55333 102.876 8.30131C102.876 7.99888 103 7.79726 103.155 7.79726C103.341 7.79726 103.559 7.99888 103.652 8.30131ZM133.138 8.80536C133.697 9.2086 133.697 9.259 132.983 9.2086C132.548 9.2086 131.803 9.00698 131.276 8.80536L130.344 8.40212H131.431C132.02 8.40212 132.796 8.55333 133.138 8.80536ZM61.3471 9.15819C56.6914 9.259 49.1492 9.259 44.5866 9.15819C40.024 9.10779 43.8417 9.05738 53.0599 9.05738C62.2782 9.05738 66.0028 9.10779 61.3471 9.15819ZM2.93367 10.8216C2.93367 11.0736 2.4681 11.3256 1.94046 11.2752C1.07139 11.2752 1.00932 11.1744 1.53696 10.8216C2.40602 10.2167 2.93367 10.2167 2.93367 10.8216ZM7.8687 10.5191C7.80663 10.6199 6.68926 10.8216 5.41671 10.9728C3.89585 11.1744 3.24405 11.124 3.55443 10.8216C3.98896 10.3679 8.17908 10.0655 7.8687 10.5191ZM129.196 11.6784C128.73 11.7793 127.892 11.7793 127.334 11.6784C126.775 11.5776 127.148 11.4768 128.172 11.4768C129.196 11.4768 129.662 11.5776 129.196 11.6784Z" fill="url(#paint0_linear_5013_167)" />
                                                        <defs>
                                                            <linearGradient id="paint0_linear_5013_167" x1="26.75" y1="18.4368" x2="31.9187" y2="30.338" gradientUnits="userSpaceOnUse">
                                                                <stop offset="1" stop-color="#00a651" />
                                                                <stop offset="1" stop-color="#F7EF33" />
                                                            </linearGradient>
                                                        </defs>
                                                    </svg>
                                                </span>
              </span>
                                </h4>
                            </div>
                        </div>
                        <div class="col-xl-6 col-lg-6">
                            <div class="dgm-project-top-text mb-30 tp_fade_anim">
                                <p>{{ convertUtf8($bs->portfolio_section_text) }}</p>
                            </div>
                        </div>
                        <div class="col-xl-2 col-lg-6">
                            <div class="dgm-project-arrow text-start text-xl-end z-index-1 mb-30 tp_fade_anim">
                                <button class="dgm-project-prev">
              <span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M15.0711 7.92898H0.928955M0.928955 7.92898L8.00002 15M0.928955 7.92898L8.00002 0.85791" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
                                </button>
                                <button class="dgm-project-next">
              <span>
                <svg width="16" height="16" viewBox="0 0 16 16" fill="none" xmlns="http://www.w3.org/2000/svg">
                  <path d="M0.928955 8.00002H15.0711M15.0711 8.00002L8.00002 0.928955M15.0711 8.00002L8.00002 15.0711" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                </svg>
              </span>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="dgm-project-slider-wrap">
                <div class="swiper-container dgm-project-active">
                    <div class="swiper-wrapper">
                        @foreach ($portfolios as $portfolio)
                            <div class="swiper-slide">
                                <div class="dgm-project-item">
                                    <div class="dgm-project-thumb">
                                        <a href="{{ route('front.portfoliodetails', [$portfolio->slug, $portfolio->id]) }}">
                                            <img src="{{ asset('assets/front/img/portfolios/featured/' . $portfolio->featured_image) }}" alt="{{ $portfolio->title }}">
                                        </a>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
                <div class="swiper-container dgm-project-text-active fix mt-55">
                    <div class="swiper-wrapper">
                        @foreach ($portfolios as $portfolio)
                            <div class="swiper-slide">
                                <div class="dgm-project-item">
                                    <div class="dgm-project-content text-center">
                                        <h4 class="dgm-project-title-sm">
                                            <a class="tp-line-white" href="{{ route('front.portfoliodetails', [$portfolio->slug, $portfolio->id]) }}">
                                                {{ strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title }}
                                            </a>
                                        </h4>
                                        @if (!empty($portfolio->service))
                                            <h5><span>{{ $portfolio->service->title }}</span></h5>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- portfolio section end -->

    <!-- testimonial area start -->
    @if ($bs->testimonial_section == 1)
        <div class="dgm-testimonial-area dgm-testimonial-radius dgm-testimonial-space grey-bg-2 pt-120 pb-120 p-relative">
            <div class="dgm-testimonial-bg" data-background="{{ asset('front/assets/img/home-03/testimonial/test-bg-shape.jpg') }}"></div>
            <div class="dgm-testimonial-thumb">
                <div class="anim-zoomin-wrap">
                    <img class="anim-zoomin" src="{{ $bex->testimonial_section_image ? asset('assets/front/img/testimonials/' . $bex->testimonial_section_image) : asset('front/assets/img/home-03/testimonial/test-bg.jpg') }}" alt="">
                </div>
                <!-- <a class="popup-video dgm-testimonial-playbtn" href="{{ $bs->hero_section_video_link }}">
      <span>
        <svg width="20" height="24" viewBox="0 0 20 24" fill="none" xmlns="http://www.w3.org/2000/svg">
          <path d="M20 12L0.5 23.2583V0.74167L20 12Z" fill="currentcolor" />
        </svg>
      </span>
                </a> -->
            </div>
            <div class="container-fluid">
                <div class="row justify-content-center">
                    <div class="offset-xl-6 col-xl-6 col-lg-8 col-md-9">
                        <div class="dgm-testimonial-title-box text-center z-index-1 mb-45">
          <span class="tp-section-subtitle subtitle-grey mb-15 tp_fade_anim" data-delay=".3">
            {{ convertUtf8($bs->testimonial_title) }}
          </span>
                            <h4 class="tp-section-title-grotesk tp_fade_anim" data-delay=".5">
                                {{ convertUtf8($bs->testimonial_subtitle) }}
                                <br>

                            </h4>
                        </div>
                        <div class="dgm-testimonial-slider-wrap z-index-1">
                            <div class="siwper-container dgm-testimonial-active fix">
                                <div class="swiper-wrapper">
                                    @foreach ($testimonials as $testimonial)
                                        <div class="swiper-slide">
                                            <div class="dgm-testimonial-slider-item text-center">
                                                <div class="dgm-testimonial-quote">
                                            <span>
                                              <svg width="40" height="32" viewBox="0 0 40 32" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M15.417 2.25185V11.4963C15.417 13.6296 14.4936 16.079 12.6467 18.8444L4.33602 30.8148C3.77395 31.6049 3.01113 32 2.04757 32C0.682522 32 0 31.2099 0 29.6296V2.37037C0 0.790124 0.802967 0 2.4089 0H13.1285C14.6542 0 15.417 0.750615 15.417 2.25185Z" fill="currentcolor" />
                                                <path d="M40 2.25185V11.4963C40 13.6296 39.0766 16.079 37.2298 18.8444L28.919 30.8148C28.357 31.6049 27.5942 32 26.6306 32C25.2656 32 24.583 31.2099 24.583 29.6296V2.37037C24.583 0.790124 25.386 0 26.9919 0H37.7115C39.2372 0 40 0.750615 40 2.25185Z" fill="currentcolor" />
                                              </svg>
                                            </span>
                                                </div>
                                                <div class="dgm-testimonial-text">
                                                    <p>
                                                        {{ convertUtf8($testimonial->comment) }}
                                                    </p>
                                                </div>
                                                <div class="dgm-testimonial-author-wrap d-flex align-items-center justify-content-center">
                                                    <div class="dgm-testimonial-author p-relative">
                                                        <img class="dgm-testimonial-author-img" src="{{ asset('assets/front/img/testimonials/' . $testimonial->image) }}" alt="{{ convertUtf8($testimonial->name) }}">
                                                        <img class="dgm-testimonial-author-logo" src="{{ asset('front/assets/img/home-03/testimonial/testi-logo.png') }}" alt="">
                                                    </div>
                                                    <div class="dgm-testimonial-author-info">
                                                        <h4 class="dgm-testimonial-author-name">{{ convertUtf8($testimonial->name) }}</h4>
                                                        <span>{{ convertUtf8($testimonial->rank) }}</span>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    @endforeach
                                </div>
                                <div class="dgm-testimonial-dot text-center"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    <!-- testimonial area end -->


    <!-- blog area start -->
    @if ($bs->news_section == 1)
        <div class="dgm-blog-area pt-120 pb-120">
            <div class="container container-1330">
                <div class="dgm-blog-title-wrap mb-60">
                    <div class="row align-items-end">
                        <div class="col-lg-6 col-md-8">
                            <div class="dgm-blog-title-box">
                                <h4 class="tp-section-title-grotesk tp_fade_anim" data-delay=".3">
                                    {{ convertUtf8($bs->blog_section_title) }} <br>
                                    <span>{{ convertUtf8($bs->blog_section_subtitle) }}</span>
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-6 col-md-4">
                            <div class="dgm-blog-btn text-start text-lg-end tp_fade_anim" data-delay=".3">
                                <a class="tp-btn-yellow-green green-solid btn-60" href="{{ route('front.blogs') }}">
                            <span>
                                <span class="text-1">{{ __('Read all posts') }}</span>
                                <span class="text-2">{{ __('Read all posts') }}</span>
                            </span>
                                    <i>
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="dgm-blog-main">
                    @foreach ($blogs->take(2) as $blog)
                        @php
                            $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale($currentLang->code)->translatedFormat('F j, Y');
                        @endphp
                        <div class="dgm-blog-item tp_fade_anim">
                            <div class="row">
                                <div class="col-xl-7 col-lg-8">
                                    <div class="dgm-blog-content-wrap d-flex">
                                        <div class="dgm-blog-content d-flex flex-column justify-content-between">
                                            <div class="dgm-blog-meta mb-30">
                                                <h4>{{ convertUtf8($blog->author ?? 'Admin') }}</h4>
                                                <span>{{ $blogDate }}</span>
                                            </div>
                                            <div class="dgm-blog-category">
                                                <span>{{ $blog->category->name ?? 'Blog' }}</span>
                                            </div>
                                        </div>
                                        <div class="dgm-blog-title-box">
                                            <h4 class="dgm-blog-title-sm">
                                                <a class="tp-line-black" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                    {{ strlen($blog->title) > 60 ? mb_substr($blog->title, 0, 60, 'utf-8') . '...' : $blog->title }}
                                                </a>
                                            </h4>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-xl-3 offset-xl-2 col-lg-4">
                                    <div class="dgm-blog-thumb-wrap text-start text-lg-end">
                                        <div class="dgm-blog-thumb">
                                            <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                <img src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}">
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @endif
    <!-- blog area end -->



  <!-- Home-only Package Categories Section -->
  @if(isset($homePackageCategories) && count($homePackageCategories) > 0)
  <div class="home-package-categories-section pt-120 pb-120">
      <div class="container container-1230">
          <div class="row">
              <div class="col-lg-12">
                  <div class="ar-hero-title-box tp_fade_anim mb-80" data-delay=".3">
                      <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                          <span class="tp-section-subtitle pre tp_fade_anim">{{__('Special Offers')}}</span>
                          <div class="ar-about-us-4-icon">
                              <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                  <rect y="4" width="80" height="1" fill="#111013" />
                                  <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                              </svg>
                          </div>
                      </div>
                      <h3 class="tp-career-title pb-30">{{__('Exclusive Packages')}} <span class="shape-1"><img src="assets/img/about-us/about-us-4/about-us-4-shape-1.png" alt=""></span></h3>
                  </div>
              </div>
          </div>
          
          <div class="app-price-box app-price-inner-style">
              @if($bex->package_banner_image)
                  <div class="package-banner-image mb-50">
                      <img src="{{ asset($bex->package_banner_image) }}" alt="Package Banner" class="img-fluid w-100" style="border-radius: 10px;">
                  </div>
              @endif
              <div class="row">
                  @foreach($homePackageCategories as $key => $category)
                      @php
                          $categoryPackages = $category->packageList()->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
                      @endphp
                      @if($categoryPackages->count() > 0)
                          <div class="col-xl-12 mb-50">
                              <div class="home-category-section">
                                  <!-- <h4 class="category-title mb-30">{{$category->name}}</h4> -->
                                  <div class="row">
                                      @foreach($categoryPackages as $packageKey => $package)
                                          <div class="col-xl-4 col-lg-6 col-md-6">
                                              <div class="crp-price-item {{ $packageKey == 1 ? 'active' : '' }}">
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
                                                      <div class="animated-border-box {{ $packageKey == 1 ? 'radius-style-2' : '' }} w-100">
                                                          @if ($bex->recurring_billing == 1)
                                                              @auth
                                                                  @if ($activeSub->count() > 0 && empty($activeSub->first()->next_package_id))
                                                                      @if ($activeSub->first()->current_package_id == $package->id)
                                                                          <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $packageKey == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Extend')}}</a>
                                                                      @else
                                                                          <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $packageKey == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Change')}}</a>
                                                                      @endif
                                                                  @elseif ($activeSub->count() == 0)
                                                                      <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $packageKey == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
                                                                  @endif
                                                              @endauth

                                                              @guest
                                                                  <a href="#" data-package-id="{{$package->id}}" class="js-purchase-package {{ $packageKey == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Purchase')}}</a>
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
                                                                  <a href="{{ $link }}" @if($package->order_status == 2) target="_blank" @endif class="{{ $packageKey == 1 ? 'tp-btn-gradient sm' : 'tp-btn-black-border' }} w-100 text-center">{{__('Place Order')}}</a>
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
                      @endif
                  @endforeach
              </div>
          </div>
      </div>
  </div>
  @endif
@endsection 
