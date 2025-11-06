@extends("front.$version.layout")

@section('pagename')
- {{__('Contact Us')}}
@endsection

@section('meta-keywords', "$be->contact_meta_keywords")
@section('meta-description', "$be->contact_meta_description")


@section('content')

    <!-- Contact page header section start -->
    <section class="panel py-8 lg:py-12 bg-white dark:bg-gray-900">
        <div class="container max-w-xl">
            <div class="vstack gap-4 lg:gap-6">
                @if(!empty($bs->contact_subtitle))
                <div class="hstack gap-2 items-center">
                    <span class="fs-7 text-uppercase fw-medium text-primary opacity-75">{{ convertUtf8($bs->contact_subtitle) }}</span>
                    <div class="vr"></div>
                </div>
                @endif
                <h1 class="h1 lg:h-xxl m-0 text-gray-900 dark:text-white">{{ convertUtf8($bs->contact_title) }}</h1>
            </div>
        </div>
    </section>
    <!-- Contact page header section end -->

    <!-- Contact information and form section start -->
    <section class="panel py-8 lg:py-12 bg-gray-50 dark:bg-gray-800">
        <div class="container max-w-xl">
            <div class="row g-4 lg:g-6">
                <!-- Contact Information Column -->
                <div class="col-lg-4">
                    <div class="panel vstack gap-4 lg:gap-6 p-4 lg:p-6 bg-white dark:bg-gray-900 rounded shadow-sm">
                        <h3 class="h4 m-0 text-gray-900 dark:text-white">{{ __('Get In Touch!') }}</h3>
                        
                        <div class="vstack gap-4">
                            <!-- Phone -->
                            <div class="hstack gap-3 items-start">
                                <div class="flex-shrink-0 w-40px h-40px rounded-circle bg-primary text-white d-flex items-center justify-center">
                                    <i class="fa-solid fa-phone icon-1"></i>
                                </div>
                                <div class="vstack gap-1">
                                    <span class="fs-7 fw-medium text-gray-900 dark:text-white">{{ __('Call Us Directly') }}</span>
                                    <div class="vstack gap-1">
                                        @php $phones = explode(',', $bex->contact_numbers); @endphp
                                        @foreach ($phones as $phone)
                                        <a class="uc-link text-gray dark:text-white" href="tel:{{ trim($phone) }}">{{ trim($phone) }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- Email -->
                            <div class="hstack gap-3 items-start">
                                <div class="flex-shrink-0 w-40px h-40px rounded-circle bg-primary text-white d-flex items-center justify-center">
                                    <i class="fa-solid fa-envelope icon-1"></i>
                                </div>
                                <div class="vstack gap-1">
                                    <span class="fs-7 fw-medium text-gray-900 dark:text-white">{{ __('Need Support?') }}</span>
                                    <div class="vstack gap-1">
                                        @php $mails = explode(',', $bex->contact_mails); @endphp
                                        @foreach ($mails as $mail)
                                        <a class="uc-link text-gray dark:text-white" href="mailto:{{ trim($mail) }}">{{ trim($mail) }}</a>
                                        @endforeach
                                    </div>
                                </div>
                            </div>

                            <!-- WhatsApp -->
                            @if(!empty($bex->whatsapp_number))
                            <div class="hstack gap-3 items-start">
                                <div class="flex-shrink-0 w-40px h-40px rounded-circle bg-primary text-white d-flex items-center justify-center">
                                    <i class="fa-brands fa-whatsapp icon-1"></i>
                                </div>
                                <div class="vstack gap-1">
                                    <a class="uc-link text-gray dark:text-white" target="_blank" href="https://wa.me/{{$bex->whatsapp_number}}">{{ __('Start Chat') }}</a>
                                </div>
                            </div>
                            @endif

                            <!-- Address -->
                            @if(!empty($bex->contact_addresses))
                            <div class="hstack gap-3 items-start">
                                <div class="flex-shrink-0 w-40px h-40px rounded-circle bg-primary text-white d-flex items-center justify-center">
                                    <i class="fa-solid fa-location-dot icon-1"></i>
                                </div>
                                <div class="vstack gap-1">
                                    <span class="fs-7 fw-medium text-gray-900 dark:text-white">{{ __('Address') }}</span>
                                    @php $addresses = explode(',', $bex->contact_addresses); @endphp
                                    @foreach ($addresses as $address)
                                    <span class="text-gray dark:text-white">{{ trim($address) }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="pt-4 border-top border-gray-200 dark:border-gray-700">
                            <p class="fs-7 text-gray dark:text-white m-0">
                                {{__('See our')}} <a class="uc-link text-primary" href="#">{{ __('Refund Policies') }}</a> {{ __('or') }} <a class="uc-link text-primary" href="{{ route('front.faq') }}">{{ __('FAQ') }}</a>
                            </p>
                        </div>
                    </div>
                </div>

                <!-- Contact Form Column -->
                <div class="col-lg-8">
                    <div class="panel p-4 lg:p-6 bg-white dark:bg-gray-900 rounded shadow-sm">
                        @if(!empty($bs->contact_form_subtitle))
                        <div class="hstack gap-2 items-center mb-4">
                            <span class="fs-7 text-uppercase fw-medium text-primary opacity-75">{{ convertUtf8($bs->contact_form_subtitle) }}</span>
                            <div class="vr"></div>
                        </div>
                        @endif
                        <h2 class="h3 lg:h-xxl m-0 mb-4 lg:mb-6 text-gray-900 dark:text-white">{{ convertUtf8($bs->contact_form_title) }}</h2>

                        <form id="contact-form" action="{{route('front.sendmail')}}" method="POST">
                            @csrf
                            <div class="vstack gap-3 lg:gap-4">
                                <div class="row g-3">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-medium text-gray-900 dark:text-white mb-1" for="name">{{ __('Full name') }}*</label>
                                            <input name="name" type="text" id="name" class="form-control form-control-md bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="{{__('Name')}}" required>
                                            @if ($errors->has('name'))
                                                <p class="text-danger fs-7 mt-1 mb-0">{{$errors->first('name')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label class="form-label fw-medium text-gray-900 dark:text-white mb-1" for="email">{{ __('Email address') }}*</label>
                                            <input name="email" type="email" id="email" class="form-control form-control-md bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="{{__('Email')}}" required>
                                            @if ($errors->has('email'))
                                                <p class="text-danger fs-7 mt-1 mb-0">{{$errors->first('email')}}</p>
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label fw-medium text-gray-900 dark:text-white mb-1" for="subject">{{ __('Subject') }}*</label>
                                    <input name="subject" type="text" id="subject" class="form-control form-control-md bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="{{__('Subject')}}" required>
                                    @if ($errors->has('subject'))
                                        <p class="text-danger fs-7 mt-1 mb-0">{{$errors->first('subject')}}</p>
                                    @endif
                                </div>
                                
                                <div class="form-group">
                                    <label class="form-label fw-medium text-gray-900 dark:text-white mb-1" for="message">{{ __('How Can We Help You') }}*</label>
                                    <textarea name="message" id="message" rows="6" class="form-control form-control-md bg-white dark:bg-gray-800 dark:border-gray-700 dark:text-white" placeholder="{{__('Comment')}}" required></textarea>
                                    @if ($errors->has('message'))
                                        <p class="text-danger fs-7 mt-1 mb-0">{{$errors->first('message')}}</p>
                                    @endif
                                </div>

                                @if ($bs->is_recaptcha == 1)
                                <div class="form-group">
                                    {!! NoCaptcha::renderJs() !!}
                                    {!! NoCaptcha::display() !!}
                                    @if ($errors->has('g-recaptcha-response'))
                                        @php
                                            $errmsg = $errors->first('g-recaptcha-response');
                                        @endphp
                                        <p class="text-danger fs-7 mt-1 mb-0">{{__("$errmsg")}}</p>
                                    @endif
                                </div>
                                @endif

                                <div class="form-group pt-2">
                                    <button class="btn btn-md btn-primary w-full sm:w-auto" type="submit">
                                        <span class="hstack gap-2 items-center">
                                            <span>{{ __('Send Message') }}</span>
                                            <i class="fa-solid fa-paper-plane icon-1"></i>
                                        </span>
                                    </button>
                                    <p class="ajax-response mt-3 mb-0 fs-7"></p>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </section>
    <!-- Contact information and form section end -->

    <!-- Map section start -->
    @if(!empty($bex->latitude) && !empty($bex->longitude))
    <section class="panel py-8 lg:py-12 bg-white dark:bg-gray-900">
        <div class="container max-w-xl">
            <div class="position-relative rounded overflow-hidden shadow-sm" style="height: 450px;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.1780048614746!2d31.137361874584236!3d30.00304477494443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458456c0c038b8d%3A0x780c651cbdf08e7!2sSEO%20Wolves%20Agency!5e0!2m2!1sen!2seg!4v1752797368460!5m2!1sen!2seg" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
    @else
    <section class="panel py-8 lg:py-12 bg-white dark:bg-gray-900">
        <div class="container max-w-xl">
            <div class="position-relative rounded overflow-hidden shadow-sm" style="height: 450px;">
                <iframe 
                    src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3455.1780048614746!2d31.137361874584236!3d30.00304477494443!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x1458456c0c038b8d%3A0x780c651cbdf08e7!2sSEO%20Wolves%20Agency!5e0!2m2!1sen!2seg!4v1752797368460!5m2!1sen!2seg" 
                    width="100%" 
                    height="100%" 
                    style="border:0;" 
                    allowfullscreen="" 
                    loading="lazy" 
                    referrerpolicy="no-referrer-when-downgrade">
                </iframe>
            </div>
        </div>
    </section>
    @endif
    <!-- Map section end -->

@endsection
