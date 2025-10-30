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
    
    <!-- preload head styles -->
    <link rel="preload" href="{{asset('front/assets/css/unicons.min.css')}}" as="style">
    <link rel="preload" href="{{asset('front/assets/css/swiper-bundle.min.css')}}" as="style">

    <!-- preload footer scripts -->
    <link rel="preload" href="{{asset('front/assets/js/libs/jquery.min.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/libs/scrollmagic.min.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/libs/swiper-bundle.min.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/libs/anime.min.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/helpers/data-attr-helper.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/helpers/swiper-helper.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/helpers/anime-helper.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/helpers/anime-helper-defined-timelines.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/uikit-components-bs.js')}}" as="script">
    <link rel="preload" href="{{asset('front/assets/js/app.js')}}" as="script">

    <!-- app head for bootstrap core -->
    <script src="{{asset('front/assets/js/app-head-bs.js')}}"></script>

    <!-- include uni-core components -->
    <link rel="stylesheet" href="{{asset('front/assets/js/uni-core/css/uni-core.min.css')}}">

    <!-- include styles -->
    <link rel="stylesheet" href="{{asset('front/assets/css/unicons.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/prettify.min.css')}}">
    <link rel="stylesheet" href="{{asset('front/assets/css/swiper-bundle.min.css')}}">

    <!-- include main style -->
    <link rel="stylesheet" href="{{asset('front/assets/css/theme/demo-seven.min.css')}}">

    <!-- include scripts -->
    <script src="{{asset('front/assets/js/uni-core/js/uni-core-bundle.min.js')}}"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css" integrity="sha512-2SwdPD6INVrV/lHTZbO2nodKhrnDdJK9/kg2XD1r9uGqPo1cUbujc+IYdlYdEErWNu69gVcYgdxlmVmzTWnetw==" crossorigin="anonymous" referrerpolicy="no-referrer" />

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
            a {
                text-decoration: none;
            }
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

<body class="uni-body panel bg-white text-gray-900 dark:bg-black dark:text-white text-opacity-50 overflow-x-hidden" @if($rtl == 1) dir="rtl" @endif data-bg-color="@yield('data-bg-color')">

    <!--  Search modal -->
    <div id="uc-search-modal" class="uc-modal-full uc-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog d-flex justify-center bg-white text-dark dark:bg-gray-900 dark:text-white" data-uc-height-viewport="">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            <div class="panel w-100 sm:w-500px px-2 py-10">
                <h3 class="h1 text-center">Search</h3>
                <form class="hstack gap-1 mt-4 border-bottom p-narrow dark:border-gray-700" action="?">
                    <span class="d-inline-flex justify-center items-center w-24px sm:w-40 h-24px sm:h-40px opacity-50"><i class="unicon-search icon-3"></i></span>
                    <input type="search" name="q" class="form-control-plaintext ms-1 fs-6 sm:fs-5 w-full dark:text-white" placeholder="Type your keyword.." aria-label="Search" autofocus>
                </form>
            </div>
        </div>
    </div>

    <!--  Menu panel -->
    <div id="uc-menu-panel" data-uc-offcanvas="overlay: true;">
        <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
            <header class="uc-offcanvas-header hstack justify-between items-center pb-4 bg-white dark:bg-gray-900">
                <div class="uc-logo">
                    <a href="{{ route('front.index') }}" class="h5 text-none text-gray-900 dark:text-white">
                        <img class="w-32px" src="{{asset('front/assets/images/common/logo-icon.svg')}}" alt="{{$bs->website_title}}" data-uc-svg>
                    </a>
                </div>
                <button class="uc-offcanvas-close p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                        <i class="fa-solid fa-xmark"></i>
            </button>
            </header>

            <div class="panel">
                <form id="search-panel" class="form-icon-group vstack gap-1 mb-3" data-uc-sticky="">
                    <input type="email" class="form-control form-control-md fs-6" placeholder="Search..">
                    <span class="form-icon text-gray">
                            <i class="unicon-search icon-1"></i>
                        </span>
                </form>
                <ul class="nav-y gap-narrow fw-bold fs-5" data-uc-nav>
                <li class="uc-parent">
                        <a href="#">Homepages</a>
                        <ul class="uc-nav-sub" data-uc-nav="">
                            <li><a href="main/index.html">Main</a></li>
                            <li><a href="demo-two/index.html">Classic News</a></li>
                            <li><a href="demo-three/index.html">Tech</a></li>
                            <li><a href="demo-four/index.html">Classic Blog</a></li>
                            <li><a href="demo-five/index.html">Gaming</a></li>
                            <li><a href="demo-six/index.html">Sports</a></li>
                            <li><a href="demo-seven/index.html">Newspaper</a></li>
                            <li><a href="demo-eight/index.html">Magazine</a></li>
                            <li><a href="demo-nine/index.html">Travel</a></li>
                            <li><a href="demo-ten/index.html">Food</a></li>
                        </ul>
                    </li>
                    <li><a href="#">Latest</a></li>
                    <li><a href="#">Trending</a></li>
                    <li class="uc-parent">
                        <a href="#">Inner Pages</a>
                        <ul class="uc-nav-sub" data-uc-nav="">
                            <li class="uc-parent">
                                <a href="#">Blog</a>
                                <ul class="uc-nav-sub">
                                    <li><a href="#">Full Width</a></li>
                                    <li><a href="#">Grid 2 Cols</a></li>
                                    <li><a href="#">Grid 3 Cols</a></li>
                                    <li><a href="#">Grid 4 Cols</a></li>
                                </ul>
                            </li>
                        </ul>
                    </li>
                    <li class="hr opacity-10 my-1"></li>
                    <li><a href="#">Sign in</a></li>
                    <li><a href="#">Create an account</a></li>
                </ul>
                <ul class="social-icons nav-x mt-4">
                    <li>
                        @if (!empty($socials))
                            @foreach ($socials as $social)
                                <a href="{{ $social->url }}"><i class="{{ $social->icon }}"></i></a>
                            @endforeach
                        @endif
                    </li>
                </ul>
                <div class="py-2 hstack gap-2 mt-4 bg-white dark:bg-gray-900" data-uc-sticky="position: bottom">
                    <div class="vstack gap-1">
                        <span class="fs-7 opacity-60">Select theme:</span>
                        <div class="darkmode-trigger" data-darkmode-switch="">
                            <label class="switch">
                                    <input type="checkbox">
                                    <span class="slider fs-5"></span>
                                </label>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        </div>

    <!--  Cart panel -->
    <div id="uc-cart-panel" data-uc-offcanvas="overlay: true; flip: true;">
        <div class="uc-offcanvas-bar bg-white text-dark dark:bg-gray-900 dark:text-white">
            <button class="uc-offcanvas-close top-0 ltr:end-0 rtl:start-0 rtl:end-auto m-2 p-0 border-0 icon-2 lg:icon-3 btn btn-md dark:text-white transition-transform duration-150 hover:rotate-90" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>

            <div class="mini-cart-content vstack justify-between panel h-100">
                <div class="mini-cart-header">
                    <h3 class="title h5 m-0 text-dark dark:text-white">Shopping cart</h3>
                </div>
                <div class="mini-cart-listing panel flex-1 my-4 overflow-scroll">
                    <p class="alert alert-warning" hidden>Your cart empty!</p>
                    <div class="panel vstack gap-3">
                        <!-- Cart items will be populated here -->
                    </div>
                </div>
                <div class="mini-cart-footer panel pt-3 border-top">
                    <div class="panel vstack gap-3 justify-between">
                        <div class="mini-cart-total hstack justify-between">
                            <h5 class="h5 m-0 text-dark dark:text-white">Subtotal</h5>
                            <b class="fs-5">$0.00</b>
                        </div>
                        <div class="mini-cart-actions vstack gap-1">
                            <a href="#" class="btn btn-md btn-outline-gray-100 text-dark dark:text-white dark:border-gray-700 dark:hover:bg-gray-700">View cart</a>
                            <a href="#" class="btn btn-md btn-primary text-white">Checkout</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
             </div>
         
    <!--  Favorites modal -->
    <div id="uc-favorites-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            <div class="panel vstack justify-center items-center gap-2 text-center px-3 py-8">
                <i class="icon icon-4 unicon-bookmark mb-2 text-primary dark:text-white"></i>
                <h2 class="h4 md:h3 m-0">Saved articles</h2>
                <p class="fs-5 opacity-60">You have not yet added any article to your bookmarks!</p>
                <a href="{{ route('front.index') }}" class="btn btn-sm btn-primary mt-2 uc-modal-close">Browse articles</a>
             </div>
        </div>
    </div>

    <!--  Newsletter modal -->
    <div id="uc-newsletter-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog w-800px bg-white text-dark dark:bg-gray-900 dark:text-white rounded overflow-hidden">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="fa-solid fa-xmark"></i>
         </button>
            <div class="row md:child-cols-6 col-match g-0">
                <div class="d-none md:d-flex">
                    <div class="position-relative w-100 ratio-1x1">
                        <img class="media-cover" src="{{asset('front/assets/images/demo-seven/common/newsletter.jpg')}}" alt="Newsletter image">
                    </div>
                </div>
                <div>
                    <div class="panel vstack self-center p-4 md:py-8 text-center">
                        <h3 class="h3 md:h2">Subscribe to the Newsletter</h3>
                        <p class="ft-tertiary">Join 10k+ people to get notified about new posts, news and tips.</p>
                        <div class="panel mt-2 lg:mt-4">
                            <form class="vstack gap-1" action="{{ route('front.subscribe') }}" method="POST">
                                @csrf
                                <input type="email" name="email" class="form-control form-control-sm w-full fs-6 bg-white dark:border-white dark:border-gray-700 dark:text-dark" placeholder="Your email address.." required>
                                <button type="submit" class="btn btn-sm btn-primary">Sign up</button>
                            </form>
                            <p class="fs-7 mt-2">Do not worry we don't spam!</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Account modal -->
    <div id="uc-account-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
            <button class="uc-modal-close-default p-0 icon-3 btn border-0 dark:text-white dark:text-opacity-50 hover:text-primary hover:rotate-90 duration-150 transition-all" type="button">
                    <i class="fa-solid fa-xmark"></i>
                </button>
            <div class="panel vstack gap-2 md:gap-4 text-center">
                <ul class="account-tabs-nav nav-x justify-center h6 py-2 border-bottom d-none" data-uc-switcher="animation: uc-animation-slide-bottom-small, uc-animation-slide-top-small">
                    <li><a href="#">Sign in</a></li>
                    <li><a href="#">Sign up</a></li>
                    <li><a href="#">Reset password</a></li>
                    <li><a href="#">Terms of use</a></li>
                </ul>
                <div class="account-tabs-content uc-switcher px-3 lg:px-4 py-4 lg:py-8 m-0 lg:mx-auto vstack justify-center items-center">
                    <div class="w-100">
                        <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                            <h4 class="h5 lg:h4 m-0">Log in</h4>
                            <div class="panel vstack gap-2 w-100 sm:w-350px mx-auto">
                                <form class="vstack gap-2">
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15" type="email" placeholder="Your email" required>
                                    <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15" type="password" placeholder="Password" autocomplete="new-password" required>
                                    <div class="hstack justify-between items-start text-start">
                                        <div class="form-check text-start">
                                            <input class="form-check-input rounded-0 dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15" type="checkbox" id="inputCheckRemember">
                                            <label class="hstack justify-between form-check-label fs-7 sm:fs-6" for="inputCheckRemember">Remember me?</label>
                                        </div>
                                        <a href="#" class="uc-link fs-6" data-uc-switcher-item="2">Forgot password</a>
                                    </div>
                                    <button class="btn btn-primary btn-sm lg:mt-1" type="submit">Log in</button>
                                </form>
                                <div class="panel h-24px">
                                    <hr class="position-absolute top-50 start-50 translate-middle hr m-0 w-100">
                                    <span class="position-absolute top-50 start-50 translate-middle px-1 fs-7 text-uppercase bg-white dark:bg-gray-800">Or</span>
                                </div>
                                <div class="hstack gap-2">
                                    <a href="#google" class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                            <i class="icon icon-1 unicon-logo-google"></i>
                                            <span class="fs-6">Google</span>
                                        </a>
                                    <a href="#facebook" class="hstack items-center justify-center flex-1 gap-1 h-40px text-none rounded border border-gray-900 dark:bg-gray-800 dark:border-white dark:border-opacity-15 border-opacity-10">
                                            <i class="icon icon-1 unicon-logo-facebook"></i>
                                            <span class="fs-6">Facebook</span>
                                        </a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  GDPR modal -->
    <div id="uc-gdpr-modal" data-uc-modal="overlay: true">
        <div class="uc-modal-dialog lg:max-w-500px bg-white text-dark dark:bg-gray-800 dark:text-white rounded">
            <div class="panel vstack gap-2 md:gap-4 text-center">
                <div class="panel vstack justify-center items-center gap-2 sm:gap-4 text-center">
                    <h4 class="h5 lg:h4 m-0">Cookie consent</h4>
                    <p class="fs-6">We use cookies to enhance your browsing experience, serve personalized content, and analyze our traffic. By clicking "Accept All", you consent to our use of cookies.</p>
                    <div class="hstack gap-2">
                        <button class="btn btn-outline-primary btn-sm">Reject All</button>
                        <button class="btn btn-primary btn-sm" id="uc-accept-gdpr">Accept</button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!--  Bottom Actions Sticky -->
    <div class="backtotop-wrap position-fixed bottom-0 end-0 z-99 m-2 vstack">
        <div class="darkmode-trigger cstack w-40px h-40px rounded-circle text-none bg-gray-100 dark:bg-gray-700 dark:text-white" data-darkmode-toggle="">
            <label class="switch">
                    <span class="sr-only">Dark mode toggle</span>
                    <input type="checkbox">
                    <span class="slider fs-5"></span>
                </label>
        </div>
        <a class="btn btn-sm bg-primary text-white w-40px h-40px rounded-circle" href="to_top" data-uc-backtotop>
                <i class="fa-solid fa-chevron-up"></i>
            </a>
    </div>


    @include('front.default.partials.navbar')
   

    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <!-- Main content start -->
        <main id="uc-main" class="uc-main">
            @yield('content')
        </main>
        <!-- Main content end -->

        <!-- Footer start -->
        <footer id="uc-footer" class="uc-footer panel uc-dark">
            <div class="footer-outer py-4 lg:py-6 bg-white dark:bg-gray-900 text-gray-900 dark:text-white text-opacity-50">
                <div class="container max-w-xl">
                    <div class="footer-inner vstack gap-6 xl:gap-8">
                        <div class="uc-footer-bottom panel vstack gap-4 justify-center lg:fs-5">
                            <nav class="footer-nav">
                                <ul class="nav-x gap-2 lg:gap-4 justify-center text-center text-uppercase fw-medium">
                                    @if (!empty($ulinks))
                                        @foreach ($ulinks as $ulink)
                                            <li><a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{ $ulink->url }}">{{ convertUtf8($ulink->name) }}</a></li>
                                        @endforeach
                                    @endif
                                </ul>
                            </nav>
                            <div class="footer-social hstack justify-center gap-2 lg:gap-3">
                                <ul class="nav-x gap-2">
                                    @if (!empty($socials))
                                        @foreach ($socials as $social)
                                            <li>
                                                <a class="hover:text-gray-900 dark:hover:text-white duration-150" href="{{ $social->url }}"><i class="{{ $social->icon }}"></i></a>
                                            </li>
                                        @endforeach
                                    @endif
                                </ul>
                                <div class="vr"></div>
                                <div class="d-inline-block">
                                    <a href="#" class="hstack gap-1 text-none fw-medium">
                                        <i class="icon icon-1 unicon-earth-filled"></i>
                                        <span>{{ $currentLang->name ?? 'English' }}</span>
                                        <span data-uc-drop-parent-icon=""></span>
                                    </a>
                                    <div class="p-2 bg-white dark:bg-gray-800 shadow-xs w-150px" data-uc-drop="mode: click; boundary: !.uc-footer-bottom; animation: uc-animation-slide-top-small; duration: 150;">
                                        <ul class="nav-y gap-1 fw-medium items-end">
                                            @foreach ($langs as $lang)
                                                <li><a href="{{ route('changeLanguage', $lang->code) }}">{{ $lang->name }}</a></li>
                                            @endforeach
                                        </ul>
                                    </div>
                                </div>
                            </div>
                            <div class="footer-copyright vstack sm:hstack justify-center items-center gap-1 lg:gap-2">
                                <p>{!! replaceBaseUrl(convertUtf8($bs->copyright_text)) !!}</p>
                                <ul class="nav-x gap-2 fw-medium">
                                    <li><a class="uc-link text-underline hover:text-gray-900 dark:hover:text-white duration-150" href="#">Privacy notice</a></li>
                                    <li><a class="uc-link text-underline hover:text-gray-900 dark:hover:text-white duration-150" href="#">Terms of condition</a></li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </footer>
        <!-- Footer end -->
        </div>
    <!-- Wrapper end -->

    {{-- WhatsApp Chat Button --}}
    <div id="WAButton"></div>


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

    <!-- include jquery & bootstrap js -->
    <script defer src="{{asset('front/assets/js/libs/jquery.min.js')}}"></script>
    <script defer src="{{asset('front/assets/js/libs/bootstrap.min.js')}}"></script>

    <!-- include scripts -->
    <script defer src="{{asset('front/assets/js/libs/anime.min.js')}}"></script>
    <script defer src="{{asset('front/assets/js/libs/swiper-bundle.min.js')}}"></script>
    <script defer src="{{asset('front/assets/js/libs/scrollmagic.min.js')}}"></script>
    <script defer src="{{asset('front/assets/js/helpers/data-attr-helper.js')}}"></script>
    <script defer src="{{asset('front/assets/js/helpers/swiper-helper.js')}}"></script>
    <script defer src="{{asset('front/assets/js/helpers/anime-helper.js')}}"></script>
    <script defer src="{{asset('front/assets/js/helpers/anime-helper-defined-timelines.js')}}"></script>
    <script defer src="{{asset('front/assets/js/uikit-components-bs.js')}}"></script>

    <!-- include app script -->
    <script defer src="{{asset('front/assets/js/app.js')}}"></script>

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