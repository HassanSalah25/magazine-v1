@if($section->posts()->count() > 0)
<div class="lg:col-8">
    <div class="block-layout grid-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
        <div class="block-header panel pt-1 border-top">
            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ route('front.blogs') }}">
                    <span>{{ $section->name }}</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </h2>
        </div>
        <div class="block-content">
            <div class="panel row child-cols-12 md:child-cols g-2 lg:g-4 col-match sep-y" data-uc-grid>
                <div class="col-12 md:col-6 order-0 md:order-1">
                    <div>
                        @if($section->featuredPost())
                            @php $featuredPost = $section->featuredPost(); @endphp
                            <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 h-100 overflow-hidden uc-dark">
                                <div class="post-media panel overflow-hidden h-100">
                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 h-100 d-none md:d-block">
                                        <canvas class="h-100 w-100"></canvas>
                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                            src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                            data-src="{{ asset('assets/front/img/blogs/' . $featuredPost->main_image) }}" 
                                            alt="{{ convertUtf8($featuredPost->title) }}" 
                                            data-uc-img="loading: lazy">
                                    </div>
                                    <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9 d-block md:d-none">
                                        <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                            src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                            data-src="{{ asset('assets/front/img/blogs/' . $featuredPost->main_image) }}" 
                                            alt="{{ convertUtf8($featuredPost->title) }}" 
                                            data-uc-img="loading: lazy">
                                    </div>
                                </div>
                                <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                                <div class="post-header panel vstack justify-end items-start gap-1 p-2 sm:p-4 position-cover text-white">
                                    <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                        <span>{{ $featuredPost->created_at->diffForHumans() }}</span>
                                    </div>
                                    <h3 class="post-title h5 lg:h4 m-0 max-w-600px text-white text-truncate-2">
                                        <a class="text-none text-white" href="{{ route('front.blogdetails', [$featuredPost->slug, $featuredPost->id]) }}">{{ convertUtf8($featuredPost->title) }}</a>
                                    </h3>
                                    <div>
                                        <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                            <div class="meta">
                                                <div class="hstack gap-2">
                                                    <div>
                                                        <div class="post-author hstack gap-1">
                                                            <a href="#" data-uc-tooltip="{{ $featuredPost->author ?? 'Admin' }}">
                                                                <img src="{{ asset('front/assets/images/avatars/03.png') }}" 
                                                                    alt="{{ $featuredPost->author ?? 'Admin' }}" 
                                                                    class="w-24px h-24px rounded-circle">
                                                            </a>
                                                            <a href="#" class="text-black dark:text-white text-none fw-bold">{{ $featuredPost->author ?? 'Admin' }}</a>
                                                        </div>
                                                    </div>
                                                    <div>
                                                        <a href="#post_comment" class="post-comments text-none hstack gap-narrow">
                                                            <i class="fa-solid fa-comment-dots"></i>
                                                            <span>{{ $featuredPost->comments()->approved()->count() }}</span>
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
                        @endif
                    </div>
                </div>
                <div class="order-1 md:order-0">
                    <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                        @foreach($section->regularPosts as $post)
                            <div>
                                <article class="post type-post panel uc-transition-toggle">
                                    <div class="row child-cols g-2 lg:g-3" data-uc-grid>
                                        <div>
                                            <div class="post-header panel vstack justify-between gap-1">
                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                    <a class="text-none hover:text-primary duration-150" href="{{ route('front.blogdetails', [$post->slug, $post->id]) }}">{{ convertUtf8($post->title) }}</a>
                                                </h3>
                                                <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                    <span>{{ $post->created_at->diffForHumans() }}</span>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-auto">
                                            <div class="post-media panel overflow-hidden max-w-72px min-w-72px">
                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-1x1">
                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                        src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                        data-src="{{ asset('assets/front/img/blogs/' . $post->main_image) }}" 
                                                        alt="{{ convertUtf8($post->title) }}" 
                                                        data-uc-img="loading: lazy">
                                                </div>
                                                <a href="{{ route('front.blogdetails', [$post->slug, $post->id]) }}" class="position-cover"></a>
                                            </div>
                                        </div>
                                    </div>
                                </article>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif
