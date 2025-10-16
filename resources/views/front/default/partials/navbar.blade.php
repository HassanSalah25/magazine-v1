<!-- offcanvas start here -->
<!-- tp-offcanvus-area-start -->
<div class="tp-offcanvas-area">
    <div class="tp-offcanvas-wrapper @@class">
        <div class="tp-offcanvas-top d-flex align-items-center justify-content-between">
            <div class="tp-offcanvas-logo">
                <a href="{{ route('front.index') }}">
                    <img class="logo-1" data-width="120" src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="Logo">
                    <img class="logo-2" data-width="120" src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="Logo">
                </a>
            </div>
            <div class="tp-offcanvas-close">
                <button class="tp-offcanvas-close-btn">
                    <svg width="37" height="38" viewBox="0 0 37 38" fill="none" xmlns="http://www.w3.org/2000/svg">
                        <path d="M9.19141 9.80762L27.5762 28.1924" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                        <path d="M9.19141 28.1924L27.5762 9.80761" stroke="currentColor" stroke-width="1.5"
                              stroke-linecap="round" stroke-linejoin="round"/>
                    </svg>
                </button>
            </div>
        </div>
        <div class="tp-offcanvas-main">
            <div class="tp-offcanvas-content d-none d-xl-block">
                <h3 class="tp-offcanvas-title">{{ __('Hello There!') }}</h3>
                <p>{{ __('Lorem ipsum dolor sit amet, consectetur adipiscing elit,') }}</p>
            </div>
            <div class="tp-offcanvas-menu d-xl-none">
                <nav></nav>
            </div>
            <div class="tp-offcanvas-gallery d-none d-xl-block">
                <div class="row gx-2">
                    <div class="col-md-3 col-3">
                        <div class="tp-offcanvas-gallery-img fix">
                            <a class="popup-image" href="{{ asset('front/assets/img/offcanvas/offcanvas-1.jpg') }}"><img
                                    src="{{ asset('front/assets/img/offcanvas/offcanvas-1.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="tp-offcanvas-gallery-img fix">
                            <a class="popup-image" href="{{ asset('front/assets/img/offcanvas/offcanvas-2.jpg') }}"><img
                                    src="{{ asset('front/assets/img/offcanvas/offcanvas-2.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="tp-offcanvas-gallery-img fix">
                            <a class="popup-image" href="{{ asset('front/assets/img/offcanvas/offcanvas-3.jpg') }}"><img
                                    src="{{ asset('front/assets/img/offcanvas/offcanvas-3.jpg') }}" alt=""></a>
                        </div>
                    </div>
                    <div class="col-md-3 col-3">
                        <div class="tp-offcanvas-gallery-img fix">
                            <a class="popup-image" href="{{ asset('front/assets/img/offcanvas/offcanvas-4.jpg') }}"><img
                                    src="{{ asset('front/assets/img/offcanvas/offcanvas-4.jpg') }}" alt=""></a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="tp-offcanvas-contact">
                <h3 class="tp-offcanvas-title sm">{{ __('Information') }}</h3>
                <ul>
                    @php $phones = explode(',', $bex->contact_numbers); @endphp
                    @foreach ($phones as $phone)
                        <li><a href="tel:{{$phone}}">{{$phone}}</a></li>
                    @endforeach
                    @php $mails = explode(',', $bex->contact_mails); @endphp
                    @foreach ($mails as $mail)
                        <li><a href="mailto:{{$mail}}">{{$mail}}</a></li>
                    @endforeach

                    @php $addresses = explode(PHP_EOL, $bex->contact_addresses); @endphp
                    @foreach ($addresses as $address)
                        <li><a href="#">{{ $address }}</a></li>
                    @endforeach
                </ul>
            </div>
            <div class="tp-offcanvas-social">
                <h3 class="tp-offcanvas-title sm">{{ __('Follow Us') }}</h3>
                <ul>
                    @if (!empty($socials))
                        @foreach ($socials as $social)
                            <li>
                                <a href="{{ $social->url }}"><i class="{{ $social->icon }}"></i></a>
                            </li>
                        @endforeach
                    @endif
                </ul>
            </div>
        </div>
    </div>
</div>
<div class="body-overlay"></div>
<!-- tp-offcanvus-area-end -->
<!-- offcanvas end here -->
<header>

    <!-- header area start -->
    <div id="header-sticky"
         class="tp-header-area tp-header-ptb tp-header-blur sticky-white-bg header-transparent tp-header-3-style">
        <div class="container container-1750">
            <div class="row align-items-center">
                <div class="col-xl-1 col-lg-5 col-5">
                    <div class="tp-header-logo">
                        <a href="{{ route('front.index') }}">
                            <img data-width="120"
                                 src="{{ asset('assets/front/img/'.$bs->logo) }}"
                                 alt="">
                        </a>
                    </div>
                </div>
                <div class="col-xl-11 col-lg-7 col-7">
                    <div class="tp-header-box d-flex align-items-center justify-content-end justify-content-xl-between">
                        <div class="tp-header-menu tp-header-dropdown dropdown-white-bg d-none d-xl-flex">
                            <nav class="tp-mobile-menu-active">
                                <ul>
                                    @php $links = json_decode($menus, true); @endphp
                                    @foreach ($links as $link)
                                        @php $href = getHref($link); @endphp
                                        @if (strpos($link['type'], '-megamenu') !== false)
                                            @includeIf('front.default.partials.mega-menu', ['link' => $link])
                                        @elseif (!array_key_exists('children', $link))
                                            <li>
                                                <a href="{{ $href }}"
                                                   target="{{ $link['target'] }}">{{ $link['text'] }}</a>
                                            </li>
                                        @else
                                                <li class="has-dropdown">
                                                    <a href="{{ $href }}"
                                                       target="{{ $link['target'] }}">{{ $link['text'] }}</a>
                                                    <ul class="tp-submenu submenu">
                                                        @foreach ($link['children'] as $child)
                                                            @php $childHref = getHref($child); @endphp
                                                            @if (array_key_exists('children', $child))
                                                            <li><a href="{{ $childHref }}"
                                                                   target="{{ $child['target'] }}">{{ $child['text'] }}</a>
                                                            </li>
1
                                                            <li class="menu-item-has-children">
                                                                <ul class="tp-submenu submenu">
                                                                    @foreach ($child['children'] as $grand)
                                                                        @php $grandHref = getHref($grand); @endphp
                                                                        <li><a href="{{ $grandHref }}"
                                                                               target="{{ $grand['target'] }}">{{ $grand['text'] }}</a>
                                                                        </li>
                                                                    @endforeach
                                                                </ul>
                                                            </li>
                                                            @else
                                                                <li>
                                                                    <a href="{{ $childHref }}"
                                                                       target="{{ $child['target'] }}">{{ $child['text'] }}</a>
                                                                </li>
                                                            @endif
                                                        @endforeach
                                                    </ul>
                                                </li>

                                        @endif
                                    @endforeach


                                </ul>
                            </nav>
                        </div>
                        <div class="tp-header-btn d-none d-md-flex align-items-center">
                            <div class="tp-header-lang d-flex align-items-center mr-20 mx-3">
                                <div class="dropdown">
                                    <button class="tp-header-lang-btn" type="button" id="dropdownLang" data-bs-toggle="dropdown">
                                        @php
                                            if (session()->has('lang')) {
                                               app()->setLocale(session()->get('lang'));
                                             } else {
                                               $defaultLang = \App\Models\Language::where('is_default', 1)->first();
                                               if (!empty($defaultLang)) {
                                                 app()->setLocale($defaultLang->code);
                                               }
                                             }
                                        @endphp
                                        <i class="fas fa-globe"></i>
                                        <i class="fas fa-chevron-down"></i>
                                    </button>
                                    <ul class="dropdown-menu tp-header-lang-list" aria-labelledby="dropdownLang">
                                        @foreach ($langs as $lang)
                                            <li class="@if($lang->code == $currentLang->code) yellow-green-bg green-solid @endif">
                                                <a href="{{ route('changeLanguage', $lang->code) }}"
                                                   class="text-dark p-2 ">
                                                    {{ $lang->name }}
                                                </a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                             <a class="tp-btn-yellow-green green-solid" href="{{ route('front.contact') }}">
                                <i>
                                    <svg width="17" height="14" viewBox="0 0 17 14" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path
                                            d="M16 2.5C16 1.675 15.325 1 14.5 1H2.5C1.675 1 1 1.675 1 2.5M16 2.5V11.5C16 12.325 15.325 13 14.5 13H2.5C1.675 13 1 12.325 1 11.5V2.5M16 2.5L8.5 7.75L1 2.5"
                                            stroke="currentcolor" stroke-width="1.5" stroke-linecap="round"
                                            stroke-linejoin="round"/>
                                    </svg>
                                </i>
                                <span>
                                        <span class="text-1">{{ __('Request A Quote') }}</span>
                                        <span class="text-2">{{ __('Request A Quote') }}</span>
                                    </span>
                            </a>

                        </div>
                        <div class="tp-header-bar ml-15 d-xl-none">
                            <button class="tp-offcanvas-open-btn">
                                <i></i>
                                <i></i>
                                <i></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- header area end -->

</header>
