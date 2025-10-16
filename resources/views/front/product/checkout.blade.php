@extends("front.$version.layout")

@section('pagename')
  -
  {{ __('Checkout') }}
@endsection

@section('meta-keywords', "$be->checkout_meta_keywords")
@section('meta-description', "$be->checkout_meta_description")

@section('breadcrumb-title', convertUtf8($be->checkout_title))
@section('breadcrumb-subtitle', convertUtf8($be->checkout_subtitle))
@section('breadcrumb-link', __('Checkout'))

@section('content')
<!-- checkout area start -->
<section class="tp-checkout-area pb-120 pt-200">
  <div class="container">
    <div class="row">
      <div class="col-xl-7 col-lg-7">
        <div class="tp-checkout-verify">
          <div class="tp-checkout-verify-item">
            <p class="tp-checkout-verify-reveal">{{ __('Have a coupon?') }}</p>
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
        </div>
      </div>
      <form action="{{ route('product.paypal.submit') }}" method="POST" id="payment" enctype="multipart/form-data" class="product_form">
              @csrf
              @if (Session::has('stock_error'))
                <p class="text-danger text-center my-3">{{ Session::get('stock_error') }}</p>
              @endif
              @if ($errors->any())
                <div class="alert alert-danger">
                  <ul class="mb-0">
                    @foreach ($errors->all() as $error)
                      <li>{{ $error }}</li>
                    @endforeach
                  </ul>
                </div>
              @endif
        <div class="row">

          <div class="col-lg-7">
            <div class="tp-checkout-bill-area">
              <h3 class="tp-checkout-bill-title">{{ __('Billing Details') }}</h3>
              <div class="tp-checkout-bill-form">
              
                  <div class="tp-checkout-bill-inner">
                    <div class="row">
                      @php
                        $bfname = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $bfname = Auth::user()->billing_fname;
                            }
                        } else {
                            $bfname = old('billing_fname');
                        }
                        $blname = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $blname = Auth::user()->billing_lname;
                            }
                        } else {
                            $blname = old('billing_lname');
                        }
                        $bcountry = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $bcountry = Auth::user()->billing_country;
                            }
                        } else {
                            $bcountry = old('billing_country');
                        }
                        $baddress = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $baddress = Auth::user()->billing_address;
                            }
                        } else {
                            $baddress = old('billing_address');
                        }
                        $bcity = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $bcity = Auth::user()->billing_city;
                            }
                        } else {
                            $bcity = old('billing_city');
                        }
                        $bmail = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $bmail = Auth::user()->billing_email;
                            }
                        } else {
                            $bmail = old('billing_email');
                        }
                        $bnumber = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $bnumber = Auth::user()->billing_number;
                            }
                        } else {
                            $bnumber = old('billing_number');
                        }
                      @endphp
                      <div class="col-md-6 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('First Name') }} <span>*</span></label>
                          <input type="text" name="billing_fname" value="{{ $bfname }}">
                          @error('billing_fname')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-6 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Last Name') }} <span>*</span></label>
                          <input type="text" name="billing_lname" value="{{ $blname }}">
                          @error('billing_lname')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Country / Region') }} *</label>
                          <input type="text" name="billing_country" value="{{ $bcountry }}">
                          @error('billing_country')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Street address') }} *</label>
                          <input type="text" name="billing_address" value="{{ $baddress }}">
                          @error('billing_address')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Town / City') }} *</label>
                          <input type="text" name="billing_city" value="{{ $bcity }}">
                          @error('billing_city')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Contact Email') }} *</label>
                          <input type="text" name="billing_email" value="{{ $bmail }}">
                          @error('billing_email')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-input">
                          <label>{{ __('Phone') }} *</label>
                          <input type="text" name="billing_number" value="{{ $bnumber }}">
                          @error('billing_number')
                            <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                          @enderror
                        </div>
                      </div>
                      <!-- Shipping Address Toggle -->
                      <div class="col-md-12 mb-4">
                        <div class="tp-checkout-option">
                          <input id="ship_to_diff_address" type="checkbox">
                          <label for="ship_to_diff_address">{{ __('Ship to a different address?') }}</label>
                        </div>
                      </div>
                      <!-- Shipping Address Fields (hidden by default, show with JS if checked) -->
                      @php
                        $scountry = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $scountry = Auth::user()->shpping_country;
                            }
                        } else {
                            $scountry = old('shpping_country');
                        }
                        $sfname = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $sfname = Auth::user()->shpping_fname;
                            }
                        } else {
                            $sfname = old('shpping_fname');
                        }
                        $slname = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $slname = Auth::user()->shpping_lname;
                            }
                        } else {
                            $slname = old('shpping_lname');
                        }
                        $saddress = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $saddress = Auth::user()->shpping_address;
                            }
                        } else {
                            $saddress = old('shpping_address');
                        }
                        $scity = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $scity = Auth::user()->shpping_city;
                            }
                        } else {
                            $scity = old('shpping_city');
                        }
                        $smail = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $smail = Auth::user()->shpping_email;
                            }
                        } else {
                            $smail = old('shpping_email');
                        }
                        $snumber = '';
                        if (empty(old())) {
                            if (Auth::check()) {
                                $snumber = Auth::user()->shpping_number;
                            }
                        } else {
                            $snumber = old('shpping_number');
                        }
                      @endphp
                      <div id="shipping-fields" style="display:none;">
                        <div class="col-md-12 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Country') }} *</label>
                            <input type="text" name="shpping_country" value="{{ $scountry }}">
                            @error('shpping_country')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('First Name') }} *</label>
                            <input type="text" name="shpping_fname" value="{{ $sfname }}">
                            @error('shpping_fname')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-6 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Last Name') }} *</label>
                            <input type="text" name="shpping_lname" value="{{ $slname }}">
                            @error('shpping_lname')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Address') }} *</label>
                            <input type="text" name="shpping_address" value="{{ $saddress }}">
                            @error('shpping_address')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Town / City') }} *</label>
                            <input type="text" name="shpping_city" value="{{ $scity }}">
                            @error('shpping_city')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Contact Email') }} *</label>
                            <input type="text" name="shpping_email" value="{{ $smail }}">
                            @error('shpping_email')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                        <div class="col-md-12 mb-4">
                          <div class="tp-checkout-input">
                            <label>{{ __('Phone') }} *</label>
                            <input type="text" name="shpping_number" value="{{ $snumber }}">
                            @error('shpping_number')
                              <p class="text-danger mt-2">{{ convertUtf8($message) }}</p>
                            @enderror
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
              </div>
            </div>
          </div>
          <div class="col-lg-4">
            <div class="tp-checkout-place white-bg mt-5">
              <h3 class="tp-checkout-place-title">{{ __('Your Order') }}</h3>
              <div class="tp-order-info-list">
                <ul>
                  <li class="tp-order-info-list-header">
                    <h4>{{ __('Product') }}</h4>
                    <h4>{{ __('Total') }}</h4>
                  </li>
                  @php $total = 0; @endphp
                  @if ($cart)
                    @foreach ($cart as $key => $item)
                      <input type="hidden" name="product_id[]" value="{{ $key }}">
                      @php
                        $total += $item['price'] * $item['qty'];
                        $product = App\Models\Product::findOrFail($key);
                      @endphp
                      <li class="tp-order-info-list-desc">
                        <p>{{ convertUtf8($item['name']) }} <span> x {{ $item['qty'] }}</span></p>
                        <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{ $item['qty'] * $item['price'] }}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                      </li>
                    @endforeach
                  @else
                    <li class="tp-order-info-list-desc text-center">
                      <p colspan="2">{{ __('Cart is empty') }}</p>
                    </li>
                  @endif
                  <li class="tp-order-info-list-subtotal">
                    <span>{{ __('Cart Total') }}</span>
                    <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}<span data="{{ cartTotal() }}" class="subtotal">{{ cartTotal() }}</span>{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                  </li>
                  <li class="tp-order-info-list-subtotal">
                    <span>{{ __('Discount') }}</span>
                    <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}<span data="{{ $discount }}">{{ $discount }}</span>{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                  </li>
                  <li class="tp-order-info-list-subtotal">
                    <span>{{ __('Subtotal') }}</span>
                    <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}<span data="{{ cartSubTotal() }}" class="subtotal" id="subtotal">{{ cartSubTotal() }}</span>{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                  </li>
                  @if (!onlyDigitalItemsInCart() && sizeof($shippings) > 0)
                    @php $scharge = round($shippings[0]->charge, 2); @endphp
                    <li class="tp-order-info-list-shipping">
                      <span>{{ __('Shipping Charge') }}</span>
                      <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
                        @foreach ($shippings as $key => $charge)
                          <span>
                            <input type="radio" {{ $key == 0 ? 'checked' : '' }} name="shipping_charge" {{ $cart == null ? 'disabled' : '' }} data="{{ $charge->charge }}" class="shipping-charge" value="{{ $charge->id }}">
                            <label>{{ convertUtf8($charge->title) }}: <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}{{ $charge->charge }}{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span></label>
                          </span>
                        @endforeach
                      </div>
                    </li>
                  @else
                    <li class="tp-order-info-list-shipping">
                      <span>{{ __('Shipping Charge') }}</span>
                      <div class="tp-order-info-list-shipping-item d-flex flex-column align-items-end">
                        <span>
                          <input style="visibility: hidden;" type="radio" checked name="shipping_charge" {{ $cart == null ? 'disabled' : '' }} data="0" class="shipping-charge" value="0">
                          <label>{{ __('No Shipping') }}</label>
                        </span>
                      </div>
                    </li>
                    @php $scharge = 0; @endphp
                  @endif
                  <li class="tp-order-info-list-subtotal">
                    <span>{{ __('Tax') }} ({{ $bex->tax }}%)</span>
                    <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}<span data-tax="{{ tax() }}" id="tax">{{ tax() }}</span>{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                  </li>
                  <li class="tp-order-info-list-total">
                    <span>{{ __('Order Total') }}</span>
                    <span>{{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}<span data="{{ cartSubTotal() + $scharge + tax() }}" class="grandTotal">{{ cartSubTotal() + $scharge + tax() }}</span>{{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}</span>
                  </li>
                </ul>
              </div>
              <div class="tp-checkout-payment">
                @includeIf('front.product.payment-gateways')
              </div>
              <div class="tp-checkout-btn-wrapper mt-4">
                <button {{ $cart ? '' : 'disabled' }} class="tp-checkout-btn w-100" type="submit"><span class="btn-title">{{ __('Place Order') }}</span></button>
              </div>
            </div>
          </div>
        </div>
      </form>
    </div>
  </div>
</section>
<!-- checkout area end -->
@endsection

@section('scripts')
  <script>
    let stripe_key = "{{ $stripe_key }}";
  </script>
  <script src="https://js.stripe.com/v3/"></script>
  <script src="https://js.paystack.co/v1/inline.js"></script>
  <script src="{{ asset('assets/front/js/shop-checkout-stripe.js') }}"></script>
  @if (session()->has('unsuccess'))
    <script>
      toastr["error"]("{{ __(session('unsuccess')) }}");
    </script>
  @endif
  <script>
    // Coupon functionality
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
    // Shipping address toggle
    $(document).on('change', '#ship_to_diff_address', function() {
      if ($(this).is(':checked')) {
        $('#shipping-fields').show();
      } else {
        $('#shipping-fields').hide();
      }
    });
    // Shipping charge update
    $(document).on('click', '.shipping-charge', function() {
      let grantotal = parseFloat($('.grandTotal').attr('data'));
      let shipCharge = parseFloat($(this).attr('data'));
      $('.shipping').text(shipCharge);
      let subtotal = parseFloat($('.subtotal').attr('data'));
      let tax = parseFloat($('#tax').attr('data-tax'));
      let discount = parseFloat($('[data="{{ $discount }}"]').text()) || 0;
      let total = subtotal + shipCharge + tax - discount;
      $('.grandTotal').attr('data', total);
      $('.grandTotal').text(total);
    });
    // Payment gateway tab logic (if needed)
    $(document).ready(function() {
      $(".input-check").first().attr('checked', true);
      let tabid = $(".input-check:checked").data('tabid');
      $('#payment').attr('action', $(".input-check:checked").data('action'));
      showDetails(tabid);
    });
    function showDetails(tabid) {
      $(".gateway-details").removeClass("d-flex");
      $(".gateway-details").addClass("d-none");
      $(".gateway-details input").attr('disabled', true);
      if ($("#tab-" + tabid).length > 0) {
        if (tabid == 'stripe') {
          $("#tab-" + tabid).removeClass("d-none");
          $("#tab-" + tabid).addClass("d-block");
        } else {
          $("#tab-" + tabid + " input").removeAttr('disabled');
          $("#tab-" + tabid).removeClass("d-none");
          $("#tab-" + tabid).addClass("d-flex");
        }
      }
      if (tabid == 'paystack') {
        $('#payment').prop('id', 'paystack');
      }
    }
    $(document).on('click', '.input-check', function() {
      $('#payment').attr('action', $(this).data('action'));
      showDetails($(this).data('tabid'));
    });
    $(document).on('submit', '#paystack', function() {
      var val = $('#sub').val();
      if (val == 0) {
        var total = $(".grandTotal").text();
        var curr = "{{ $bex->base_currency_text }}";
        total = Math.round(total);
        var handler = PaystackPop.setup({
          key: "{{ $paystack['key'] }}",
          email: "{{ $paystack['email'] }}",
          amount: total * 100,
          currency: curr,
          ref: '' + Math.floor((Math.random() * 1000000000) + 1),
          callback: function(response) {
            $('#ref_id').val(response.reference);
            $('#sub').val('1');
            $('#paystack button[type="submit"]').click();
          },
          onClose: function() {
            window.location.reload();
          }
        });
        handler.openIframe();
        return false;
      } else {
        return true;
      }
    });
  </script>
@endsection
