<header id="gl-header" class="gl-header-section gl-header-type-one">
    <div class="container">
        <div class="gl-header-content position-relative">
            {{-- Top Info --}}
            <div class="gl-header-top d-flex justify-content-between align-items-center">
                <div class="gl-header-top-info ul-li">
                    <ul>
                        <li><i class="fas fa-map-marker-alt"></i> <span>{{ $bs->contact_address ?? 'Address Here' }}</span></li>
                        <li><i class="fas fa-envelope"></i> <span>{{ $bs->contact_email ?? 'email@example.com' }}</span></li>
                    </ul>
                </div>
                <div class="gl-header-top-social ul-li">
                    <ul>
                        <li><a href="#"><i class="fab fa-facebook-f"></i></a></li>
                        <li><a href="#"><i class="fab fa-twitter"></i></a></li>
                        <li><a href="#"><i class="fab fa-behance"></i></a></li>
                        <li><a href="#"><i class="fab fa-youtube"></i></a></li>
                    </ul>
                </div>
            </div>

            {{-- Main Menu --}}
            <div class="gl-header-main-menu d-flex align-items-center justify-content-between">
                <div class="gl-brand-logo">
                    <a href="{{ route('front.index') }}">
                        <img src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="Logo" class="new-img" style="width: 50%; margin: auto; display: flex;">
                    </a>
                </div>

                <div class="gl-header-main-menu-cta d-flex align-items-center">
                    <nav class="gl-main-navigation scroll-nav clearfix ul-li">
                        <ul id="gl-main-nav" class="nav navbar-nav clearfix">
                            <li><a href="#gl-slider-1">Home</a></li>
                            <li><a href="#gl-about">About</a></li>
                            <li><a href="#gl-about-feature">Services</a></li>
                            <li><a href="#gl-team">Team</a></li>
                            <li><a href="#gl-call-to-action">Contact</a></li>
                        </ul>
                    </nav>

                    {{-- CTA Button --}}
                    @if ($bs->is_quote == 1)
                        <div class="gl-header-cta-btn">
                            <a href="{{ route('front.quote') }}" class="btn btn-primary d-flex justify-content-center align-items-center">
                                {{ __('Request A Quote') }}
                            </a>
                        </div>
                    @endif

                    <div class="gl-header-side-btn text-center navSidebar-button">
                        <button class="gl-sidebar-menu-open">
                            <img src="{{ asset('assets8/img/logo/bar.png') }}" alt="">
                        </button>
                    </div>
                </div>
            </div>

            {{-- Mobile Menu --}}
            <div class="mobile_menu position-relative">
                <div class="mobile_menu_button open_mobile_menu">
                    <i class="fa-solid fa-bars"></i>
                </div>
                <div class="mobile_menu_wrap">
                    <div class="mobile_menu_overlay open_mobile_menu"></div>
                    <div class="mobile_menu_content">
                        <div class="mobile_menu_close open_mobile_menu">
                            <i class="fa-solid fa-xmark"></i>
                        </div>
                        <div class="m-brand-logo">
                            <a href="{{ route('front.index') }}">
                                <img src="{{ asset('assets/front/img/'.$bs->logo) }}" alt="Logo">
                            </a>
                        </div>
                        <nav class="mobile-main-navigation scroll-nav clearfix ul-li">
                            <ul id="m-main-nav" class="navbar-nav text-capitalize clearfix">
                                <li><a href="#gl-slider-1">Home</a></li>
                                <li><a href="#gl-about">About</a></li>
                                <li><a href="#gl-about-feature">Services</a></li>
                                <li><a href="#gl-team">Team</a></li>
                                <li><a href="#gl-call-to-action">Contact</a></li>
                            </ul>
                        </nav>
                    </div>
                </div>
            </div>
            {{-- End Mobile --}}
        </div>
    </div>
</header>
<!-- Sidebar sidebar Item -->
<div class="xs-sidebar-group info-group">
    <div class="xs-overlay xs-bg-black"></div>
    <div class="xs-sidebar-widget">
        <div class="sidebar-widget-container">
            <div class="widget-heading">
                <a href="#" class="close-side-widget">
                    X
                </a>
            </div>
            <div class="sidebar-textwidget">

                <!-- Sidebar Info Content -->
                <div class="sidebar-info-contents headline pera-content">
                    <div class="content-inner">
                        <div class="logo">
                            <a href="index.html"><img src="assets8/Wolf_logo.png" style="    width: 55%;
    filter: invert(1);" alt=""></a>
                        </div>
                        <div class="content-box">
                            <h5>About Us</h5>
                            <p class="text">The argument in favor of using filler text goes something like this: If you use real content in the Consulting Process, anytime you reach a review point you’ll end up reviewing and negotiating the content itself and not
                                the design.</p>
                        </div>
                        <div class="gallery-box ul-li">
                            <h5>Gallery</h5>
                            <ul>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/01.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/02.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/03.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/04.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/05.png" alt=""></a>
                                </li>
                                <li>
                                    <a href="#"><img src="assets8/img/gallery/06.png" alt=""></a>
                                </li>
                            </ul>
                        </div>
                        <!-- Social Box -->
                        <div class="content-box">
                            <h5>Social Account</h5>
                            <ul class="social-box">
                                <li><a href="https://www.facebook.com/" class="fab fa-facebook-f"></a></li>
                                <li><a href="https://www.twitter.com/" class="fab fa-twitter"></a></li>
                                <li><a href="https://dribbble.com/" class="fab fa-dribbble"></a></li>
                                <li><a href="https://www.linkedin.com/" class="fab fa-linkedin"></a></li>
                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>
<!-- END sidebar widget item -->
<!-- End of header section
============================================= -->
