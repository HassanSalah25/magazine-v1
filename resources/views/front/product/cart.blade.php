@extends("front.$version.layout")

@section('pagename')
 -
 {{__('Cart')}}
@endsection

@section('meta-keywords', "$be->cart_meta_keywords")
@section('meta-description', "$be->cart_meta_description")

@section('styles')
<link rel="stylesheet" href="{{asset('assets/front/css/jquery-ui.min.css')}}">
@endsection

@section('breadcrumb-title', convertUtf8($be->cart_title))
@section('breadcrumb-subtitle', convertUtf8($be->cart_subtitle))
@section('breadcrumb-link', __('Cart'))

@section('content')

<!--====== SHOPPING CART PART START ======-->
<section class="tp-cart-area pb-120 pt-200">
    <div class="container">
        <div class="row">
            <div class="col-xl-9 col-lg-8">
                <div class="tp-cart-list mb-25 mr-30">
                    @if($cart != null)
                    <table class="table">
                        <thead>
                            <tr>
                                <th colspan="2" class="tp-cart-header-product">{{__('Product')}}</th>
                                <th class="tp-cart-header-price">{{__('Price')}}</th>
                                <th class="tp-cart-header-quantity">{{__('Quantity')}}</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $cartTotal = 0;
                                $countitem = 0;
                            @endphp
                            @foreach ($cart as $id => $item)
                                @php
                                    $product = App\Models\Product::findOrFail($id);
                                    $cartTotal += $item['price'] * $item['qty'];
                                    $countitem += $item['qty'];
                                @endphp
                                <tr class="remove{{$id}}">
                                    <!-- img -->
                                    <td class="tp-cart-img">
                                        @if($product->feature_image)
                                            <a href="{{route('front.product.details',$product->slug)}}">
                                                <img src="{{asset('assets/front/img/product/featured/' . $product->feature_image)}}" alt="{{ $item['name'] }}">
                                            </a>
                                        @endif
                                    </td>
                                    <!-- title -->
                                    <td class="tp-cart-title">
                                        <a href="{{route('front.product.details',$product->slug)}}">{{convertUtf8($item['name'])}}</a>
                                    </td>
                                    <!-- price -->
                                    <td class="tp-cart-price">
                                        <span>
                                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$item['price']}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                                        </span>
                                    </td>
                                    <!-- quantity -->
                                    <td class="tp-cart-quantity tp-product-details-quantity">
                                        <div class="tp-product-quantity mt-10 mb-10">
                                            <span class="tp-cart-minus" data-id="{{$id}}">
                                                <svg width="10" height="2" viewBox="0 0 10 2" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M1 1H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                            <input class="tp-cart-input cart_qty" type="text" value="{{$item['qty']}}" data-id="{{$id}}">
                                            <span class="tp-cart-plus" data-id="{{$id}}">
                                                <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                    <path d="M5 1V9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                    <path d="M1 5H9" stroke="currentColor" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round" />
                                                </svg>
                                            </span>
                                        </div>
                                    </td>
                                    <!-- action -->
                                    <td class="tp-cart-action">
                                        <button class="tp-cart-action-btn item-remove" rel="{{$id}}" data-href="{{route('cart.item.remove',$id)}}">
                                            <svg width="10" height="10" viewBox="0 0 10 10" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                <path fill-rule="evenodd" clip-rule="evenodd" d="M9.53033 1.53033C9.82322 1.23744 9.82322 0.762563 9.53033 0.46967C9.23744 0.176777 8.76256 0.176777 8.46967 0.46967L5 3.93934L1.53033 0.46967C1.23744 0.176777 0.762563 0.176777 0.46967 0.46967C0.176777 0.762563 0.176777 1.23744 0.46967 1.53033L3.93934 5L0.46967 8.46967C0.176777 8.76256 0.176777 9.23744 0.46967 9.53033C0.762563 9.82322 1.23744 9.82322 1.53033 9.53033L5 6.06066L8.46967 9.53033C8.76256 9.82322 9.23744 9.82322 9.53033 9.53033C9.82322 9.23744 9.82322 8.76256 9.53033 8.46967L6.06066 5L9.53033 1.53033Z" fill="currentColor" />
                                            </svg>
                                            <span>{{__('Remove')}}</span>
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                    @else
                        <div class="bg-light py-5 text-center">
                            <h3 class="text-uppercase">{{__('Cart is empty!')}}</h3>
                        </div>
                    @endif
                </div>
                @if($cart != null)
                <div class="tp-cart-bottom">
                    <div class="row align-items-end">
                        <div class="col-xl-6 col-md-8">
                            <div class="tp-cart-coupon">
                                <form id="couponForm" action="javascript:void(0);">
                                    <div class="tp-cart-coupon-input-box">
                                        <label>{{__('Coupon Code')}}:</label>
                                        <div class="tp-cart-coupon-input d-flex align-items-center">
                                            <input type="text" id="coupon_code" placeholder="{{__('Enter Coupon Code')}}">
                                            <button type="submit">{{__('Apply')}}</button>
                                        </div>
                                    </div>
                                </form>
                                <div id="coupon-message"></div>
                            </div>
                        </div>
                        <div class="col-xl-6 col-md-4">
                            <div class="tp-cart-update text-md-end">
                                <button type="button" class="tp-cart-update-btn" id="cartUpdate" data-href="{{route('cart.update')}}">{{__('Update Cart')}}</button>
                            </div>
                        </div>
                    </div>
                </div>
                @endif
            </div>
            <div class="col-xl-3 col-lg-4 col-md-6">
                @if($cart != null)
                <div class="tp-cart-checkout-wrapper">
                    <div class="tp-cart-checkout-top d-flex align-items-center justify-content-between">
                        <span class="tp-cart-checkout-top-title">{{__('Subtotal')}}</span>
                        <span class="tp-cart-checkout-top-price">
                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$cartTotal}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                        </span>
                    </div>
                    @if($discount > 0)
                    <div class="tp-cart-checkout-discount d-flex align-items-center justify-content-between">
                        <span>{{__('Discount')}}</span>
                        <span>-{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$discount}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                    </div>
                    @endif
                    @if($tax > 0)
                    <div class="tp-cart-checkout-tax d-flex align-items-center justify-content-between">
                        <span>{{__('Tax')}}</span>
                        <span>+{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$tax}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                    </div>
                    @endif
                    @if($shipping > 0)
                    <div class="tp-cart-checkout-shipping d-flex align-items-center justify-content-between">
                        <span>{{__('Shipping')}}</span>
                        <span>+{{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$shipping}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}</span>
                    </div>
                    @endif
                    <div class="tp-cart-checkout-total d-flex align-items-center justify-content-between">
                        <span>{{__('Total')}}</span>
                        <span>
                            {{$bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : ''}}{{$grandTotal}}{{$bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : ''}}
                        </span>
                    </div>
                    <div class="tp-cart-checkout-proceed">
                        <a href="{{route('front.checkout')}}" class="tp-cart-checkout-btn w-100">{{__('Proceed to Checkout')}}</a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
<!--====== SHOPPING CART PART ENDS ======-->
@endsection

@section('scripts')
<script>
    var symbol = "{{$bex->base_currency_symbol}}";
    var position = "{{$bex->base_currency_symbol_position}}";
</script>
<script src="{{asset('assets/front/js/jquery.ui.js')}}"></script>
<script src="{{asset('assets/front/js/product.js')}}"></script>
<script src="{{asset('assets/front/js/cart.js')}}"></script>
<script>
$(document).on('click', '#cartUpdate', function(e) {
    e.preventDefault();
    var items = {};
    $('.cart_qty').each(function() {
        var id = $(this).data('id');
        var qty = $(this).val();
        items[id] = qty;
    });
    $.ajax({
        url: $('#cartUpdate').data('href'),
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            items: items
        },
        success: function(response) {
            location.reload();
        },
        error: function(xhr) {
            alert('حدث خطأ أثناء تحديث السلة');
        }
    });
});

$(document).on('submit', '#couponForm', function(e) {
    e.preventDefault();
    var code = $('#coupon_code').val();
    $.ajax({
        url: '{{ route("front.coupon") }}',
        type: 'POST',
        data: {
            _token: '{{ csrf_token() }}',
            coupon: code
        },
        success: function(response) {
            if(response.status === 'success') {
                $('#coupon-message').html('<span style="color:green;">' + response.message + '</span>');
                setTimeout(function(){ location.reload(); }, 1000); // Reload to update discount
            } else {
                $('#coupon-message').html('<span style="color:red;">' + response.message + '</span>');
            }
        },
        error: function() {
            $('#coupon-message').html('<span style="color:red;">{{ __('An error occurred') }}</span>');
        }
    });
});
</script>
@endsection
