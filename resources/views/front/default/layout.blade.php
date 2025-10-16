<!DOCTYPE html>
<html class="no-js @yield('html_class')" lang="zxx" @if($rtl == 1) dir="rtl" @endif>
<head>
    <!--Start of Google Analytics script-->
    @if ($bs->is_analytics == 1)
        {!! $bs->google_analytics_script !!}
    @endif
    <!--End of Google Analytics script-->
    <meta name="facebook-domain-verification" content="qb2ci5k6a7kbkn0dlgli038i0mhilp" />
    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$bs->website_title}} @yield('pagename')</title>
    @if(isset($blog) && $blog->canonical != null)
        <link rel="canonical" href="{{ $blog->canonical }}">
    @endif
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
    <!-- plugin css -->
    <link rel="stylesheet" href="{{asset('assets/front/css/plugin.min.css')}}">

    @yield('styles')
    <style>
        .tp-service-4-solution-item-content p{
            color: black !important;
        }
       
        .Btn-11 {
     display: flex;
    align-items: center;
    justify-content: flex-end;
    width: 45px;
    height: 45px;
    border: none;
    border-radius: 50%;
    cursor: pointer;
    position: relative;
    overflow: hidden;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    box-shadow: 0 4px 15px rgba(0, 166, 81, 0.3);
    background-color: rgb(0 166 81);
    position: fixed;
    right: 50px;
    bottom: 100px;
    z-index: 9999;
    transform: scale(1);
}

.Btn-11::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: linear-gradient(45deg, rgba(255,255,255,0.1), transparent);
    opacity: 0;
    transition: opacity 0.3s ease;
    border-radius: inherit;
}

/* plus sign */
.sign-22 {
     width: 100%;
    transition: all 0.4s cubic-bezier(0.25, 0.46, 0.45, 0.94);
    display: flex;
    align-items: center;
    justify-content: center;
    flex-direction: row;
    transform: scale(1);
}

.sign-22 svg {
  width: 17px;
  transition: transform 0.3s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.sign-22 svg path {
  fill: white;
  transition: fill 0.3s ease;
}
/* text */
.text-33 {
  position: absolute;
  left: 10px; /* يطلع على طول من بعد الأيقونة */
  top: 50%;
  transform: translateY(-50%) translateX(-20px); /* يبدأ داخل الأيقونة */
  opacity: 0;
  color: white;
  font-size: 1.2em;
  font-weight: 600;
  white-space: nowrap; /* عشان الكلمة متكسرش */
  transition: all 0.35s cubic-bezier(0.25, 0.46, 0.45, 0.94);
}

.text-33 a {
  color: inherit;
  text-decoration: none;
  transition: color 0.3s ease;
}
/* hover effect on button width */
.Btn-11:hover {
  width: 220px;
  border-radius: 40px;
  box-shadow: 0 8px 25px rgba(0, 166, 81, 0.4);
  transform: scale(1.05);
}

.Btn-11:hover::before {
  opacity: 1;
}

.Btn-11:hover .sign-22 {
  width: 30%;
  transform: scale(0.9);
}

.Btn-11:hover .sign-22 svg {
  transform: rotate(5deg);
}

/* hover effect button's text */
.Btn-11:hover .text-33 {
  opacity: 1;
  width: 70%;
  padding-left: 16px;
  transform: translateX(0);
  opacity: 1;
  transform: translateY(-50%) translateX(0); /* يخرج من جوة الأيقونة */
}
/* button click effect*/
.Btn-11:active {
  transform: scale(0.95) translate(1px, 1px);
  box-shadow: 0 2px 8px rgba(0, 166, 81, 0.3);
  transition: all 0.1s ease;
}

/* Focus state for accessibility */
.Btn-11:focus {
  outline: none;
  box-shadow: 0 4px 15px rgba(0, 166, 81, 0.3), 0 0 0 3px rgba(0, 166, 81, 0.2);
}

/* Smooth entrance animation */
@keyframes slideInUp {
  from {
    transform: translateY(100px);
    opacity: 0;
  }
  to {
    transform: translateY(0);
    opacity: 1;
  }
}

.Btn-11 {
  animation: slideInUp 0.6s cubic-bezier(0.25, 0.46, 0.45, 0.94) forwards;
}

        @media only screen and (max-width: 600px) {
            .page-seo{
                margin-top: 3rem !important;
            }
            .Btn-11{
                    right: 26px;
                    bottom: 115px;
            }
        }

        /* Pulse animation for quote button */
        @keyframes pulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.05); }
            100% { transform: scale(1); }
        }
    </style>

    @if ($bs->is_tawkto == 1 || $bex->is_whatsapp == 1)
        <style>
            .back-to-top.show {
                right: auto;
                left: 20px;
            }
        </style>
    @endif
    @if (count($langs) == 0)
        <style media="screen">
            .support-bar-area ul.social-links li:last-child {
                margin-right: 0px;
            }

            .support-bar-area ul.social-links::after {
                display: none;
            }
        </style>
    @endif

    <!-- jquery js -->
    <script src="{{asset('assets/front/js/jquery-3.3.1.min.js')}}"></script>

    @if ($bs->is_appzi == 1)
        <!-- Start of Appzi Feedback Script -->
        <script async src="https://app.appzi.io/bootstrap/bundle.js?token={{$bs->appzi_token}}"></script>
        <!-- End of Appzi Feedback Script -->
    @endif

    <!-- Start of Facebook Pixel Code -->
    @if ($be->is_facebook_pexel == 1)
        {!! $be->facebook_pexel_script !!}
    @endif
    <!-- End of Facebook Pixel Code -->

    <!--Start of Appzi script-->
    @if ($bs->is_appzi == 1)
        {!! $bs->appzi_script !!}
    @endif
    <!--End of Appzi script-->

    @if ($rtl == 1)
        <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;700&display=swap" rel="stylesheet">
        <!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/swiper-bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/font-awesome-pro.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/spacing.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/atropos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front/rtl/assets/css/main.css') }}">
        <!-- CSS here -->

        <style>
            body {
                font-family: 'Cairo', sans-serif !important;
            }
            .dgm-hero-text-box img{
                margin-right: 40px;
            }

            .dgm-footer-widget-social a{
                line-height: 40px !important;
            }
        </style>

    @else
        <!-- CSS here -->
        <link rel="stylesheet" href="{{ asset('front/assets/css/bootstrap.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/slick.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/swiper-bundle.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/magnific-popup.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/font-awesome-pro.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/spacing.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/atropos.min.css') }}">
        <link rel="stylesheet" href="{{ asset('front/assets/css/main.css') }}">
        <!-- CSS here -->

        <style>
             .content-with-image {
                    position: relative;
                }

                .content-with-image .float-img {
                    float: right; /* or left if you want */
                    margin: 0 0 20px 30px; /* space between text & image */
                    max-width: 45%; /* control image size */
                    border-radius: 8px; /* optional: rounded corners */
                }

                /* in mobile screen */
                @media (max-width: 768px) {
                    .content-with-image .float-img {
                    float: right; /* or left if you want */
                    margin: 0 0 20px 30px; /* space between text & image */
                    max-width: 100%; /* control image size */
                    border-radius: 8px; /* optional: rounded corners */
                }
                }

        </style>
    @endif
</head>
<body class="tp-magic-cursor" @if($rtl == 1) dir="rtl" @endif data-bg-color="@yield('data-bg-color')">

    <!-- Begin magic cursor -->
        <div id="magic-cursor">
            <div id="ball"></div>
        </div>
    <!-- End magic cursor -->
    <!-- preloader -->
    @if ($bex->preloader_status == 1)
        <div id="preloader">
            <div class="preloader">
                <span></span>
                <span></span>
            </div>
        </div>
    @endif
    <!-- preloader end  -->

    <!-- back to top start -->
        <div class="back-to-top-wrapper">
            <button id="back_to_top" type="button" class="back-to-top-btn">
                <svg width="12" height="7" viewBox="0 0 12 7" fill="none" xmlns="http://www.w3.org/2000/svg">
                    <path d="M11 6L6 1L1 6" stroke="currentColor" stroke-width="1.5" stroke-linecap="round"
                        stroke-linejoin="round"/>
                </svg>
            </button>
        </div>


         <button class="Btn-11" data-bs-toggle="modal" data-bs-target="#quoteModal">
             <div class="sign-22">
                 <svg viewBox="0 0 512 512">
                     <path d="M377.9 105.9L500.7 228.7c7.2 7.2 11.3 17.1 11.3 27.3s-4.1 20.1-11.3 27.3L377.9 406.1c-6.4 6.4-15 9.9-24 9.9c-18.7 0-33.9-15.2-33.9-33.9l0-62.1-128 0c-17.7 0-32-14.3-32-32l0-64c0-17.7 14.3-32 32-32l128 0 0-62.1c0-18.7 15.2-33.9 33.9-33.9c9 0 17.6 3.6 24 9.9zM160 96L96 96c-17.7 0-32 14.3-32 32l0 256c0 17.7 14.3 32 32 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32l-64 0c-53 0-96-43-96-96L0 128C0 75 43 32 96 32l64 0c17.7 0 32 14.3 32 32s-14.3 32-32 32z"></path>
                 </svg>
             </div>
         
             <div class="text-33">
                 <span>Request A Quote</span>
             </div>
         </button>
    <!-- back to top end -->


    <!--   header area start   -->
    @includeIf('front.default.partials.navbar')

    <div id="smooth-wrapper">
        <div id="smooth-content">
        <main>
            @yield('content')
        </main>

        <footer class="pb-20">

            <div class="dgm-footer-bg p-relative">

                <!-- footer area start -->
                <div class="dgm-footer-area black-bg-5 pt-100 pb-60">
                    <div class="container container-1430">
                        <div class="row">
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-40">
                                <div class="dgm-footer-widget dgm-footer-col-1 z-index-1 tp_fade_anim" data-delay=".3">
                                    <div class="dgm-footer-logo mb-30">
                                        <a href="{{ route('front.index') }}"><img data-width="120px"
                                                                                src="{{ asset('assets/front/img/'.$bs->footer_logo) }}"
                                                                                alt="footer logo"></a>
                                    </div>
                                    <div class="dgm-footer-widget-paragraph mb-35">
                                        <p>
                                            @if (strlen($bs->footer_text) > 194)
                                                {{ mb_substr($bs->footer_text, 0, 194, 'UTF-8') }}
                                                <span
                                                    style="display: none;">{{ mb_substr($bs->footer_text, 194, null, 'UTF-8') }}</span>
                                                <a href="#" class="see-more">{{ __('see more') }}...</a>
                                            @else
                                                {{ $bs->footer_text }}
                                            @endif
                                        </p>
                                    </div>
                                    <div class="dgm-footer-widget-social">
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
                            </div>
                            <div class="col-xl-2 col-lg-2  col-md-3 mb-40">
                                <div class="dgm-footer-widget dgm-footer-col-2 tp_fade_anim" data-delay=".4">
                                    <h4 class="dgm-footer-widget-title">{{ __('Useful Links') }}</h4>
                                    <div class="dgm-footer-widget-menu">
                                        <ul>
                                            @foreach ($ulinks as $ulink)
                                                <li><a href="{{ $ulink->url }}">{{ convertUtf8($ulink->name) }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-2 col-lg-2 col-md-3 mb-40">
                                <div class="dgm-footer-widget dgm-footer-col-3 tp_fade_anim" data-delay=".5">
                                    <h4 class="dgm-footer-widget-title">{{ __('Contact Info') }}</h4>
                                    <div class="dgm-footer-widget-menu">
                                        <ul>
                                            @php $addresses = explode(PHP_EOL, $bex->contact_addresses); @endphp
                                            @foreach ($addresses as $address)
                                                <li><a href="#">{{ $address }}</a></li>
                                            @endforeach
                                            @php $phones = explode(',', $bex->contact_numbers); @endphp
                                            @foreach ($phones as $phone)
                                                <li><a href="tel:{{ $phone }}">{{ $phone }}</a></li>
                                            @endforeach
                                            @php $mails = explode(',', $bex->contact_mails); @endphp
                                            @foreach ($mails as $mail)
                                                <li><a href="mail:{{$mail}}">{{$mail}}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="col-xl-4 col-lg-4 col-md-6 mb-40">
                                <div class="dgm-footer-widget dgm-footer-col-4 z-index-1 tp_fade_anim" data-delay=".6">
                                    <h4 class="dgm-footer-widget-title">{{ __('Subscribe Us') }}</h4>
                                    <div class="dgm-footer-widget-paragraph color-style mb-35">
                                        <p> {{ convertUtf8($bs->newsletter_text ?? 'Subscribe our newsletter for future updates. <br> Don’t worry, we won’t spam your email.') }}</p>
                                    </div>
                                    <div class="dgm-footer-widget-input p-relative">
                                        <form id="footerSubscribeForm"
                                            action="{{ route('front.subscribe') }}" method="POST">
                                            <input id="email" type="email" name="email"
                                                placeholder="{{ __('Enter your email...') }}" required>
                                            <span class="input-icon">
                                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                                            xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M16 2.5C16 1.675 15.325 1 14.5 1H2.5C1.675 1 1 1.675 1 2.5M16 2.5V11.5C16 12.325 15.325 13 14.5 13H2.5C1.675 13 1 12.325 1 11.5V2.5M16 2.5L8.5 7.74998L1 2.5"
                                                                stroke="#A1A4AA" stroke-width="1.5" stroke-linecap="round"
                                                                stroke-linejoin="round"/>
                                                        </svg>
                                                    </span>
                                            <button class="input-button" type="submit">
                                                        <span>
                                                            <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                                xmlns="http://www.w3.org/2000/svg">
                                                                <path
                                                                    d="M17.4918 0.523919C17.0417 0.0609703 16.3754 -0.110257 15.7541 0.0709359L1.2672 4.28277C0.611729 4.46578 0.147138 4.98852 0.0219872 5.65169C-0.105865 6.32754 0.340718 7.18639 0.924156 7.54515L5.45391 10.3283C5.9185 10.6146 6.51815 10.543 6.9026 10.1552L12.0896 4.93597C12.3507 4.66328 12.7829 4.66328 13.044 4.93597C13.3051 5.1978 13.3051 5.62451 13.044 5.8963L7.84799 11.1156C7.46263 11.5033 7.3906 12.1049 7.67422 12.5733L10.442 17.1484C10.7661 17.6911 11.3243 18 11.9366 18C12.0086 18 12.0896 18 12.1617 17.99C12.8639 17.9003 13.4222 17.4193 13.6293 16.7398L17.924 2.27243C18.1131 1.65638 17.942 0.985961 17.4918 0.523919Z"
                                                                    fill="currentcolor"/>
                                                                <path opacity="0.4"
                                                                    d="M6.7091 15.5302C6.97201 15.7957 6.97201 16.226 6.7091 16.4915L5.47919 17.7281C5.34774 17.8613 5.17487 17.9274 5.002 17.9274C4.82913 17.9274 4.65626 17.8613 4.5248 17.7281C4.261 17.4627 4.261 17.0332 4.5248 16.7678L5.75381 15.5302C6.01761 15.2657 6.44529 15.2657 6.7091 15.5302ZM6.00348 12.0984C6.26639 12.3639 6.26639 12.7942 6.00348 13.0597L4.77358 14.2963C4.64212 14.4295 4.46925 14.4956 4.29638 14.4956C4.12351 14.4956 3.95064 14.4295 3.81919 14.2963C3.55538 14.0309 3.55538 13.6014 3.81919 13.336L5.04819 12.0984C5.312 11.8339 5.73967 11.8339 6.00348 12.0984ZM2.61701 11.0182C2.87992 11.2836 2.87992 11.714 2.61701 11.9794L1.38711 13.216C1.25566 13.3492 1.08279 13.4154 0.909915 13.4154C0.737044 13.4154 0.564173 13.3492 0.432719 13.216C0.168911 12.9506 0.168911 12.5212 0.432719 12.2557L1.66172 11.0182C1.92553 10.7536 2.35321 10.7536 2.61701 11.0182Z"
                                                                    fill="currentcolor"/>
                                                            </svg>
                                                        </span>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!-- footer area end -->
                @if (!($bex->home_page_pagebuilder == 0 && $bs->copyright_section == 0))
                    <!-- copyright area start -->
                    <div class="tp-copyright-2-area tp-copyright-2-border black-bg-5">
                        <div class="container container-1430">
                            <div class="row align-items-center">
                                <div class="col-xl-4 col-lg-5 col-md-6">
                                    <div class="tp-copyright-2-left text-center text-md-start z-index-1">
                                        {!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- copyright area end -->
                @endif

            </div>

        </footer>
        </div>
    </div>

    {{-- WhatsApp Chat Button --}}
    <div id="WAButton"></div>

    @if ($bex->is_shop == 1 && $bex->catalog_mode == 0)
        <style>
            #cartIconWrapper {
                position: fixed;
                top: 50%;
                right: 0;
                transform: translateY(-50%);
                z-index: 9999;
                background: #00a651;
                    border-radius: 31px 0 0 31px;
                box-shadow: 0 8px 24px rgba(0,0,0,0.18);
                padding: 10px 18px 10px 10px;
                display: flex;
                flex-direction: column;
                align-items: center;
                min-width: 70px;
                transition: box-shadow 0.2s, background 0.2s;
            }
            #cartIconWrapper:hover {
                box-shadow: 0 12px 32px rgba(0,0,0,0.22);
                background: #a89c5d;
            }
            #cartIcon {
                display: flex;
                flex-direction: column;
                align-items: center;
                text-decoration: none;
                color: #fff;
            }
            .cart-length {
                display: flex;
                flex-direction: column-reverse;
                align-items: center;
                font-weight: bold;
                margin-bottom: 6px;
            }
            .cart-length i {
                font-size: 26px;
                color: #ffffffff;
                margin-bottom: 2px;
            }
            .cart-length .length {
                color: #ffffffff;
                font-size: 13px;
                font-weight: bold;
                background: none;
                border-radius: 0;
                padding: 0;
                margin: 0;
            }
            .cart-total {
                font-size: 14px;
                color: #e0e0e0;
                font-weight: 500;
                text-align: center;
            }
            @media (max-width: 600px) {
                #cartIconWrapper {
                    top: unset;
                    bottom: 10px;
                    right: 10px;
                    left: unset;
                    transform: none;
                    border-radius: 8px;
                    min-width: 60px;
                    padding: 8px 10px;
                }
                .cart-length i {
                    font-size: 20px;
                }
                .cart-total {
                    font-size: 12px;
                }
            }
        </style>
        <div id="cartIconWrapper">
            <a class="d-block" id="cartIcon" href="{{route('front.cart')}}">
                <div class="cart-length">
                    <i class="fas fa-cart-plus"></i>
                    <span class="length">{{cartLength()}}</span>
                </div>
                <div class="cart-total">
                    {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}
                    {{cartTotal()}}
                    {{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                </div>
            </a>
        </div>
    @endif


    {{-- Cookie alert dialog start --}}
    @if ($be->cookie_alert_status == 1)
        @include('cookie-consent::index')
    @endif
    {{-- Cookie alert dialog end --}}

    {{-- Popups start --}}
    @includeIf('front.partials.popups')
    {{-- Popups end --}}

    {{-- Global Subscription Modal --}}
    @includeIf('front.partials.subscription-modal')

    {{-- Global Quote Modal --}}
    @includeIf('front.partials.quote-modal')


    @php
        $mainbs = [];
        $mainbs = json_encode($mainbs);
    @endphp
    <script>
        var mainbs = {!! $mainbs !!};
        var mainurl = "{{url('/')}}";
        var vap_pub_key = "{{env('VAPID_PUBLIC_KEY')}}";
        var rtl = {{ $rtl }};
    </script>
    <!-- popper js -->
    <script src="{{asset('assets/front/js/popper.min.js')}}"></script>
    <!-- bootstrap js -->
    <script src="{{asset('assets/front/js/bootstrap.min.js')}}"></script>
    <!-- Plugin js -->
    <script src="{{asset('assets/front/js/plugin.min.js')}}"></script>
    <!-- main js -->
    <script src="{{asset('assets/front/js/main.js')}}"></script>
    <!-- pagebuilder custom js -->
    <script src="{{asset('assets/front/js/common-main.js')}}" defer></script>

    {{--               whatsapp init code--}}
    {{--@if ($bex->is_whatsapp == 1)
        <script type="text/javascript">
            var whatsapp_popup = {{$bex->whatsapp_popup}};
            var whatsappImg = "{{asset('assets/front/img/whatsapp.svg')}}";
            $(function () {
                $('#WAButton').floatingWhatsApp({
                    phone: "{{$bex->whatsapp_number}}", //WhatsApp Business phone number
                    headerTitle: "{{$bex->whatsapp_header_title}}", //Popup Title
                    popupMessage: `{!! nl2br($bex->whatsapp_popup_message) !!}`, //Popup Message
                    showPopup: whatsapp_popup == 1 ? true : false, //Enables popup display
                    buttonImage: '<img src="' + whatsappImg + '" />', //Button Image
                    position: "right" //Position: left | right

                });
            });
        </script>
    @endif--}}
    @yield('scripts')
    @stack('event-js')

    @if (session()->has('success'))
        <script>
            toastr["success"]("{{__(session('success'))}}");
        </script>
    @endif

    @if (session()->has('error'))
        <script>
            toastr["error"]("{{__(session('error'))}}");
        </script>
    @endif

    <!--Start of subscribe functionality-->
    <script>
        $(document).ready(function () {
            $("#subscribeForm, #footerSubscribeForm").on('submit', function (e) {
                // console.log($(this).attr('id'));

                e.preventDefault();

                let formId = $(this).attr('id');
                let fd = new FormData(document.getElementById(formId));
                let $this = $(this);

                $.ajax({
                    url: $(this).attr('action'),
                    type: $(this).attr('method'),
                    data: fd,
                    contentType: false,
                    processData: false,
                    success: function (data) {
                        // console.log(data);
                        if ((data.errors)) {
                            $this.find(".err-email").html(data.errors.email[0]);
                        } else {
                            toastr["success"]("You are subscribed successfully!");
                            $this.trigger('reset');
                            $this.find(".err-email").html('');
                        }
                    }
                });
            });


        });
    </script>
    <!--End of subscribe functionality-->

    <!-- Quote button animation -->
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const quoteButton = document.querySelector('.Btn-11');
            if (quoteButton) {
                quoteButton.addEventListener('click', function() {
                    // Add a subtle pulse effect
                    this.style.animation = 'none';
                    setTimeout(() => {
                        this.style.animation = 'pulse 0.6s ease-in-out';
                    }, 10);
                });
            }
        });
    </script>

    <!--Start of Tawk.to script-->
    @if ($bs->is_tawkto == 1)
        {!! $bs->tawk_to_script !!}
    @endif
    <!--End of Tawk.to script-->

    <!--Start of AddThis script-->
    @if ($bs->is_addthis == 1)
        {!! $bs->addthis_script !!}
    @endif
<!--End of AddThis script-->
@if($rtl == 1)

    <script src="{{ asset('front/rtl/assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/plugin.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/three.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/slick.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/scroll-magic.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/hover-effect.umd.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/parallax-slider.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/purecounter.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/Observer.min.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/splitting.min.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/webgl.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/atropos.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/slider-active.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/main.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/tp-cursor.js') }}"></script>
    <script src="{{ asset('front/rtl/assets/js/portfolio-slider-1.js') }}"></script>
    <script type="module" src="{{ asset('front/rtl/assets/js/distortion-img.js') }}"></script>
    <script type="module" src="{{ asset('front/rtl/assets/js/skew-slider/index.js') }}"></script>
    <script type="module" src="{{ asset('front/rtl/assets/js/img-revel/index.js') }}"></script>
@else
    <script src="{{ asset('front/assets/js/vendor/jquery.js') }}"></script>
    <script src="{{ asset('front/assets/js/bootstrap-bundle.js') }}"></script>
    <script src="{{ asset('front/assets/js/swiper-bundle.js') }}"></script>
    <script src="{{ asset('front/assets/js/plugin.js') }}"></script>
    <script src="{{ asset('front/assets/js/three.js') }}"></script>
    <script src="{{ asset('front/assets/js/slick.js') }}"></script>
    <script src="{{ asset('front/assets/js/scroll-magic.js') }}"></script>
    <script src="{{ asset('front/assets/js/hover-effect.umd.js') }}"></script>
    <script src="{{ asset('front/assets/js/magnific-popup.js') }}"></script>
    <script src="{{ asset('front/assets/js/parallax-slider.js') }}"></script>
    <script src="{{ asset('front/assets/js/nice-select.js') }}"></script>
    <script src="{{ asset('front/assets/js/purecounter.js') }}"></script>
    <script src="{{ asset('front/assets/js/isotope-pkgd.js') }}"></script>
    <script src="{{ asset('front/assets/js/imagesloaded-pkgd.js') }}"></script>
    <script src="{{ asset('front/assets/js/ajax-form.js') }}"></script>
    <script src="{{ asset('front/assets/js/Observer.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/splitting.min.js') }}"></script>
    <script src="{{ asset('front/assets/js/webgl.js') }}"></script>
    <script src="{{ asset('front/assets/js/parallax-scroll.js') }}"></script>
    <script src="{{ asset('front/assets/js/atropos.js') }}"></script>
    <script src="{{ asset('front/assets/js/slider-active.js') }}"></script>
    <script src="{{ asset('front/assets/js/main.js') }}"></script>
    <script src="{{ asset('front/assets/js/tp-cursor.js') }}"></script>
    <script src="{{ asset('front/assets/js/portfolio-slider-1.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/distortion-img.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/skew-slider/index.js') }}"></script>
    <script type="module" src="{{ asset('front/assets/js/img-revel/index.js') }}"></script>
@endif

</body>
</html>
