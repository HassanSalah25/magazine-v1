@extends("front.$version.layout")
@section('html_class')
    agntix-light
@endsection
@section('pagename')
    - {{__('Service')}} - {{convertUtf8($service->title)}}
@endsection

@section('meta-keywords', "$service->meta_keywords")
@section('meta-description', "$service->meta_description")


@section('content')
    <!-- about area start -->
    <div class="pp-about-area pp-service-details-ptb p-relative pb-100">
        <div class="pp-about-shape">
            <img data-speed=".8" src="{{ asset('front/assets/img/home-14/about/about-shape.png') }}" alt="">
        </div>
        <div class="pp-service-shape service-details-shape">
            <img data-speed="1.1" src="{{ asset('front/assets/img/home-14/about/about-shape-2.png') }}" alt="">
        </div>
        <div class="pp-service-details-top pb-50">
            <div class="container container-1230">
                <div class="row">
                    <div class="col-lg-12">
                        <div class="pp-service-details-heading pb-55 tp_fade_anim mb-80" data-delay=".3">
                            <h3 class="pp-service-details-title">
                                {{ convertUtf8($service->title) }}
                                <i>
                                    <svg xmlns="http://www.w3.org/2000/svg" width="123" height="130" viewBox="0 0 123 130" fill="none">
                                        <path d="M58.2803 1.15449C63.3023 14.3017 71.049 54.3533 48.1082 67.0973C36.1831 73.4283 11.7107 77.3064 2.37778 43.9355C-1.14293 31.3468 9.61622 20.8908 32.0893 28.8395C45.055 33.4255 76.4207 44.0467 90.5787 70.0771C98.0511 83.8154 104.166 111.84 99.1745 129.671M99.1745 129.671C100.942 121.014 108.128 104.495 122.737 107.673M99.1745 129.671C100.181 123.978 97.0522 110.014 76.485 99.698M75.3644 33.2431C80.479 35.6688 96.6446 46.4742 101.81 64.2891" stroke="black" stroke-width="1.5" />
                                    </svg>
                                </i>
                                <br>
                                 <span>
                                     {{$service->scategory->name }}
                                     <svg xmlns="http://www.w3.org/2000/svg" width="22" height="21" viewBox="0 0 22 21" fill="none">
                                                    <path d="M1.95047 15.9635C0.349769 15.5874 0.171812 13.4796 1.68557 12.8255L1.93099 12.7195C6.64382 10.6828 10.2834 6.75878 11.9603 1.90627C12.481 0.397291 14.6914 0.346013 15.2509 1.82979L21.2703 17.8126C21.3776 18.0967 21.4017 18.4043 21.34 18.7025C21.2783 19.0007 21.133 19.2781 20.9199 19.5049C20.7068 19.7317 20.4338 19.8993 20.1304 19.9897C19.827 20.0801 19.5047 20.0898 19.198 20.0178L1.95047 15.9635Z" fill="#FFF669" />
                                                </svg>
                                 </span>
                            </h3>
                        </div>
                        <div class="pp-service-details-about-wrap ">
                            <div class="pp-about-content tp_text_anim">
                                <p>
                                    {{ convertUtf8($bs->service_details_title) }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pp-service-details-bottom">
            <div class="container container-1230">
                <div class="row gx-0">
                    @foreach($statistics as $statistic)
                    <div class="col-lg-4 col-md-6">
                        <div class="pp-service-details-about-item mb-30 tp_fade_anim" data-delay=".3">
                            <span>
                                <i data-purecounter-duration="1" data-purecounter-end="{{ $statistic->quantity }}" class="purecounter">0</i> %
                            </span>
                            <p>{{ $statistic->title }}</p>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
    <!-- about area end -->
    <!-- add service summary -->
    <div class="pp-service-details-summary-area pb-60">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pp-service-details-summary-content tp_text_anim">
                        <p>
                            {{ $service->summary ?? '' }}
                        </p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- banner area start -->
    <div class="tp-service-4-banner-area p-relative">
        <div class="ar-banner-wrap ar-about-us-4">
            <img class="w-100" src="{{ $service->main_image ? asset('assets/front/img/services/' . $service->main_image) : asset('assets/front/img/services/default.jpg') }}"
                 alt="" data-speed=".8">
        </div>
    </div>
    <!-- banner area end -->

    <!-- ovareview area start -->
    <div class="pp-service-details-overview-ptb pt-140 pb-110">
    <div class="container container-1230">
        <div class="row">
            <div class="col-lg-12">
                <div class="pp-service-details-overview-heading">
                    <h4 class="pp-service-details-overview-title tp_fade_anim" data-delay=".3">
                        {{ __('Service Overview') }}
                    </h4>
                </div>
            </div>

            <div class="col-lg-12">
                <div class="pp-service-details-overview-wrapper" style="padding-left: 30px;">
                    <div class="content-with-image">
                        <img src="{{ asset('assets/front/img/services/' . $service->second_image) }}" 
                             alt="" class="float-img">
                        {!! $service->content !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

    <!-- ovareview area end -->

    <!-- service details solution area start -->
    <div class="pp-service-details-solution-ptb pb-90">
        <div class="container container-1230">
            <div class="row">
                @php
                    $service_tabs = json_decode($service->nav_tab ?? '[]', true);
                @endphp
                @if (!empty($service_tabs))
                    @foreach ($service_tabs as $index => $service_tab)
                    <div class="col-lg-4 col-md-6">
                        <div class="tp-service-4-solution-item service-details mb-30 tp_fade_anim" data-delay=".3">
                            <div class="tp-service-4-solution-item-icon">
                                <span><svg xmlns="http://www.w3.org/2000/svg" width="60" height="60" viewBox="0 0 60 60" fill="none">
                                                    <path d="M59.2609 59.9944C59.167 59.9968 59.0734 59.9805 58.9858 59.9464C58.8983 59.9123 58.8183 59.861 58.7508 59.7956L43.9892 45.704L30.5338 59.7718C30.4648 59.8439 30.3819 59.9013 30.2902 59.9406C30.1984 59.9798 30.0996 60 29.9999 60C29.9001 60 29.8013 59.9798 29.7095 59.9406C29.6178 59.9013 29.5349 59.8439 29.4659 59.7718L16.0107 45.704L1.24906 59.7956C1.14439 59.8955 1.0127 59.9625 0.870324 59.9882C0.727945 60.014 0.581145 59.9973 0.448134 59.9404C0.315123 59.8834 0.201754 59.7887 0.122091 59.6679C0.0424276 59.5471 -2.49001e-05 59.4056 1.0957e-08 59.2609C1.0957e-08 59.2609 0.000443676 28.6391 0.00147816 28.6206C0.013607 28.4349 0.0951674 28.2605 0.229951 28.1322L29.4869 0.20316C29.7696 -0.0667097 30.2338 -0.0692224 30.5146 0.204638L59.7718 28.1338C59.9068 28.2629 59.9878 28.4384 59.9987 28.6249C59.9996 28.6391 60 59.22 60 59.2611C59.9999 59.6911 59.6378 59.9861 59.2609 59.9944ZM17.0796 44.6837L29.9999 58.1921L42.9201 44.6837L29.9999 32.3497L17.0796 44.6837ZM45.0106 44.6361L58.522 57.5342V30.5096L45.0106 44.6361ZM1.47768 30.5096V57.5341L14.9891 44.6361L1.47768 30.5096ZM30.7388 31.0121L43.9416 43.6156L58.2157 28.6917L30.7388 2.46203V31.0121ZM1.78404 28.6917L16.0581 43.6156L29.2609 31.0121V2.46203L1.78404 28.6917Z" fill="black" />
                                                </svg></span>
                            </div>
                            <div class="tp-service-4-solution-item-content">
                                <h4 class="tp-service-4-solution-item-title">
                                    {{ $service_tab['title'] }}
                                </h4>
                                {!! $service_tab['text'] !!}
                            </div>
                        </div>
                    </div>
                    @endforeach
                @endif
            </div>
        </div>
    </div>
    <!-- service details solution area end -->

    <!-- service details thumb area start -->
    <div class="pp-service-details-thumb-ptb pb-90">
        <div class="container container-1430">
            <div class="row">
                @foreach($service->scategory->portfolios as $portfolio)
                    <div class="col-lg-6">
                        <div class="pp-service-details-thumb fix mb-30">
                            <div class="tp_img_reveal">
                                <img src="{{ asset('assets/front/img/portfolios/featured/' . $portfolio->featured_image) }}" alt="">
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    </div>
    <!-- service details thumb area end -->

    <!-- service details process area start -->
    <div class="pp-service-details-process-ptb pt-130 pb-90" data-bg-color="#F6F6F9">
        <div class="container container-1350">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pp-service-details-process-heading text-center pb-100 tp_fade_anim" data-delay=".3">
                                    <span class="pp-service-details-process-subtitle"><svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                            <circle cx="5" cy="5" r="5" fill="currentColor" />
                                        </svg> {{ __('Working Process') }}</span>
                        <h3 class="pp-service-details-process-title">{{__('Product making for friendly users')}}</h3>
                    </div>
                </div>
            </div>
            <div class="pp-service-details-process-box z-index-1 pb-40 tp_fade_anim" data-delay=".5">
                <div class="row">
                    @php
                        $steps = explode(',', $service->process_list);
                    @endphp

                    @foreach($steps as $index => $step)
                    <div class="col-lg-3 col-sm-6">
                        <div class="pp-service-details-process-item text-center mb-30">
                            <span>{{ $loop->iteration }}</span>
                            <h4>{{$step}}</h4>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            <div class="row">
                <div class="col-lg-12">
                    <div class="pp-service-details-process-bottom text-center">
                                    <span>{{ __('Don’t hesitate collaborate with expertise') }} - <a href="{{ route('front.quote') }}"><svg xmlns="http://www.w3.org/2000/svg" width="25" height="11" viewBox="0 0 25 11" fill="none">
                                                <path d="M18.675 10.0096L24.72 5.70942C24.806 5.64025 24.8766 5.54578 24.9255 5.43455C24.9744 5.32331 25 5.19883 25 5.07235C25 4.94587 24.9744 4.82138 24.9255 4.71015C24.8766 4.59892 24.806 4.50445 24.72 4.43528L18.675 0.135054C18.5572 0.0563568 18.4215 0.0281769 18.2892 0.0549569C18.157 0.0817369 18.0358 0.161954 17.9446 0.282961C17.8535 0.403968 17.7977 0.558882 17.7859 0.723281C17.7742 0.88768 17.8072 1.05221 17.8798 1.19094L19.633 4.335L0.598757 4.335C0.439957 4.335 0.287661 4.41268 0.175371 4.55096C0.0630817 4.68924 0 4.87679 0 5.07235C0 5.26791 0.0630817 5.45545 0.175371 5.59373C0.287661 5.73201 0.439957 5.8097 0.598757 5.8097L19.633 5.8097L17.8798 8.95376C17.8072 9.09249 17.7742 9.25702 17.7859 9.42142C17.7977 9.58582 17.8535 9.74073 17.9446 9.86174C18.0358 9.98274 18.157 10.063 18.2892 10.0897C18.4215 10.1165 18.5572 10.0883 18.675 10.0096Z" fill="currentColor" />
                                            </svg> {{ __('Let’s Talk') }}</a></span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- service details process area end -->

    <!-- price area start -->
    <div class="app-price-area p-relative pb-130 mt-100">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-12">
                    <div class="tp-service-5-price-heading service-details d-flex align-items-start pb-70 tp_fade_anim">
                        <div class="ar-about-us-4-title-box d-flex align-items-center mb-20">
                            <span class="tp-section-subtitle pre">{{ __('pricing plans') }}</span>
                            <div class="ar-about-us-4-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                    <rect y="4" width="80" height="1" fill="#000" />
                                    <path d="M77 7.96366L80.5 4.48183L77 1" stroke="#000" stroke-linecap="round" stroke-linejoin="round" />
                                </svg>
                            </div>
                        </div>
                        <h3 class="tp-career-title fs-100">{{ __('Profitable pricing plans') }}</h3>
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
        </div>
    </div>
    <!-- price area end -->

    @if($faqs->count() > 0)
    <!-- FAQ area start -->
    <div class="pp-service-details-faq-ptb pt-130 pb-90">
        <div class="container container-1230">
            <div class="row">
                <div class="col-lg-12">
                    <div class="pp-service-details-faq-heading text-center pb-100 tp_fade_anim" data-delay=".3">
                        <span class="pp-service-details-faq-subtitle">
                            <svg xmlns="http://www.w3.org/2000/svg" width="10" height="10" viewBox="0 0 10 10" fill="none">
                                <circle cx="5" cy="5" r="5" fill="currentColor" />
                            </svg> {{ __('Frequently Asked Questions') }}
                        </span>
                        <h3 class="pp-service-details-faq-title">{{ __('Common Questions About') }} {{ convertUtf8($service->title) }}</h3>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 offset-lg-2">
                    <div class="pp-service-details-faq-wrapper">
                        <div class="accordion" id="faqAccordion">
                            @foreach($faqs as $index => $faq)
                            <div class="accordion-item mb-20">
                                <h2 class="accordion-header" id="heading{{ $index }}">
                                    <button class="accordion-button {{ $index == 0 ? '' : 'collapsed' }}" type="button" 
                                            data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}" 
                                            aria-expanded="{{ $index == 0 ? 'true' : 'false' }}" 
                                            aria-controls="collapse{{ $index }}">
                                        {{ convertUtf8($faq->question) }}
                                    </button>
                                </h2>
                                <div id="collapse{{ $index }}" class="accordion-collapse collapse {{ $index == 0 ? 'show' : '' }}" 
                                     aria-labelledby="heading{{ $index }}" data-bs-parent="#faqAccordion">
                                    <div class="accordion-body">
                                        {!! convertUtf8($faq->answer) !!}
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- FAQ area end -->
    @endif
@endsection
