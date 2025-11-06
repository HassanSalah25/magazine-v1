@php
    $catAvailable = true;
    $megaMenus = [];
    $cats = collect();

    switch ($link['type']) {
        case 'services-megamenu':
            $data = $currentLang->megamenus()->where('type', 'services')->where('category', serviceCategory() ? 1 : 0);
            $itemModel = '\\App\\Models\\Service';
            $allUrl = 'front.services';
            if (serviceCategory()) {
                $cats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
                $catModel = '\\App\\Models\\Scategory';
            } else {
                $catAvailable = false;
            }
            $singleRoute = 'front.servicedetails';
            break;

        case 'products-megamenu':
            $data = $currentLang->megamenus()->where('type', 'products')->where('category', 1);
            $cats = $currentLang->pcategories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\Pcategory';
            $itemModel = '\\App\\Models\\Product';
            $allUrl = 'front.product';
            $singleRoute = 'front.product.details';
            break;

        case 'portfolios-megamenu':
            $data = $currentLang->megamenus()->where('type', 'portfolios')->where('category', serviceCategory() ? 1 : 0);
            $itemModel = '\\App\\Models\\Portfolio';
            $allUrl = 'front.portfolios';
            if (serviceCategory()) {
                $cats = $currentLang->scategories()->where('status', 1)->get();
                $catModel = '\\App\\Models\\Scategory';
            } else {
                $catAvailable = false;
            }
            $singleRoute = 'front.portfoliodetails';
            break;

        case 'courses-megamenu':
            $data = $currentLang->megamenus()->where('type', 'courses')->where('category', 1);
            $cats = $currentLang->course_categories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\CourseCategory';
            $itemModel = '\\App\\Models\\Course';
            $allUrl = 'courses';
            $singleRoute = 'front.course_details';
            break;

        case 'causes-megamenu':
            $data = $currentLang->megamenus()->where('type', 'causes')->where('category', 0);
            $itemModel = '\\App\\Models\\Donation';
            $catAvailable = false;
            $allUrl = 'front.causes';
            $singleRoute = 'front.cause_details';
            break;

        case 'events-megamenu':
            $data = $currentLang->megamenus()->where('type', 'events')->where('category', 1);
            $cats = $currentLang->event_categories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\EventCategory';
            $itemModel = '\\App\\Models\\Event';
            $allUrl = 'front.events';
            $singleRoute = 'front.event_details';
            break;

        case 'blogs-megamenu':
            $data = $currentLang->megamenus()->where('type', 'blogs')->where('category', 1);
            $cats = $currentLang->bcategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
            $catModel = '\\App\\Models\\Bcategory';
            $itemModel = '\\App\\Models\\Blog';
            $allUrl = 'front.blogs';
            $singleRoute = 'front.blogdetails';
            break;

        default:
            // Check if it's a blog category mega menu (blog-category-{id}-megamenu)
            if (strpos($link['type'], 'blog-category-') === 0 && strpos($link['type'], '-megamenu') !== false) {
                // Extract category ID from type
                $categoryId = str_replace(['blog-category-', '-megamenu'], '', $link['type']);
                $category = $currentLang->bcategories()->where('id', $categoryId)->where('status', 1)->first();
                
                if ($category) {
                    // Get mega menu data for this specific category
                    $data = $currentLang->megamenus()->where('type', 'blogs')->where('category', 1);
                    $cats = collect([$category]); // Only show this category
                    $catModel = '\\App\\Models\\Bcategory';
                    $itemModel = '\\App\\Models\\Blog';
                    $allUrl = 'front.blogs';
                    $categorySlug = $category->slug; // Store category slug for the main link
                    $singleRoute = 'front.blogdetails';
                    $catAvailable = true;
                } else {
                    $data = collect();
                    $catAvailable = false;
                }
            } else {
                $data = collect();
                $catAvailable = false;
            }
            break;
    }

    if ($data->count() > 0) {
        $megaMenus = json_decode($data->first()->menus, true);
    }
@endphp

<li>
    @php
        // For blog category mega menus, use the category slug in the URL
        if (strpos($link['type'], 'blog-category-') === 0 && strpos($link['type'], '-megamenu') !== false && isset($categorySlug)) {
            $mainUrl = route($allUrl, $categorySlug);
        } else {
            $mainUrl = route($allUrl);
        }
    @endphp
    <a href="{{ $mainUrl }}" target="{{ $link['target'] }}">{{ $link['text'] }} <span data-uc-navbar-parent-icon></span></a>
    <div class="uc-navbar-dropdown ft-primary text-unset p-3 pb-4 rounded-0 hide-scrollbar" data-uc-drop=" offset: 0; boundary: !.navbar-container; stretch: x; animation: uc-animation-slide-top-small; duration: 150;">
        <div class="row child-cols col-match g-2">
            @if(($link['type'] == 'blogs-megamenu' || (strpos($link['type'], 'blog-category-') === 0 && strpos($link['type'], '-megamenu') !== false)) && $catAvailable && count($megaMenus) > 0)
                {{-- Blog Mega Menu with Grid Layout --}}
                @foreach ($megaMenus as $mCatId => $mItemIds)
                    @php
                        $category = $cats->where('id', $mCatId)->first();
                        if (!$category) continue;
                        $catUrl = $allUrl;
                        $blogItems = collect($mItemIds)->map(function($itemId) use ($itemModel) {
                            return $itemModel::find($itemId);
                        })->filter();
                    @endphp
                    @foreach ($blogItems->take(4) as $blog)
                                @php
                                    $url = route($singleRoute, $blog->slug);
                                    $blogDate = $blog->created_at ? $blog->created_at->diffForHumans() : '';
                                    $commentsCount = isset($blog->id) && method_exists($blog, 'approvedComments') ? $blog->approvedComments()->count() : ($blog->comments_count ?? 0);
                                @endphp
                        <div class="col-2">
                            <div class="row child-cols g-2 mt-2">
                                    <div>
                                        <article class="post type-post panel vstack gap-1">
                                            <div class="post-media panel overflow-hidden">
                                                <div class="featured-image bg-gray-25 dark:bg-gray-800 ratio ratio-16x9">
                                                    <img class="media-cover image uc-transition-scale-up uc-transition-opaque" 
                                                        src="{{ asset('front/assets/images/common/img-fallback.png') }}" 
                                                        data-src="{{ asset('assets/front/img/blogs/' . ($blog->main_image ?? 'default.jpg')) }}" 
                                                        alt="{{ convertUtf8($blog->title) }}" 
                                                        data-uc-img="loading: lazy">
                                                </div>
                                                <a href="{{ $url }}" class="position-cover"></a>
                                            </div>
                                            <div class="post-header panel vstack gap-narrow">
                                                <h3 class="post-title h6 m-0 text-truncate-2">
                                                    <a class="text-none hover:text-primary duration-150" href="{{ $url }}">
                                                        {{ convertUtf8(strlen($blog->title) > 50 ? mb_substr($blog->title, 0, 50, 'utf-8') . '...' : $blog->title) }}
                                                    </a>
                                                </h3>
                                                <div class="post-meta panel hstack justify-start gap-1 fs-7 ft-tertiary fw-medium text-gray-900 dark:text-white text-opacity-60">
                                                    @if($blogDate)
                                                        <div>
                                                            <div class="post-date hstack gap-narrow">
                                                                <span>{{ $blogDate }}</span>
                                                            </div>
                                                        </div>
                                                    @endif
                                                    @if($commentsCount > 0)
                                                        <div>·</div>
                                                        <div>
                                                            <a href="{{ $url }}#blog-comment" class="post-comments text-none hstack gap-narrow">
                                                                <i class="fa-solid fa-comment-dots"></i>
                                                                <span>{{ $commentsCount }}</span>
                                                            </a>
                                                        </div>
                                                    @endif
                                                </div>
                                            </div>
                                        </article>
                                    </div>
                            </div>
                        </div>
                    @endforeach
                @endforeach
            @elseif($catAvailable && count($megaMenus) > 0)
                {{-- Other mega menus (non-blog) --}}
                @foreach ($megaMenus as $mCatId => $mItemIds)
                    @php
                        $category = $cats->where('id', $mCatId)->first();
                        if (!$category) continue;
                        $catUrl = $allUrl;
                    @endphp
                    <div class="col-2">
                        <ul class="uc-nav uc-navbar-dropdown-nav">
                            <li class="uc-nav-header fs-6 ft-tertiary fw-medium mb-1">
                                <a href="{{ route($catUrl, $category->slug ?? '') }}" class="fw-bold">{{ convertUtf8($category->name) }}</a>
                            </li>
                            @foreach ($mItemIds as $mItemId)
                                @php
                                    $item = $itemModel::find($mItemId);
                                    if (!$item) continue;
                                    $url = route($singleRoute, $item->slug);
                                @endphp
                                <li><a href="{{ $url }}">{{ convertUtf8($item->title) }}</a></li>
                            @endforeach
                        </ul>
                    </div>
                @endforeach
            @else
                {{-- Fallback for simple menu items --}}
                <div class="col-2">
                    <ul class="uc-nav uc-navbar-dropdown-nav">
                        <li><a href="{{ route($allUrl) }}">All {{ $link['text'] }}</a></li>
                        @if(isset($cats) && $cats->count() > 0)
                            @foreach($cats->take(5) as $cat)
                                <li><a href="{{ route($allUrl, $cat->slug) }}">{{ convertUtf8($cat->name) }}</a></li>
                            @endforeach
                        @endif
                    </ul>
                </div>
            @endif
        </div>
    </div>
</li>
