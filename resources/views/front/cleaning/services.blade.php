@extends('front.cleaning.layout')

@section('pagename')
 -
 @if (empty($category))
 {{__('All')}}
 @else
 {{$category->name}}
 @endif
 {{__('Services')}}
@endsection

@section('meta-keywords', "$be->services_meta_keywords")
@section('meta-description', "$be->services_meta_description")

@section('breadcrumb-title', convertUtf8($bs->service_title))
@section('breadcrumb-subtitle', $bs->service_subtitle)
@section('breadcrumb-link', __('Services'))

@section('content')

  <!--    services section start   -->
  <div class="service-section">
     <div class="container">
        <div class="row">
           <div class="col-lg-8">
              <section class="pt-120 pb-120">
                <div class="service-carousel-active">
                    <div class="row">
                        @if (count($services) == 0)
                            <div class="col-12 bg-light py-5">
                                <h3 class="text-center">{{__('NO SERVICE FOUND')}}</h3>
                            </div>
                        @else
                        @foreach ($services as $key => $service)
                            <div class="col-lg-6 mb-5">
                                <div class="single-service-item mx-0">
                                    @if (!empty($service->main_image))
                                        <div class="single-service-bg">
                                            <img class="lazy" data-src="{{asset('assets/front/img/services/' . $service->main_image)}}" alt="">
                                            <span><i class="fas fa-quidditch"></i></span>
                                            @if($service->details_page_status == 1)
                                                <div class="single-service-link">
                                                    <a href="{{route('front.servicedetails', [$service->slug])}}" class="main-btn service-btn">{{__('View More')}}</a>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="single-service-content">
                                            <h4>{{convertUtf8($service->title)}}</h4>
                                            <p>
                                                @if (strlen(convertUtf8($service->summary)) > 100)
                                                   {{mb_substr($service->summary, 0, 100, 'utf-8')}}<span style="display: none;">{{mb_substr($service->summary, 100, null, 'utf-8')}}</span>
                                                   <a href="#" class="see-more">{{__('see more')}}...</a>
                                                @else
                                                   {{convertUtf8($service->summary)}}
                                                @endif
                                            </p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                        @endif
                    </div>
                </div>

                @if(isset($packages) && count($packages) > 0)
                <!-- Packages Section -->
                <div class="row mt-5">
                    <div class="col-12">
                        <h3 class="mb-4">{{__('Packages')}}</h3>
                    </div>
                    @foreach($packages as $package)
                    <div class="col-lg-4 col-md-6 mb-4">
                        <div class="card h-100">
                            @if(!empty($package->image))
                            <img src="{{asset('assets/front/img/packages/' . $package->image)}}" class="card-img-top" alt="{{$package->title}}" style="height: 200px; object-fit: cover;">
                            @endif
                            <div class="card-body d-flex flex-column">
                                <h5 class="card-title">{{convertUtf8($package->title)}}</h5>
                                <p class="card-text flex-grow-1">
                                    @if(strlen(convertUtf8($package->description)) > 100)
                                        {{mb_substr(strip_tags(convertUtf8($package->description)), 0, 100, 'utf-8')}}...
                                    @else
                                        {{strip_tags(convertUtf8($package->description))}}
                                    @endif
                                </p>
                                <div class="mt-auto">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="h4 text-primary mb-0">{{(int)$package->price}} {{$abx->base_currency_text ?? '$'}}</span>
                                        @if($package->order_status == 1)
                                            <a href="{{route('front.packageorder', $package->id)}}" class="btn btn-primary">{{__('Order Now')}}</a>
                                        @elseif($package->order_status == 2)
                                            <a href="{{$package->link}}" class="btn btn-primary" target="_blank">{{__('View Details')}}</a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                    <nav class="pagination-nav">
                        {{$services->appends(['category' => request()->input('category'), 'term' => request()->input('term')])->links()}}
                    </nav>
                    </div>
                </div>
              </section>
           </div>
           <!--    service sidebar start   -->
           <div class="col-lg-4 pt-115 pb-120">
             <div class="blog-sidebar-widgets">
                <div class="searchbar-form-section">
                   <form action="{{route('front.services')}}">
                      <div class="searchbar">
                         <input name="category" type="hidden" value="{{request()->input('category')}}">
                         <input name="term" type="text" placeholder="{{__('Search Services')}}" value="{{request()->input('term')}}">
                         <button type="submit"><i class="fa fa-search"></i></button>
                      </div>
                   </form>
                </div>
             </div>
             @if (serviceCategory())
             <div class="blog-sidebar-widgets category-widget">
                <div class="category-lists job">
                   <h4>{{__('Categories')}}</h4>
                   <ul>
                     @foreach ($scats as $key => $scat)
                       <li class="single-category {{$scat->id == request()->input('category') ? 'active' : ''}}"><a href="{{route('front.services', ['category' => $scat->id, 'term'=>request()->input('term')])}}">{{convertUtf8($scat->name)}}</a></li>
                     @endforeach
                   </ul>
                </div>
             </div>
             @endif
             <div class="subscribe-section">
                <span>{{__('SUBSCRIBE')}}</span>
                <h3>{{__('SUBSCRIBE FOR NEWSLETTER')}}</h3>
                <form id="subscribeForm" class="subscribe-form" action="{{route('front.subscribe')}}" method="POST">
                   @csrf
                   <div class="form-element"><input name="email" type="email" placeholder="{{__('Email')}}"></div>
                   <p id="erremail" class="text-danger mb-3 err-email"></p>
                   <div class="form-element"><input type="submit" value="{{__('Subscribe')}}"></div>
                </form>
             </div>
           </div>
           <!--    service sidebar end   -->
        </div>
     </div>
  </div>
  <!--    services section end   -->
@endsection
