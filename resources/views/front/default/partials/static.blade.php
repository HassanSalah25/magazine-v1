<!-- Featured Blog Slider Section start -->
<div class="section panel mb-4 lg:mb-6">
    <div class="section-outer panel">
        <div class="container max-w-xl">
            <div class="section-inner panel vstack gap-4">
                <div class="section-content">
                    <div class="row child-col-12 lg:child-cols g-4 lg:g-6 col-match">
                        <div class="lg:col-9">
                            <div class="block-layout slider-layout swiper-parent uc-dark">
                                <div class="block-content panel uc-visible-toggle">
                                    <div class="swiper" data-uc-swiper="items: 1; active: 1; gap: 4; prev: .nav-prev; next: .nav-next; autoplay: 6000; parallax: true; fade: true; effect: fade; disable-class: d-none;">
                                        <div class="swiper-wrapper">
                                            @if(isset($featured_slider_blogs) && count($featured_slider_blogs) > 0)
                                                @foreach($featured_slider_blogs as $blog)
                                                    @php
                                                        $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale($currentLang->code)->translatedFormat('M j');
                                                    @endphp
                                                    <div class="swiper-slide">
                                                        <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                            <div class="post-media panel overflow-hidden h-100">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                    <canvas class="h-100 w-100"></canvas>
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                         src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                         data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                         alt="{{ convertUtf8($blog->title) }}" 
                                                                         data-uc-img="loading: lazy">
                                                                </div>
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                         src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                         data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                         alt="{{ convertUtf8($blog->title) }}" 
                                                                         data-uc-img="loading: lazy">
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                                            <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white" data-swiper-parallax-y="-24">
                                                                <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                    <span>{{ $blogDate }}</span>
                                                                </div>
                                                                <h3 class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                    <a class="text-none text-white" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                                </h3>
                                                                <div>
                                                                    <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div class="post-author hstack gap-1">
                                                                                        <a href="#" data-uc-tooltip="{{ $blog->author ?? 'Admin' }}">
                                                                                            <img src="{{ asset('front/assets/images/avatars/02.png') }}" 
                                                                                                 alt="{{ $blog->author ?? 'Admin' }}" 
                                                                                                 class="w-24px h-24px rounded-circle">
                                                                                        </a>
                                                                                        <a href="#" class="text-black dark:text-white text-none fw-bold">{{ $blog->author ?? 'Admin' }}</a>
                                                                            </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                        <i class="fa-solid fa-comment-dots"></i>
                                                                                        <span>{{ $blog->comments()->approved()->count() }}</span>
                                                                                    </a>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                        <div class="actions">
                                                                            <div class="hstack gap-1"></div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @else
                                                <div class="swiper-slide">
                                                    <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                                        <div class="post-media panel overflow-hidden h-100">
                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                                                <canvas class="h-100 w-100"></canvas>
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                     src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                     alt="Welcome" 
                                                                     data-uc-img="loading: lazy">
                                                            </div>
                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                     src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                     alt="Welcome" 
                                                                     data-uc-img="loading: lazy">
                                                            </div>
                                                        </div>
                                                        <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                                        <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white" data-swiper-parallax-y="-24">
                                                            <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <span>Today</span>
                                                            </div>
                                                            <h3 class="post-title h5 lg:h4 xl:h3 m-0 max-w-600px text-white text-truncate-2">
                                                                <a class="text-none text-white" href="#">Welcome to {{ $bs->website_title }}</a>
                                                            </h3>
                                                            <div>
                                                                <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                                                    <div class="meta">
                                                                        <div class="hstack gap-2">
                                                                            <div>
                                                                                <div class="post-author hstack gap-1">
                                                                                    <a href="#" data-uc-tooltip="Admin">
                                                                                        <img src="{{ asset('front/assets/images/avatars/02.png') }}" 
                                                                                             alt="Admin" 
                                                                                             class="w-24px h-24px rounded-circle">
                                                                                    </a>
                                                                                    <a href="#" class="text-black dark:text-white text-none fw-bold">Admin</a>
                                                                                </div>
                                                                            </div>
                                                                            <div>
                                                                                <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                    <i class="fa-solid fa-comment-dots"></i>
                                                                                    <span>0</span>
                                                                                </a>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="actions">
                                                                        <div class="hstack gap-1"></div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                @endif
            </div>
        </div>
                                    <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                        <i class="fa-solid fa-angle-left"></i>
                                    </div>
                                    <div class="swiper-nav nav-next position-absolute top-50 end-0 translate-middle-y btn btn-alt-primary text-black rounded-circle p-0 mx-2 border-0 shadow-xs w-32px h-32px z-1 uc-hidden-hover">
                                        <i class="fa-solid fa-angle-right"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="lg:col-3">
                            <div class="panel cstack gap-2 h-100">
                                <div>
                                    <div class="widget ad-widget vstack gap-2">
                                        <div class="widget-title text-center">
                                            <h5 class="fs-7 ft-tertiary text-uppercase m-0">Sponsored</h5>
                                        </div>
                                        <div class="widget-content">
                                            <a class="cstack max-w-300px mx-auto text-none" href="#" target="_blank" rel="nofollow">
                                                <img class="d-none sm:d-block" src="{{ asset('front/assets/images/common/ad-desktop.jpg') }}" alt="Ad slot">
                                                <img class="d-block sm:d-none" src="{{ asset('front/assets/images/common/ad-mobile.jpg') }}" alt="Ad slot">
                            </a>
                        </div>
                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Featured Blog Slider Section end -->
