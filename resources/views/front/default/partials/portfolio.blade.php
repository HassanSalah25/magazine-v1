<!-- Portfolio section start -->
<div class="section panel py-4 lg:py-8 bg-gray-900 text-white">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-6">
                            <h2 class="h3 lg:h2 mb-3">{{ convertUtf8($bs->portfolio_section_title) }}</h2>
                        </div>
                        <div class="col-lg-6">
                            <p class="mb-0 text-white text-opacity-80">{{ convertUtf8($bs->portfolio_section_text) }}</p>
                        </div>
                    </div>
                </div>
                
                <div class="block-content panel">
                    <div class="swiper" data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; next: .nav-next; prev: .nav-prev;" data-uc-swiper-s="items: 2; gap: 24;" data-uc-swiper-l="items: 3; gap: 24;">
                        <div class="swiper-wrapper">
                            @foreach ($portfolios as $portfolio)
                                <div class="swiper-slide">
                                    <div class="card panel bg-white bg-opacity-10 backdrop-blur-sm rounded overflow-hidden">
                                        <div class="card-media panel">
                                            <div class="featured-image ratio ratio-16x9">
                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                     src="{{ asset('assets/front/img/portfolios/featured/' . $portfolio->featured_image) }}" 
                                                     alt="{{ $portfolio->title }}" 
                                                     data-uc-img="loading: lazy">
                                            </div>
                                            <a href="{{ route('front.portfoliodetails', [$portfolio->slug, $portfolio->id]) }}" class="position-cover"></a>
                                        </div>
                                        <div class="card-body panel p-4">
                                            <h4 class="h6 mb-2">
                                                <a class="text-white text-decoration-none hover:text-primary duration-150" 
                                                   href="{{ route('front.portfoliodetails', [$portfolio->slug, $portfolio->id]) }}">
                                                    {{ strlen($portfolio->title) > 36 ? mb_substr($portfolio->title, 0, 36, 'utf-8') . '...' : $portfolio->title }}
                                                </a>
                                            </h4>
                                            @if (!empty($portfolio->service))
                                                <p class="fs-6 text-white text-opacity-60 mb-0">{{ $portfolio->service->title }}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Navigation -->
                        <div class="swiper-navigation d-flex justify-content-center gap-2 mt-4">
                            <button class="btn btn-sm btn-white nav-prev">
                                <i class="fa-solid fa-chevron-left"></i>
                            </button>
                            <button class="btn btn-sm btn-white nav-next">
                                <i class="fa-solid fa-chevron-right"></i>
                            </button>
                        </div>
                        
                        <!-- Dots -->
                        <div class="dot-nav d-flex justify-content-center gap-1 mt-3"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Portfolio section end -->
