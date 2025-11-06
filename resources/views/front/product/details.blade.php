@extends("front.$version.layout")

@section('pagename')
 - {{__('Product')}} - {{convertUtf8($product->title)}}
@endsection

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/slick.css')}}">
{{-- أضف هنا أي CSS إضافي خاص بالتصميم الجديد إذا لزم --}}
@endsection

@section('meta-keywords', "$product->meta_keywords")
@section('meta-description', "$product->meta_description")

@php
    $reviews = App\Models\ProductReview::where('product_id', $product->id)->get();
    $avarage_rating = App\Models\ProductReview::where('product_id',$product->id)->avg('review');
    $avarage_rating =  round($avarage_rating,2);
@endphp

@section('breadcrumb-title', $be->product_details_title)
@section('breadcrumb-subtitle', strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title)
@section('breadcrumb-link', strlen($product->title) > 40 ? mb_substr($product->title,0,40,'utf-8') . '...' : $product->title)

@section('content')
<!-- breadcrumb area start -->
<div class="breadcrumb__area breadcrumb__style-2 pt-150 pb-20">
    <div class="container container-1750">
        <div class="row">
            <div class="col-xxl-12">
                <div class="breadcrumb__content p-relative z-index-1">
                    <div class="breadcrumb__list has-icon">
                        <span class="breadcrumb-icon">
                            <!-- SVG icon here -->
                        </span>
                        <span><a href="/">{{__('Home')}}</a></span>
                        @if($product->category)
                        <span><a href="{{ route('front.product').'?category_id='.$product->category_id }}">{{ $product->category ? convertUtf8($product->category->name) : '' }}</a></span>
                        @endif
                        <span>{{ convertUtf8($product->title) }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- breadcrumb area end -->

<!-- product details area start -->
<section class="tp-product-details-area">
    <div class="tp-product-details-top pb-115">
        <div class="container container-1750">
            <div class="row">
                <div class="col-xl-7 col-lg-6">
                    <div class="tp-product-details-thumb-wrapper tp-tab d-md-flex">
                        <div class="tab-content m-img" id="productDetailsNavContent2">
                            @foreach ($product->product_images as $key => $image)
                                <div class="tab-pane fade {{ $key == 0 ? 'show active' : '' }}" id="nav-{{ $key+1 }}" role="tabpanel" aria-labelledby="nav-{{ $key+1 }}-tab" tabindex="0">
                                    <div class="tp-product-details-nav-main-thumb">
                                        <img src="{{ asset('assets/front/img/product/sliders/'.$image->image) }}" alt="">
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        <nav>
                            <div class="nav nav-tab flex-md-column " id="productDetailsNavThumb2" role="tablist">
                                @foreach ($product->product_images as $key => $image)
                                    <button class="nav-links {{ $key == 0 ? 'active' : '' }}" id="nav-{{ $key+1 }}-tab" data-bs-toggle="tab" data-bs-target="#nav-{{ $key+1 }}" type="button" role="tab" aria-controls="nav-{{ $key+1 }}" aria-selected="{{ $key == 0 ? 'true' : 'false' }}">
                                        <img src="{{ asset('assets/front/img/product/sliders/'.$image->image) }}" alt="">
                                    </button>
                                @endforeach
                            </div>
                        </nav>
                    </div>
                </div> <!-- col end -->
                <div class="col-xl-5 col-lg-6">
                    <div class="tp-product-details-wrapper">
                        <div class="tp-product-details-category">
                            @if($product->category)
                                <span>{{ $product->category ? convertUtf8($product->category->name) : '' }}</span>
                            @endif
                        </div>
                        <h3 class="tp-product-details-title">{{ convertUtf8($product->title) }}</h3>
                        <!-- inventory details -->
                        <div class="tp-product-details-inventory d-flex align-items-center mb-10">
                            <div class="tp-product-details-stock mb-10">
                                @if ($product->type != 'digital')
                                    @if ($product->stock > 0)
                                        <span>{{__('In Stock')}}</span>
                                    @else
                                        <span>{{__('Out of Stock')}}</span>
                                    @endif
                                @endif
                            </div>
                            <div class="tp-product-details-rating-wrapper d-flex align-items-center mb-10">
                                @if ($bex->product_rating_system == 1)
                                <div class="tp-product-details-rating">
                                    @for($i=1;$i<=5;$i++)
                                        <span><i class="fa-solid fa-star{{ $i <= round($avarage_rating) ? '' : '-o' }}"></i></span>
                                    @endfor
                                </div>
                                <div class="tp-product-details-reviews">
                                    <span>({{ count($reviews) }} {{__('Reviews')}})</span>
                                </div>
                                @endif
                            </div>
                        </div>
                        <div class="tp-product-details-sort-desc">
                            @if (!empty($product->summary))
                                <p>{{ convertUtf8($product->summary) }}</p>
                            @endif
                        </div>
                        <!-- price -->
                        <div class="tp-product-details-price-wrapper mb-20">
                            @if ($bex->catalog_mode == 0)
                                @if (!empty($product->previous_price))
                                    <span class="tp-product-details-price old-price">
                                        {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->previous_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                    </span>
                                @endif
                                <span class="tp-product-details-price new-price">
                                    {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$product->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                </span>
                            @endif
                        </div>
                        <!-- actions -->
                        <div class="tp-product-details-action-wrapper">
                            <h3 class="tp-product-details-action-title">{{__('Quantity')}}</h3>
                            <div class="tp-product-details-action-item-wrapper d-flex align-items-center">
                                <div class="tp-product-details-quantity">
                                    <div class="tp-product-quantity mb-15 mr-15">
                                        <span class="tp-cart-minus">-</span>
                                        <input class="tp-cart-input" type="text" value="1">
                                        <span class="tp-cart-plus">+</span>
                                    </div>
                                </div>
                                <div class="tp-product-details-add-to-cart mb-15 w-100">
                                    <button class="tp-product-details-add-to-cart-btn w-100 add-to-cart-btn" type="button" data-href="{{route('add.cart',$product->id)}}">{{__('Add To Cart')}}</button>
                                </div>
                            </div>
                            <form method="GET" action="{{route('front.product.checkout',$product->slug)}}">
                                <input type="hidden" value="1" name="qty">
                                <button type="submit" class="tp-product-details-buy-now-btn w-100">{{__('Buy Now')}}</button>
                            </form>
                        </div>
                        <div class="tp-product-details-query">
                            @if(!empty($product->sku))
                            <div class="tp-product-details-query-item d-flex align-items-center">
                                <span>SKU: </span>
                                <p>{{ $product->sku }}</p>
                            </div>
                            @endif
                            @if($product->category)
                            <div class="tp-product-details-query-item d-flex align-items-center">
                                <span>{{__('Category')}}: </span>
                                <p>{{ $product->category ? convertUtf8($product->category->name) : '' }}</p>
                            </div>
                            @endif
                        </div>
                        <!-- social icons, wishlist, etc. يمكن إضافتها لاحقاً -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- product details area end -->

<!-- باقي الأقسام (التبويبات، المنتجات المرتبطة) سيتم نقلها لاحقاً -->

<!-- product tabs area start -->
<div class="tp-product-details-bottom pb-140">
    <div class="container container-1230">
        <div class="row">
            <div class="col-xl-12">
                <div class="tp-product-details-tab-nav tp-tab">
                    <nav>
                        <div class="nav nav-tabs justify-content-center p-relative tp-product-tab" id="navPresentationTab" role="tablist">
                            <button class="nav-link active" id="nav-description-tab" data-bs-toggle="tab" data-bs-target="#nav-description" type="button" role="tab" aria-controls="nav-description" aria-selected="true">{{__('Description')}}</button>
                            <button class="nav-link" id="nav-addInfo-tab" data-bs-toggle="tab" data-bs-target="#nav-addInfo" type="button" role="tab" aria-controls="nav-addInfo" aria-selected="false">{{__('Additional information')}}</button>
                            @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                            <button class="nav-link" id="nav-review-tab" data-bs-toggle="tab" data-bs-target="#nav-review" type="button" role="tab" aria-controls="nav-review" aria-selected="false">{{__('Reviews')}} ({{count($reviews)}})</button>
                            @endif
                            <span id="productTabMarker" class="tp-product-details-tab-line"></span>
                        </div>
                    </nav>
                    <div class="tab-content" id="navPresentationTabContent">
                        <div class="tab-pane fade show active" id="nav-description" role="tabpanel" aria-labelledby="nav-description-tab" tabindex="0">
                            <div class="tp-product-details-desc-wrapper pt-50">
                                <div class="row justify-content-center">
                                    <div class="col-xl-10">
                                        <div class="tp-product-details-desc-item">
                                            <div class="row">
                                                <div class="col-lg-12">
                                                    <div class="tp-product-details-desc-content pt-25">
                                                        <h3 class="tp-product-details-desc-title">{{__('Product Description')}}</h3>
                                                        <p>{!! replaceBaseUrl(convertUtf8($product->description)) !!}</p>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="tab-pane fade" id="nav-addInfo" role="tabpanel" aria-labelledby="nav-addInfo-tab" tabindex="0">
                            <div class="tp-product-details-additional-info ">
                                <div class="row justify-content-center">
                                    <div class="col-xl-10">
                                        <table>
                                            <tbody>
                                                @if(!empty($product->sku))
                                                <tr>
                                                    <td>{{__('SKU')}}</td>
                                                    <td>{{ $product->sku }}</td>
                                                </tr>
                                                @endif
                                                @if($product->category)
                                                <tr>
                                                    <td>{{__('Category')}}</td>
                                                    <td>{{ $product->category ? convertUtf8($product->category->name) : '' }}</td>
                                                </tr>
                                                @endif
                                                <!-- يمكنك إضافة المزيد من المعلومات الإضافية هنا -->
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @if ($bex->product_rating_system == 1 && $bex->catalog_mode == 0)
                        <div class="tab-pane fade" id="nav-review" role="tabpanel" aria-labelledby="nav-review-tab" tabindex="0">
                            <div class="tp-product-details-review-wrapper pt-60">
                                <div class="row">
                                    <div class="col-lg-6">
                                        <div class="tp-product-details-review-statics">
                                            <!-- number -->
                                            <div class="tp-product-details-review-number d-inline-block mb-50">
                                                <h3 class="tp-product-details-review-number-title">{{__('Customer reviews')}}</h3>
                                                <div class="tp-product-details-review-summery d-flex align-items-center">
                                                    <div class="tp-product-details-review-summery-value">
                                                        <span>{{ $avarage_rating }}</span>
                                                    </div>
                                                    <div class="tp-product-details-review-summery-rating d-flex align-items-center">
                                                        @for($i=1;$i<=5;$i++)
                                                            <span><i class="fa-solid fa-star{{ $i <= round($avarage_rating) ? '' : '-o' }}"></i></span>
                                                        @endfor
                                                        <p>({{ count($reviews) }} {{__('Reviews')}})</p>
                                                    </div>
                                                </div>
                                                <!-- توزيع التقييمات (يمكنك تطويره لاحقاً) -->
                                            </div>
                                            <!-- reviews -->
                                            <div class="tp-product-details-review-list pr-110">
                                                <h3 class="tp-product-details-review-title">{{__('Rating & Review')}}</h3>
                                                @forelse ($reviews as $review)
                                                <div class="tp-product-details-review-avater d-flex align-items-start">
                                                    <div class="tp-product-details-review-avater-thumb">
                                                        <a href="#">
                                                            @if (strpos($review->user->photo, 'facebook') !== false || strpos($review->user->photo, 'google'))
                                                                <img src="{{$review->user->photo ? $review->user->photo : asset('assets/front/img/user/profile.jpg')}}" alt="user image">
                                                            @else
                                                                <img src="{{$review->user->photo ? asset('assets/front/img/user/'.$review->user->photo) : asset('assets/front/img/user/profile.jpg')}}" alt="user image">
                                                            @endif
                                                        </a>
                                                    </div>
                                                    <div class="tp-product-details-review-avater-content">
                                                        <div class="tp-product-details-review-avater-rating d-flex align-items-center">
                                                            @for($i=1;$i<=5;$i++)
                                                                <span><i class="fa-solid fa-star{{ $i <= $review->review ? '' : '-o' }}"></i></span>
                                                            @endfor
                                                        </div>
                                                        <h3 class="tp-product-details-review-avater-title">{{ $review->user->username }}</h3>
                                                        <span class="tp-product-details-review-avater-meta">{{ $review->created_at->format('d-m-Y') }}</span>
                                                        <div class="tp-product-details-review-avater-comment">
                                                            <p>{{ convertUtf8($review->comment) }}</p>
                                                        </div>
                                                    </div>
                                                </div>
                                                @empty
                                                <div class="bg-light mt-4 text-center py-5">
                                                    {{__('NOT RATED YET')}}
                                                </div>
                                                @endforelse
                                            </div>
                                        </div>
                                    </div> <!-- end col -->
                                    <div class="col-lg-6">
                                        <div class="tp-product-details-review-form">
                                            <h3 class="tp-product-details-review-form-title">{{__('Review this product')}}</h3>
                                            <p>{{__('Your email address will not be published. Required fields are marked *')}}</p>
                                            @if(Auth::user())
                                                @if(App\Models\OrderItem::where('user_id',Auth::user()->id)->where('product_id',$product->id)->exists())
                                                <form class="mt-3" action="{{route('product.review.submit')}}" method="POST">@csrf
                                                    <div class="tp-product-details-review-form-rating d-flex align-items-center">
                                                        <p>{{__('Your Rating')}} :</p>
                                                        <div class="tp-product-details-review-form-rating-icon d-flex align-items-center review-content">
                                                            @for($i=1;$i<=5;$i++)
                                                                <a class="cursor-pointer mx-1" data-href="{{$i}}"><i class="far fa-star fa-lg"></i></a>
                                                            @endfor
                                                        </div>
                                                    </div>
                                                    <div class="tp-product-details-review-input-wrapper">
                                                        <div class="tp-product-details-review-input-box">
                                                            <div class="tp-product-details-review-input-title">
                                                                <label for="msg">{{__('Comment')}}</label>
                                                            </div>
                                                            <div class="tp-product-details-review-input">
                                                                <textarea id="msg" name="comment" placeholder="{{__('Write your review here...')}}"></textarea>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <input type="hidden" value="" id="reviewValue" name="review">
                                                    <input type="hidden" value="{{$product->id}}" name="product_id">
                                                    <div class="tp-product-details-review-btn-wrapper">
                                                        <button type="submit" class="tp-product-details-review-btn">{{__('Submit')}}</button>
                                                    </div>
                                                </form>
                                                @endif
                                            @else
                                                <div class="review-login mt-4 text-center">
                                                    <a class="boxed-btn d-inline-block mr-2" href="{{route('user.login')}}">{{__('Login')}}</a> {{__('to leave a rating')}}
                                                </div>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- product tabs area end -->

@if($related_product->count() > 0)
<!-- product related area start -->
<div class="tp-product-related-ptb pt-100 pb-90">
    <div class="container container-1750">
        <div class="row">
            <div class="col-lg-12">
                <div class="tp-product-related-heading mb-40">
                    <h4 class="tp-product-related-title">{{__('Related Products')}}</h4>
                </div>
            </div>
        </div>
        <div class="row">
            @foreach ($related_product as $related)
            <div class="col-xl-3 col-lg-4 col-sm-6 tp_fade_anim" data-delay=".{{ $loop->iteration * 2 }}">
                <div class="tp-product-item mb-30">
                    <div class="tp-product-item-thumb">
                        <a href="{{ route('front.product.details', $related->slug) }}">
                            <img class="w-100" src="{{ asset('assets/front/img/product/featured/'.$related->feature_image) }}" alt="">
                        </a>
                        <div class="tp-product-quick-view-wrapper">
                            <button class="tp-quick-view-btn" data-bs-toggle="modal" data-bs-target="#producQuickViewModal">
                                <!-- يمكنك وضع SVG الأيقونة هنا إذا أردت -->
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                        <div class="tp-product-item-btn">
                            @if ($bex->catalog_mode == 0)
                            <a class="tp-action-btn cart-link" data-href="{{route('add.cart',$related->id)}}">{{__('Add to cart')}}</a>
                            @endif
                        </div>
                    </div>
                    <div class="tp-product-item-content d-flex justify-content-between align-content-center">
                        <h4 class="tp-product-item-title">
                            <a class="tp-line-black" href="{{ route('front.product.details', $related->slug) }}">{{ convertUtf8($related->title) }}</a>
                        </h4>
                        <span class="tp-product-item-price">
                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$related->current_price}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                        </span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</div>
<!-- product related area end -->
@endif
@endsection

@section('scripts')
<script src="{{asset('assets/front/js/slick.min.js')}}"></script>
<script src="{{asset('assets/front/js/product.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>
{{-- أضف هنا أي JS إضافي خاص بالتصميم الجديد إذا لزم --}}
<script>
// Add to cart button (AJAX) - copied from product.blade.php
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
// Add SweetAlert2 if not already included
if (typeof Swal === 'undefined') {
    var script = document.createElement('script');
    script.src = 'https://cdn.jsdelivr.net/npm/sweetalert2@11';
    document.head.appendChild(script);
}
</script>
@endsection
