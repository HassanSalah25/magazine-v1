@extends("front.$version.layout")

@section('html_class')
    agntix-light
@endsection

@section('pagename')
    - {{convertUtf8($blog->meta_title)}}
@endsection

@section('meta-keywords', "$blog->meta_keywords")
@section('meta-description', "$blog->meta_description")

@section('styles')
<style>
.faq-section {
    border-top: 1px solid #e5e5e5;
    padding-top: 40px;
}

.faq-title {
    font-size: 28px;
    font-weight: 600;
    color: #333;
    margin-bottom: 30px;
}

.faq-item {
    border: 1px solid #e5e5e5;
    border-radius: 8px;
    overflow: hidden;
    margin-bottom: 15px;
    background: #fff;
}

.faq-question {
    background: #f8f9fa;
    padding: 20px;
    cursor: pointer;
    display: flex;
    justify-content: space-between;
    align-items: center;
    transition: all 0.3s ease;
    border-bottom: 1px solid #e5e5e5;
}

.faq-question:hover {
    background: #e9ecef;
}

.faq-question-text {
    font-size: 16px;
    font-weight: 500;
    color: #333;
    margin: 0;
    flex: 1;
    padding-right: 15px;
}

.faq-icon {
    transition: transform 0.3s ease;
    color: #666;
}

.faq-question[aria-expanded="true"] .faq-icon {
    transform: rotate(45deg);
}

.faq-answer {
    padding: 20px;
    background: #fff;
    color: #666;
    line-height: 1.6;
}

.faq-answer p {
    margin-bottom: 10px;
}

.faq-answer p:last-child {
    margin-bottom: 0;
}

@media (max-width: 768px) {
    .faq-title {
        font-size: 24px;
    }
    
    .faq-question {
        padding: 15px;
    }
    
    .faq-question-text {
        font-size: 14px;
    }
    
    .faq-answer {
        padding: 15px;
    }
}
</style>
@endsection

@section('content')
    <div class="breadcrumbs panel z-1 py-2 bg-gray-25 dark:bg-gray-100 dark:bg-opacity-5 dark:text-white">
        <div class="container max-w-xl">
            <ul class="breadcrumb nav-x justify-center gap-1 fs-7 sm:fs-6 m-0">
                <li><a href="{{ route('front.index') }}">{{ __('Home') }}</a></li>
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li><a href="{{ route('front.blogs') }}">{{ __('Blog') }}</a></li>
                <li><i class="fa-solid fa-angle-right"></i></li>
                <li><span class="opacity-50">{{ $blog->bcategory->name }}</span></li>
            </ul>
        </div>
    </div>

    <article class="post type-post single-post py-4 lg:py-6 xl:py-9">
        <div class="container max-w-xl">
            <div class="post-header">
                <div class="panel vstack gap-4 md:gap-6 xl:gap-8 text-center">
                    <div class="panel vstack items-center max-w-400px sm:max-w-500px xl:max-w-md mx-auto gap-2 md:gap-3">
                        <h1 class="h4 sm:h2 lg:h1 xl:display-6">{{ $blog->title }}</h1>
                        <ul class="post-share-icons nav-x gap-1 dark:text-white">
                            <li>
                                <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.blogdetails', $blog->slug)) }}" target="_blank" rel="noopener"><i class="unicon-logo-facebook icon-1"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://twitter.com/intent/tweet?url={{ urlencode(route('front.blogdetails', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener"><i class="unicon-logo-x-filled icon-1"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('front.blogdetails', $blog->slug)) }}" target="_blank" rel="noopener"><i class="unicon-logo-linkedin icon-1"></i></a>
                            </li>
                            <li>
                                <a class="btn btn-md p-0 border-gray-900 border-opacity-15 w-32px lg:w-48px h-32px lg:h-48px text-dark dark:text-white dark:border-white hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . route('front.blogdetails', $blog->slug)) }}" target="_blank" rel="noopener"><i class="unicon-email icon-1"></i></a>
                            </li>
                        </ul>
                    </div>
                    <figure class="featured-image m-0">
                        <figure class="featured-image m-0 ratio ratio-2x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ asset('assets/front/img/blogs/'.$blog->main_image) }}" alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}">
                        </figure>
                    </figure>
                </div>
            </div>
        </div>
        <div class="panel position-relative mt-4 lg:mt-6 xl:mt-9">
            <div class="container">
                <div class="content-wrap row child-col-12 lg:child-cols g-4 lg:g-6">
                    <div class="lg:col-8 uc-first-column">
                        <div class="max-w-lg">
                            <div class="post-content panel fs-6 md:fs-5" data-uc-lightbox="animation: scale">
                                {!! replaceBaseUrl(convertUtf8($blog->content)) !!}
                            </div>
                            <div class="post-footer panel vstack sm:hstack gap-3 justify-between justifybetween border-top py-4 mt-4 xl:py-9 xl:mt-9">
                                <ul class="nav-x gap-narrow text-primary">
                                    <li><span class="text-black dark:text-white me-narrow">{{ __('Tags:') }}</span></li>
                                    @foreach($blog->tags as $tag)
                                        <li>
                                            <a href="{{ route('front.tag', $tag->slug) }}" class="uc-link gap-0 dark:text-white">{{ $tag->title }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                                <ul class="post-share-icons nav-x gap-narrow">
                                    <li class="me-1"><span class="text-black dark:text-white">{{ __('Share:') }}</span></li>
                                    <li>
                                        <a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.blogdetails', $blog->slug)) }}" target="_blank" rel="noopener"><i class="unicon-logo-facebook icon-1"></i></a>
                                    </li>
                                    <li>
                                        <a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="https://twitter.com/intent/tweet?url={{ urlencode(route('front.blogdetails', $blog->slug)) }}&text={{ urlencode($blog->title) }}" target="_blank" rel="noopener"><i class="unicon-logo-x-filled icon-1"></i></a>
                                    </li>
                                    <li>
                                        <a class="btn btn-md btn-outline-gray-100 p-0 w-32px lg:w-40px h-32px lg:h-40px text-dark dark:text-white dark:border-gray-600 hover:bg-primary hover:border-primary hover:text-white rounded-circle" href="mailto:?subject={{ urlencode($blog->title) }}&body={{ urlencode(route('front.blogdetails', $blog->slug)) }}"><i class="unicon-email icon-1"></i></a>
                                    </li>
                                </ul>
                            </div>
                            
                            @php
                                $prevBlog = \App\Models\Blog::where('language_id', $blog->language_id)
                                    ->where('created_at', '<', $blog->created_at)
                                    ->orderBy('created_at', 'DESC')
                                    ->first();
                                
                                $nextBlog = \App\Models\Blog::where('language_id', $blog->language_id)
                                    ->where('created_at', '>', $blog->created_at)
                                    ->orderBy('created_at', 'ASC')
                                    ->first();
                            @endphp
                            
                            @if($prevBlog || $nextBlog)
                            <div class="post-navigation panel vstack sm:hstack justify-between gap-2 mt-8 xl:mt-9">
                                @if($prevBlog)
                                <div class="new-post panel hstack w-100 sm:w-1/2">
                                    <div class="panel hstack justify-center w-100px h-100px">
                                        <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ asset('assets/front/img/blogs/' . $prevBlog->main_image) }}" alt="{{ convertUtf8($prevBlog->title) }}" data-uc-img="loading: lazy">
                                            <a href="{{ route('front.blogdetails', $prevBlog->slug) }}" class="position-cover" data-caption="{{ convertUtf8($prevBlog->title) }}"></a>
                                        </figure>
                                    </div>
                                    <div class="panel vstack justify-center px-2 gap-1 w-1/3">
                                        <span class="fs-7 opacity-60">{{ __('Prev Article') }}</span>
                                        <h6 class="h6 lg:h5 m-0">{{ $prevBlog->title }}</h6>
                                    </div>
                                    <a href="{{ route('front.blogdetails', $prevBlog->slug) }}" class="position-cover"></a>
                                </div>
                                @endif
                                @if($nextBlog)
                                <div class="new-post panel hstack w-100 sm:w-1/2">
                                    <div class="panel vstack justify-center px-2 gap-1 w-1/3 text-end">
                                        <span class="fs-7 opacity-60">{{ __('Next Article') }}</span>
                                        <h6 class="h6 lg:h5 m-0">{{ $nextBlog->title }}</h6>
                                    </div>
                                    <div class="panel hstack justify-center w-100px h-100px">
                                        <figure class="featured-image m-0 ratio ratio-1x1 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                            <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ asset('assets/front/img/blogs/' . $nextBlog->main_image) }}" alt="{{ convertUtf8($nextBlog->title) }}" data-uc-img="loading: lazy">
                                            <a href="{{ route('front.blogdetails', $nextBlog->slug) }}" class="position-cover" data-caption="{{ convertUtf8($nextBlog->title) }}"></a>
                                        </figure>
                                    </div>
                                    <a href="{{ route('front.blogdetails', $nextBlog->slug) }}" class="position-cover"></a>
                                </div>
                                @endif
                            </div>
                            @endif
                            
                            @php
                                $relatedBlogs = \App\Models\Blog::where('language_id', $blog->language_id)
                                    ->where('bcategory_id', $blog->bcategory_id)
                                    ->where('id', '!=', $blog->id)
                                    ->orderBy('created_at', 'DESC')
                                    ->take(3)
                                    ->get();
                            @endphp
                            
                            @if($relatedBlogs->count() > 0)
                            <div class="post-related panel border-top pt-2 mt-8 xl:mt-9">
                                <h4 class="h5 xl:h4 mb-5 xl:mb-6">{{ __('Related to this topic:') }}</h4>
                                <div class="row child-cols-6 md:child-cols-4 gx-2 gy-4 sm:gx-3 sm:gy-6">
                                    @foreach($relatedBlogs as $relatedBlog)
                                    <div>
                                        <article class="post type-post panel vstack gap-2">
                                            <figure class="featured-image m-0 ratio ratio-4x3 rounded uc-transition-toggle overflow-hidden bg-gray-25 dark:bg-gray-800">
                                                <img class="media-cover image uc-transition-scale-up uc-transition-opaque" src="{{ asset('assets/front/img/blogs/' . $relatedBlog->main_image) }}" alt="{{ convertUtf8($relatedBlog->title) }}" data-uc-img="loading: lazy">
                                                <a href="{{ route('front.blogdetails', $relatedBlog->slug) }}" class="position-cover" data-caption="{{ convertUtf8($relatedBlog->title) }}"></a>
                                            </figure>
                                            <div class="post-header panel vstack gap-1">
                                                <h5 class="h6 md:h5 m-0">
                                                    <a class="text-none" href="{{ route('front.blogdetails', $relatedBlog->slug) }}">{{ convertUtf8($relatedBlog->title) }}</a>
                                                </h5>
                                                <div class="post-date hstack gap-narrow fs-7 opacity-60">
                                                    <span>{{ $relatedBlog->created_at->format('M d, Y') }}</span>
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                            
                            @php
                                $approvedComments = $blog->approvedComments()->whereNull('parent_id')->orderBy('created_at', 'ASC')->get();
                            @endphp
                            
                            <div id="blog-comment" class="panel border-top pt-2 mt-8 xl:mt-9">
                                <h4 class="h5 xl:h4 mb-5 xl:mb-6">{{ __('Comments') }} ({{ $blog->approvedComments()->count() }})</h4>

                                <div class="spacer-half"></div>

                                @if($approvedComments->count() > 0)
                                <ol>
                                    @foreach($approvedComments as $comment)
                                    <li>
                                        <div class="avatar">
                                            <img src="{{ asset('assets/front/img/avatars/avatar-' . (($loop->index % 5) + 1) . '.png') }}" alt="{{ convertUtf8($comment->commenter_name) }}" onerror="this.src='{{ asset('assets/front/img/default-avatar.png') }}'">
                                        </div>
                                        <div class="comment-info">
                                            <span class="c_name">{{ convertUtf8($comment->commenter_name) }}</span>
                                            <span class="c_date id-color">{{ $comment->created_at->diffForHumans() }}</span>
                                            <span class="c_reply"><a href="#comment-form-wrapper" data-reply-to="{{ $comment->id }}" class="reply-link">{{ __('Reply') }}</a></span>
                                            <div class="clearfix"></div>
                                        </div>
                                        <div class="comment">{{ convertUtf8($comment->comment) }}</div>
                                        
                                        @if($comment->replies()->approved()->count() > 0)
                                        <ol>
                                            @foreach($comment->replies()->approved()->orderBy('created_at', 'ASC')->get() as $reply)
                                            <li>
                                                <div class="avatar">
                                                    <img src="{{ asset('assets/front/img/avatars/avatar-' . (($loop->parent->index % 5) + 1) . '.png') }}" alt="{{ convertUtf8($reply->commenter_name) }}" onerror="this.src='{{ asset('assets/front/img/default-avatar.png') }}'">
                                                </div>
                                                <div class="comment-info">
                                                    <span class="c_name">{{ convertUtf8($reply->commenter_name) }}</span>
                                                    <span class="c_date id-color">{{ $reply->created_at->diffForHumans() }}</span>
                                                    <span class="c_reply"><a href="#comment-form-wrapper" data-reply-to="{{ $comment->id }}" class="reply-link">{{ __('Reply') }}</a></span>
                                                    <div class="clearfix"></div>
                                                </div>
                                                <div class="comment">{{ convertUtf8($reply->comment) }}</div>
                                            </li>
                                            @endforeach
                                        </ol>
                                        @endif
                                    </li>
                                    @endforeach
                                </ol>
                                @else
                                <p class="text-center opacity-60 py-4">{{ __('No comments yet. Be the first to comment!') }}</p>
                                @endif

                                <div class="spacer-single"></div>

                                <div id="comment-form-wrapper" class="panel pt-2 mt-8 xl:mt-9">
                                    <h4 class="h5 xl:h4 mb-5 xl:mb-6">{{ __('Leave a Comment') }}</h4>
                                    <div class="comment_form_holder">
                                        <form action="{{ route('front.blogcomment.store') }}" method="POST" class="vstack gap-2">
                                            @csrf
                                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                            <input type="hidden" name="parent_id" id="parent_id" value="">
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="text" name="name" placeholder="{{ __('First name') }}" required>
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="text" name="last_name" placeholder="{{ __('Last name') }}">
                                            <input class="form-control form-control-sm h-40px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" type="email" name="email" placeholder="{{ __('Your email') }}" required>
                                            <textarea class="form-control h-250px w-full fs-6 bg-white dark:bg-opacity-0 dark:text-white dark:border-gray-300 dark:border-opacity-30" name="comment" placeholder="{{ __('Your comment') }}" required></textarea>
                                            <button class="btn btn-primary btn-sm mt-1" type="submit">{{ __('Send') }}</button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            
                        </div>
                    </div>
                    @if ($blog->sidebar == 1)
                    <div class="lg:col-4">
                        <div class="sidebar-wrap panel vstack gap-2" data-uc-sticky="end: true;">
                            <div class="right-sidebar">
                                <div class="recent-widget widget">
                                    <h2 class="widget-title">{{ __('Recent Posts') }}</h2>
                                    <div class="recent-post-widget clearfix">
                                        @foreach($recentBlogs as $recentBlog)
                                            <div class="show-featured clearfix">
                                            <div class="post-img">
                                                    <a href="{{ route('front.blogdetails', $recentBlog->slug) }}">
                                                        <img width="1200" height="700" src="{{ asset('assets/front/img/blogs/' . $recentBlog->main_image) }}" alt="{{ convertUtf8($recentBlog->title) }}"
                                                            class="attachment-full size-full wp-post-image" decoding="async" data-uc-img="loading: lazy">
                                                        </a>
                                                </div>
                                                <div class="post-item">
                                                    <div class="post-desc">
                                                        <div class="rt-site-mega">
                                                            <span class="author-post">{{ $recentBlog->created_at->format('M d, Y') }}</span>
                                                        </div>
                                                        <a href="{{ route('front.blogdetails', $recentBlog->slug) }}">{{ $recentBlog->title }}</a>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                                <div class="recent-widget widget">
                                    <h2 class="widget-title">{{ __('Category') }}</h2>
                                    <ul>
                                        @foreach ($bcats as $bcat)
                                            <li><a href="{{route('front.blogs', ['category'=>$bcat->slug])}}">{{ convertUtf8($bcat->name) }} </a> <span>({{ $bcat->blogs->count() }})</span></li>
                                        @endforeach
                                    </ul>
                                </div>
                                
                                <section id="media_image-1" class="widget widget_media_image"><img width="600" height="700" src="https://reactheme.com/news5/news-magazine/wp-content/uploads/sites/26/2025/04/add__image.png" class="image wp-image-10098 attachment-full size-full" alt="" decoding="async" srcset="https://reactheme.com/news5/news-magazine/wp-content/uploads/sites/26/2025/04/add__image.png 600w, https://reactheme.com/news5/news-magazine/wp-content/uploads/sites/26/2025/04/add__image-257x300.png 257w" sizes="(max-width: 600px) 100vw, 600px"></section>
                                
                                <div class="recent-widget widget newsletter">
                                    <h4 class="widget-title">{{ __('Subscribe To Our Newsletter') }}</h4>
                                    <p>{{ __('No spam, notifications only about new products, updates.') }}</p>
                                    <form action="#" class="newsletter-form">
                                        <input type="email" placeholder="{{ __('Your Email') }}">
                                        <button class="btn btn-primary btn-sm mt-1" type="submit">{{ __('Sign Up') }}</button>
                                    </form>
                                </div>
                                    
                            </div>
                        </div>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </article>
@endsection

@section('scripts')
    @if($bs->is_disqus == 1)
        {!! $bs->disqus_script !!}
    @endif
    
    <script>
        $(document).ready(function() {
            // FAQ Accordion functionality
            $('.faq-question').on('click', function() {
                var target = $(this).data('bs-target');
                var isExpanded = $(this).attr('aria-expanded') === 'true';
                
                // Close all other FAQ items
                $('.faq-question').attr('aria-expanded', 'false');
                $('.collapse').removeClass('show');
                
                // Toggle current FAQ item
                if (!isExpanded) {
                    $(this).attr('aria-expanded', 'true');
                    $(target).addClass('show');
                }
            });
            
            // Comment reply functionality
            $('.reply-link').on('click', function(e) {
                e.preventDefault();
                var parentId = $(this).data('reply-to');
                $('#parent_id').val(parentId);
                
                // Scroll to comment form
                $('html, body').animate({
                    scrollTop: $('#comment-form-wrapper').offset().top - 100
                }, 500);
                
                // Focus on textarea
                setTimeout(function() {
                    $('textarea[name="comment"]').focus();
                }, 600);
            });
        });
    </script>
@endsection
