@extends("front.$version.layout")

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{convertUtf8($category->name)}}
 @endif
 {{__('Jobs')}}
@endsection

@section('meta-keywords', "$be->career_meta_keywords")
@section('meta-description', "$be->career_meta_description")


@section('content')
    {{-- Hero Section --}}
    <div class="ar-hero-area p-relative">
        <div class="tp-career-shape-1">
        <span>
            <svg xmlns="http://www.w3.org/2000/svg" width="84" height="84" viewBox="0 0 84 84" fill="none">
                <path d="M36.3761 0.5993C40.3065 8.98556 47.3237 34.898 32.8824 44.3691C25.3614 49.0997 9.4871 52.826 1.7513 31.3747C-1.16691 23.2826 5.38982 15.9009 20.5227 20.0332C29.2536 22.4173 50.3517 27.8744 60.9 44.2751C66.4672 52.9311 71.833 71.0287 69.4175 82.9721M69.4175 82.9721C70.1596 77.2054 74.079 66.0171 83.8204 67.3978M69.4175 82.9721C69.8033 79.1875 67.076 70.1737 53.0797 64.3958M49.1371 20.8349C52.611 22.1801 63.742 28.4916 67.9921 39.9344"
                      stroke="#030303" stroke-width="1.5" />
            </svg>
        </span>
        </div>

        <div class="container container-1230">
            <div class="ar-about-us-4-hero-ptb">
                <div class="row justify-content-center">
                    <div class="col-xl-12">
                        <div class="ar-hero-title-box tp_fade_anim" data-delay=".3">
                            <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                                <span class="tp-section-subtitle pre tp_fade_anim">{{ __('Career') }}</span>
                                <div class="ar-about-us-4-icon">
                                    <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                        <rect y="4" width="80" height="1" fill="#111013" />
                                        <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                    </svg>
                                </div>
                            </div>

                            <h3 class="tp-career-title">
                                {{ convertUtf8($be->career_title ?? __('Join us & make')) }}
                            </h3>
                            <p>
                                {{ convertUtf8($be->career_subtitle ?? __('an impact through')) }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="tp-career-btn">
            <div class="st-hero-btn tp_fade_anim" data-delay=".3" data-fade-from="top" data-ease="bounce">
                <a href="{{ route('front.team') }}">
                <span class="st-hero-btn-svg">
                    <svg xmlns="http://www.w3.org/2000/svg" width="22" height="22" viewBox="0 0 22 22" fill="none">
                        <path fill-rule="evenodd" clip-rule="evenodd" d="M11.3793 3.0269C14.6433 2.80336 18.8918 1.42595 22 0C20.5735 3.10763 19.1955 7.35556 18.9725 10.6196L16.8278 6.04382L1.05218 21.82C0.936508 21.9354 0.77977 22.0001 0.616396 22C0.494507 22 0.375362 21.9638 0.274025 21.8961C0.172686 21.8284 0.0936985 21.7321 0.0470581 21.6195C0.000415802 21.5069 -0.0117893 21.383 0.0119839 21.2634C0.0357552 21.1439 0.0944386 21.034 0.180614 20.9478L15.9563 5.17221L11.3793 3.0269Z" fill='currentColor'/>
                    </svg>
                </span>
                    <span class="st-hero-btn-text">{{ __('Meet with the team') }}</span>
                </a>
            </div>
        </div>
    </div>

    <!-- banner area start -->
    <div class="ar-banner-area">
        <div class="ar-banner-wrap ar-about-us-4">
            <img class="w-100" src="{{ asset('assets/front/img/' . $bs->breadcrumb) }}" alt="" data-speed=".8">
        </div>
    </div>
    <!-- banner area end -->
    <section class="tp-benefit-ptb pt-140 pb-160">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-benefit-heading mb-85">
                        <div class="ar-about-us-4-title-box tp_fade_anim d-flex align-items-center mb-15">
                            <span class="tp-section-subtitle pre">{{ __('Benefit') }}</span>
                            <div class="ar-about-us-4-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                    <rect y="4" width="80" height="1" fill="#111013" />
                                    <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="tp-section-title lts tp_fade_anim">{{ __('Our benefit') }}</h3>
                    </div>
                </div>
            </div>

            <div class="tp-benefit-box">
                <div class="row gx-0">

                    @foreach($benefits as $benefit)
                        <div class="col-lg-3 col-md-6">
                            <div class="tp-benefit-item {{ $loop->iteration <= 4 ? 'tp-benefit-borber-bottom' : 'br' }}">
                                <div class="tp-benefit-item-icon pb-30">
                                <span>
                                    {{-- SVG/IMG Icon --}}
                                    @if($benefit->icon)
                                        <i class="{{$benefit->icon }} fa-xl"> </i>
                                    @else
                                        <img src="{{ asset('assets/front/img/benefits/' . $benefit->icon) }}" alt="{{ $benefit->title }}" width="44">
                                    @endif
                                </span>
                                </div>
                                <h4 class="tp-benefit-item-title" style="color: {{ $benefit->color }}">
                                    {{ convertUtf8($benefit->title) }}
                                </h4>
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

  {{--  <!-- career slider area start -->
    <div class="tp-career-slider-ptb pb-180">
        <div class="tp-career-slider-wrapper">
            <div class="tp-career-slider-active swiper-container">
                <div class="swiper-wrapper align-items-center slide-transtion">

                    @forelse ($jobs as $job)
                        <div class="swiper-slide">
                            <div class="tp-career-slider-thumb">
                                <a href="{{ route('front.careerdetails', [$job->slug]) }}">
                                    <img src="{{ asset('front/assets/img/jobs/' . $job->image) }}" alt="{{ $job->title }}">
                                </a>
                            </div>
                        </div>
                    @empty
                        <div class="swiper-slide">
                            <div class="tp-career-slider-thumb text-center">
                                <h4 class="text-muted">{{ __('NO JOB FOUND') }}</h4>
                            </div>
                        </div>
                    @endforelse

                </div>
            </div>
        </div>
    </div>
    <!-- career slider area end -->--}}


    <!-- career opening area start -->
    <section class="tp-career-opening-ptb pb-160">
        <div class="container container-1230">
            <div class="row mb-5">
                <div class="col-lg-6 mx-auto">
                    <form action="{{ route('front.career') }}">
                        <div class="searchbar d-flex align-items-center position-relative">
                            <input name="category" type="hidden" value="{{ request()->input('category') }}">
                            <input name="term" type="text" placeholder="{{ __('Search Jobs') }}" value="{{ request()->input('term') }}" class="form-control">
                            <button type="submit" class="btn position-absolute end-0 top-0 h-100 px-4 bg-dark text-white">
                                <i class="fa fa-search"></i>
                            </button>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-benefit-heading mb-100">
                        <div class="ar-about-us-4-title-box tp_fade_anim d-flex align-items-center mb-15">
                            <span class="tp-section-subtitle pre">{{ __('Benefit') }}</span>
                            <div class="ar-about-us-4-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                    <rect y="4" width="80" height="1" fill="#111013" />
                                    <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#111013" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="tp-section-title lts tp_fade_anim">{{ __('Current Openings') }}</h3>
                    </div>
                </div>
            </div>

            <div class="tp-career-opening-item">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>{{ __('Position') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>{{ __('Roles') }}</span>
                        </div>
                    </div>
                    <div class="col-lg-4">
                        <div class="tp-career-opening-heading">
                            <span>{{ __('Type') }}</span>
                        </div>
                    </div>
                </div>
            </div>

            @forelse ($jobs as $key => $job)
                <div class="tp-career-opening-item ptb">
                    <div class="row align-items-center">
                        <div class="col-lg-4">
                            <div class="tp-career-opening-title">
                                <h4 class="tp-career-opening-title-name">
                                    {{ convertUtf8($job->title) }}
                                </h4>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="tp-career-opening-role">
                            <span>
                                ({{ $job->vacancy ?? '01' }} {{ __('Open Role') }})
                            </span>
                            </div>
                        </div>
                        <div class="col-lg-4">
                            <div class="tp-career-opening-Type d-flex justify-content-between align-items-center">
                                <span>{{ $job->employment_status ?? 'Full-Time' }}</span>
                                <div class="tp-career-opening-btn">
                                    <a href="{{ route('front.careerdetails', [$job->slug]) }}" class="tp-btn-black btn-red-bg">
                                    <span class="tp-btn-black-filter-blur">
                                        <svg width="0" height="0">
                                            <defs>
                                                <filter id="buttonFilter{{ $key }}">
                                                    <feGaussianBlur in="SourceGraphic" stdDeviation="5" result="blur"></feGaussianBlur>
                                                    <feColorMatrix in="blur" values="1 0 0 0 0  0 1 0 0 0  0 0 1 0 0  0 0 0 19 -9"></feColorMatrix>
                                                    <feComposite in="SourceGraphic" in2="buttonFilter{{ $key }}" operator="atop"></feComposite>
                                                    <feBlend in="SourceGraphic" in2="buttonFilter{{ $key }}"></feBlend>
                                                </filter>
                                            </defs>
                                        </svg>
                                    </span>
                                        <span class="tp-btn-black-filter d-inline-flex align-items-center" style="filter: url(#buttonFilter{{ $key }})">
                                        <span class="tp-btn-black-text">{{ __('Apply Now') }}</span>
                                        <span class="tp-btn-black-circle">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M1 9L9 1M9 1H1M9 1V9" stroke="currentcolor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                            </svg>
                                        </span>
                                    </span>
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            @empty
                <div class="tp-career-opening-item ptb">
                    <div class="row align-items-center">
                        <div class="col text-center">
                            <h5 class="text-muted">{{ __('No job openings available at the moment.') }}</h5>
                        </div>
                    </div>
                </div>
                @endforelse
            </div>
        </section>
    <!-- career opening area end -->

@endsection
