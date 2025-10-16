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
    <!-- breadcurmb area start -->
    <div class="tp-breadcrumb-area tp-breadcrumb-ptb">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-xxl-12">
                    <div class="tp-breadcrumb-content text-center">
                        <h3 class="tp-breadcrumb-title">{{ strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30, 'utf-8') . '...' : $blog->title }}</h3>
                        <div class="tp-breadcrumb-list mb-35">
                            <span><a href="{{ route('front.index') }}">{{ __('Home') }}</a></span>
                            <span class="dvdr"><i>|</i></span>
                            <span>{{ $blog->bcategory->name }}</span>
                            <span class="dvdr"><i>|</i></span>
                            <span>{{ strlen($blog->title) > 30 ? mb_substr($blog->title, 0, 30, 'utf-8') . '...' : $blog->title }}</span>
                        </div>
                        <div class="tp-breadcrumb-scrolldown smooth">
                            <a href="#postbox">
                                            <span>
                                                <svg width="16" height="9" viewBox="0 0 16 9" fill="none"
                                                     xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1L8 8L15 1" stroke="black" stroke-width="2"
                                                          stroke-linecap="round" stroke-linejoin="round"/>
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
                <div class="{{$blog->sidebar == 1 ? 'col-xxl-8 col-xl-8 col-lg-8' : 'col-xxl-12 col-xl-12 col-lg-12'}}">
                    <div class="postbox-wrapper mb-115">
                        <article class="postbox-details-item item-border mb-20">
                            <div class="postbox-details-info-wrap">
                                <div class="postbox-tag postbox-details-tag">
                                                <span>
                                                    <i>
                                                        <svg width="15" height="15" viewBox="0 0 15 15" fill="none"
                                                             xmlns="http://www.w3.org/2000/svg">
                                                            <path
                                                                d="M4.39101 4.39135H4.39936M13.6089 8.73899L8.74578 13.6021C8.61979 13.7283 8.47018 13.8283 8.3055 13.8966C8.14082 13.9649 7.9643 14 7.78603 14C7.60777 14 7.43124 13.9649 7.26656 13.8966C7.10188 13.8283 6.95228 13.7283 6.82629 13.6021L1 7.78264V1H7.78264L13.6089 6.82629C13.8616 7.08045 14.0034 7.42427 14.0034 7.78264C14.0034 8.14102 13.8616 8.48483 13.6089 8.73899Z"
                                                                stroke="black" stroke-opacity="0.6" stroke-width="2"
                                                                stroke-linecap="round" stroke-linejoin="round"/>
                                                        </svg>
                                                    </i>
                                                    {{ $blog->bcategory->name }}
                                                </span>
                                    <span>{{ $blog->created_at->format('d/m/Y h:i A') }}</span>
                                </div>
                                <h4 class="postbox-title fs-54">{{ $blog->title }}</h4>
                                <div class="postbox-details-meta d-flex align-items-center">
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
                                        <span>{{date('F d, Y', strtotime($blog->created_at))}}</span>
                                    </div>
                                </div>
                            </div>
                        </article>
                        <div class="postbox-details-thumb mb-45">
                            <img class="w-100" src="{{asset('assets/front/img/blogs/'.$blog->main_image)}}"
                                 alt="{{ $blog->alt_image ? convertUtf8($blog->alt_image) : convertUtf8($blog->title) }}">
                        </div>
                        {!! replaceBaseUrl(convertUtf8($blog->content)) !!}
                        
                        @if(count($faqs) > 0)
                        <!-- FAQ Section -->
                        <div class="faq-section mt-60 mb-60">
                            <h3 class="faq-title mb-40">{{ __('Frequently Asked Questions') }}</h3>
                            <div class="faq-accordion">
                                @foreach($faqs as $index => $faq)
                                <div class="faq-item mb-20">
                                    <div class="faq-question" data-bs-toggle="collapse" data-bs-target="#faq{{$faq->id}}" aria-expanded="false" aria-controls="faq{{$faq->id}}">
                                        <h4 class="faq-question-text">{{ convertUtf8($faq->question) }}</h4>
                                        <span class="faq-icon">
                                            <svg width="20" height="20" viewBox="0 0 20 20" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path d="M10 4.16667V15.8333M4.16667 10H15.8333" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"/>
                                            </svg>
                                        </span>
                                    </div>
                                    <div class="collapse" id="faq{{$faq->id}}">
                                        <div class="faq-answer">
                                            {!! convertUtf8($faq->answer) !!}
                                        </div>
                                    </div>
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                        
                        <div class="postbox-details-tag-wrap d-flex justify-content-between align-items-center">
                            <div class="postbox-details-tag d-flex align-items-center mb-0">
                                <span>{{ __('Tagged with :') }}</span>
                                <div class="tagcloud">
                                    @php $tags = $blog->tags; @endphp
                                    @foreach($tags as $tag)
                                        <a href="{{ route('front.tag',  $tag->slug) }}">{{ $tag->title }}</a>
                                    @endforeach
                                </div>
                            </div>
                            <div class="postbox-details-social">
                                {{-- Facebook --}}
                                <a href="https://www.facebook.com/sharer/sharer.php?u={{ urlencode(route('front.blogdetails', $blog->slug)) }}"
                                   target="_blank" rel="noopener">
                                                <span>
                                                    <svg width="18" height="17" viewBox="0 0 11 15" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M1.77219 6.41667C1.13333 6.41667 1 6.54137 1 7.13889V8.22222C1 8.81974 1.13333 8.94444 1.77219 8.94444H3.31657V13.2778C3.31657 13.8753 3.4499 14 4.08876 14H5.63314C6.272 14 6.40533 13.8753 6.40533 13.2778V8.94444H8.13944C8.62396 8.94444 8.74881 8.85636 8.88192 8.42063L9.21286 7.3373C9.44088 6.59088 9.30037 6.41667 8.47038 6.41667H6.40533V4.61111C6.40533 4.21224 6.75106 3.88889 7.17752 3.88889H9.3753C10.0142 3.88889 10.1475 3.76419 10.1475 3.16667V1.72222C10.1475 1.1247 10.0142 1 9.3753 1H7.17752C5.04518 1 3.31657 2.61675 3.31657 4.61111V6.41667H1.77219Z"
                                                              stroke="currentcolor" stroke-width="1.5"
                                                              stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                </a>
                                {{-- Twitter (X) --}}
                                <a href="https://twitter.com/intent/tweet?url={{ urlencode(route('front.blogdetails', $blog->slug)) }}&text={{ urlencode($blog->title) }}"
                                   target="_blank" rel="noopener">
                                        <span>
                                                    <svg width="18" height="17" viewBox="0 0 18 17" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path fill-rule="evenodd" clip-rule="evenodd"
                                                              d="M5.67227 0H0L6.72535 8.79151L0.430223 16.1665H3.33876L8.09997 10.5886L12.3277 16.1153H18L11.0793 7.06826L11.0915 7.08386L17.0504 0.102701H14.1418L9.71667 5.28701L5.67227 0ZM3.131 1.53968H4.89685L14.869 14.5755H13.1032L3.131 1.53968Z"
                                                              fill="currentcolor"/>
                                                    </svg>
                                                </span>
                                </a>
                                {{-- LinkedIn --}}
                                <a href="https://www.linkedin.com/sharing/share-offsite/?url={{ urlencode(route('front.blogdetails', $blog->slug)) }}"
                                   target="_blank" rel="noopener">
                                                <span>
                                                    <svg width="19" height="19" viewBox="0 0 19 19" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M17.9994 10.5256C17.2116 10.3786 16.4014 10.302 15.5746 10.302C11.025 10.302 6.97863 12.6212 4.39943 16.2214M15.45 3.53634C12.79 6.63763 8.79271 8.61014 4.32318 8.61014C3.17971 8.61014 2.06716 8.48103 1 8.23695M11.7254 17.9135C11.9384 16.8869 12.0503 15.8237 12.0503 14.7345C12.0503 9.39347 9.35944 4.67635 5.25026 1.84649M18 9.45632C18 14.1266 14.1944 17.9126 9.5 17.9126C4.80558 17.9126 1 14.1266 1 9.45632C1 4.78603 4.80558 1 9.5 1C14.1944 1 18 4.78603 18 9.45632Z"
                                                            stroke="currentcolor" stroke-width="1.5"
                                                            stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                </a>
                                {{-- WhatsApp --}}
                                <a href="https://api.whatsapp.com/send?text={{ urlencode($blog->title . ' ' . route('front.blogdetails', $blog->slug)) }}"
                                   target="_blank" rel="noopener">
                                                <span>
                                                    <svg width="20" height="19" viewBox="0 0 20 19" fill="none"
                                                         xmlns="http://www.w3.org/2000/svg">
                                                        <path
                                                            d="M14.2426 4.82562H14.2496M5.27195 1H13.8159C16.1752 1 18.0878 2.90279 18.0878 5.25V13.75C18.0878 16.0972 16.1752 18 13.8159 18H5.27195C2.91262 18 1 16.0972 1 13.75V5.25C1 2.90279 2.91262 1 5.27195 1ZM12.9615 8.96482C13.0669 9.67223 12.9455 10.3947 12.6144 11.0295C12.2833 11.6643 11.7595 12.179 11.1174 12.5005C10.4753 12.8221 9.74767 12.934 9.03796 12.8204C8.32825 12.7067 7.67263 12.3734 7.16433 11.8677C6.65603 11.362 6.32096 10.7098 6.20675 10.0037C6.09255 9.29764 6.20504 8.57373 6.52823 7.93494C6.85141 7.29615 7.36883 6.775 8.00688 6.44563C8.64494 6.11625 9.37115 5.99542 10.0822 6.10032C10.8075 6.20732 11.479 6.54356 11.9975 7.05938C12.516 7.5752 12.854 8.24324 12.9615 8.96482Z"
                                                            stroke="currentcolor" stroke-width="2"
                                                            stroke-linecap="round" stroke-linejoin="round"/>
                                                    </svg>
                                                </span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                @if ($blog->sidebar == 1)
                    <div class="col-xxl-4 col-xl-4 col-lg-4">
                        <div class="sidebar-wrapper">
                            <div class="sidebar-widget mb-45">
                                <div class="sidebar-search">
                                    <form action="{{route('front.blogs', ['category' => request()->input('category'), 'month' => request()->input('month'), 'year' => request()->input('year')])}}"
                                          method="GET">
                                        <div class="sidebar-search-input">
                                            <input name="category" type="hidden"
                                                   value="{{request()->input('category')}}">
                                            <input name="month" type="hidden" value="{{request()->input('month')}}">
                                            <input name="year" type="hidden" value="{{request()->input('year')}}">
                                            <input name="term" type="text" placeholder="{{__('Search Blogs')}}"
                                                   value="{{request()->input('term')}}">
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
                            <div class="sidebar-widget mb-45">
                                <h3 class="sidebar-widget-title">{{ __('Category') }}</h3>
                                <div class="sidebar-widget-category">
                                    <ul>
                                        @foreach ($bcats as $key => $bcat)
                                            <li >
                                                <a  class="d-flex align-items-center justify-content-between" href="{{route('front.blogs', ['term'=>request()->input('term'), 'category'=>$bcat->slug, 'month' => request()->input('month'), 'year' => request()->input('year')])}}">{{convertUtf8($bcat->name)}}</a>
                                            </li>
                                        @endforeach
                                    </ul>
                                </div>
                            </div>
                            <div class="sidebar-widget mb-45">
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
                                        @foreach($blog->tags as $tag)
                                            <a href="{{ route('front.tag', $tag->slug) }}">{{ $tag->title }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
        </div>
    </section>
    <!-- postbox area end -->


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
        });
    </script>
@endsection
