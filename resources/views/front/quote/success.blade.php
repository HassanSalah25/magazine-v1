@extends("front.$version.layout")

@section('breadcrumb-subtitle', __('Success!'))
@section('breadcrumb-link', __('Success'))

@section('content')
  <div class="quote-message pt-200" style="background: #f8f9fa; min-height: 60vh;">
      <div class="container d-flex justify-content-center align-items-center" style="min-height: 50vh;">
          <div class="card shadow-lg p-4 border-0" style="max-width: 500px; width: 100%;">
              <div class="quote-success text-center">
                  <div class="icon text-success mb-3" style="font-size: 4rem;"><i class="far fa-check-circle"></i></div>
                  <h2 class="mb-3">{{__('Success!')}}</h2>
                  <p class="lead">{{__('Your quote request has been sent successfully!')}}</p>
                  <p>{{__('We have received your quote request and will get back to you soon with a detailed proposal.')}}</p>
                  <p class="mt-4 mb-4">{{__('Thank you for your interest! If you have any questions, feel free to contact our support team.')}}</p>
                  <a href="{{ route('front.index') }}" class="btn btn-success btn-lg w-100">{{__('Back to Home')}}</a>
              </div>
          </div>
      </div>
  </div>
@endsection
