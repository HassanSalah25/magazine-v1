<!-- rts banner area start -->
<div class="banner-area banner-style-one banner-bg-1 hero__area-3 banner__jump position-relative overflow-hidden"
    style="background-image: url('{{ asset('assets/front/img/' . $bs->hero_bg) }}'); background-size: cover; background-position: center;background-repeat: no-repeat"
>
    {{-- 💫 Optional Shape --}}
    <div class="shape-image">
{{--         <img src="{{ asset('assets/front/img/' . $bs->hero_bg) }}" alt="banner">--}}
    </div>

    {{-- 🌀 Scroll Down Button Circle --}}
    <div class="top-center-image rts-scroll-down-circle-wrapper-3">
        <a href="#" class="speen-shape scroll-down-circle-3">
            <svg class="uni-circle-text-path uk-text-secondary uni-animation-spin" viewBox="0 0 100 100" width="180" height="180">
                <defs>
                    <path id="circle" d="M 50, 50 m -37, 0 a 37,37 0 1,1 74,0 a 37,37 0 1,1 -74,0"></path>
                </defs>
                <text font-size="11.75">
                    <textPath xlink:href="#circle">Project Showcase • Project Showcase •</textPath>
                </text>
            </svg>
            <i class="fa-solid fa-star"></i>
        </a>
    </div>

    <div class="container">
        <div class="row ptb--200 ptb_sm--150">
            <div class="col-lg-9">
                <div class="banner-one-wrapper mt--80 mt_sm--0">

                    {{-- 🎯 Dynamic Title --}}
                    @if (!empty($bs->hero_section_title))
                        <span class="hero-subtitle d-block mb-3">
                            {{ convertUtf8($bs->hero_section_title) }}
                        </span>
                    @endif

                    {{-- 📣 Dynamic Heading --}}
                    @if (!empty($bs->hero_section_text))
                        <h1 class="title rts_hero__title mb-4">
                            {{ convertUtf8($bs->hero_section_text) }}
                        </h1>
                    @endif

                    {{-- 🚀 Dynamic CTA Button --}}
                    @if (!empty($bs->hero_section_button_url) && !empty($bs->hero_section_button_text))
                        <div class="bannerJump_animation banner-jump-button rts-scroll-down-circle-wrapper-4">
                            <div class="jump__anim rts_round_btn_wrap scroll-down-circle-4">
                                <div class="rts-mouse-move-button">
                                    <div class="btn_wrapper">
                                        <a href="{{ $bs->hero_section_button_url }}" target="_blank"
                                           class="rts-btn-mouse-move btn-hover btn-item">
                                            <span></span>
                                            {{ convertUtf8($bs->hero_section_button_text) }}
                                            <br>
                                            <i class="fa-solid fa-square-arrow-up-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                </div>
            </div>
        </div>
    </div>

</div>
<!-- rts banner area end -->
