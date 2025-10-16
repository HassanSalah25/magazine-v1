<!-- hero area start -->
<div class="dgm-hero-top pt-20">
    <div class="dgm-hero-ptb grey-bg-2 fix z-index-1 p-relative">
        <div class="dgm-hero-bg" data-background="{{ asset('front/assets/img/home-03/hero/hero-bg-shape.png') }}"></div>
        <div class="dgm-hero-rotate-text">
            <span>{{ $be->hero_section_text2 ? $be->hero_section_text2 : __('Award winning agency') }}</span>
        </div>
        <div class="dgm-hero-social-box">
            <div class="dgm-hero-social-text">
                <span>{{ __('Follow') }}</span>
            </div>
            <div class="dgm-hero-social">
                @if (!empty($socials))
                    @foreach ($socials as $social)
                        <a href="{{ $social->url }}">
                            <span>
                                <i class="{{ $social->icon }}"></i>
                            </span>
                        </a>
                    @endforeach
                @endif
            </div>
        </div>
        <div class="container container-1430">
            <div class="row">
                <div class="col-lg-6">
                    <div class="dgm-hero-content mb-120">
                        <!--<span class="dgm-hero-subtitle tp_fade_anim" data-delay=".3">{{ $bs->hero_section_title ?? '🔥 BEST MARKETING AGENCY' }}</span>-->
                        <h4 class="dgm-hero-title tp_fade_anim" style="color: #00a551 !important" data-delay=".5">
                             <img class="dgm-hero-title-mike d-none d-md-inline-block" src="{{ asset('front/assets/img/home-03/hero/icon_page1.png') }}" alt="mike">
                            {{ $bs->hero_section_text }}
                        </h4>
                        <div class="tp_fade_anim" data-delay=".7">
                            <a class="tp-btn-black-square" href="{{ $bs->hero_section_button_url }}">
                                                <span>
                                                    <span class="text-1"> {{ convertUtf8($bs->hero_section_button_text) }}</span>
                                                    <span class="text-2"> {{ convertUtf8($bs->hero_section_button_text) }}</span>
                                                </span>
                                <i>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 11L11 1" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1 1H11V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                    <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 11L11 1" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                        <path d="M1 1H11V11" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </i>
                            </a>
                        </div>
                    </div>
                    <div class="dgm-hero-funfact-wrap">
                        <div class="row">
                            @foreach($statistics->take(2) as $statistic)
                            <div class="col-xl-4 col-lg-6 col-md-4 col-sm-6">
                                <div class="dgm-hero-funfact tp_fade_anim mb-40" data-delay=".7" data-fade-from="top" data-ease="bounce">
                                    <span><i data-purecounter-duration="1" data-purecounter-end="{{ convertUtf8($statistic->quantity) }}" class="purecounter">0</i>%</span>
                                    <p>{!! preg_replace('/ /', '<br>', convertUtf8($statistic->title), 1) !!}</p>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="dgm-hero-thumb anim-zoomin-wrap">
            <div class="anim-zoomin">
                <img src="{{ asset('assets/front/img/' . $bs->hero_bg) }}" alt="">
            </div>
            <div class="dgm-hero-text-box" data-background="{{ asset('front/assets/img/home-03/hero/hero-text-shape.png') }}">
                <img src="{{ $be->hero_bg2 ? asset('assets/front/img/' . $be->hero_bg2) : asset('front/assets/img/home-03/hero/hi-shape.png') }}" alt="">
                <p>{{ $be->hero_section_text3 ? $be->hero_section_text3 : __('World-class digital media agency.') }}</p>
                <a class="dgm-hero-arrow" href="{{ $bs->hero_section_button_url }}">
                                    <span>
                                        <svg width="25" height="24" viewBox="0 0 25 24" fill="none" xmlns="http://www.w3.org/2000/svg">
                                            <path d="M5.23804 17.2178L18.2428 8.11173" stroke="#141414" stroke-width="2" stroke-miterlimit="10" />
                                            <path d="M8.62744 5.00098C11.1637 8.6231 16.1444 9.50353 19.7634 6.96947" stroke="#141414" stroke-width="2" stroke-miterlimit="10" />
                                            <path d="M19.7642 6.96914C16.1452 9.5032 15.2691 14.4847 17.8053 18.1068" stroke="#141414" stroke-width="2" stroke-miterlimit="10" />
                                        </svg>
                                    </span>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- hero area end -->
