<!-- Blogs section start -->
<div class="section panel py-4 lg:py-8 bg-white dark:bg-gray-900">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel">
                    <div class="row align-items-end g-3">
                        <div class="col-lg-8">
                            <h2 class="h3 lg:h2 mb-0">
                                {{ convertUtf8($bs->blog_section_title) }} 
                                <br>
                                <span class="text-primary">{{ convertUtf8($bs->blog_section_subtitle) }}</span>
                            </h2>
                        </div>
                        <div class="col-lg-4 text-lg-end">
                            <a class="btn btn-primary" href="{{ route('front.blogs') }}">
                                {{ __('Read all posts') }}
                                <i class="fa-solid fa-arrow-right ms-2"></i>
                            </a>
                        </div>
                    </div>
                </div>
                
                <div class="block-content panel">
                    <div class="vstack gap-4">
                        @foreach ($blogs->take(2) as $blog)
                            @php
                                $blogDate = \Carbon\Carbon::parse($blog->created_at)->locale($currentLang->code)->translatedFormat('F j, Y');
                            @endphp
                            <div class="card panel bg-gray-25 dark:bg-gray-800 rounded p-4 lg:p-6">
                                <div class="row align-items-center g-4">
                                    <div class="col-lg-8">
                                        <div class="blog-content d-flex gap-4">
                                            <div class="blog-meta">
                                                <div class="author-info mb-3">
                                                    <h5 class="h6 mb-1">{{ convertUtf8($blog->author ?? 'Admin') }}</h5>
                                                    <span class="fs-6 text-gray-500 dark:text-gray-400">{{ $blogDate }}</span>
                                                </div>
                                                <div class="blog-category">
                                                    <span class="badge badge-primary">{{ $blog->category->name ?? 'Blog' }}</span>
                                                </div>
                                            </div>
                                            <div class="blog-title">
                                                <h4 class="h5 mb-0">
                                                    <a class="text-dark dark:text-white text-decoration-none hover:text-primary duration-150" 
                                                       href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                        {{ strlen($blog->title) > 60 ? mb_substr($blog->title, 0, 60, 'utf-8') . '...' : $blog->title }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-lg-4">
                                        <div class="blog-thumb">
                                            <a href="{{ route('front.blogdetails', [$blog->slug, $blog->id]) }}">
                                                <div class="featured-image ratio ratio-16x9 rounded overflow-hidden">
                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                         src="{{ asset('assets/front/img/blogs/' . $blog->main_image) }}" 
                                                         alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}" 
                                                         data-uc-img="loading: lazy">
                                                </div>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Blogs section end -->
