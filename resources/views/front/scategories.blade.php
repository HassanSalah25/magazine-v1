@extends("front.$version.layout")

@section('pagename')
    -
    @if (empty($category))
        {{__('All')}}
    @else
        {{$category->name}}
    @endif
    {{__('Services')}}
@endsection

@section('meta-keywords', "$be->scategories_meta_keywords")
@section('meta-description', "$be->scategories_meta_description")

@section('content')
    @section('breadcrumb-title', convertUtf8($bs->service_title))
    @section('breadcrumb-subtitle', convertUtf8($bs->service_subtitle))
    @section('breadcrumb-link', __('Services'))

    <div class="service-section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8">
                    <div class="row">
                        @if ($categories->count() == 0)
                            <div class="col-12 bg-light py-5">
                                <h3 class="text-center">{{__('NO SERVICE FOUND')}}</h3>
                            </div>
                        @else
                            @foreach ($categories as $category)
                                <div class="col-md-6">
                                    <div class="single-service">
                                        <div class="service-img-wrapper">
                                            <img loading="lazy" src="{{ $category->image ? asset('assets/front/img/service_category_icons/' . $category->image) : asset('assets/front/img/placeholder.png') }}" alt="{{ $category->title }}">
                                        </div>
                                        <div class="service-txt">
                                            <h4 class="service-title">
                                                <a href="{{ route('front.servicedetails', [$category->slug]) }}">
                                                    {{ \Illuminate\Support\Str::limit(convertUtf8($category->name), 18, '...') }}
                                                </a>
                                            </h4>

                                            <p class="service-summary">
                                                @if (strlen($category->short_text) > 120)
                                                    {{ mb_substr($category->short_text, 0, 120, 'utf-8') }}
                                                    <span class="extra-text" style="display: none;">{{ mb_substr($category->short_text, 120, null, 'utf-8') }}</span>
                                                    <a href="#" class="see-more">{{__('see more')}}...</a>
                                                @else
                                                    {{ $category->short_text }}
                                                @endif
                                            </p>

                                            <a href="{{ route('front.servicedetails', [$category->slug]) }}" class="readmore-btn"><span>{{__('Read More')}}</span></a>

                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @endif
                    </div>
                    <div class="row">
                        <div class="col-md-12">
                            <nav class="pagination-nav">
                                {{ $categories->appends(['category' => request()->input('category'), 'term' => request()->input('term')])->links() }}
                            </nav>
                        </div>
                    </div>
                </div>

                <div class="col-lg-4">
                    <div class="blog-sidebar-widgets">
                        <div class="searchbar-form-section">
                            <form action="{{ route('front.scategories') }}">
                                <div class="searchbar">
                                    <input name="category" type="hidden" value="{{ request()->input('category') }}">
                                    <input name="term" type="text" placeholder="{{__('Search Services')}}" value="{{ request()->input('term') }}">
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
                                    @foreach ($scats as $scat)
                                        <li class="single-category {{ $scat->id == request()->input('category') ? 'active' : '' }}">
                                            <a href="{{ route('front.scategories', ['category' => $scat->id, 'term' => request()->input('term')]) }}">{{ convertUtf8($scat->name) }}</a>
                                        </li>
                                    @endforeach
                                </ul>
                            </div>
                        </div>
                    @endif

                    <div class="subscribe-section">
                        <span>{{__('SUBSCRIBE')}}</span>
                        <h3>{{__('SUBSCRIBE FOR NEWSLETTER')}}</h3>
                        <form id="subscribeForm" class="subscribe-form" action="{{ route('front.subscribe') }}" method="POST">
                            @csrf
                            <div class="form-element"><input name="email" type="email" placeholder="{{__('Email')}}"></div>
                            <p id="erremail" class="text-danger mb-3 err-email"></p>
                            <div class="form-element"><input type="submit" value="{{__('Subscribe')}}"></div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function () {
                document.querySelectorAll('.see-more').forEach(link => {
                    link.addEventListener('click', function (e) {
                        e.preventDefault();
                        const extra = this.previousElementSibling;
                        if (extra && extra.style.display === 'none') {
                            extra.style.display = 'inline';
                            this.style.display = 'none';
                        }
                    });
                });
            });
        </script>
    @endpush
@endsection
