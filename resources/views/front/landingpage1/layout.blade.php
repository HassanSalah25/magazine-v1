<!DOCTYPE html>
<html lang="en">
<head>
    <!--Start of Google Analytics script-->
    @if ($bs->is_analytics == 1)
        {!! $bs->google_analytics_script !!}
    @endif
    <!--End of Google Analytics script-->

    <meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge"/>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <meta name="description" content="@yield('meta-description')">
    <meta name="keywords" content="@yield('meta-keywords')">

    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{$bs->website_title}} @yield('pagename')</title>
    <!-- favicon -->
    <link rel="shortcut icon" href="{{asset('assets/front/img/'.$bs->favicon)}}" type="image/x-icon">
    @yield('styles')

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


    @if ($rtl == 1)
    @endif

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

    <link rel="stylesheet" href="{{ asset('front/assets8/css/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/fontawesome-all.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/flaticon.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/animate.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/nice-select.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/odometer-theme-default.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/video.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/owl.carousel.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/jquery.mCustomScrollbar.min.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/slick-theme.css') }}">
    <link rel="stylesheet" href="{{ asset('front/assets8/css/slick.css') }}">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="{{ asset('front/assets8/css/style.css') }}">

</head>
<body>
<div class="up">
    <a href="#" class="scrollup text-center"><i class="fas fa-chevron-up"></i></a>
</div>
<!--   header area start   -->
@include('front.landingpage1.partials.navbar')

@yield('content')


<section id="gl-footer-1" class="gl-footer-section-1">
    <div class="container">
        <div class="gl-footer-widget-wrapper">
            <div class="row">
                {{-- Logo and About --}}
                <div class="col-lg-4 col-md-6">
                    <div class="gl-footer-widget ul-li headline pera-content">
                        <div class="logo-widget">
                            <div class="site-logo">
                                <a href="{{ route('front.index') }}">
                                    <img src="{{ asset('assets/front/img/' . $bs->footer_logo) }}"
                                         style="width: 50%; margin-bottom: 30px; filter: invert(1);" alt="Footer Logo">
                                </a>
                            </div>
                            <p>
                                {{ Str::limit($bs->footer_text, 150) }}
                            </p>
                            <div class="gl-footer-social">
                                <span>Social Account</span>
                                <ul>
                                    @foreach ($socials as $social)
                                        <li><a href="{{ $social->url }}"><i class="{{ $social->icon }}"></i></a></li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>

                {{-- Quick Links --}}
                <div class="col-lg-2 col-md-6">
                    <div class="gl-footer-widget ul-li-block headline pera-content">
                        <div class="menu-widget">
                            <h3 class="widget-title">{{ __('Quick Links') }}</h3>
                            <ul>
                                @foreach ($ulinks as $ulink)
                                    <li><a href="{{ $ulink->url }}">{{ convertUtf8($ulink->name) }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Support Links (if any custom list, replace this section with dynamic) --}}
                <div class="col-lg-2 col-md-6">
                    <div class="gl-footer-widget ul-li-block headline pera-content">
                        <div class="menu-widget">
                            <h3 class="widget-title">{{ __('Helps & Support') }}</h3>
                            <ul>
                                <li><a href="{{ route('front.packages') }}">{{ __('Pricing') }}</a></li>
                                <li><a href="{{ route('front.team') }}">{{ __('Team') }}</a></li>
                                <li><a href="{{ route('front.services') }}">{{ __('Services') }}</a></li>
{{--                                <li><a href="{{ route('front.tes') }}">{{ __('Testimonials') }}</a></li>--}}
{{--                                <li><a href="{{ route('front.contact') }}">{{ __('Contact') }}</a></li>--}}
                            </ul>
                        </div>
                    </div>
                </div>

                {{-- Contact Info --}}
                <div class="col-lg-4 col-md-6">
                    <div class="gl-footer-widget ul-li-block headline pera-content">
                        <div class="address-widget">
                            <h3 class="widget-title">{{ __('Get in touch') }}</h3>
                            <ul>
                                @foreach (explode(PHP_EOL, $bex->contact_addresses) as $address)
                                    <li><i class="fas fa-map-marker-alt"></i> <span>{{ $address }}</span></li>
                                @endforeach
                                @foreach (explode(',', $bex->contact_mails) as $mail)
                                    <li><i class="fas fa-envelope"></i> <span>{{ trim($mail) }}</span></li>
                                @endforeach
                                @foreach (explode(',', $bex->contact_numbers) as $phone)
                                    <li><i class="fas fa-phone-alt"></i> <span>{{ trim($phone) }}</span></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Copyright --}}
    <div class="gl-footer-copyright">
        <div class="container">
            <div class="gl-footer-copyright-content d-flex justify-content-between">
                <div class="copyright-text">
                    {!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}
                </div>
                <div class="copyright-menu ul-li">
                    <ul>
{{--                        <li><a href="{{ route('front.terms') }}">{{ __('Terms & Condition') }}</a></li>--}}
{{--                        <li><a href="{{ route('front.privacy') }}">{{ __('Privacy Policy') }}</a></li>--}}
                    </ul>
                </div>
            </div>
        </div>
    </div>
</section>



{{-- WhatsApp Chat Button --}}
<div id="WAButton"></div>

<!--====== PRELOADER PART START ======-->
@if ($bex->preloader_status == 1)
    <div id="preloader"></div>
@endif
<!--====== PRELOADER PART ENDS ======-->



{{-- Cookie alert dialog start --}}
@if ($be->cookie_alert_status == 1)
    @include('cookie-consent::index')
@endif
{{-- Cookie alert dialog end --}}

{{-- Popups start --}}
@includeIf('front.partials.popups')
{{-- Popups end --}}

<!-- dark light switcher start-->
<div class="modal-sidebar-scroll rts-dark-light">
    <ul>
        <li class="go-dark-w"><span>Dark</span><i class="fa fa-solid fa-moon"></i></li>
        <li class="go-light-w"><span>Light</span><i class="fa fa-solid fa-sun"></i></li>

        <!-- <li><i class=" fa-moon"></i></li> -->
    </ul>
</div>
<!-- dark light switcher end -->

<!-- free analysis start-->
<div class="modal-sidebar-scroll rts-dark-light" style="top: 60% !important;">
    <button id="toggleModalBtn"  data-bs-toggle="modal" data-bs-target="#seoFormModal">
        <i class="fa-solid mx-1 fa-magnifying-glass"></i>
        <span class="d-none d-md-inline-block">Free Analysis</span>
    </button>
</div>
<!-- free analysis end -->

<!-- Modal -->
<div class="modal fade" id="seoFormModal" tabindex="-1" aria-labelledby="seoFormLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-slideout modal-dialog-end">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="seoFormLabel">SEO Analyzer Form</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <form method="POST" action="{{ route('seo.analyze') }}">
                    @csrf
                    <div class="mb-3">
                        <label for="website" class="form-label">Website URL</label>
                        <input type="url" class="form-control" id="website" name="website" placeholder="https://example.com" required>
                    </div>
                    <button type="submit" class="btn btn-primary w-100">Analyze Now</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!--End of AddThis script-->
<script src="{{ asset('front/assets8/js/jquery.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/bootstrap.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/popper.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/jquery.magnific-popup.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/appear.js') }}"></script>
<script src="{{ asset('front/assets8/js/slick.js') }}"></script>
<script src="{{ asset('front/assets8/js/jquery.counterup.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/waypoints.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/imagesloaded.pkgd.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/jquery.filterizr.js') }}"></script>
<script src="{{ asset('front/assets8/js/odometer.js') }}"></script>
<script src="{{ asset('front/assets8/js/pagenav.js') }}"></script>
<script src="{{ asset('front/assets8/js/jquery.mCustomScrollbar.concat.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/wow.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/parallax-scroll.js') }}"></script>
<script src="{{ asset('front/assets8/js/jquery.cssslider.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/owl.carousel.min.js') }}"></script>
<script src="{{ asset('front/assets8/js/script.js') }}"></script>

@php
    $mainbs = [];
    $mainbs = json_encode($mainbs);
@endphp
{{--               whatsapp init code--}}
@if ($bex->is_whatsapp == 1)
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
@endif
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

<!--End of subscribe functionality-->

<!--Start of Tawk.to script-->
@if ($bs->is_tawkto == 1)
    {!! $bs->tawk_to_script !!}
@endif
<!--End of Tawk.to script-->

<!--Start of AddThis script-->
@if ($bs->is_addthis == 1)
    {!! $bs->addthis_script !!}
@endif
</body>
</html>
