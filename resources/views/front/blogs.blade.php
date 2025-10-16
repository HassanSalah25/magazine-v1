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

    <!-- breadcurmb area start -->
    <div class="tp-breadcrumb-area tp-breadcrumb-ptb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="tp-breadcrumb-content text-center">
                        <h3 class="tp-breadcrumb-title">{{ convertUtf8($bs->blog_subtitle) }}</h3>
                        <div class="tp-breadcrumb-list mb-35">
                            <span><a href="{{ route('front.index') }}">{{ __('Home') }}</a></span>
                            <span class="dvdr"><i>|</i></span>
                            <span>{{ convertUtf8($bs->blog_title) }}</span>
                        </div>
                        <div class="tp-breadcrumb-scrolldown smooth">
                            <a href="#postbox">
                                <span>
                                    <svg width="16" height="9" viewBox="0 0 16 9" fill="none"
                                         xmlns="http://www.w3.org/2000/svg">
                                        <path d="M1 1L8 8L15 1" stroke="black" stroke-width="2" stroke-linecap="round"
                                              stroke-linejoin="round"/>
                                    </svg>
                                </span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- breadcurmb area end -->

    <!-- postbox area start -->
    <section id="postbox" class="postbox-area pt-110 pb-80">
        <div class="container container-1330">
            <div class="row">
                <div class="col-xxl-8 col-xl-8 col-lg-8">
                    @forelse ($blogs as $blog)
                        <div class="postbox-wrapper">
                            @foreach ($blogs as $blog)
                                <article class="postbox-item mb-30">
                                    <div
                                        class="postbox-author-wrap d-flex align-items-center justify-content-between mb-30">
                                        <div class="postbox-meta">
                                            <i>
                                                <svg width="18" height="18" viewBox="0 0 18 18" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path
                                                        d="M9 4.19997V8.99997L12.2 10.6M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z"
                                                        stroke="black" stroke-opacity="0.6" stroke-width="2"
                                                        stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </i>
                                            <span>{{ $blog->created_at->format('d/m/Y h:i A') }}</span>
                                        </div>
                                    </div>
                                    <div class="postbox-thumb mb-35">
                                        <a href="{{ route('front.blogdetails', $blog->slug) }}">
                                            <img class="w-100"
                                                 src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}"
                                                 alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}">
                                        </a>
                                    </div>
                                    <div class="postbox-content">
                                        @php $category = $bcats->firstWhere('id', $blog->bcategory_id); @endphp
                                        <span class="postbox-tag">
                                    <i>
                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                             xmlns="http://www.w3.org/2000/svg">
                                            <path
                                                d="M4.39101 4.39135H4.39936M13.6089 8.73899L8.74578 13.6021C8.61979 13.7283 8.47018 13.8283 8.3055 13.8966C8.14082 13.9649 7.9643 14 7.78603 14C7.60777 14 7.43124 13.9649 7.26656 13.8966C7.10188 13.8283 6.95228 13.7283 6.82629 13.6021L1 7.78264V1H7.78264L13.6089 6.82629C13.8616 7.08045 14.0034 7.42427 14.0034 7.78264C14.0034 8.14102 13.8616 8.48483 13.6089 8.73899Z"
                                                stroke="black" stroke-opacity="0.6" stroke-width="2"
                                                stroke-linecap="round" stroke-linejoin="round"/>
                                        </svg>
                                    </i>
                                    {{$category->name}}
                                </span>
                                        <h3 class="postbox-title"><a
                                                href="{{ route('front.blogdetails', $blog->slug) }}">
                                                {{ $blog->title }}</a></h3>
                                        <p>
                                            {!! Str::limit(strip_tags($blog->content), 160) !!}
                                        </p>
                                        <a class="tp-btn-yellow-border postbox-btn"
                                           href="{{ route('front.blogdetails', $blog->slug) }}">
                                            <span>
                                                <span class="text-1">{{ __('Read More') }}</span>
                                                <span class="text-2">{{ __('Read More') }}</span>
                                            </span>
                                            <i>
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 11L11 1M11 1V11M11 1H1" stroke="#000"
                                                          stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                                <svg width="12" height="12" viewBox="0 0 12 12" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 11L11 1M11 1V11M11 1H1" stroke="#000"
                                                          stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
                                                </svg>
                                            </i>
                                        </a>
                                    </div>
                                </article>
                            @endforeach
                            {{ $blogs->appends(request()->query())->links('vendor.pagination.custom') }}
                        </div>
                    @empty
                        <div class="bg-dark py-5">
                            <h3 class="text-center">{{ __('NO BLOG FOUND') }}</h3>
                        </div>
                    @endforelse
                </div>
                <div class="col-xxl-4 col-xl-4 col-lg-4">
                    <div class="sidebar-wrapper">
                        <div class="sidebar-widget mb-30">
                            <div class="sidebar-search">
                                <form action="{{ route('front.blogs') }}" method="GET">
                                    <div class="sidebar-search-input">
                                        <input type="text" name="term"
                                               placeholder="{{ __('Enter Keyword') }}" value="{{ request('term') }}">
                                        <button type="submit">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none"
                                                 xmlns="http://www.w3.org/2000/svg">
                                                <path
                                                    d="M18.9999 19L14.6499 14.65M17 9C17 13.4183 13.4183 17 9 17C4.58172 17 1 13.4183 1 9C1 4.58172 4.58172 1 9 1C13.4183 1 17 4.58172 17 9Z"
                                                    stroke="currentcolor" stroke-opacity="0.8" stroke-width="2"
                                                    stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </button>
                                    </div>
                                </form>
                            </div>
                        </div>
                        <div class="sidebar-widget mb-55">
                            <h3 class="sidebar-widget-title">{{ __('Category') }}</h3>
                            <div class="sidebar-widget-category">
                                <ul>
                                    @foreach($bcats as $bcat)
                                        <li>
                                            <a class="d-flex align-items-center justify-content-between"
                                               href="{{ route('front.blogs', $bcat->slug) }}">
                                                {{ $bcat->name }}
                                                <span>{{ $bcat->blogs->count() }}</span>
                                            </a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                        <div class="sidebar-widget mb-55">
                            <h3 class="sidebar-widget-title">{{ __('Latest Posts') }}</h3>
                            <div class="rc-post-wrap">
                                @foreach($recentBlogs as $recentBlog)
                                <div class="rc-post d-flex align-items-center">
                                    <div class="rc-post-thumb">
                                        <a href="{{ route('front.blogdetails', $recentBlog->slug) }}">
                                            <img width="80" src="{{ asset('assets/front/img/blogs/' . $recentBlog->main_image) }}" alt="{{ $recentBlog->alt_image ? convertUtf8($recentBlog->alt_image) : convertUtf8($recentBlog->title) }}">
                                        </a>
                                    </div>
                                    <div class="rc-post-content">
                                        @php $category = $bcats->firstWhere('id', $recentBlog->bcategory_id); @endphp
                                        <div class="rc-post-category">
                                            <a href="#">{{ $category ? convertUtf8($category->name) : __('Uncategorized') }}</a>
                                        </div>
                                        <h3 class="rc-post-title">
                                            <a href="{{ route('front.blogdetails', $recentBlog->slug) }}">{{ $recentBlog->title }}</a>
                                        </h3>
                                        <div class="rc-post-meta">
                                            <span>{{ $recentBlog->created_at->format('d/m/Y h:i A') }}</span>
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        <div class="sidebar-widget">
                            <h3 class="sidebar-widget-title">{{ __('Tags') }}</h3>
                            <div class="sidebar-widget-content">
                                <div class="tagcloud">
                                    @foreach($popularTags as $tag)
                                        <a href="{{ route('front.tag', $tag->slug) }}">{{ $tag->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- postbox area end -->
@endsection
