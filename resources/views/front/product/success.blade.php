@extends("front.$version.layout")

@section('breadcrumb-subtitle', __('Success!'))
@section('breadcrumb-link', __('Success'))

@section('content')
  <div class="checkout-message py-5" style="background: #f8f9fa; min-height: 60vh;">
      <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
          <div class="card shadow-lg p-4 border-0" style="max-width: 500px; width: 100%;">
              <div class="checkout-success text-center">
                  <div class="icon text-success mb-3" style="font-size: 4rem;"><i class="far fa-check-circle"></i></div>
                  <h2 class="mb-3">{{__('Success!')}}</h2>
                  <p class="lead">{{__('Your order has been placed successfully!')}}</p>
                  <p>{{__('We have sent you an email with your invoice and order details.')}}</p>
                  <p class="mt-4 mb-4">{{__('Thank you for shopping with us! If you have any questions, feel free to contact our support team.')}}</p>
                  <a href="{{ route('front.product') }}" class="btn btn-success btn-lg w-100">{{__('Continue Shopping')}}</a>
              </div>
          </div>
      </div>
  </div>
@endsection
