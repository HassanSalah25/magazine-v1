<!-- Header start -->
<header class="uc-header header-seven uc-navbar-sticky-wrap z-999" data-uc-sticky="sel-target: .uc-navbar-container; cls-active: uc-navbar-sticky; cls-inactive: uc-navbar-transparent; end: !*;">
    <nav class="uc-navbar-container text-gray-900 dark:text-white fs-6 z-1">
        <div class="uc-top-navbar panel z-3 overflow-hidden bg-primary-600 swiper-parent" style="--uc-nav-height: 32px" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container container-full">
                <div class="uc-navbar-item">
                    <div class="swiper swiper-ticker swiper-ticker-sep px-2" style="--uc-ticker-gap: 32px" data-uc-swiper="items: auto; gap: 32; center: true; center-bounds: true; autoplay: 10000; speed: 10000; autoplay-delay: 0.1; loop: true; allowTouchMove: false; freeMode: true; autoplay-disableOnInteraction: true;">
                        <div class="swiper-wrapper">
                            @if(isset($breakingNews) && count($breakingNews) > 0)
                                @foreach($breakingNews as $news)
                                    <div class="swiper-slide text-white">
                                        <div class="type-post post panel">
                                            <a href="{{ route('front.blogdetails', [$news->slug, $news->id]) }}" class="fs-7 fw-normal text-none text-inherit">{{ convertUtf8($news->title) }}</a>
            </div>
        </div>
                                @endforeach
                            @else
                                <div class="swiper-slide text-white">
                                    <div class="type-post post panel">
                                        <a href="#" class="fs-7 fw-normal text-none text-inherit">Welcome to {{ $bs->website_title }}</a>
                        </div>
                    </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-center-navbar panel hstack z-2 min-h-48px d-none lg:d-flex" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
            <div class="container max-w-xl">
                <div class="navbar-container hstack border-bottom">
                    <div class="uc-navbar-center gap-2 lg:gap-3 flex-1">
                        <ul class="uc-navbar-nav gap-3 justify-between flex-1 fs-6 fw-bold" style="--uc-nav-height: 48px">
                                    @php $links = json_decode($menus, true); @endphp
                                    @foreach ($links as $link)
                                        @php $href = getHref($link); @endphp
                                        @if (strpos($link['type'], '-megamenu') !== false)
                                            @includeIf('front.default.partials.mega-menu', ['link' => $link])
                                        @elseif (!array_key_exists('children', $link))
                                            <li>
                                        <a href="{{ $href }}" target="{{ $link['target'] }}">{{ $link['text'] }}</a>
                                            </li>
                                        @else
                                    <li>
                                        <a href="{{ $href }}" target="{{ $link['target'] }}">{{ $link['text'] }} <span data-uc-navbar-parent-icon></span></a>
                                        <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar" data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
                                            <div class="row child-cols col-match g-2">
                                                        @foreach ($link['children'] as $child)
                                                            @php $childHref = getHref($child); @endphp
                                                    <div class="col-2">
                                                        <ul class="uc-nav uc-navbar-dropdown-nav">
                                                            <li><a href="{{ $childHref }}" target="{{ $child['target'] }}">{{ $child['text'] }}</a></li>
                                                        </ul>
                                                    </div>
                                                                    @endforeach
                                            </div>
                                        </div>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                    </div>
                </div>
            </div>
        </div>
        <div class="uc-bottom-navbar panel z-1">
            <div class="container max-w-xl">
                <div class="uc-navbar min-h-72px lg:min-h-100px" data-uc-navbar=" animation: uc-animation-slide-top-small; duration: 150;">
                    <div class="uc-navbar-left">
                        <div>
                            <a class="uc-menu-trigger icon-2" href="#uc-menu-panel" data-uc-toggle></a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="btn btn-xs gap-narrow ps-1 border rounded-pill fw-bold dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900" href="#live_now" data-uc-scroll="offset: 128">
                                <i class="fa-regular fa-circle-dot text-red" style="color:red;" data-uc-animate="flash"></i>
                                <span>Live</span>
                            </a>
                        </div>
                        <!-- <div class="uc-logo d-block md:d-none">
                            <a href="{{ route('front.index') }}">
                                <img class="w-100px text-dark dark:text-white" src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="{{ $bs->website_title }}" data-uc-svg>
                            </a>
                        </div> -->
                    </div>
                    <div class="uc-navbar-center">
                        <div class="uc-logo d-none md:d-block">
                            <a href="{{ route('front.index') }}">
                                <img class="w-150px text-dark dark:text-white" src="{{ $bs->logo ? asset('assets/front/img/'.$bs->logo) : asset('front/assets/images/demo-seven/common/logo.svg') }}" alt="{{ $bs->website_title }}" data-uc-svg>
                            </a>
                                </div>
                            </div>
                    <div class="uc-navbar-right gap-2 lg:gap-3">
                        <div class="uc-navbar-item d-inline-flex lg:d-none">
                            <a class="btn btn-xs gap-narrow ps-1 border rounded-pill fw-bold dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900" href="#live_now" data-uc-scroll="offset: 128">
                                <i class="fa-regular fa-circle-dot text-red" style="color:red;" data-uc-animate="flash"></i>
                                <span>Live</span>
                            </a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="uc-account-trigger position-relative btn btn-sm border-0 p-0 gap-narrow duration-0 dark:text-white" href="#uc-account-modal" data-uc-toggle>
                                <i class="fa-solid fa-right-to-bracket"></i>
                            </a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <a class="uc-search-trigger cstack text-none text-dark dark:text-white" href="#uc-search-modal" data-uc-toggle>
                                <i class="fa-solid fa-magnifying-glass"></i>
                            </a>
                        </div>
                        <div class="uc-navbar-item d-none lg:d-inline-flex">
                            <div class="uc-modes-trigger btn btn-xs w-32px h-32px p-0 border fw-normal rounded-circle dark:text-white hover:bg-gray-25 dark:hover:bg-gray-900" data-darkmode-toggle="">
                                <label class="switch">
                                    <span class="sr-only">Dark toggle</span>
                                    <input type="checkbox">
                                    <span class="slider"></span>
                                </label>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </nav>
</header>
<!-- Header end -->
