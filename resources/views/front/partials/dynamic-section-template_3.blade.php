@if($section->posts()->count() > 0)
<div class="lg:col-4">
    <div class="block-layout list-layout vstack gap-2 lg:gap-3 panel overflow-hidden">
        <div class="block-header panel pt-1 border-top">
            <h2 class="h6 ft-tertiary fw-bold ls-0 text-uppercase m-0 text-black dark:text-white">
                <a class="hstack d-inline-flex gap-0 text-none hover:text-primary duration-150" href="{{ route('front.blogs') }}">
                    <span>{{ $section->name }}</span>
                    <i class="fa-solid fa-chevron-right"></i>
                </a>
            </h2>
        </div>
        <div class="block-content">
            <div class="row child-cols-12 g-2 lg:g-4 sep-x" data-uc-grid>
                @if($section->featuredPost())
                    @php $featuredPost = $section->featuredPost(); @endphp
                    <div>
                        <article class="post type-post panel uc-transition-toggle vstack gap-2 lg:gap-3 overflow-hidden uc-dark">
                            <div class="post-media panel overflow-hidden">
                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-4x3">
                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                         src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                         data-src="{{ asset('assets/front/img/blogs/' . $featuredPost->main_image) }}" 
                                         alt="{{ convertUtf8($featuredPost->title) }}" 
                                         data-uc-img="loading: lazy">
                                </div>
                            </div>
                            <div class="position-cover bg-gradient-to-t from-black to-transparent opacity-90"></div>
                            <div class="post-header panel vstack justify-start items-start flex-column-reverse gap-1 p-2 position-cover text-white">
                                <div class="post-meta panel hstack justify-between fs-7 text-white text-opacity-60 mt-1">
                                    <div class="meta">
                                        <div class="hstack gap-2">
                                            <div>
                                                <div class="post-author hstack gap-1">
                                                    <a href="#" data-uc-tooltip="{{ $featuredPost->author ?? 'Admin' }}">
                                                        <img src="{{ asset('front/assets/images/avatars/01.png') }}" 
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
                                <h3 class="post-title h6 lg:h5 m-0 m-0 max-w-600px text-white text-truncate-2">
                                    <a class="text-none text-white" href="{{ route('front.blogdetails', [$featuredPost->slug, $featuredPost->id]) }}">{{ convertUtf8($featuredPost->title) }}</a>
                                </h3>
                                <div class="post-date hstack gap-narrow fs-7 text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                    <span>{{ $featuredPost->created_at->diffForHumans() }}</span>
                                </div>
                            </div>
                            <a href="{{ route('front.blogdetails', [$featuredPost->slug, $featuredPost->id]) }}" class="position-cover"></a>
                        </article>
                    </div>
                @endif
                
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
@endif
