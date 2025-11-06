@extends("front.$version.layout")

@section('pagename')
    {{ __('Our products') }}
@endsection

@section('meta-keywords', "$be->products_meta_keywords")
@section('meta-description', "$be->products_meta_description")

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection

@section('content')
<!-- product area start -->
<div class="tp-product-ptb pt-200 pb-30">
    <div class="container container-1750">
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-product-heading mb-50">
                    <div class="tp-shop-category-title-box">
                        <span class="tp-shop-section-subtitle mb-10">[ {{ __('Shop') }} ]</span>
                        <h4 class="tp-shop-section-title">{{ __('Our products') }}</h4>
                    </div>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tp-product-cats pb-40">
                    <a href="{{ route('front.product') }}" class="{{ request()->input('category_id') == '' ? 'active' : '' }}">{{ __('All') }} ({{ $products->total() }})</a>
                    @foreach ($categories as $category)
                        <a href="{{ route('front.product', array_merge(request()->all(), ['category_id' => $category->id])) }}" class="{{ request()->input('category_id') == $category->id ? 'active' : '' }}">{{ $category->name }} ({{ $category->products->count() ?? '?' }})</a>
                    @endforeach
                </div>
            </div>
            <div class="col-lg-6">
                <div class="tp-product-filter-wrap d-flex justify-content-lg-end align-items-center pb-40">
                    <div class="tp-product-filter-select">
                        <form id="sortForm" method="get" action="{{ route('front.product') }}">
                            <div id="customSelect" class="custom-select">
                                <div class="selected">{{ __('Sort by') }}
                                    @php
                                        $type = request()->input('type', 'new');
                                        $sortText = [
                                            'low-to-high' => __('Low to High'),
                                            'high-to-low' => __('High to Low'),
                                            'new' => __('Newest'),
                                            'old' => __('Oldest'),
                                            'on-sale' => __('On Sale'),
                                        ];
                                    @endphp
                                    {{ $sortText[$type] ?? __('Newest Product') }}<span class="arrow"></span>
                                </div>
                                <ul class="options">
                                    <li data-value="low-to-high">{{ __('Low to High') }}</li>
                                    <li data-value="high-to-low">{{ __('High to Low') }}</li>
                                    <li data-value="new">{{ __('Newest Product') }}</li>
                                    <li data-value="old">{{ __('Oldest Product') }}</li>
                                    <li data-value="on-sale">{{ __('On Sale') }}</li>
                                </ul>
                            </div>
                        <input type="hidden" name="type" id="typeInput" value="{{ $type }}">
                        @foreach(request()->except('type') as $key => $val)
                            <input type="hidden" name="{{ $key }}" value="{{ $val }}">
                        @endforeach
                    </form>
                </div>
            </div>
        </div>
        <div class="row">
            @forelse ($products as $product)
                <div class="col-xl-3 col-lg-4 col-sm-6">
                    <div class="tp-product-item mb-30">
                        <div class="tp-product-item-thumb">
                            <a href="{{ route('front.product.details', $product->slug) }}">
                                <img class="w-100" src="{{ asset('assets/front/img/product/featured/'.$product->feature_image) }}" alt="{{ $product->title }}">
                            </a>
                            <div class="tp-product-quick-view-wrapper">
                                <button class="tp-quick-view-btn"
                                    data-bs-toggle="modal" data-bs-target="#producQuickViewModal"
                                    data-title="{{ $product->title }}"
                                    data-image="{{ asset('assets/front/img/product/featured/'.$product->feature_image) }}"
                                    data-images='@json(
                                        $product->product_images->count()
                                            ? $product->product_images->pluck("image")->map(fn($img) => asset("assets/front/img/product/sliders/".$img))->prepend(asset("assets/front/img/product/featured/".$product->feature_image))->values()
                                            : [asset("assets/front/img/product/featured/".$product->feature_image)]
                                    )'
                                    data-price="{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{ $product->current_price }}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}"
                                    data-oldprice="{{ $product->previous_price ? ($bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '') . $product->previous_price . ($bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '') : '' }}"
                                    data-category="{{ $product->category->name ?? __('No Category') }}"
                                    data-desc="{{ $product->summary ?? ($product->description ?? __('No description available')) }}"
                                    data-stock="{{ isset($product->stock) ? ($product->stock > 0 ? __('In Stock') : __('Out of Stock')) : __('') }}"
                                    data-rating="{{ $product->rating ?? 0 }}"
                                    data-reviews="{{ $product->reviews_count ?? 0 }}"
                                    data-addtocart="{{ route('add.cart', $product->id) }}"
                                    data-buynow="{{ route('front.product.checkout', $product->slug) }}"
                                >
                                    <svg width="18" height="15" viewBox="0 0 18 15" fill="none" xmlns="http://www.w3.org/2000/svg">
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M8.99948 5.06828C7.80247 5.06828 6.82956 6.04044 6.82956 7.23542C6.82956 8.42951 7.80247 9.40077 8.99948 9.40077C10.1965 9.40077 11.1703 8.42951 11.1703 7.23542C11.1703 6.04044 10.1965 5.06828 8.99948 5.06828ZM8.99942 10.7482C7.0581 10.7482 5.47949 9.17221 5.47949 7.23508C5.47949 5.29705 7.0581 3.72021 8.99942 3.72021C10.9407 3.72021 12.5202 5.29705 12.5202 7.23508C12.5202 9.17221 10.9407 10.7482 8.99942 10.7482Z" fill="currentColor"></path>
                                        <path fill-rule="evenodd" clip-rule="evenodd" d="M1.41273 7.2346C3.08674 10.9265 5.90646 13.1215 8.99978 13.1224C12.0931 13.1215 14.9128 10.9265 16.5868 7.2346C14.9128 3.54363 12.0931 1.34863 8.99978 1.34773C5.90736 1.34863 3.08674 3.54363 1.41273 7.2346ZM9.00164 14.4703H8.99804H8.99714C5.27471 14.4676 1.93209 11.8629 0.0546754 7.50073C-0.0182251 7.33091 -0.0182251 7.13864 0.0546754 6.96883C1.93209 2.60759 5.27561 0.00288103 8.99714 0.000185582C8.99894 -0.000712902 8.99894 -0.000712902 8.99984 0.000185582C9.00164 -0.000712902 9.00164 -0.000712902 9.00254 0.000185582C12.725 0.00288103 16.0676 2.60759 17.945 6.96883C18.0188 7.13864 18.0188 7.33091 17.945 7.50073C16.0685 11.8629 12.725 14.4676 9.00254 14.4703H9.00164Z" fill="currentColor"></path>
                                    </svg>
                                </button>
                            </div>
                            <div class="tp-product-item-btn">
                                @if ($bex->catalog_mode == 0)
                                    <button class="tp-action-btn add-to-cart-btn" data-href="{{ route('add.cart', $product->id) }}" type="button">{{ __('Add to cart') }}</button>
                                @endif
                            </div>
                        </div>
                        <div class="tp-product-item-content d-flex justify-content-between align-content-center">
                            <h4 class="tp-product-item-title">
                                <a class="tp-line-black" href="{{ route('front.product.details', $product->slug) }}">
                                    {{ strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title }}
                                </a>
                            </h4>
                            <span class="tp-product-item-price">
                                {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{ $product->current_price }}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                            </span>
                        </div>
                    </div>
                </div>
            @empty
                <div class="col-12 text-center py-5 bg-light" style="margin-top: 30px;">
                    <h4 class="text-center">{{__('Product Not Found')}}</h4>
                </div>
            @endforelse
        </div>
        <!-- product pagination start -->
        <div class="tp-product-pagination-ptb pb-100">
            <div class="basic-pagination-wrap">
                <div class="container container-1750">
                    <div class="row">
                        <div class="col-xl-6">
                            <div class="basic-pagination product-pagination mb-0">
                                <nav>
                                    {{ $products->appends(request()->except('page'))->links('vendor.pagination.custom') }}
                                </nav>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- product pagination end -->
    </div>
</div>
<!-- product area end -->

<!-- Quick View Modal -->
<div class="modal fade tp-product-modal" id="producQuickViewModal" tabindex="-1" aria-labelledby="producQuickViewModal" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered">
        <div class="modal-content">
            <div class="tp-product-modal-content d-lg-flex">
                <button type="button" class="tp-product-modal-close-btn" data-bs-dismiss="modal"><i class="fa-regular fa-xmark"></i></button>
                <div class="tp-product-details-thumb-wrapper tp-tab d-sm-flex">
                    <div class="tab-content m-img" id="productDetailsNavContent">
                        <div class="tab-pane fade show active" id="nav-1-1" role="tabpanel" tabindex="0">
                            <div class="tp-product-details-nav-main-thumb">
                                <img id="modal-product-image" src="" alt="" style="max-width: 250px;">
                            </div>
                        </div>
                    </div>
                    <nav>
                        <div class="nav nav-tab flex-sm-column" id="modal-product-thumbs" role="tablist">
                            <!-- Thumbnails will be injected here -->
                        </div>
                    </nav>
                </div>
                <div class="tp-product-details-wrapper">
                    <div class="tp-product-details-category">
                        <span id="modal-product-category"></span>
                    </div>
                    <h3 class="tp-product-details-title" id="modal-product-title"></h3>
                    <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                        <div class="tp-product-details-stock mb-10">
                            <span id="modal-product-stock"></span>
                        </div>
                        <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
                            <div class="tp-product-details-rating" id="modal-product-rating">
                                <!-- Stars will be injected here -->
                            </div>
                            <div class="tp-product-details-reviews">
                                <span id="modal-product-reviews"></span>
                            </div>
                        </div>
                    </div>
                    <div class="tp-product-details-sort-desc">
                        <p id="modal-product-desc"></p>
                    </div>
                    <div class="tp-product-details-price-wrapper mb-20">
                        <span class="tp-product-details-price old-price" id="modal-product-old-price"></span>
                        <span class="tp-product-details-price new-price" id="modal-product-price"></span>
                    </div>
                    <div class="tp-product-details-action-wrapper">
                        <h3 class="tp-product-details-action-title">{{ __('Quantity') }}</h3>
                        <div class="tp-product-details-action-item-wrapper d-flex align-items-center">
                            <div class="tp-product-details-quantity">
                                <div class="tp-product-quantity mb-15 mr-15">
                                    <span class="tp-cart-minus">-</span>
                                    <input class="tp-cart-input" type="text" value="1">
                                    <span class="tp-cart-plus">+</span>
                                </div>
                            </div>
                            <div class="tp-product-details-add-to-cart mb-15 w-100">
                                <a id="modal-add-to-cart" href="#" class="tp-product-details-add-to-cart-btn w-100">{{ __('Add To Cart') }}</a>
                            </div>
                        </div>
                        <a id="modal-buy-now" href="#" class="tp-product-details-buy-now-btn w-100 text-center">{{ __('Buy Now') }}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Quick View Modal -->

@section('scripts')
@parent
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script>
// Custom select for sorting
$(document).on('click', '#customSelect .selected', function() {
    $(this).siblings('.options').toggle();
});
$(document).on('click', '#customSelect .options li', function() {
    var value = $(this).data('value');
    var text = $(this).text();
    $('#typeInput').val(value);
    $('#sortForm').submit();
});
$(document).on('click', function(e) {
    if (!$(e.target).closest('#customSelect').length) {
        $('#customSelect .options').hide();
    }
});
// Add to cart button (AJAX)
$(document).on('click', '.add-to-cart-btn', function(e) {
    e.preventDefault();
    var url = $(this).data('href');
    var btn = $(this);
    btn.prop('disabled', true);

    $.ajax({
        url: url,
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}'
        },
        dataType: 'json',
        success: function(response) {
            // Use SweetAlert for success
            Swal.fire({
                icon: 'success',
                title: response.message || '{{ __("Product added to cart!") }}',
                showConfirmButton: false,
                timer: 1500
            });
        },
        error: function(xhr) {
            // Use SweetAlert for error
            Swal.fire({
                icon: 'error',
                title: xhr.responseJSON?.message || xhr.responseJSON?.error || '{{ __("Failed to add product to cart.") }}',
                showConfirmButton: false,
                timer: 2000
            });
        },
        complete: function() {
            btn.prop('disabled', false);
        }
    });
});
$(document).on('click', '.tp-quick-view-btn', function() {
    var btn = $(this);
    var title = btn.data('title') || '{{ __('No Title') }}';
    var image = btn.data('image') || '';
    var images = btn.data('images') || [];
    if (typeof images === 'string') {
        try { images = JSON.parse(images); } catch(e) { images = [image]; }
    }
    var price = btn.data('price') || '';
    var oldPrice = btn.data('oldprice') || '';
    var category = btn.data('category') || '{{ __('No Category') }}';
    var desc = btn.data('desc') || '{{ __('No description available') }}';
    var stock = btn.data('stock') || '';
    var rating = btn.data('rating') || 0;
    var reviews = btn.data('reviews') || 0;
    var addToCart = btn.data('addtocart') || '#';
    var buyNow = btn.data('buynow') || '#';

    $('#modal-product-title').text(title);
    $('#modal-product-image').attr('src', images[0] || image);
    $('#modal-product-category').text(category);
    $('#modal-product-desc').text(desc);
    $('#modal-product-stock').text(stock);
    $('#modal-product-price').text(price);
    $('#modal-product-old-price').text(oldPrice ? oldPrice : '');
    $('#modal-product-reviews').text(reviews ? '('+reviews+' {{ __('Reviews') }})' : '');
    $('#modal-add-to-cart').attr('href', addToCart);
    $('#modal-buy-now').attr('href', buyNow);
    // نجوم التقييم
    var stars = '';
    rating = parseInt(rating);
    for(var i=1;i<=5;i++){
        stars += '<span><i class="fa-solid fa-star'+(i<=rating?'':'-o')+'"></i></span>';
    }
    $('#modal-product-rating').html(stars);
    // Render thumbnails
    var thumbsHtml = '';
    images.forEach(function(img, idx) {
        thumbsHtml += '<button class="nav-links'+(idx==0?' active':'')+'" data-img="'+img+'" type="button"><img src="'+img+'" alt="" ></button>';
    });
    $('#modal-product-thumbs').html(thumbsHtml);
});
// Change main image on thumbnail click
$(document).on('click', '#modal-product-thumbs .nav-links', function() {
    $('#modal-product-thumbs .nav-links').removeClass('active');
    $(this).addClass('active');
    var img = $(this).data('img');
    $('#modal-product-image').attr('src', img);
});
// كمية المنتج (اختياري)
$(document).on('click', '.tp-cart-plus', function() {
    var input = $(this).siblings('input');
    var val = parseInt(input.val()) || 1;
    input.val(val+1);
});
$(document).on('click', '.tp-cart-minus', function() {
    var input = $(this).siblings('input');
    var val = parseInt(input.val()) || 1;
    if(val>1) input.val(val-1);
});
// Add SweetAlert2 if not already included
if (typeof Swal === 'undefined') {
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);
}
</script>
@endsection
