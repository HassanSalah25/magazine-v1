@extends('front.landingpage2.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")


@section('content')
    <!--   hero area start   -->
    @include('front.landingpage2.partials.slider')
    <!--   hero area end    -->

    <section id="gl-featured" class="gl-featured-section position-relative">
    <span class="gl-featured-shape position-absolute">
        <img src="{{ asset('front/assets8/img/shape/sh1.png') }}" alt="">
    </span>
        <div class="container">
            <div class="gl-title-top-content headline pera-content d-flex justify-content-between">
                <div class="gl-title-top-head wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                    <h2>{{ convertUtf8($bs->feature_section_title ?? 'Trusted by thousands of users') }}</h2>
                </div>
                <div class="gl-title-top-text wow fadeInRight" data-wow-delay="0ms" data-wow-duration="1500ms">
                    {{ convertUtf8($bs->feature_section_subtitle ?? 'Description about your features section here.') }}
                </div>
            </div>

            <div class="gl-featured-inner-content position-relative">
            <span class="gl-featured-shape2 position-absolute" data-parallax='{"x" : -70}'>
                <img src="{{ asset('front/assets8/img/shape/sh2.png') }}" alt="">
            </span>
                <div class="row">
                    @foreach ($features as $index => $feature)
                        <div class="col-lg-3 col-md-6 headline wow fadeInUp" data-wow-delay="{{ $index * 200 }}ms"
                             data-wow-duration="1500ms">
                            <div class="gl-featured-inner-item">
                                <div class="thx-inner-item">
                                    <div class="thx-inner-icon">
                                        <i class="{{ $feature->icon }}"></i>
                                    </div>
                                    <div class="thx-inner-title headline">
                                        <h3>{{ convertUtf8($feature->title) }}</h3>
                                    </div>
                                    <div class="thx-inner-text">
                                        {{ convertUtf8($feature->text) }}
                                    </div>
                                    <div class="thx-inner-btn">
                                        <a href="{{ $feature->url ?? '#' }}">
                                            {{ __('Explore More') }} <i class="fa-solid fa-arrow-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>

            @if(!empty($bs->feature_section_cta_text) && !empty($bs->feature_section_cta_link))
                <div class="gl-featured-more d-flex justify-content-end headline wow fadeInRight" data-wow-delay="800ms"
                     data-wow-duration="1500ms">
                <span>
                    {{ convertUtf8($bs->feature_section_cta_text) }}
                    <a class="text-uppercase"
                       href="{{ $bs->feature_section_cta_link }}">{{ __('Find Your Solution') }}</a>
                </span>
                </div>
            @endif
        </div>
    </section>

    <section id="gl-about" class="gl-about-section position-relative">
    <span class="gl-about-shape position-absolute">
        <img src="{{ asset('front/assets8/img/shape/sh3.png') }}" alt="">
    </span>
        <div class="gl-about-bg position-absolute">
            <img src="{{ asset('front/assets8/img/bg/ab-bg.png') }}" alt="">
        </div>
        <div class="container">
            <div class="gl-about-content">
                <div class="row">
                    {{-- Image Section --}}
                    <div class="col-lg-6">
                        <div class="gl-about-img-wrap position-relative">
                            <div class="gl-about-img1">
                                <img src="{{ asset('assets/front/img/' . $bs->about_image1) }}" alt="">
                            </div>
                            <div class="gl-about-img2 position-absolute">
                                <img src="{{ asset('assets/front/img/' . $bs->about_image2) }}" alt="">
                            </div>
                            <div class="gl-about-exp-text-wrap d-flex align-items-center position-absolute">
                                <div class="gl-about-exp-icon d-flex align-items-center justify-content-center">
                                    <i class="fa-solid fa-note-sticky"></i>
                                </div>
                                <div class="gl-about-exp-text headline pera-content">
                                    <h3><span class="odometer" data-count="{{ $bs->experience_years ?? 10 }}"></span>+
                                    </h3>
                                    <p>{{ __('Year’s Experience') }}</p>
                                </div>
                            </div>
                        </div>
                    </div>

                    {{-- Text Section --}}
                    <div class="col-lg-6">
                        <div class="gl-about-text-wrap">
                            <div class="gl-section-title headline pera-content wow fadeInUp" data-wow-delay="0ms"
                                 data-wow-duration="1500ms">
                                <h2>{{ convertUtf8($bs->about_title) }}</h2>
                                <p>{{ convertUtf8($bs->about_text) }}</p>
                            </div>
                            <div class="gl-about-feature-list ul-li-block wow fadeInUp" data-wow-delay="200ms"
                                 data-wow-duration="1500ms">
                                <ul>
                                    @foreach (explode(PHP_EOL, $bs->about_features ?? '') as $feat)
                                        <li>{{ trim($feat) }}</li>
                                    @endforeach
                                </ul>
                            </div>
                            <div class="gl-about-text-area wow fadeInUp" data-wow-delay="400ms"
                                 data-wow-duration="1500ms">
                                {{ convertUtf8($bs->about_extra_text) }}
                            </div>
                            <div class="gl-about-text-author-details d-flex align-items-center wow fadeInUp"
                                 data-wow-delay="600ms" data-wow-duration="1500ms">
                                <div class="gl-about-author d-flex align-items-center">
                                    <div class="gl-abt-ath-img">
                                        <img src="{{ asset('assets/front/img/' . $bs->about_author_img) }}" alt="">
                                    </div>
                                    <div class="gl-abt-ath-text headline">
                                        <h3>{{ $bs->about_author_name ?? 'Dianne Russell' }}</h3>
                                        <span>{{ $bs->about_author_title ?? 'Managing Director' }}</span>
                                    </div>
                                </div>
                                <div class="gl-about-author-sign">
                                    <img src="{{ asset('assets/front/img/' . $bs->about_signature) }}" alt="">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>


    @if ($bs->statistics_section == 1)
        <section id="gl-funfact" class="gl-funfact-section position-relative">
    <span class="gl-funfact-shape position-absolute">
        <img src="{{ asset('front/assets8/img/bg/fn-bg.png') }}" alt="">
    </span>

            <div class="container">
                {{-- Section Title --}}
                <div class="gl-section-title headline text-center wow fadeInUp" data-wow-delay="0ms"
                     data-wow-duration="1500ms">
                    <h2>{{ convertUtf8($bs->statistics_section_title ?? "We're Trusted by Our Professional Customers") }}</h2>
                </div>

                {{-- Fun Fact Items --}}
                <div class="gl-fan-fact-content">
                    <div class="row">
                        @foreach ($statistics as $index => $stat)
                            <div class="col-lg-3 col-md-6">
                                <div class="gl-funfact-inner-item">
                                    <div class="thx-inner-item">
                                        <div class="thx-inner-icon d-flex align-items-center justify-content-center">
                                            <i class="{{ $stat->icon ?? 'fa-solid fa-note-sticky' }}"></i>
                                        </div>
                                        <div class="thx-inner-title headline">
                                            <h3>
                                                <span class="odometer"
                                                      data-count="{{ $stat->quantity }}">{{ $stat->quantity }}</span>
                                                {{ $stat->after ?? '' }}
                                            </h3>
                                        </div>
                                        <div class="thx-inner-text">
                                            {!! preg_replace('/ /', '<br>', convertUtf8($stat->title), 1) !!}
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    <section id="gl-about-feature" class="gl-about-feature-section position-relative">
        <div class="container">
            <div class="gl-about-feature-content">
                <div class="row">
                    {{-- Text Section --}}
                    <div class="col-lg-6">
                        <div class="gl-about-feature-text clearfix">
                            <div class="gl-section-title headline pera-content wow fadeInUp" data-wow-delay="0ms"
                                 data-wow-duration="1500ms">
                                <h2>{{ convertUtf8($bs->about_feature_title ?? 'Excellent Performance We Focus on Critical IT.') }}</h2>
                                <p>{{ convertUtf8($bs->about_feature_subtitle ?? 'How this mistaken idea of denouncing pleasure came about.') }}</p>
                            </div>

                            {{-- Feature List --}}
                            <div class="gl-about-feature-list-2 clearfix ul-li-block wow fadeInUp"
                                 data-wow-delay="200ms" data-wow-duration="1500ms">
                                <ul>
                                    @foreach (explode(PHP_EOL, $bs->about_feature_list ?? '') as $point)
                                        <li>{{ trim($point) }}</li>
                                    @endforeach
                                </ul>
                            </div>

                            {{-- Subscribe Form --}}
                            @if (!empty($bs->about_feature_subscribe_text))
                                <div
                                    class="gl-about-feature-subscribe-form d-flex align-items-center justify-content-between wow fadeInUp"
                                    data-wow-delay="400ms" data-wow-duration="1500ms">
                                    <div class="gl-about-feature-subs-text">
                                        {{ convertUtf8($bs->about_feature_subscribe_text) }}
                                    </div>
                                    <div class="gl-about-feature-subs-form position-relative">
                                        <form action="{{ route('front.subscribe') }}" method="POST">
                                            @csrf
                                            <input type="email" name="email" placeholder="{{ __('Type Your Email') }}"
                                                   required>
                                            <button type="submit"><i class="far fa-paper-plane"></i></button>
                                        </form>
                                    </div>
                                </div>
                            @endif
                        </div>
                    </div>

                    {{-- Image Section --}}
                    <div class="col-lg-6">
                        <div class="gl-about-feature-img position-relative wow fadeInRight" data-wow-delay="500ms"
                             data-wow-duration="1500ms">
                        <span class="gl-about-feature-img-shape position-absolute" data-parallax='{"x" : -70}'>
                            <img src="{{ asset('front/assets8/img/shape/sh4.png') }}" alt="">
                        </span>
                            <img src="{{ asset('assets/front/img/' . $bs->about_feature_image) }}" alt="About Image">
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    @if ($bs->team_section == 1)
        <section id="gl-team" class="gl-team-section position-relative"
                 @if($bs->home_version != 'parallax')
                     style="background-image: url('{{ asset('assets/front/img/'.$bs->team_bg) }}'); background-size: cover;"
                 @else
                     data-parallax="scroll" data-speed="0.2"
                 data-image-src="{{ asset('assets/front/img/'.$bs->team_bg) }}"
            @endif>
            <div class="container">
                {{-- Title --}}
                <div
                    class="gl-title-top-content headline pera-content d-flex justify-content-between align-items-center">
                    <div class="gl-title-top-head wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <h2>{{ convertUtf8($bs->team_section_title ?? 'Our Expert Team Members') }}</h2>
                    </div>
                    <div class="gl-title-top-text wow fadeInRight" data-wow-delay="100ms" data-wow-duration="1500ms">
                        @if (!empty($bs->team_section_button_text) && !empty($bs->team_section_button_url))
                            <a class="d-flex justify-content-center align-items-center"
                               href="{{ $bs->team_section_button_url }}">
                                {{ $bs->team_section_button_text }}
                            </a>
                        @endif
                    </div>
                </div>

                {{-- Team Cards --}}
                <div class="gl-team-content position-relative">
            <span class="gl-team-shape position-absolute" data-parallax='{"x" : -20}'>
                <img src="{{ asset('front/assets8/img/shape/sh3.png') }}" alt="">
            </span>
                    <div class="row justify-content-center">
                        @foreach ($members as $index => $member)
                            <div class="col-lg-3 col-md-6 wow fadeInUp" data-wow-delay="{{ $index * 200 }}ms"
                                 data-wow-duration="1500ms">
                                <div class="gl-team-inner-item">
                                    <div class="thx-inner-item text-center">
                                        <div class="thx-inner-img">
                                            <img class="lazy"
                                                 data-src="{{ asset('assets/front/img/members/'.$member->image) }}"
                                                 alt="{{ $member->name }}">
                                        </div>
                                        <div class="thx-inner-title headline">
                                            <h3><a href="#">{{ convertUtf8($member->name) }}</a></h3>
                                        </div>
                                        <div class="thx-inner-degi">{{ convertUtf8($member->rank) }}</div>

                                        <div class="thx-inner-social d-flex justify-content-center">
                                            @if ($member->facebook)
                                                <a href="{{ $member->facebook }}"><i class="fab fa-facebook-f"></i></a>
                                            @endif
                                            @if ($member->twitter)
                                                <a href="{{ $member->twitter }}"><i class="fab fa-twitter"></i></a>
                                            @endif
                                            @if ($member->linkedin)
                                                <a href="{{ $member->linkedin }}"><i class="fab fa-linkedin-in"></i></a>
                                            @endif
                                            @if ($member->instagram)
                                                <a href="{{ $member->instagram }}"><i class="fab fa-instagram"></i></a>
                                            @endif
                                        </div>

                                        <div class="thx-inner-btn">
                                            <a href="mailto:{{ $member->email ?? 'info@example.com' }}">
                                                {{ __('Contact Today') }}
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if ($be->pricing_section == 1)
        <section id="gl-pricing" class="gl-pricing-section position-relative">
            <div class="container">
                {{-- Section Title --}}
                <div class="gl-section-title headline text-center wow fadeInUp" data-wow-delay="0ms"
                     data-wow-duration="1500ms">
                    <h2>{{ convertUtf8($bs->pricing_section_title ?? 'Special Offer! Choose your Pack Today!') }}</h2>
                </div>

                <div class="gl-pricing-content position-relative">
            <span class="gl-pricing-shape1 position-absolute">
                <img src="{{ asset('front/assets8/img/shape/sh3.png') }}" alt="">
            </span>
                    <span class="gl-pricing-shape2 position-absolute">
                <img src="{{ asset('front/assets8/img/shape/sh5.png') }}" alt="">
            </span>

                    <div class="row justify-content-center">
                        @foreach ($packages as $index => $package)
                            <div class="col-lg-4 col-md-6 wow fadeInUp" data-wow-delay="{{ $index * 200 }}ms"
                                 data-wow-duration="1500ms">
                                <div class="gl-pricing-inner-item text-center">
                                    <div class="thx-inner-item">
                                        {{-- Title --}}
                                        <div class="thx-inner-title headline">
                                            <h3>{{ convertUtf8($package->title) }}</h3>
                                        </div>

                                        {{-- Price --}}
                                        <div class="thx-inner-price-plan headline position-relative">
                                            <h4>
                                                {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}
                                                {{ number_format($package->price, 2) }}
                                                {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                                            </h4>
                                            <span>{{ __('Per Month') }}</span>
                                        </div>

                                        {{-- Feature List --}}
                                        <div class="thx-inner-price-list ul-li-block clearfix">


                                            {!! Str::limit(replaceBaseUrl(convertUtf8($package->description)), 120) !!}
                                        </div>

                                        {{-- Purchase Button --}}
                                        <div class="thx-inner-price-btn">
                                            @if ($package->order_status == 1)
                                                <a class="d-flex justify-content-center align-items-center"
                                                   href="{{ route('front.packageorder.index', $package->id) }}">
                                                    {{ __('Purchase Now') }}
                                                </a>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>

                    {{-- CTA button --}}
                    @if (!empty($bs->pricing_section_link))
                        <div class="row mt-5">
                            <div class="col-lg-12 text-center">
                                <div class="btn--area-center">
                                    <a href="{{ $bs->pricing_section_link }}" class="learn-more-btn">
                                        {{ __('Try It for Free') }} <i class="fa-solid fa-arrow-right"></i>
                                    </a>
                                </div>
                            </div>
                        </div>
                    @endif
                </div>
            </div>
        </section>
    @endif
    @if ($bs->testimonial_section == 1)
        <section id="gl-testimonial" class="gl-testimonial-section position-relative">
            {{-- Title --}}
            <div class="gl-section-title headline text-center wow fadeInUp" data-wow-delay="0ms"
                 data-wow-duration="1500ms">
                <h2>{{ convertUtf8($bs->testimonial_title ?? 'Check What’s Clients Say About Us') }}</h2>
            </div>

            <div class="gl-testimonial-content">
                <div class="gl-testimonial-slider-wrapper">
                    @foreach ($testimonials as $testimonial)
                        <div class="thx-slider-inner">
                            <div class="gl-testimonial-slider-item">
                                <div class="gl-testimonial-slider-item-area d-flex">
                                    {{-- Image --}}
                                    <div class="gl-testimonial-slider-img">
                                        <img src="{{ asset('assets/front/img/testimonials/' . $testimonial->image) }}"
                                             alt="{{ convertUtf8($testimonial->name) }}">
                                    </div>

                                    {{-- Text --}}
                                    <div class="gl-testimonial-slider-text headline pera-content">
                                        <div class="gl-tst-text">
                                            “{{ convertUtf8($testimonial->comment) }}”
                                        </div>

                                        {{-- Author --}}
                                        <div class="gl-tst-author-rate">
                                            <h3>{{ convertUtf8($testimonial->name) }}</h3>
                                            <span>{{ convertUtf8($testimonial->rank) }}</span>

                                            {{-- Stars --}}
                                            <div class="gl-tst-rate ul-li clearfix">
                                                <ul>
                                                    @for ($i = 0; $i < 5; $i++)
                                                        <li><i class="fas fa-star"></i></li>
                                                    @endfor
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </section>
    @endif

    @if ($bs->news_section == 1)
        <section id="gl-blog" class="gl-blog-section">
            <div class="container">
                {{-- Header --}}
                <div
                    class="gl-title-top-content headline pera-content d-flex justify-content-between align-items-center">
                    <div class="gl-title-top-head wow fadeInLeft" data-wow-delay="0ms" data-wow-duration="1500ms">
                        <h2>{{ convertUtf8($bs->blog_section_title ?? 'Get Latest News From Glow') }}</h2>
                    </div>
                    <div class="gl-title-top-text wow fadeInRight" data-wow-delay="200ms" data-wow-duration="1500ms">
                        <a class="d-flex justify-content-center align-items-center" href="{{ route('front.blogs') }}">
                            {{ __('More Blog') }}
                        </a>
                    </div>
                </div>

                {{-- Blog Cards --}}
                <div class="gl-blog-content">
                    <div class="row justify-content-center">
                        @foreach ($blogs->take(3) as $blog)
                            <div class="col-lg-4 col-md-6 wow fadeInUp"
                                 data-wow-delay="{{ $loop->index * 200 }}ms"
                                 data-wow-duration="1500ms">
                                <div class="gl-blog-inner-item">
                                    <div class="thx-inner-item">
                                        {{-- Image --}}
                                        <div class="thx-inner-img position-relative">
                                            <img src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                                 alt="{{ convertUtf8($blog->title) }}">
                                            @if (!empty($blog->bcategory))
                                                <a class="post-cat position-absolute"
                                                   href="{{ route('front.blogs', $blog->bcategory->slug) }}">
                                                    {{ convertUtf8($blog->bcategory->name) }}
                                                </a>
                                            @endif
                                        </div>

                                        {{-- Author --}}
                                        <div class="thx-inner-meta">
                                            <a href="#"><i class="fas fa-user"></i> {{ $blog->author ?? 'Admin' }}</a>
                                        </div>

                                        {{-- Title --}}
                                        <div class="thx-inner-title headline">
                                            <h3>
                                                <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                    {{ mb_strimwidth($blog->title, 0, 55, '...') }}
                                                </a>
                                            </h3>
                                        </div>

                                        {{-- Button --}}
                                        <div class="thx-inner-btn">
                                            <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                {{ __('Explore More') }} <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>
    @endif

    @if (!empty($bs->app_section) && $bs->app_section == 1)
        <section id="gl-app-download" class="gl-app-download-section position-relative">
            <div class="container">
                <div class="gl-app-download-content position-relative">
                    {{-- الموبايل --}}
                    <div class="gl-app-download-img position-absolute wow fadeInUp"
                         data-wow-delay="200ms" data-wow-duration="1500ms">
                        <img src="{{ asset('assets/front/img/' . $bs->app_section_image) }}" alt="app">
                    </div>

                    <div class="row">
                        <div class="col-lg-6">
                            <div class="gl-app-download-text headline">
                                {{-- العنوان --}}
                                <div class="gl-section-title headline pera-content">
                                    <h2>{{ convertUtf8($bs->app_section_title ?? 'Download Our Mobile App? One Click') }}</h2>
                                </div>

                                {{-- أزرار التحميل --}}
                                <div class="gl-app-download-btn">
                                    @if (!empty($bs->app_store_link))
                                        <a href="{{ $bs->app_store_link }}" target="_blank">
                                            <img src="{{ asset('front/assets8/img/logo/app1.png') }}" alt="App Store">
                                        </a>
                                    @endif
                                    @if (!empty($bs->play_store_link))
                                        <a href="{{ $bs->play_store_link }}" target="_blank">
                                            <img src="{{ asset('front/assets8/img/logo/app2.png') }}" alt="Play Store">
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    @endif

    {{-- CTA تحتها مباشرة لو مفعّلة --}}
    @if(!empty($bs->feature_section_cta_text) && !empty($bs->feature_section_cta_link))
        <div class="gl-featured-more d-flex justify-content-end headline wow fadeInRight"
             data-wow-delay="800ms" data-wow-duration="1500ms">
        <span>
            {{ convertUtf8($bs->cta_section_text) }}
            <a class="text-uppercase" href="{{ $bs->cta_section_button_url }}">
                {{$abs->cta_section_button_text}}
            </a>
        </span>
        </div>
    @endif

@endsection
