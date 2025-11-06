@extends('front.default.layout')

@section('meta-keywords', "$be->home_meta_keywords")
@section('meta-description', "$be->home_meta_description")


@section('styles')
    <style>
        .services-area {
            padding: 0px;
        }
        .case-section {
            padding: 0px;
        }
        .faq-section {
            padding: 0px;
        }
        .testimonial-section {
            padding-bottom: 0px;
        }
        .pricing-tables {
            padding-top: 0px;
        }
        .blog-section {
            padding: 0px;
        }
        .service-categories {
            padding: 0px;
        }
        .approach-section {
            padding: 0;
        }

        .home-category-section {
            margin-bottom: 50px;
        }

        .category-title {
            font-size: 24px;
            font-weight: 600;
            color: #111013;
            border-bottom: 2px solid #f0f0f0;
            padding-bottom: 15px;
        }

        .home-package-categories-section {
            background-color: #f8f9fa;
        }

    </style>
    @if (!empty($home->css))
    <style>
        {!! replaceBaseUrl($home->css) !!}
    </style>
    @endif
    @if(count($features) == 0)
    <style>
        .intro-section {
            margin-top: 0;
        }
        .hero-txt {
            padding: 310px 270px 165px 0px;
            color: #fff;
            position: relative;
            z-index: 100;
        }
    </style>
    @endif
@endsection


@section('content')
  <!--   hero area start   -->
  @if ($bs->home_version == 'static')
    @include('front.default.partials.static')
  @elseif ($bs->home_version == 'slider')
    @include('front.default.partials.slider')
  @elseif ($bs->home_version == 'video')
    @include('front.default.partials.video')
  @endif
  <!--   hero area end    -->


  <div class="intro-section">
      <div class="container">
        @if (count($features) > 0)
        <div class="hero-features">
            <div class="row">
                @foreach ($features as $key => $feature)
                    <style>
                        .sf{{$feature->id}}::after {
                            background-color: #{{$feature->color}};
                        }
                    </style>
                    <div class="col-md-3 col-sm-6 single-hero-feature sf{{$feature->id}}" style="background-color: #{{$feature->color}};">
                    <div class="outer-container">
                        <div class="inner-container">
                            <div class="icon-wrapper">
                            <i class="{{$feature->icon}}"></i>
                            </div>
                            <h3>{{convertUtf8($feature->title)}}</h3>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
       @endif

      </div>
  </div>

  @if (!empty($home->html))
  {!! convertHtml(convertUtf8($home->html)) !!}
  @else
    @include('front.partials.pagebuilder-notice')
  @endif


@endsection
