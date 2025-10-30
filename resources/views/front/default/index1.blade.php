@extends('front.default.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")

@section('content')
    <!-- News Carousel Section start -->
    <div class="section panel overflow-hidden swiper-parent border-top">
        <div class="section-outer panel py-2 lg:py-4 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-content panel">
                            <div class="swiper" data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;" data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 4; gap: 24;">
                                <div class="swiper-wrapper">
                                    @if(isset($carousel_blogs) && count($carousel_blogs) > 0)
                                        @foreach($carousel_blogs->take(8) as $blog)
                                            <div class="swiper-slide">
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle gap-2">
                                                        <div class="row child-cols g-2" data-uc-grid>
                                                            <div class="col-auto">
                                                                <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                             src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                             data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                             alt="{{ convertUtf8($blog->title) }}" 
                                                                             data-uc-img="loading: lazy">
                                                                    </div>
                                                                    <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}" class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                            <div>
                                                                <div class="post-header panel vstack justify-between gap-1">
                                                                    <h3 class="post-title h6 m-0 text-truncate-2">
                                                                        <a class="text-none hover:text-primary duration-150" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                                    </h3>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="swiper-slide">
                                            <div>
                                                <article class="post type-post panel uc-transition-toggle gap-2">
                                                    <div class="row child-cols g-2" data-uc-grid>
                                                        <div class="col-auto">
                                                            <div class="post-media panel overflow-hidden max-w-64px min-w-64px">
                                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                         src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                         alt="Welcome" 
                                                                         data-uc-img="loading: lazy">
                                                                </div>
                                                                <a href="#" class="position-cover"></a>
                                                                </div>
                                                            </div>
                                                        <div>
                                                            <div class="post-header panel vstack justify-between gap-1">
                                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                                    <a class="text-none hover:text-primary duration-150" href="#">Welcome to {{ $bs->website_title }}</a>
                                                                </h3>
                                                    </div>
                                                        </div>
                                                            </div>
                                                </article>
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <!-- Navigation arrows -->
                                <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                    <i class="fa-solid fa-angle-left"></i>
                                    </div>
                                <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px h-32px z-1">
                                    <i class="fa-solid fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- News Carousel Section end -->

    <!-- Main content sections will be added here -->
    @include('front.default.partials.static')

    <div class="uX-cryptoWrap_mq" id="uX-cryptoWrap"></div>

    <!-- Blog Categories Carousel Section start -->
    <div class="image-links-panel panel overflow-hidden pt-2 swiper-parent mb-4">
        <div class="container max-w-xl">
            <div class="panel">
                <div class="swiper" data-uc-swiper="items: 3.25; gap: 8; center: true; freeMode: true; center-bounds: true; disable-class: d-none;" data-uc-swiper-s="items: 6;" data-uc-swiper-l="items: 8; gap: 16;">
                    <div class="swiper-wrapper">
                        @if(isset($bcategories) && count($bcategories) > 0)
                            @foreach($bcategories->take(9) as $category)
                                @php
                                    $colors = ['orange-600', 'lime-600', 'red-600', 'green-600', 'blue-600', 'teal-600', 'purple-600', 'pink-600', 'indigo-600'];
                                    $colorIndex = $loop->index % count($colors);
                                    $color = $colors[$colorIndex];
                                @endphp
                                <div class="swiper-slide">
                                    <div class="panel uc-transition-toggle vstack text-center overflow-hidden rounded border border-white border-opacity-10">
                                        <figure class="featured-image m-0 ratio ratio-3x4 rounded-0 overflow-hidden bg-gray-25 dark:bg-gray-800">
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                 src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                 data-src="{{ asset('assets/front/img/service_category_icons/' . $category->image) }}" 
                                                 alt="{{ convertUtf8($category->name) }}" 
                                                 data-uc-img="loading: lazy">
                                            <a href="{{ route('front.blogs', $category->slug) }}" class="position-cover" data-caption="{{ convertUtf8($category->name) }}"></a>
                                        </figure>
                                        <div class="overlay position-cover z-0 bg-black bg-opacity-50"></div>
                                        <div class="position-absolute bottom-0 vstack justify-end gap-1 lg:gap-2 h-3/4 w-100 p-2 bg-gradient-to-t from-{{ $color }} to-transparent">
                                            <span class="fs-5 lg:fs-4 fw-bold text-white m-0">{{ convertUtf8($category->name) }}</span>
                                            <a href="{{ route('front.blogs', $category->slug) }}" class="btn btn-2xs border-white border-opacity-25 fs-7 text-white rounded-1">Visit</a>
                                        </div>
                                        <a class="position-cover text-none z-1" href="{{ route('front.blogs', $category->slug) }}"></a>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            {{-- Fallback categories if none exist --}}
                            @php
                                $fallbackCategories = [
                                    ['name' => 'Tech', 'color' => 'orange-600', 'image' => 'img-01.jpg'],
                                    ['name' => 'Gadgets', 'color' => 'lime-600', 'image' => 'img-02.jpg'],
                                    ['name' => 'Security', 'color' => 'red-600', 'image' => 'img-03.jpg'],
                                    ['name' => 'Network', 'color' => 'green-600', 'image' => 'img-04.jpg'],
                                    ['name' => 'Startups', 'color' => 'blue-600', 'image' => 'img-05.jpg'],
                                    ['name' => 'Space', 'color' => 'teal-600', 'image' => 'img-06.jpg'],
                                    ['name' => 'VR', 'color' => 'purple-600', 'image' => 'img-07.jpg'],
                                    ['name' => 'Repair', 'color' => 'pink-600', 'image' => 'img-20.jpg'],
                                    ['name' => 'AI', 'color' => 'indigo-600', 'image' => 'img-09.jpg']
                                ];
                            @endphp
                            @foreach($fallbackCategories as $category)
                                <div class="swiper-slide">
                                    <div class="panel uc-transition-toggle vstack text-center overflow-hidden rounded border border-white border-opacity-10">
                                        <figure class="featured-image m-0 ratio ratio-3x4 rounded-0 overflow-hidden bg-gray-25 dark:bg-gray-800">
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                 src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                 data-src="{{ asset('front/assets/images/demo-three/posts/' . $category['image']) }}" 
                                                 alt="{{ $category['name'] }}" 
                                                 data-uc-img="loading: lazy">
                                            <a href="#" class="position-cover" data-caption="{{ $category['name'] }}"></a>
                                        </figure>
                                        <div class="overlay position-cover z-0 bg-black bg-opacity-50"></div>
                                        <div class="position-absolute bottom-0 vstack justify-end gap-1 lg:gap-2 h-3/4 w-100 p-2 bg-gradient-to-t from-{{ $category['color'] }} to-transparent">
                                            <span class="fs-5 lg:fs-4 fw-bold text-white m-0">{{ $category['name'] }}</span>
                                            <a href="#" class="btn btn-2xs border-white border-opacity-25 fs-7 text-white rounded-1">Visit</a>
                                        </div>
                                        <a class="position-cover text-none z-1" href="#"></a>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Categories Carousel Section end -->

    <!-- Blog Posts Grid Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        <!-- Dynamic Sections -->
                        
                        {!! dynamicSection('World') !!}
                        {!! dynamicSection('Opinions') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Blog Posts Grid Section end -->

    <!-- Advertisement Section start -->
    <div class="section panel overflow-hidden mt-3 mb-3">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    @if(isset($partners) && $partners->count() > 0)
                        @foreach($partners->take(1) as $partner)
                            <a href="{{$partner->url}}" target="_blank" rel="nofollow">
                                @include('front.components.responsive-sponsor', ['partner' => $partner])
                            </a>
                        @endforeach
                    @else
                        <img class="d-none md:d-block" src="{{ asset('front/assets/images/common/ad-slot.jpg') }}" alt="Ad slot">
                        <img class="d-block md:d-none" src="{{ asset('front/assets/images/common/ad-slot-mobile.jpg') }}" alt="Ad slot">
                    @endif
                </div>
            </div>
        </div>
    </div>
    <!-- Advertisement Section end -->

    <!-- Hot Now Carousel Section start -->
    <div class="section panel overflow-hidden swiper-parent">
        <div class="section-outer panel py-4 lg:py-6 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner panel vstack gap-2">
                    <div class="block-layout carousel-layout vstack gap-2 lg:gap-3 panel">
                        <div class="block-header panel pt-1 border-top">
                            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Hot now</h2>
                        </div>
                        <div class="block-content panel">
                            <div class="swiper" data-uc-swiper="items: 2; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev; disable-class: d-none;" data-uc-swiper-s="items: 3; gap: 24;" data-uc-swiper-l="items: 5; gap: 24;">
                                <div class="swiper-wrapper">
                                    @if(isset($hot_now_blogs) && count($hot_now_blogs) > 0)
                                        @foreach($hot_now_blogs as $blog)
                                            <div class="swiper-slide">
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle vstack gap-2">
                                                        <div class="post-media panel overflow-hidden">
                                                            <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                     src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                     data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                     alt="{{ convertUtf8($blog->title) }}" 
                                                                     data-uc-img="loading: lazy">
                                                            </div>
                                                            <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}" class="position-cover"></a>
                                                        </div>
                                                        <div class="post-header panel vstack gap-1">
                                                            <h3 class="post-title h6 m-0 text-truncate-2">
                                                                <a class="text-none hover:text-primary duration-150" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                            </h3>
                                                            <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex z-1 d-none md:d-block">
                                                                <div>
                                                                    <div class="post-date hstack gap-narrow">
                                                                        <span>{{ $blog->created_at->diffForHumans() }}</span>
                                                                    </div>
                                                                </div>
                                                                <div>·</div>
                                                                <div>
                                                                    <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                        <i class="fa-solid fa-comment-dots"></i>
                                                                        <span>{{ $blog->comments()->approved()->count() }}</span>
                                                                    </a>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                            </div>
                                        @endforeach
                                    @endif
                                </div>
                                <div class="swiper-nav nav-prev position-absolute top-50 start-0 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                    <i class="fa-solid fa-angle-left"></i>
                                </div>
                                <div class="swiper-nav nav-next position-absolute top-50 start-100 translate-middle btn btn-alt-primary text-black rounded-circle p-0 border shadow-xs w-32px lg:w-40px h-32px lg:h-40px z-1">
                                    <i class="fa-solid fa-angle-right"></i>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Hot Now Carousel Section end -->

         <!-- Section end -->
         <div class="section panel overflow-hidden mt-3 mb-3">
                    <div class="section-outer panel">
                        <div class="container max-w-xl">
                            <div class="section-inner">
                                @if(isset($partners) && $partners->count() > 1)
                                    @foreach($partners->take(1) as $partner)
                                        <a href="{{$partner->url}}" target="_blank" rel="nofollow">
                                            @include('front.components.responsive-sponsor', ['partner' => $partner])
                                        </a>
                                    @endforeach
                                @else
                                    <img class="d-none md:d-block" src="{{ asset('front/assets/images/common/ad-slot.jpg') }}" alt="Ad slot">
                                    <img class="d-block md:d-none" src="{{ asset('front/assets/images/common/ad-slot-mobile.jpg') }}" alt="Ad slot">
                                @endif
                            </div>
                        </div>
                    </div>
                    </div>
                    <section class="uX-tableSection_v1">
                        <div class="uX-tableHead_8b">
                            <h2>Top Companies by Market Cap</h2>
                        </div>
                        <div class="uX-tableWrapper_9x">
                            <table class="uX-table_92">
                                <thead>
                                    <tr>
                                    <th>Rank</th><th>Name</th><th>Market Cap</th><th>Price</th><th>Today</th><th>Chart (7d)</th>
                                    </tr>
                                </thead>
                                <tbody id="vx91x-body"></tbody>
                            </table>
                        </div>
                    </section>
                    <div class="uX-container_v2">
                        <div class="uX-companyTop_j8">
                            <div class="uX-companyInfo_55">
                                <img id="xx-logo" class="uX-companyLogo_9" src="https://companiesmarketcap.com/img/company-logos/256/NVDA.webp" alt="logo" />
                                <div>
                                    <h3 id="xx-name" class="uX-companyName_2">Company Name</h3>
                                    <div id="xx-symbol" class="uX-companyTicker_6">TICK</div>
                                </div>
                            </div>
                            <div class="uX-companyStats_7">
                                <div class="uX-statBlock_a1"><span>Market Cap</span><strong id="xx-marketcap">$0.00</strong></div>
                                <div class="uX-statBlock_a1"><span>Price</span><strong id="xx-price">$0.00</strong></div>
                                <div class="uX-statBlock_a1"><span>Change (24h)</span><strong id="xx-change" class="uX-mutedText_s1">0%</strong></div>
                                <div class="uX-statBlock_a1"><span>Country</span><div class="uX-companyTicker_6"><img src="https://flagcdn.com/us.svg" style="width:18px;vertical-align:middle;margin-right:6px;"> USA</div>
                            </div>
                        </div>
                    </div>
            </div>

    <!-- Additional Blog Posts Grid Section start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        <!-- Dynamic Sections will be rendered here -->
                        {!! dynamicSection('Politics') !!}
                        {!! dynamicSection('Media') !!}
                           
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Additional Blog Posts Grid Section end -->

    <!-- Three Column Blog Sections start -->
    <div class="section panel overflow-hidden">
        <div class="section-outer panel py-4 lg:py-6 dark:text-white">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="row child-cols-12 lg:child-cols g-4 lg:g-6 col-match" data-uc-grid>
                        
                        {!! dynamicSection('Tech') !!}
                        {!! dynamicSection('Health') !!}
                        {!! dynamicSection('Science') !!}
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Three Column Blog Sections end -->

    <!-- Live Now Video Section start -->
    <div id="live_now" class="live_now section panel uc-dark swiper-parent">
        <div class="section-outer panel py-4 lg:py-6 bg-gray-900 text-white">
            <div class="container max-w-xl">
                <div class="block-layout slider-thumbs-layout slider-thumbs panel vstack gap-2 lg:gap-3 panel overflow-hidden">
                    <div class="block-header panel">
                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase hstack gap-narrow m-0 text-black dark:text-white">
                            <i class="fa-regular fa-circle-dot text-red" style="color:red;" data-uc-animate="flash"></i>
                            <span>Live now</span>
                        </h2>
                    </div>
                    <div class="block-content">
                        <div class="row child-cols-12 g-2" data-uc-grid>
                            <div class="md:col-8 lg:col-9">
                                <div class="panel overflow-hidden rounded">
                                    <div class="swiper swiper-main" data-uc-swiper="connect: .swiper-thumbs; items: 1; gap: 8; autoplay: 7000; parallax: true; fade: true; effect: fade; dots: .swiper-pagination; disable-class: last-slide;">
                                        <div class="swiper-wrapper">
                                            @if(isset($blogs) && count($blogs) > 38)
                                                @foreach($blogs->skip(38)->take(4) as $blog)
                                                    <div class="swiper-slide">
                                                        <article class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                            <div class="post-media panel overflow-hidden position-cover">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                                    <video class="video-cover video-lazyload min-h-100px" preload="none" loop playsinline>
                                                                        <source src="{{ asset('front/assets/images/common/img-fallback.png') }}" data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80"></div>
                                                            <div class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                                <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2" data-swiper-parallax-x="-8">
                                                                    <a class="text-none" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                                </h3>
                                                                <div data-swiper-parallax-x="8">
                                                                    <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div class="post-author hstack gap-1">
                                                                                        <a href="#" data-uc-tooltip="{{ $blog->author ?? 'Admin' }}">
                                                                                            <img src="{{ asset('front/assets/images/avatars/03.png') }}" 
                                                                                                 alt="{{ $blog->author ?? 'Admin' }}" 
                                                                                                 class="w-24px h-24px rounded-circle">
                                                                                        </a>
                                                                                        <a href="#" class="text-black dark:text-white text-none fw-bold">{{ $blog->author ?? 'Admin' }}</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="post-date hstack gap-narrow">
                                                                                        <span>{{ $blog->created_at->diffForHumans() }}</span>
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
                                                {{-- Fallback content for Live Now section --}}
                                                @php
                                                    $livePosts = [
                                                        ['title' => 'Balancing Work and Wellness: Tech Solutions for Healthy', 'date' => '1h ago', 'author' => 'Sarah Eddrissi', 'avatar' => '03.png', 'comments' => 0],
                                                        ['title' => 'Business Agility the Digital Age: Leveraging AI and Automation', 'date' => '7d ago', 'author' => 'Nisi Nyung', 'avatar' => '08.png', 'comments' => 23],
                                                        ['title' => 'The Art of Baking: From Classic Bread to Artisan Pastries', 'date' => '9d ago', 'author' => 'Nisi Nyung', 'avatar' => '08.png', 'comments' => 112],
                                                        ['title' => 'AI-Powered Financial Planning: How Algorithms Revolutionizing', 'date' => '2mo ago', 'author' => 'Sarah Eddrissi', 'avatar' => '03.png', 'comments' => 2]
                                                    ];
                                                @endphp
                                                @foreach($livePosts as $post)
                                                    <div class="swiper-slide">
                                                        <article class="post type-post h-250px md:h-350px lg:h-500px bg-black uc-dark">
                                                            <div class="post-media panel overflow-hidden position-cover">
                                                                <div class="featured-video bg-gray-700 ratio ratio-3x2">
                                                                    <video class="video-cover video-lazyload min-h-100px" preload="none" loop playsinline>
                                                                        <source src="{{ asset('front/assets/images/common/img-fallback.png') }}" data-src="{{ asset('front/assets/images/demo-two/videos/vid-01.webm') }}" type="video/webm">
                                                                        Your browser does not support the video tag.
                                                                    </video>
                                                                </div>
                                                            </div>
                                                            <div class="position-cover bg-gradient-to-t from-black to-transparent z-1 opacity-80"></div>
                                                            <div class="post-header panel position-absolute bottom-0 vstack justify-between gap-2 xl:gap-4 max-300px lg:max-w-600px p-2 md:p-4 xl:p-6 z-1">
                                                                <h3 class="post-title h4 lg:h3 xl:h2 m-0 text-truncate-2" data-swiper-parallax-x="-8">
                                                                    <a class="text-none" href="#">{{ $post['title'] }}</a>
                                                                </h3>
                                                                <div data-swiper-parallax-x="8">
                                                                    <div class="post-meta panel hstack justify-between fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                        <div class="meta">
                                                                            <div class="hstack gap-2">
                                                                                <div>
                                                                                    <div class="post-author hstack gap-1">
                                                                                        <a href="#" data-uc-tooltip="{{ $post['author'] }}">
                                                                                            <img src="{{ asset('front/assets/images/avatars/' . $post['avatar']) }}" 
                                                                                                 alt="{{ $post['author'] }}" 
                                                                                                 class="w-24px h-24px rounded-circle">
                                                                                        </a>
                                                                                        <a href="#" class="text-black dark:text-white text-none fw-bold">{{ $post['author'] }}</a>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <div class="post-date hstack gap-narrow">
                                                                                        <span>{{ $post['date'] }}</span>
                                                                                    </div>
                                                                                </div>
                                                                                <div>
                                                                                    <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                                                        <i class="fa-solid fa-comment-dots"></i>
                                                                                        <span>{{ $post['comments'] }}</span>
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
                                            @endif
                                        </div>
                                        <!-- Add Pagination -->
                                        <div class="swiper-pagination top-auto start-auto bottom-0 end-0 m-2 md:m-4 xl:m-6 text-white d-none md:d-inline-flex justify-end w-auto"></div>
                                    </div>
                                </div>
                            </div>
                            <div class="md:col-4 lg:col-3">
                                <div class="panel md:vstack gap-1 h-100">
                                    <!-- Slides thumbs -->
                                    <div class="swiper swiper-thumbs swiper-thumbs-progress rounded order-2" data-uc-swiper="items: 2; gap: 4; disable-class: last-slide;" data-uc-swiper-s="items: auto; direction: vertical; autoHeight: true; mousewheel: true; freeMode: false; watchSlidesVisibility: true; watchSlidesProgress: true; watchOverflow: true">
                                        <div class="swiper-wrapper md:flex-1">
                                            @if(isset($blogs) && count($blogs) > 38)
                                                @foreach($blogs->skip(38)->take(4) as $blog)
                                                    <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                        <div class="swiper-slide-progress position-cover z-0">
                                                            <span></span>
                                                        </div>
                                                        <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                            <div class="row gx-1">
                                                                <div class="col-auto post-media-wrap">
                                                                    <div class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                        <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                            <video class="video-cover video-lazyload min-h-100px" preload="none" loop playsinline>
                                                                                <source src="{{ asset('front/assets/images/common/img-fallback.png') }}" data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" type="video/webm">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        </div>
                                                                        <div class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50"></div>
                                                                        <span class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                            <i class="fa-solid fa-play"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <p class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">{{ convertUtf8($blog->title) }}</p>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @else
                                                {{-- Fallback thumbs content --}}
                                                @php
                                                    $liveThumbs = [
                                                        'Balancing Work and Wellness: Tech Solutions for Healthy',
                                                        'Business Agility the Digital Age: Leveraging AI and Automation',
                                                        'The Art of Baking: From Classic Bread to Artisan Pastries',
                                                        'AI-Powered Financial Planning: How Algorithms Revolutionizing'
                                                    ];
                                                @endphp
                                                @foreach($liveThumbs as $thumb)
                                                    <div class="swiper-slide overflow-hidden rounded min-h-64px lg:min-h-100px">
                                                        <div class="swiper-slide-progress position-cover z-0">
                                                            <span></span>
                                                        </div>
                                                        <article class="post type-post panel uc-transition-toggle p-1 z-1">
                                                            <div class="row gx-1">
                                                                <div class="col-auto post-media-wrap">
                                                                    <div class="post-media panel overflow-hidden w-40px lg:w-64px rounded">
                                                                        <div class="featured-video bg-gray-700 ratio ratio-3x4">
                                                                            <video class="video-cover video-lazyload min-h-100px" preload="none" loop playsinline>
                                                                                <source src="{{ asset('front/assets/images/common/img-fallback.png') }}" data-src="{{ asset('front/assets/images/demo-two/videos/vid-01.webm') }}" type="video/webm">
                                                                                Your browser does not support the video tag.
                                                                            </video>
                                                                        </div>
                                                                        <div class="has-video-overlay position-absolute top-0 end-0 w-40px h-40px lg:w-64px lg:h-64px bg-gradient-45 from-transparent via-transparent to-black opacity-50"></div>
                                                                        <span class="cstack has-video-icon position-absolute top-50 start-50 translate-middle fs-6 w-40px h-40px text-white">
                                                                            <i class="fa-solid fa-play"></i>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                                <div class="col">
                                                                    <p class="fs-6 m-0 text-truncate-2 text-gray-900 dark:text-white">{{ $thumb }}</p>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <!-- Tablet, Desktop and big screens nav -->
                                    <div class="swiper-prev btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-1">Prev</div>
                                    <div class="swiper-next btn btn-2xs lg:btn-xs btn-primary w-100 d-none md:d-flex order-3">Next</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Live Now Video Section end -->

    <!-- Latest News Section start -->
    <div id="latest_news" class="latest-news section panel">
        <div class="section-outer panel py-4 lg:py-6">
            <div class="container max-w-xl">
                <div class="section-inner">
                    <div class="content-wrap row child-cols-12 g-4 lg:g-6" data-uc-grid>
                        <div class="md:col-9">
                            <div class="main-wrap panel vstack gap-3 lg:gap-6">
                                <div class="block-layout grid-layout vstack gap-2 panel overflow-hidden">
                                    <div class="block-header panel pt-1 border-top">
                                        <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">Latest</h2>
                                    </div>
                                    <div class="block-content">
                                        <div class="row child-cols-12 g-2 lg:g-4 sep-x">
                                            @if(isset($latest_blogs) && count($latest_blogs) > 0)
                                                @foreach($latest_blogs->take(12) as $blog)
                                                    <div>
                                                        <article class="post type-post panel uc-transition-toggle">
                                                            <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                                <div class="col-auto">
                                                                    <div class="post-media panel overflow-hidden max-w-150px min-w-100px lg:min-w-250px">
                                                                        <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-3x2">
                                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                                 src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                                                 data-src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                                 alt="{{ convertUtf8($blog->title) }}" 
                                                                                 data-uc-img="loading: lazy">
                                                                        </div>
                                                                        <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}" class="position-cover"></a>
                                                                    </div>
                                                                </div>
                                                                <div>
                                                                    <div class="post-header panel vstack justify-between gap-1">
                                                                        <h3 class="post-title h5 lg:h4 m-0 text-truncate-2">
                                                                            <a class="text-none hover:text-primary duration-150" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                                        </h3>
                                                                    </div>
                                                                    <p class="post-excrept ft-tertiary fs-6 text-gray-900 dark:text-white text-opacity-60 text-truncate-2 my-1">{!! Str::limit(strip_tags($blog->content), 150) !!}</p>
                                                                    <div class="post-link">
                                                                        <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}" class="link fs-7 fw-bold text-uppercase text-none mt-1 pb-narrow p-0 border-bottom dark:text-white">
                                                                            <span>Read more</span>
                                                                        </a>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </article>
                                                    </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                    <div class="block-footer cstack lg:mt-2">
                                        <a href="{{ route('front.blogs') }}" class="animate-btn gap-0 btn btn-sm btn-alt-primary bg-transparent text-black dark:text-white border w-100">
                                            <span>Load more posts</span>
                                            <i class="fa-solid fa-angle-right"></i>
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="md:col-3">
                            <div class="sidebar-wrap panel vstack gap-2 pb-2" data-uc-sticky="end: .content-wrap; offset: 150; media: @m;">
                                <div class="widget ad-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-content">
                                        @if(isset($partners) && $partners->count() > 0)
                                            @foreach($partners->take(1) as $partner)
                                                <a class="cstack max-w-300px mx-auto text-none" href="{{$partner->url}}" target="_blank" rel="nofollow">
                                                    @include('front.components.responsive-sponsor', ['partner' => $partner])
                                                </a>
                                            @endforeach
                                        @else
                                            <a class="cstack max-w-300px mx-auto text-none" href="#" target="_blank" rel="nofollow">
                                                <img class="d-block dark:d-none" src="{{ asset('front/assets/images/common/ad-slot-aside.jpg') }}" alt="Ad slot">
                                                <img class="d-none dark:d-block" src="{{ asset('front/assets/images/common/ad-slot-aside-2.jpg') }}" alt="Ad slot">
                                            </a>
                                        @endif
                                    </div>
                                </div>
                                <div class="widget popular-widget vstack gap-2 p-2 border">
                                    <div class="widget-title text-center">
                                        <h5 class="fs-7 ft-tertiary text-uppercase m-0">Popular now</h5>
                                    </div>
                                    <div class="widget-content">
                                        <div class="row child-cols-12 gx-4 gy-3 sep-x" data-uc-grid>
                                            @if(isset($featured_blogs) && count($featured_blogs) > 0)
                                                @foreach($featured_blogs as $index => $blog)
                                                <div>
                                                    <article class="post type-post panel uc-transition-toggle">
                                                        <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                                            <div>
                                                                <div class="hstack items-start gap-3">
                                                                    <span class="h3 lg:h2 ft-tertiary fst-italic text-center text-primary m-0 min-w-24px">{{ $index + 1 }}</span>
                                                                    <div class="post-header panel vstack justify-between gap-1">
                                                                        <h3 class="post-title h6 m-0">
                                                                            <a class="text-none hover:text-primary duration-150" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a>
                                                                        </h3>
                                                                        <div class="post-meta panel hstack justify-between fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                            <div class="meta">
                                                                                <div class="hstack gap-2">
                                                                                    <div>
                                                                                        <div class="post-date hstack gap-narrow">
                                                                                            <span>{{ $blog->created_at->diffForHumans() }}</span>
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
                                                            </div>
                                                        </div>
                                                    </article>
                                                </div>
                                                @endforeach
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="widget social-widget vstack gap-2 text-center p-2 border">
                                    <div class="widgt-title">
                                        <h4 class="fs-7 ft-tertiary text-uppercase m-0">Follow {{ $bs->website_title ?? 'News' }}</h4>
                                    </div>
                                    <div class="widgt-content">
                                        <form class="vstack gap-1" action="{{ route('front.subscribe') }}" method="POST">
                                            @csrf
                                            <input class="form-control form-control-sm fs-6 fw-medium h-40px w-full bg-white dark:bg-gray-800 dark:bg-gray-800 dark:border-white dark:border-opacity-15 dark:border-opacity-15" type="email" name="email" placeholder="Your email" required="">
                                            <button class="btn btn-sm btn-primary" type="submit">Sign up</button>
                                        </form>
                                        <ul class="nav-x justify-center gap-1 mt-3">
                                            @if (!empty($socials))
                                                @foreach ($socials as $social)
                                                    <li>
                                                        <a href="{{ $social->url }}" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150" target="_blank">
                                                            <i class="{{ $social->icon }}"></i>
                                                        </a>
                                                    </li>
                                                @endforeach
                                            @else
                                                <li>
                                                    <a href="#fb" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                        <i class="icon icon-1 unicon-logo-facebook"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#x" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                        <i class="icon icon-1 unicon-logo-x-filled"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#in" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                        <i class="icon icon-1 unicon-logo-instagram"></i>
                                                    </a>
                                                </li>
                                                <li>
                                                    <a href="#yt" class="cstack w-32px h-32px border rounded-circle hover:text-black dark:hover:text-white hover:scale-110 transition-all duration-150">
                                                        <i class="icon icon-1 unicon-logo-youtube"></i>
                                                    </a>
                                                </li>
                                            @endif
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Latest News Section end -->

    <!-- Google Ads Integration -->
    @include('front.components.google-ads')

   
@endsection 
