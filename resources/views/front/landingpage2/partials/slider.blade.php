<section id="gl-slider-1" class="gl-slider-section-1 position-relative" data-background="{{ asset('front/assets8/img/slider/s-bg.jpg') }}">
    <div class="background_overlay"></div>

    {{-- Decorative Stars --}}
    <span class="gl-star-shape1 position-absolute"><img src="{{ asset('front/assets8/img/slider/st1.png') }}" alt=""></span>
    <span class="gl-star-shape2 position-absolute"><img src="{{ asset('front/assets8/img/slider/st2.png') }}" alt=""></span>
    <span class="gl-star-shape3 position-absolute"><img src="{{ asset('front/assets8/img/slider/st3.png') }}" alt=""></span>
    <span class="gl-star-shape4 position-absolute"><img src="{{ asset('front/assets8/img/slider/st4.png') }}" alt=""></span>

    <div class="gl-slider-arrow1">Scroll Down <i class="fa-solid fa-arrow-right"></i></div>
    <div class="gl-slider-arrow2">
        <a class="d-flex justify-content-center align-items-center" href="#"><i class="fa-solid fa-arrow-down"></i></a>
    </div>

    <div class="gl-slider-wrapper">
        <div class="gl-slider-area-1 owl-carousel owl-theme">
            @foreach ($sliders as $slider)
                <div class="gl-slide-item">
                    <div class="container">
                        <div class="gl-slide-text-img position-relative">
                            {{-- Text Content --}}
                            <div class="gl-slide-text headline pera-content">
                                <div class="slider-slug">{{ convertUtf8($slider->title) }}</div>
                                <h1>{!! convertUtf8($slider->text) !!}</h1>

                                <p>{{ convertUtf8($slider->short_text ?? '') }}</p>

                                <div class="slider-btn">
                                    <div class="gl-slide-btn-wrapper d-flex align-items-center">
                                        @if (!empty($slider->button_url) && !empty($slider->button_text))
                                            <div class="gl-slide-btn">
                                                <a type="button" class="btn btn-primary d-flex justify-content-center align-items-center" href="{{ $slider->button_url }}">
                                                    {{ convertUtf8($slider->button_text) }} <i class="fa-solid fa-arrow-right"></i>
                                                </a>
                                            </div>
                                        @endif

                                        @if (!empty($slider->video_url))
                                            <div class="gl-slide-video-btn">
                                                <a class="video_box" href="{{ $slider->video_url }}" data-lity>
                                                    <i class="fas fa-play"></i>
                                                    <span>{{ __('How It Work') }}</span>
                                                </a>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>

                            {{-- Slider Image --}}
                            <div class="gl-slide-img position-absolute">
                                <img src="{{ asset('assets/front/img/sliders/' . $slider->image) }}" alt="{{ $slider->title }}">
                            </div>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
</section>
