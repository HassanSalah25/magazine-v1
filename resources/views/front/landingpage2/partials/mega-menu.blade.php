@php
    $catAvailable = true;
    $megaMenus = [];
    $cats = collect();

    switch ($link['type']) {
        case 'services-megamenu':
            $data = $currentLang->megamenus()->where('type', 'services')->where('category', serviceCategory() ? 1 : 0);
            $itemModel = '\\App\\Models\\Service';
            $allUrl = route('front.services');
            if (serviceCategory()) {
                $cats = $currentLang->scategories()->where('status', 1)->orderBy('serial_number', 'ASC')->get();
                $catModel = '\\App\\Models\\Scategory';
            } else {
                $catAvailable = false;
            }
            break;

        case 'products-megamenu':
            $data = $currentLang->megamenus()->where('type', 'products')->where('category', 1);
            $cats = $currentLang->pcategories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\Pcategory';
            $itemModel = '\\App\\Models\\Product';
            $allUrl = route('front.product');
            break;

        case 'portfolios-megamenu':
            $data = $currentLang->megamenus()->where('type', 'portfolios')->where('category', serviceCategory() ? 1 : 0);
            $itemModel = '\\App\\Models\\Portfolio';
            $allUrl = route('front.portfolios');
            if (serviceCategory()) {
                $cats = $currentLang->scategories()->where('status', 1)->get();
                $catModel = '\\App\\Models\\Scategory';
            } else {
                $catAvailable = false;
            }
            break;

        case 'courses-megamenu':
            $data = $currentLang->megamenus()->where('type', 'courses')->where('category', 1);
            $cats = $currentLang->course_categories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\CourseCategory';
            $itemModel = '\\App\\Models\\Course';
            $allUrl = route('courses');
            break;

        case 'causes-megamenu':
            $data = $currentLang->megamenus()->where('type', 'causes')->where('category', 0);
            $itemModel = '\\App\\Models\\Donation';
            $catAvailable = false;
            $allUrl = route('front.causes'); // optional if needed
            break;

        case 'events-megamenu':
            $data = $currentLang->megamenus()->where('type', 'events')->where('category', 1);
            $cats = $currentLang->event_categories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\EventCategory';
            $itemModel = '\\App\\Models\\Event';
            $allUrl = route('front.events');
            break;

        case 'blogs-megamenu':
            $data = $currentLang->megamenus()->where('type', 'blogs')->where('category', 1);
            $cats = $currentLang->bcategories()->where('status', 1)->get();
            $catModel = '\\App\\Models\\Bcategory';
            $itemModel = '\\App\\Models\\Blog';
            $allUrl = route('front.blogs');
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


<li class="header__list-item has-submenu">
    <a href="#">
        <span>{{ $link['text'] }}</span>
        <svg xmlns="http://www.w3.org/2000/svg" width="9" height="5" viewBox="0 0 9 5" fill="none">
            <path fill-rule="evenodd" clip-rule="evenodd"
                  d="M0.612712 0.200408C0.916245 -0.081444 1.39079 -0.0638681 1.67265 0.239665L4.37305 3.14779L7.07345 0.239665C7.35531 -0.0638681 7.82986 -0.081444 8.13339 0.200408C8.43692 0.48226 8.4545 0.956809 8.17265 1.26034L4.92265 4.76034C4.78074 4.91317 4.5816 5 4.37305 5C4.1645 5 3.96536 4.91317 3.82345 4.76034L0.573455 1.26034C0.291603 0.956809 0.309179 0.48226 0.612712 0.200408Z"
                  fill="white"/>
        </svg>
    </a>
    <div class="submenu-wrapper">
        <div class="submenu-list__wrapper">
            <div class="submenu-list__title">{{ __('Categories') }}</div>
            <ul class="submenu-list">
                @foreach ($megaMenus as $mCatId => $mItemIds)
                    @php
                        $category = $cats->where('id', $mCatId)->first();
                        if (!$category) continue;
                        $catUrl = route('front.services', $category->slug);
                    @endphp
                    <li class="submenu-list__item has-submenu {{ $loop->iteration == 1 ? 'active' : '' }}">
                        <div class="submenu-list__item-wrapper">
                            <div class="submenu-list__item-icon">
                                <svg xmlns="http://www.w3.org/2000/svg" width="44" height="44" viewBox="0 0 44 44"
                                     fill="none">
                                    <rect width="44" height="44" rx="10" fill="#2BBE22" fill-opacity="0.1"/>
                                    <circle cx="22" cy="22" r="8" fill="#2BBE22"/>
                                </svg>
                            </div>
                            <a href="{{ $catUrl }}" class="submenu-list__item-link">
                                <span class="submenu-list__item-title">{{ $category->name }}</span>
                            </a>
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="14" viewBox="0 0 16 14"
                                 fill="none">
                                <path d="M0.5 6.99996H15.5M15.5 6.99996L9.66667 1.16663M15.5 6.99996L9.66667 12.8333"
                                      stroke="white" stroke-linecap="round" stroke-linejoin="round"/>
                            </svg>
                        </div>
                        <div class="submenu-content">
                            <div class="submenu-content__title">{{ __('Latest Services') }}</div>
                            <ul class="submenu-content__list">
                                @foreach ($mItemIds as $mItemId)
                                    @php
                                        $item = $itemModel::find($mItemId);
                                        if (!$item) continue;
                                        $img = asset('assets/front/img/services/' . $item->main_image);
                                        $url = route('front.servicedetails', $item->slug);
                                    @endphp
                                    <li class="submenu-content__list-item">
                                        <a href="{{ $url }}" class="submenu-content__link">
                                            <div class="submenu-content__link-img">
                                                <img loading="lazy" src="{{ $img }}" alt="{{ $item->title }}">
                                            </div>
                                            <div class="submenu-content__link-title">{{ $item->title }}</div>
                                            <div class="submenu-content__link-text">
                                                {{ Str::limit(strip_tags($item->summary ?? $item->content), 80) }}
                                            </div>
                                        </a>
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
</li>
