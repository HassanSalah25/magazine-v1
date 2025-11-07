@extends("front.$version.layout")

@section('html_class')
    agntix-light
@endsection

@section('pagename')
    -
    @if (empty($category))
        {{__('All')}}
    @else
        {{convertUtf8($category->name)}}
    @endif
    {{__('Blogs')}}
@endsection

@section('meta-keywords', "$be->blogs_meta_keywords")
@section('meta-description', "$be->blogs_meta_description")

@section('content')
    <!-- Wrapper start -->
    <div id="wrapper" class="wrap overflow-hidden-x">
        <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
            <div class="container max-w-xl">
                <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                    <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><a href="{{ route('front.blogs') }}">{{ __('Blog') }}</a></li>
                    <li><i class="unicon-chevron-right opacity-50"></i></li>
                    <li><span class="opacity-50">
                        @if (empty($category))
                            {{__('All')}}
                        @else
                            {{convertUtf8($category->name)}}
                        @endif
                        {{__('Blogs')}}
                    </span></li>
                </ul>
            </div>
        </div>

        <div class="section py-3 sm:py-6 lg:py-9">
            <div class="container max-w-xl">
                <div class="panel vstack gap-3 sm:gap-6 lg:gap-9">
                    <header class="page-header vstack justify-center items-center text-center max-w-500px mx-auto">
                        <h1 class="h4 lg:h1">
                            @if (empty($category))
                                {{__('All')}}
                            @else
                                {{convertUtf8($category->name)}}
                            @endif
                            {{__('Blogs')}}
                        </h1>
                        <p class="fs-6 lg:fs-5 opacity-60">{{ convertUtf8($bs->blog_subtitle) }}</p>
                    </header>
                    
                    <div class="row g-4 xl:g-8">
                        <div class="col">
                            <div class="panel text-center">
                                @if($blogs->count() > 0)
                                    <div class="row child-cols-12 sm:child-cols-6 lg:child-cols-4 xl:child-cols-3 col-match gy-4 xl:gy-6 gx-2 sm:gx-4">
                                        @foreach ($blogs as $blog)
                                            <div>
                                                <article class="post type-post panel vstack gap-2">
                                                    <div class="post-image panel overflow-hidden">
                                                        <figure class="featured-image m-0 ratio ratio-16x9 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                                 src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                                 alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}">
                                                            <a href="{{ route('front.blogdetails', $blog->slug) }}" class="position-cover" data-caption="{{ convertUtf8($blog->title) }}"></a>
                                                        </figure>
                                                        @php $category = $bcats->firstWhere('id', $blog->bcategory_id); @endphp
                                                        @if($category)
                                                            <div class="post-category hstack gap-narrow position-absolute top-0 start-0 m-1 fs-7 fw-bold h-24px px-1 rounded-1 shadow-xs bg-white text-primary">
                                                                <a class="text-none" href="{{ route('front.blogs', $category->slug) }}">{{ $category->name }}</a>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="post-header panel vstack gap-1 lg:gap-2">
                                                        <h3 class="post-title h6 sm:h5 m-0 text-truncate-2 m-0">
                                                            <a class="text-none" href="{{ route('front.blogdetails', $blog->slug) }}">{{ convertUtf8($blog->title) }}</a>
                                                        </h3>
                                                        <div>
                                                            <div class="post-meta panel hstack justify-center fs-7 fw-medium text-gray-900 dark:text-white text-opacity-60 d-none md:d-flex">
                                                                <div class="meta">
                                                                    <div class="hstack gap-2">
                                                                        <div>
                                                                            <div class="post-date hstack gap-narrow">
                                                                                <span>{{ $blog->created_at->format('M d, Y') }}</span>
                                                                            </div>
                                                                        </div>
                                                                        <div>·</div>
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
                                        @endforeach
                                    </div>
                                    
                                    <!-- Pagination -->
                                    <div class="nav-pagination pt-3 mt-6 lg:mt-9 border-top border-gray-100 dark:border-gray-800">
                                        {{ $blogs->appends(request()->query())->links('vendor.pagination.custom') }}
                                    </div>
                                @else
                                    <div class="bg-dark py-5">
                                        <h3 class="text-center">{{ __('NO BLOG FOUND') }}</h3>
                                    </div>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Wrapper end -->
@endsection
