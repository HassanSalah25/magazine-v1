@extends("front.$version.layout")

@section('data-bg-color', '#020202')

@section('pagename')
    -
    @if (empty($category))
        {{__('All')}}
    @else
        {{convertUtf8($category->name)}}
    @endif
    {{__('Portfolios')}}
@endsection

@section('meta-keywords', "$be->portfolios_meta_keywords")
@section('meta-description', "$be->portfolios_meta_description")

@section('content')
    <!-- project area start -->
    <div class="design-project-area pt-200 pb-80 title-box">
        <div class="container container-1680">
            <div class="design-project-title-wrap p-relative mb-140">
                <div class="tp-portfolio-metro-shape">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="732" height="9" viewBox="0 0 732 9"
                                           fill="none">
                                        <path d="M728 7.96512L731.5 4.48256L728 1M1 4H731V5H1V4Z" stroke="#E0EEEE"
                                              stroke-opacity="0.8" stroke-linecap="round" stroke-linejoin="round"/>
                                    </svg> {{ __('Know More') }}</span>
                </div>
                <div class="row align-items-end">
                    <div class="col-xl-9 col-lg-9 col-md-9">
                        <div class="design-project-title-box">
                            <h4 class="tp-section-title-dirtyline">
                                <span
                                    class="tp-text-right-scroll tp_text_invert_2">{{ $bs->portfolio_title ? convertUtf8($bs->portfolio_title) : __('recent')}}</span>
                                <br>
                                <span
                                    class="tp_text_invert_2">{{ $bs->portfolio_subtitle ? convertUtf8($bs->portfolio_subtitle) : __('recent')}}</span>
                            </h4>
                        </div>
                    </div>
                    <div class="col-xl-3 col-lg-3 col-md-3">
                        <div class="tp-portfolio-metro-social text-md-end pb-50">
                            @if (!empty($socials))
                                @foreach ($socials as $social)
                                    <div>
                                        <a href="{{ $social->url }}">
                                                <span>
                                                    <i class="{{ $social->icon }}"></i>
                                                </span>
                                        </a>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
                <div id="top" class="design-project-item-wrap">
                    @if (count($portfolios) == 0)
                        <div class="col-lg-12 py-5 bg-light text-center mb-4">
                            <h3>{{__('NO PORTFOLIO FOUND')}}</h3>
                        </div>
                    @else
                        @foreach ($portfolios as $key => $portfolio)
                            @if($loop->iteration % 2 == 0)
                                <div class="design-project-item mb-120">
                                    <div class="row align-items-center">
                                        <div class="col-xl-5 order-xl-0 order-1">
                                            <div class="design-project-content pr-200">
                                                <h4 class="design-project-title tp_reveal_anim"><a
                                                        href="{{route('front.portfoliodetails', [$portfolio->slug])}}">{{strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title}}</a>
                                                </h4>
                                                <span class="tp_reveal_anim">
                                                    @foreach($portfolio->scategories as $service) {{ $service->name }} @if(!$loop->last) , @endif @endforeach
                                                </span>
                                                <a class="tp-btn-sky-border height-50"
                                                   href="{{route('front.portfoliodetails', [$portfolio->slug])}}">{{__('View project')}}</a>
                                            </div>
                                        </div>
                                        <div class="col-xl-7 order-xl-1 order-0">
                                            <div class="design-project-thumb item-1 text-end">
                                                <img
                                                    src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}"
                                                    alt="{{ $portfolio->title }}">
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @else
                                <div class="design-project-item mb-120">
                                    <div class="row align-items-center">
                                        <div class="col-xl-7">
                                            <div class="design-project-thumb item-2">
                                                <img
                                                    src="{{asset('assets/front/img/portfolios/featured/'.$portfolio->featured_image)}}"
                                                    alt="{{ $portfolio->title }}">
                                            </div>
                                        </div>
                                        <div class="col-xl-5">
                                            <div class="design-project-content pl-200">
                                                <h4 class="design-project-title tp_reveal_anim"><a
                                                        href="{{route('front.portfoliodetails', [$portfolio->slug])}}">{{strlen($portfolio->title) > 25 ? mb_substr($portfolio->title, 0, 25, 'utf-8') . '...' : $portfolio->title}}</a>
                                                </h4>
                                                <span class="tp_reveal_anim">
                                                    @foreach($portfolio->scategories as $service) {{ $service->name }} @if(!$loop->last) , @endif @endforeach
                                                </span>
                                                <a class="tp-btn-sky-border height-50"
                                                   href="{{route('front.portfoliodetails', [$portfolio->slug])}}">{{ __('View project') }}</a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endif
                        @endforeach
                        {{ $portfolios->appends(request()->query())->links('vendor.pagination.custom') }}
                    @endif
                </div>
            </div>
        </div>
        <!-- project area end -->

@endsection

