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
            $allUrl = 'front.causes'; // optional if needd
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
            $cats = $currentLang->bcategories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\Bcategory';
            $itemModel = '\\App\\Models\\Blog';
            $allUrl = 'front.blogs';
            $singleRoute = 'front.blogdetails';
            break;

        default:
            $data = collect(); // fallback, just to avoid null errors
            $catAvailable = false;
            break;
    }

    if ($data->count() > 0) {
        $megaMenus = json_decode($data->first()->menus, true);
    }
@endphp
<li class="has-dropdown">
    <a href="{{ route($allUrl) }}">{{ $link['text'] }}</a>
    <div class="tp-megamenu-wrapper mega-menu megamenu-white-bg">
        <div class="row gx-0">
            @if($catAvailable)
                @foreach ($megaMenus as $mCatId => $mItemIds)
                    @php
                        $category = $cats->where('id', $mCatId)->first();
                        if (!$category) continue;
                        $catUrl = $allUrl;
                    @endphp
                    <div class="col-xl-2" style="margin-top:50px;">
                        <div class="tp-megamenu-list">
                            <h4 class="tp-megamenu-title"><a href="{{ route($catUrl, $category->slug) }}">{{ $category->name }}</a></h4>
                            <ul style="padding-bottom:0px !important;">
                                @foreach ($mItemIds as $mItemId)
                                    @php
                                        $item = $itemModel::find($mItemId);
                                        if (!$item) continue;
                                        $url = route($singleRoute, $item->slug);
                                    @endphp
                                    <li><a href="{{ $url }}">{{ $item->title }}</a></li>
                                @endforeach
                            </ul>
                        </div>
                    </div>
                @endforeach
            @endif
        </div>
    </div>
</li>
