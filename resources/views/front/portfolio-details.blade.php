@extends("front.$version.layout")
@section('html_class')
    agntix-light
@endsection
@section('pagename')
    - {{convertUtf8($portfolio->title)}}
@endsection

@section('meta-keywords', "$portfolio->meta_keywords")
@section('meta-description', "$portfolio->meta_description")

@section('breadcrumb-title', convertUtf8($bs->portfolio_details_title))
@section('breadcrumb-subtitle', convertUtf8($portfolio->title))
@section('breadcrumb-link', __('Portfolio Details'))

@section('content')
    <!-- portfolio details 2 area start -->
    <div class="tp-pd-2-ptb pt-200 pb-80">
        <div class="container container-1230">
            <div class="row justify-content-center">
                <div class="col-lg-10">
                    <div class="tp-pd-2-top pb-70 text-center">
                        <div class="tp-pd-2-categories mb-30 tp_fade_anim" data-delay=".3">
                            <span>@foreach($portfolio->scategories as $service) {{ $service->name }} @if(!$loop->last) , @endif @endforeach</span>
                        </div>
                        <h3 class="tp-pd-2-title tp_fade_anim"
                            data-delay=".5">{{ $portfolio->title ? convertUtf8($portfolio->title) : __('Olivia Rivers') }}</h3>
                    </div>
                    <div class="tp-pd-2-bottom d-flex justify-content-between tp_fade_anim" data-delay=".7">
                        <div class="tp-pd-2-bottom-item text-center">
                            <span>{{ __('Client') }}</span>
                            <h6>{{convertUtf8($portfolio->client_name)}}</h6>
                        </div>
                        <div class="tp-pd-2-bottom-item text-center">
                            <span>{{ __('Duration') }}</span>
                            <h6>
                                @if ($portfolio->start_date != null && $portfolio->submission_date != null)
                                    @php
                                        $startDate = Carbon\Carbon::parse($portfolio->start_date);
                                        $endDate = Carbon\Carbon::parse($portfolio->submission_date);
                                        $diff = $startDate->diffInDays($endDate);
                                    @endphp
                                    {{ $diff }} {{ __('Days') }}
                                @else
                                    {{ __('N/A') }}
                                @endif
                            </h6>
                        </div>
                        <div class="tp-pd-2-bottom-item text-center">
                            <span>{{ __('Executor') }}</span>
                            <h6>{{ __('We') }}</h6>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- portfolio details 2 area end -->

    <!-- portfolio details area start -->
    <div class="tp-pd-2-area pb-140">
        <div class="container-fluid p-0">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-pd-2-banner">
                        <img data-speed=".8" src="{{ $portfolio->featured_image ? asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image) : asset('front/assets/img/portfolio/portfolio-details-2/portfolio-details-thumb-1.jpg') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- portfolio details area end -->

    <!-- portfolio details overview start -->
    <div class="tp-pd-2-overview-ptb pb-70">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-6">
                    <div class="tp-pd-2-overview-heading tp_fade_anim" data-delay=".3">
                        <h3 class="tp-pd-2-overview-title">{{ __('brand_content') }}</h3>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="tp-pd-2-overview-wrap">
                        {!! $portfolio->brand_content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- portfolio details overview end -->

    <!-- portfolio details thumb slider -->
    <div class="tp-pd-2-slider-ptb pb-140">
        <div class="container-fluid">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-pd-2-slider-wrapper">
                        <div class="tp-pd-2-active swiper">
                            <div class="swiper-wrapper">
                                @foreach ($portfolio->portfolio_images as $key => $pi)
                                <div class="swiper-slide">
                                    <div class="tp-pd-2-slider-thumb">
                                        <img src="{{asset('assets/front/img/portfolios/sliders/'.$pi->image)}}" alt="{{$pi->id}}">
                                    </div>
                                </div>
                                @endforeach
                            </div>
                            <div class="tp-pd-2-dot text-center"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- portfolio details thumb slider -->

    <!-- portfolio details step start -->
    <div class="tp-pd-2-step-ptb pb-70">
        <div class="container container-1230">
        {!! replaceBaseUrl(convertUtf8($portfolio->content)) !!}
        </div>
    </div>
    <!-- portfolio details step end -->


    <!-- portfolio details np start -->
    <div class="tp-pd-2-np-ptb pb-120">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-pd-2-np-content d-flex justify-content-center align-items-center flex-wrap">
                        @if($navigation['prev'])
                        <div class="tp_fade_anim" data-delay=".3" data-fade-from="top" data-ease="bounce">
                            <a href="{{ route('front.portfoliodetails', $navigation['prev']->slug) }}">
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="13" height="14" viewBox="0 0 13 14" fill="none">
                                        <path d="M0.250745 12.3137C0.250745 12.7279 0.586531 13.0637 1.00074 13.0637H7.75074C8.16496 13.0637 8.50074 12.7279 8.50074 12.3137C8.50074 11.8995 8.16496 11.5637 7.75074 11.5637L1.75074 11.5637L1.75074 5.56371C1.75074 5.14949 1.41496 4.81371 1.00074 4.81371C0.586531 4.81371 0.250745 5.14949 0.250745 5.56371V12.3137ZM12.3145 1L11.7841 0.46967L0.470415 11.7834L1.00074 12.3137L1.53107 12.844L12.8448 1.53033L12.3145 1Z" fill="currentColor" />
                                    </svg>
                                </span>
                                {{ __('Prev Work') }}
                            </a>
                        </div>
                        @endif

                        @if($navigation['next'])
                        <div class="tp_fade_anim" data-delay=".5" data-fade-from="top" data-ease="bounce">
                            <a href="{{ route('front.portfoliodetails', $navigation['next']->slug) }}">
                                {{ __('Next Work') }}
                                <span>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="14" height="13" viewBox="0 0 14 13" fill="none">
                                        <path d="M13.0637 0.828381C13.0637 0.414168 12.7279 0.0783817 12.3137 0.0783812L5.56371 0.0783814C5.14949 0.0783814 4.81371 0.414168 4.81371 0.828382C4.81371 1.2426 5.14949 1.57838 5.56371 1.57838H11.5637V7.57838C11.5637 7.9926 11.8995 8.32838 12.3137 8.32838C12.7279 8.32838 13.0637 7.9926 13.0637 7.57838L13.0637 0.828381ZM1 12.1421L1.53033 12.6724L12.844 1.35871L12.3137 0.828382L11.7834 0.298051L0.46967 11.6118L1 12.1421Z" fill="currentColor" />
                                    </svg>
                                </span>
                            </a>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- portfolio details np end -->

@endsection
