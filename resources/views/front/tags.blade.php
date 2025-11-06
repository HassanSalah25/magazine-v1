@extends("front.$version.layout")

@section('html_class')
    agntix-light
@endsection

@section('pagename')
    {{__('Tags')}}
@endsection

@section('meta-keywords', "$be->tags_meta_keywords")
@section('meta-description', "$be->tags_meta_description")

@section('content')
    <!-- breadcurmb area start -->
    <div class="tp-breadcrumb-area tp-breadcrumb-ptb include-bg" data-background="{{ asset('front/assets/img/about-us/about-us-4/about-us-4-bg.png') }}">
        <div class="container container-1330">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="tp-blog-heading-wrap p-relative pb-130">
                                    <span class="tp-section-subtitle pre tp_fade_anim">{{ convertUtf8($bs->tags_subtitle) }} <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                            <rect y="4.04333" width="80" height="1" fill="black" />
                                            <path d="M77 8.00783L80.5 4.52527L77 1.04271" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                                        </svg>
                                    </span>

                        <h3 class="tp-blog-title tp_fade_anim smooth">{{convertUtf8($bs->tags_title)}}</h3>

                        <div class="tp-blog-shape">
                                        <span><svg xmlns="http://www.w3.org/2000/svg" width="109" height="109" viewBox="0 0 109 109" fill="none">
                                                <path d="M46.8918 0.652597C52.0111 11.5756 61.1509 45.3262 42.3414 57.6622C32.5453 63.8237 11.8693 68.6772 1.79348 40.7372C-2.00745 30.1973 6.53261 20.5828 26.243 25.965C37.6149 29.0703 65.0949 36.1781 78.8339 57.5398C86.0851 68.8141 93.074 92.3859 89.9278 107.942M89.9278 107.942C90.8943 100.431 95.9994 85.8585 108.687 87.6568M89.9278 107.942C90.4304 103.013 86.878 91.2724 68.6481 83.7468M63.5129 27.0092C68.0375 28.7613 82.5356 36.982 88.0712 51.886" stroke="currentColor" stroke-width="1.5" />
                                            </svg></span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcurmb area end -->

    <!-- blog masonry area start -->
    <div id="down" class="tp-blog-masonry-ptb pb-70">
        <h2 class="m-3">{{ __('All Services') }}</h2>
        <div class="container container-1330">
            <div class="row ">
                @foreach($services as $service)
                    @if($loop->iteration % 2 == 1)
                            <div class="col-lg-4 col-md-6 grid-item">
                                <div class="tp-blog-masonry-item mb-30">
                                    <div class="tp-blog-masonry-item-top d-flex justify-content-between align-items-center mb-30">
                                        <div class="tp-blog-masonry-item-time">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $service->created_at?->format('d/m/Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="tp-blog-masonry-thumb mb-30">
                                        <a href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}"><img src="{{ asset('assets/front/img/services/' . $service->main_image) }}" alt="{{ convertUtf8($service->title) }}"></a>
                                    </div>
                                    <div class="tp-blog-masonry-content">
                                        <div class="tp-blog-masonry-tag mb-15">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M4.39012 4.13048H4.39847M13.6056 8.14369L8.74375 12.6328C8.6178 12.7492 8.46823 12.8415 8.30359 12.9046C8.13896 12.9676 7.96248 13 7.78426 13C7.60604 13 7.42956 12.9676 7.26493 12.9046C7.10029 12.8415 6.95072 12.7492 6.82477 12.6328L1 7.2609V1H7.78087L13.6056 6.37811C13.8582 6.61273 14 6.93009 14 7.2609C14 7.59171 13.8582 7.90908 13.6056 8.14369Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $service->scategory->name }}</span>
                                        </div>
                                        <h4 class="tp-blog-masonry-title"><a class="tp-line-white" href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}"> {{ convertUtf8($service->title) }}</a></h4>
                                        <div class="tp-blog-masonry-btn">
                                            <a href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">{{ __('Read More') }} <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @else
                            <div class="col-lg-4 col-md-6 grid-item">
                                <div class="tp-blog-masonry-item-2 mb-30">
                                    <div class="tp-blog-masonry-item-top d-flex justify-content-between align-items-center mb-30">
                                        <div class="tp-blog-masonry-item-time">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $service->created_at?->format('d/m/Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="tp-blog-masonry-content">
                                        <div class="tp-blog-masonry-tag mb-15">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M4.39012 4.13048H4.39847M13.6056 8.14369L8.74375 12.6328C8.6178 12.7492 8.46823 12.8415 8.30359 12.9046C8.13896 12.9676 7.96248 13 7.78426 13C7.60604 13 7.42956 12.9676 7.26493 12.9046C7.10029 12.8415 6.95072 12.7492 6.82477 12.6328L1 7.2609V1H7.78087L13.6056 6.37811C13.8582 6.61273 14 6.93009 14 7.2609C14 7.59171 13.8582 7.90908 13.6056 8.14369Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $service->scategory->name }}</span>
                                        </div>
                                        <h4 class="tp-blog-masonry-title"><a class="tp-line-white" href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">{{ convertUtf8($service->title) }}</a></h4>
                                        <div class="tp-blog-masonry-btn">
                                            <a href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">{{ __('Read More') }} <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span></a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                    @endif
                @endforeach
                    {{ $services->appends(request()->query())->links('vendor.pagination.custom') }}

            </div>
        </div>
    </div>
    <!-- blog masonry area end -->

    <!-- blog masonry area start -->
    <div id="down" class="tp-blog-masonry-ptb pb-70">
        <h2 class="m-3">{{ __('All Blogs') }}</h2>
        <div class="container container-1330">
            <div class="row ">
                @foreach($blogs as $blog)
                    @if($loop->iteration % 2 == 1)
                        <div class="col-lg-4 col-md-6 grid-item">
                            <div class="tp-blog-masonry-item mb-30">
                                <div class="tp-blog-masonry-item-top d-flex justify-content-between align-items-center mb-30">
                                    <div class="tp-blog-masonry-item-time">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $blog->created_at?->format('d/m/Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="tp-blog-masonry-thumb mb-30">
                                    <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}"><img src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}"></a>
                                </div>
                                <div class="tp-blog-masonry-content">
                                    <div class="tp-blog-masonry-tag mb-15">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M4.39012 4.13048H4.39847M13.6056 8.14369L8.74375 12.6328C8.6178 12.7492 8.46823 12.8415 8.30359 12.9046C8.13896 12.9676 7.96248 13 7.78426 13C7.60604 13 7.42956 12.9676 7.26493 12.9046C7.10029 12.8415 6.95072 12.7492 6.82477 12.6328L1 7.2609V1H7.78087L13.6056 6.37811C13.8582 6.61273 14 6.93009 14 7.2609C14 7.59171 13.8582 7.90908 13.6056 8.14369Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $blog->bcategory->name }}</span>
                                    </div>
                                    <h4 class="tp-blog-masonry-title"><a class="tp-line-white" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}"> {{ convertUtf8($blog->title) }}</a></h4>
                                    <div class="tp-blog-masonry-btn">
                                        <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ __('Read More') }} <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @else
                        <div class="col-lg-4 col-md-6 grid-item">
                            <div class="tp-blog-masonry-item-2 mb-30">
                                <div class="tp-blog-masonry-item-top d-flex justify-content-between align-items-center mb-30">
                                    <div class="tp-blog-masonry-item-time">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 18 18" fill="none">
                                                        <path d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $blog->created_at?->format('d/m/Y h:i A') }}</span>
                                    </div>
                                </div>
                                <div class="tp-blog-masonry-content">
                                    <div class="tp-blog-masonry-tag mb-15">
                                                <span><svg xmlns="http://www.w3.org/2000/svg" width="15" height="14" viewBox="0 0 15 14" fill="none">
                                                        <path d="M4.39012 4.13048H4.39847M13.6056 8.14369L8.74375 12.6328C8.6178 12.7492 8.46823 12.8415 8.30359 12.9046C8.13896 12.9676 7.96248 13 7.78426 13C7.60604 13 7.42956 12.9676 7.26493 12.9046C7.10029 12.8415 6.95072 12.7492 6.82477 12.6328L1 7.2609V1H7.78087L13.6056 6.37811C13.8582 6.61273 14 6.93009 14 7.2609C14 7.59171 13.8582 7.90908 13.6056 8.14369Z" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                    </svg> {{ $blog->bcategory->name }}</span>
                                    </div>
                                    <h4 class="tp-blog-masonry-title"><a class="tp-line-white" href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ convertUtf8($blog->title) }}</a></h4>
                                    <div class="tp-blog-masonry-btn">
                                        <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">{{ __('Read More') }} <span><svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg xmlns="http://www.w3.org/2000/svg" width="12" height="12" viewBox="0 0 12 12" fill="none">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#ffcb05" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span></a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif
                @endforeach
                {{ $blogs->appends(request()->query())->links('vendor.pagination.custom') }}

            </div>
        </div>
    </div>
    <!-- blog masonry area end -->

@endsection
