@extends("front.$version.layout")

@section('pagename')
    - {{__('Our Story')}}
@endsection

@section('meta-keywords', "$bex->our_story_meta_keywords")
@section('meta-description', "$bex->our_story_meta_description")


@section('breadcrumb-title', convertUtf8($bex->our_story_title))
@section('breadcrumb-subtitle', convertUtf8($bex->our_story_subtitle))
@section('breadcrumb-link', __('Our Story'))
@section('page_class', 'about')


@section('content')
    <!-- rts about area start -->
    <div class="rts-about-area rts-section-gap mt--10">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-page-main-thumbnail-big-img-wrapper rts-reveal-to-bottom-wrapper">
                        <img class="rts-reveal-image-toBottom" src="{{ asset('assets/front/img/' . $bex->ourstory_page_image) }}" alt="about_large">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts about area end -->

    @if ($bs->approach_section == 1)
        <!-- our approch area start -->
        <div class="our-approch-area-style-one rts-section-gap bg-dark-1">
            <div class="container">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="grid-lines-wrapper">
                            <div class="grid-lines">
                                <div class="grid-line"></div>
                                <div class="grid-line"></div>
                                <div class="grid-line"></div>
                                <div class="grid-line"></div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <!-- Left Side -->
                    <div class="col-lg-7 col-md-6 rts-slide-right-gsap ">
                        <div class="approch-area-left">
                            <div class="title-area-left-wrapper">
                                <span class="pre-title">{{ convertUtf8($bs->approach_title) }}</span>
                                <h2 class="title quote" style="color:#00a651;">{{ convertUtf8($bs->approach_subtitle) }}</h2>
                            </div>
                            <p class="disc rts-text-anim">
                                {{-- Optional: add a dynamic paragraph if needed --}}
                            </p>
                            @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                                <a href="{{ $bs->approach_button_url }}" style="color:#00a651 !important;" class="learn-more-btn" target="_blank">
                                    {{ convertUtf8($bs->approach_button_text) }}
                                    <i class="fa-solid fa-arrow-up-right"></i>
                                </a>
                            @endif
                        </div>
                    </div>

                    <!-- Right Side -->
                    <div class="col-lg-5 col-md-6 rts-slide-left-gsap mt_sm--30">
                        @foreach ($points as $key => $point)
                            <div
                                class="single-approach-area-start single-approach-area-start{{ $loop->index }}">
                                <style>
                                    .single-approach-area-start{{ $loop->index }}::before {
                                        background-image: url({{ asset('assets/front/img/' . $point->image) }});
                                    }
                                    .single-approach-area-start{{ $loop->index }}::after {
                                        content: "0{{$point->serial_number}}" !important;
                                    }
                                </style>
                                <div class="left-area">
                                    <h3 class="title">{{ convertUtf8($point->title) }}</h3>
                                    <p class="disc rts-text-anim">
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
        </div>
        <!-- our approch area end -->
    @endif
    <!-- progress-team aarea -->
    <div class="progress-team-area rts-team__area rts-section-gap bg-dark-1 rts_jump_counter__animation">

        @if ($bs->statistics_section == 1)
            <div class="container">z
                <div class="row">
                    <div class="col-lg-12">
                        <div class="progress-ciurcle-wrapper-one">
                            @foreach ($statistics as $statistic)
                                <div class="counter_animation">
                                    <!-- single progress -->
                                    <div class="single-progress-circle counter__anim">
                                        <svg class="radial-progress" data-countervalue="{{ $statistic->quantity % 10000 == 0 ? convertUtf8($statistic->quantity) /500 : convertUtf8($statistic->quantity) }}" viewBox="0 0 80 80">
                                            <circle class="bar-static" cx="40" cy="40" r="35"></circle>
                                            <circle class="bar--animated" cx="40" cy="40" r="35" style="stroke-dashoffset: 217.8;"></circle>
                                            <text class="countervalue start" x="50%" y="56%" transform="matrix(0, 1, -1, 0, 80, 0)">
                                                {{ convertUtf8($statistic->quantity) }}
                                            </text>
                                        </svg>
                                        <span class="small-text">
                                    {!! preg_replace('/ /', '<br>', convertUtf8($statistic->title), 1) !!}
                                </span>
                                    </div>
                                    <!-- single progress end -->
                                </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        @endif
            @if ($bs->team_section == 1)
                <div class="team-title-4">
                    <h2 class="title rts-has-mask-fill-2">{{ convertUtf8($bs->team_section_title) }}</h2>
                </div>

                <div class="container">
                    <div class="row g-24">
                        @foreach ($members as $member)
                            <div class="col-lg-4 col-md-6 col-sm-6 col-12">
                                <!-- single-team -->
                                <div class="single-team-style-one rts-team__item">
                                    <a href="#" class="thumbnail">
                                        <img class="lazy" data-src="{{ asset('assets/front/img/members/' . $member->image) }}" alt="{{ $member->name }}">
                                    </a>
                                    <div class="inner-content">
                                        <span>{{ convertUtf8($member->rank) }}</span>
                                        <a href="#">
                                            <h5 class="name">{{ convertUtf8($member->name) }}</h5>
                                        </a>
                                        @if (!empty($member->facebook) || !empty($member->twitter) || !empty($member->linkedin) || !empty($member->instagram))
                                            <ul class="social-account-lists mt-2">
                                                @if (!empty($member->facebook))
                                                    <li><a href="{{ $member->facebook }}"><i class="fab fa-facebook-f"></i></a></li>
                                                @endif
                                                @if (!empty($member->twitter))
                                                    <li><a href="{{ $member->twitter }}"><i class="fab fa-twitter"></i></a></li>
                                                @endif
                                                @if (!empty($member->linkedin))
                                                    <li><a href="{{ $member->linkedin }}"><i class="fab fa-linkedin-in"></i></a></li>
                                                @endif
                                                @if (!empty($member->instagram))
                                                    <li><a href="{{ $member->instagram }}"><i class="fab fa-instagram"></i></a></li>
                                                @endif
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <!-- single-team end -->
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
    </div>
    <!-- progress-team aarea end -->
    @if (count($faqs))
        <!-- rts faq area start  -->
        <div class="rts-faq-section-area rts-section-gapBottom">
            <div class="container mb--50">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="title-faq-4">
                            <span class="pre">FAQ</span>
                            <h2 class="title quote">{{ convertUtf8($bex->faq_section_title) }}</h2>
                        </div>
                    </div>
                </div>
            </div>

            <div class="container-140 mt--100">
                <div class="row">
                    <!-- Image Thumbnail -->
                    <div class="col-lg-4 rts-slide-left-gsap">
                        <img src="{{ asset('assets/front/img/' . $bex->faq_bg2) }}" alt="faq">
                    </div>

                    <!-- Accordion -->
                    <div class="col-lg-8 pr--140 pl--50 pl_md--15 pl_sm--15 pr_md--15 pr_sm--15">
                        <div class="four-accordion-area-faq">
                            <div class="accordion" id="accordionExample">
                                @foreach ($faqs as $index => $faq)
                                    <div class="accordion-item rts-slide-up-gsap">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button {{ $index !== 0 ? 'collapsed' : '' }}" type="button"
                                                    data-bs-toggle="collapse"
                                                    data-bs-target="#collapse{{ $index }}"
                                                    aria-expanded="{{ $index === 0 ? 'true' : 'false' }}"
                                                    aria-controls="collapse{{ $index }}">
                                                {{ convertUtf8($faq->question) }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}"
                                             class="accordion-collapse collapse {{ $index === 0 ? 'show' : '' }}"
                                             aria-labelledby="heading{{ $index }}"
                                             data-bs-parent="#accordionExample">
                                            <div class="accordion-body">
                                                <p>{{ convertUtf8($faq->answer) }}</p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <!-- Accordion End -->
                </div>
            </div>
        </div>
        <!-- rts faq area end  -->
    @endif

    <!-- rts video area start -->
    <div class="rts-video-area-about rts-section-gap bg_image"  style="background-image: url({{ asset('assets/front/img/' . $bex->ourstory_page_image2) }});">

    </div>
    <!-- rts video area end -->

    @if ($bs->testimonial_section == 1)
        <!-- testimonials area start -->
        <div class="rts-testimonials-area rts-section-gap rts-slide-up-gsap">
            <div class="container plr--60">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="single-swiper-wrapper-inner-service">
                            <div class="swiper mySwiper-testimonails-about-s">
                                <div class="swiper-wrapper">

                                    @foreach ($testimonials as $testimonial)
                                        <div class="swiper-slide">
                                            <!-- testimonials main wrapper -->
                                            <div class="testimonials-main-wrapper-about">
                                                <div class="left-side">
                                                    <h6 class="title">
                                                        {{ convertUtf8($bs->testimonial_title) }}
                                                        <br>
                                                        <!--{{ convertUtf8($bs->testimonial_subtitle) }}-->
                                                    </h6>
                                                    <img src="{{ asset('assets/front/img/testimonials/' . $testimonial->image) }}"
                                                         alt="{{ convertUtf8($testimonial->name) }}">
                                                </div>
                                                <div class="right-side">
                                                    <p class="disc">
                                                        {{ convertUtf8($testimonial->comment) }}
                                                    </p>
                                                    <div class="bottom">
                                                        <p>{{ convertUtf8($testimonial->name) }} , {{ convertUtf8($testimonial->rank) }}</p>
                                                    </div>
                                                </div>
                                            </div>
                                            <!-- testimonials main wrapper end -->
                                        </div>
                                    @endforeach

                                </div>

                                <!-- swiper nav -->
                                <div class="swiper-button-next"></div>
                                <div class="swiper-button-prev"></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- testimonials area end -->
    @endif

    <!-- rts brand area start -->
    <div class="rtes-brand-area rts-section-gapBottom">
        <div class="container plr--60">
            <div class="row mb--60">
                <div class="col-lg-12">
                    <div class="title-faq-4">
                        <span class="pre">{{ __('INTERNATIONAL BRANDS') }}</span>
                        <h2 class="title quote">{{ __('We are happy to work with global largest brands') }}</h2>
                    </div>
                </div>
            </div>
        </div>
        <div class="container plr--60">
            <div class="row rts-slide-left-gsap">
                <div class="col-lg-12">
                    <!-- brand main wrapper  -->
                    <div class="brand-main-wrapper-about">
                        @foreach ($portfolios as $portfolio)
                            @if ($portfolio->client_image)
                                <a href="#" class="single-brand">
                                    <img src="{{ asset('assets/front/img/portfolios/featured/' . $portfolio->client_image) }}" alt="{{ $portfolio->title }}">
                                </a>
                            @endif
                        @endforeach
                    </div>
                    <!-- brand main wrapper end -->
                </div>
            </div>
        </div>
    </div>
    <!-- rts brand area end -->


@endsection
