@extends('admin.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">{{ __('Free Analysis Page Content') }}</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{route('admin.dashboard')}}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ __('Page Management') }}</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">{{ __('Free Analysis') }}</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-lg-12">
        <div class="card">
            <div class="card-header">
                <h5 class="mb-0">
                    <i class="fas fa-cogs text-primary"></i>
                    {{ __('Free Analysis Page Content') }}
                </h5>
                <p class="text-muted mb-0">{{ __('Customize all content and images for the free analysis page') }}</p>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.free-analysis.update', $lang_id) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <!-- Language Selector -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-language text-info"></i>
                                    {{ __('Current Language') }}
                                </label>
                                <select class="form-control" onchange="window.location.href='{{ route('admin.free-analysis.index') }}?language=' + this.value">
                                    @foreach(\App\Models\Language::all() as $lang)
                                        <option value="{{ $lang->code }}" {{ request()->get('language') == $lang->code ? 'selected' : '' }}>
                                            {{ $lang->name }} ({{ $lang->code }})
                                        </option>
                                    @endforeach
                                </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-eye text-success"></i>
                                    {{ __('Preview Page') }}
                                </label>
                                <div>
                                    <a href="{{ route('free-analysis.index') }}" target="_blank" class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-external-link-alt"></i>
                                        {{ __('View Live Page') }}
                                    </a>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Meta Information Section -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-search"></i>
                                {{ __('SEO Meta Information') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-tags text-warning"></i>
                                    {{ __('Meta Keywords') }}
                                    <small class="text-muted">({{ __('Separate with commas') }})</small>
                                </label>
                                <input type="text" class="form-control" name="free_analysis_meta_keywords" 
                                       value="{{ $abe->free_analysis_meta_keywords }}" 
                                       placeholder="{{ __('e.g., seo analysis, website audit, free tools') }}">
                                <small class="form-text text-muted">{{ __('Keywords for search engine optimization') }}</small>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left text-info"></i>
                                    {{ __('Meta Description') }}
                                    <span class="badge badge-info" id="descCounter">0/160</span>
                                </label>
                                <textarea class="form-control" name="free_analysis_meta_description" rows="3" 
                                          placeholder="{{ __('Enter a compelling description for search engines') }}"
                                          onkeyup="updateCounter(this, 'descCounter', 160)">{{ $abe->free_analysis_meta_description }}</textarea>
                                <small class="form-text text-muted">{{ __('Brief description that appears in search results (max 160 characters)') }}</small>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hero Section -->
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-star"></i>
                                {{ __('Hero Section') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-heading text-primary"></i>
                                    {{ __('Hero Subtitle') }}
                                </label>
                                <input type="text" class="form-control" name="free_analysis_hero_subtitle" 
                                       value="{{ $abe->free_analysis_hero_subtitle }}" 
                                       placeholder="{{ __('e.g., Get Solid Solution') }}">
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="fgorm-label">
                                            <i class="fas fa-font text-primary"></i>
                                            {{ __('Hero Title Part 1') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_title_1" 
                                               value="{{ $abe->free_analysis_hero_title_1 }}" 
                                               placeholder="{{ __('e.g., Reliable &') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-font text-primary"></i>
                                            {{ __('Hero Title Part 2') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_title_2" 
                                               value="{{ $abe->free_analysis_hero_title_2 }}" 
                                               placeholder="{{ __('e.g., Secure Managed') }}">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-font text-primary"></i>
                                            {{ __('Hero Title Part 3') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_title_3" 
                                               value="{{ $abe->free_analysis_hero_title_3 }}" 
                                               placeholder="{{ __('e.g., IT Services.') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-justify text-info"></i>
                                    {{ __('Hero Description') }}
                                </label>
                                <textarea class="form-control" name="free_analysis_hero_description" rows="3" 
                                          placeholder="{{ __('Enter compelling description for hero section') }}">{{ $abe->free_analysis_hero_description }}</textarea>
                            </div>
                            
                            <!-- Buttons Section -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-hand-pointer text-success"></i>
                                            {{ __('Primary Button Text') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_button_1_text" 
                                               value="{{ $abe->free_analysis_hero_button_1_text }}" 
                                               placeholder="{{ __('e.g., Our all Services') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-link text-primary"></i>
                                            {{ __('Primary Button URL') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_button_1_url" 
                                               value="{{ $abe->free_analysis_hero_button_1_url }}" 
                                               placeholder="{{ __('e.g., /services') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-hand-pointer text-info"></i>
                                            {{ __('Secondary Button Text') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_button_2_text" 
                                               value="{{ $abe->free_analysis_hero_button_2_text }}" 
                                               placeholder="{{ __('e.g., Contact us') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-link text-primary"></i>
                                            {{ __('Secondary Button URL') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_hero_button_2_url" 
                                               value="{{ $abe->free_analysis_hero_button_2_url }}" 
                                               placeholder="{{ __('e.g., /contact') }}">
                                    </div>
                                </div>
                            </div>
                            
                            <!-- Form Section -->
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-keyboard text-warning"></i>
                                            {{ __('Form Placeholder Text') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_form_placeholder" 
                                               value="{{ $abe->free_analysis_form_placeholder }}" 
                                               placeholder="{{ __('e.g., Enter your website link') }}">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-search text-success"></i>
                                            {{ __('Analyze Button Text') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_form_button_text" 
                                               value="{{ $abe->free_analysis_form_button_text }}" 
                                               placeholder="{{ __('e.g., Analyze') }}">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Hero Images Section -->
                    <div class="card mb-4 border-warning">
                        <div class="card-header bg-warning text-dark">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-images"></i>
                                {{ __('Hero Section Images') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-primary"></i>
                                            {{ __('Hero Shape 1') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview1">
                                            @if($abe->free_analysis_hero_shape_1)
                                                <img src="{{ asset($abe->free_analysis_hero_shape_1) }}" alt="Current Hero Shape 1" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput1" type="hidden" name="free_analysis_hero_shape_1" value="{{ $abe->free_analysis_hero_shape_1 }}">
                                        <button id="chooseImage1" class="choose-image btn btn-outline-primary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-primary"></i>
                                            {{ __('Hero Shape 2') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview2">
                                            @if($abe->free_analysis_hero_shape_2)
                                                <img src="{{ asset($abe->free_analysis_hero_shape_2) }}" alt="Current Hero Shape 2" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput2" type="hidden" name="free_analysis_hero_shape_2" value="{{ $abe->free_analysis_hero_shape_2 }}">
                                        <button id="chooseImage2" class="choose-image btn btn-outline-primary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal2">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-primary"></i>
                                            {{ __('Hero Shape 3') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview3">
                                            @if($abe->free_analysis_hero_shape_3)
                                                <img src="{{ asset($abe->free_analysis_hero_shape_3) }}" alt="Current Hero Shape 3" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput3" type="hidden" name="free_analysis_hero_shape_3" value="{{ $abe->free_analysis_hero_shape_3 }}">
                                        <button id="chooseImage3" class="choose-image btn btn-outline-primary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal3">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-primary"></i>
                                            {{ __('Hero Shape 4') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview4">
                                            @if($abe->free_analysis_hero_shape_4)
                                                <img src="{{ asset($abe->free_analysis_hero_shape_4) }}" alt="Current Hero Shape 4" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput4" type="hidden" name="free_analysis_hero_shape_4" value="{{ $abe->free_analysis_hero_shape_4 }}">
                                        <button id="chooseImage4" class="choose-image btn btn-outline-primary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal4">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-image text-success"></i>
                                    {{ __('Hero Thumbnail') }}
                                </label>
                                <div class="thumb-preview" id="thumbPreview5">
                                    @if($abe->free_analysis_hero_thumb)
                                        <img src="{{ asset($abe->free_analysis_hero_thumb) }}" alt="Current Hero Thumb" class="img-thumbnail" style="max-height: 150px;">
                                    @else
                                        <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 150px;">
                                    @endif
                                </div>
                                <br>
                                <input id="fileInput5" type="hidden" name="free_analysis_hero_thumb" value="{{ $abe->free_analysis_hero_thumb }}">
                                <button id="chooseImage5" class="choose-image btn btn-outline-success btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal5">
                                    <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step Section -->
                    <div class="card mb-4 border-info">
                        <div class="card-header bg-info text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-list-ol"></i>
                                {{ __('Step Section') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-heading text-info"></i>
                                    {{ __('Step Subtitle') }}
                                </label>
                                <input type="text" class="form-control" name="free_analysis_step_subtitle" 
                                       value="{{ $abe->free_analysis_step_subtitle }}" 
                                       placeholder="{{ __('e.g., How we works') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-font text-info"></i>
                                    {{ __('Step Title') }}
                                </label>
                                <input type="text" class="form-control" name="free_analysis_step_title" 
                                       value="{{ $abe->free_analysis_step_title }}" 
                                       placeholder="{{ __('e.g., Transforming IT, One Step at a Time') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-justify text-info"></i>
                                    {{ __('Step Description') }}
                                </label>
                                <textarea class="form-control" name="free_analysis_step_description" rows="3" 
                                          placeholder="{{ __('Enter step section description') }}">{{ $abe->free_analysis_step_description }}</textarea>
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-1 text-primary"></i>
                                    {{ __('Step 1 Title') }}
                                </label>
                                <input type="text" class="form-control" name="free_analysis_step_1_title" 
                                       value="{{ $abe->free_analysis_step_1_title }}" 
                                       placeholder="{{ __('e.g., Discovery') }}">
                            </div>
                            
                            <div class="form-group">
                                <label class="form-label">
                                    <i class="fas fa-align-left text-primary"></i>
                                    {{ __('Step 1 Description') }}
                                </label>
                                <textarea class="form-control" name="free_analysis_step_1_description" rows="3" 
                                          placeholder="{{ __('Enter step 1 description') }}">{{ $abe->free_analysis_step_1_description }}</textarea>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Step Images Section -->
                    <div class="card mb-4 border-secondary">
                        <div class="card-header bg-secondary text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-images"></i>
                                {{ __('Step Section Images') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-image text-info"></i>
                                            {{ __('Step About Image') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview6">
                                            @if($abe->free_analysis_step_about_1)
                                                <img src="{{ asset($abe->free_analysis_step_about_1) }}" alt="Current Step About" class="img-thumbnail" style="max-height: 120px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 120px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput6" type="hidden" name="free_analysis_step_about_1" value="{{ $abe->free_analysis_step_about_1 }}">
                                        <button id="chooseImage6" class="choose-image btn btn-outline-info btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal6">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-secondary"></i>
                                            {{ __('Step Shape 1') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview7">
                                            @if($abe->free_analysis_step_shape_1)
                                                <img src="{{ asset($abe->free_analysis_step_shape_1) }}" alt="Current Step Shape 1" class="img-thumbnail" style="max-height: 100px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 100px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput7" type="hidden" name="free_analysis_step_shape_1" value="{{ $abe->free_analysis_step_shape_1 }}">
                                        <button id="chooseImage7" class="choose-image btn btn-outline-secondary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal7">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-secondary"></i>
                                            {{ __('Step Shape 2') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview8">
                                            @if($abe->free_analysis_step_shape_2)
                                                <img src="{{ asset($abe->free_analysis_step_shape_2) }}" alt="Current Step Shape 2" class="img-thumbnail" style="max-height: 80px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 80px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput8" type="hidden" name="free_analysis_step_shape_2" value="{{ $abe->free_analysis_step_shape_2 }}">
                                        <button id="chooseImage8" class="choose-image btn btn-outline-secondary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal8">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-secondary"></i>
                                            {{ __('Step Shape 3') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview9">
                                            @if($abe->free_analysis_step_shape_3)
                                                <img src="{{ asset($abe->free_analysis_step_shape_3) }}" alt="Current Step Shape 3" class="img-thumbnail" style="max-height: 80px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 80px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput9" type="hidden" name="free_analysis_step_shape_3" value="{{ $abe->free_analysis_step_shape_3 }}">
                                        <button id="chooseImage9" class="choose-image btn btn-outline-secondary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal9">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-shapes text-secondary"></i>
                                            {{ __('Step Shape 4') }}
                                        </label>
                                        <div class="thumb-preview" id="thumbPreview10">
                                            @if($abe->free_analysis_step_shape_4)
                                                <img src="{{ asset($abe->free_analysis_step_shape_4) }}" alt="Current Step Shape 4" class="img-thumbnail" style="max-height: 80px;">
                                            @else
                                                <img src="{{ asset('assets/admin/img/noimage.jpg') }}" alt="No Image" class="img-thumbnail" style="max-height: 80px;">
                                            @endif
                                        </div>
                                        <br>
                                        <input id="fileInput10" type="hidden" name="free_analysis_step_shape_4" value="{{ $abe->free_analysis_step_shape_4 }}">
                                        <button id="chooseImage10" class="choose-image btn btn-outline-secondary btn-sm" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal10">
                                            <i class="fas fa-upload"></i> {{ __('Choose Image') }}
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- Analysis Form Section -->
                    <div class="card mb-4 border-success">
                        <div class="card-header bg-success text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-clipboard-list"></i>
                                {{ __('Analysis Form') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-heading text-success"></i> {{ __('Form Title') }}</label>
                                <input type="text" class="form-control" name="free_analysis_form_title" value="{{ $abe->free_analysis_form_title }}" placeholder="e.g.: Analyze Your Website Now">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-align-left text-success"></i> {{ __('Form Description') }}</label>
                                <input type="text" class="form-control" name="free_analysis_form_subtitle" value="{{ $abe->free_analysis_form_subtitle }}" placeholder="e.g.: Get a comprehensive and free analysis of your website">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-tag text-success"></i> {{ __('Field Label') }}</label>
                                <input type="text" class="form-control" name="free_analysis_form_label" value="{{ $abe->free_analysis_form_label }}" placeholder="e.g.: Your Website URL">
                            </div>
                            <div class="form-group">
                                <label class="form-label"><i class="fas fa-info-circle text-success"></i> {{ __('Help Text') }}</label>
                                <input type="text" class="form-control" name="free_analysis_form_help" value="{{ $abe->free_analysis_form_help }}" placeholder="e.g.: Enter the full URL of the website you want to analyze">
                            </div>
                            <div class="row mt-4">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-1 text-primary"></i>
                                            {{ __('Feature 1 Title') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_feature_1_title" 
                                               value="{{ $abe->free_analysis_feature_1_title }}" 
                                               placeholder="e.g.: Comprehensive Analysis">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><i class="fas fa-shield-alt text-info"></i> {{ __('Feature 1 Description') }}</label>
                                        <input type="text" class="form-control" name="free_analysis_feature_1_desc" value="{{ $abe->free_analysis_feature_1_desc }}" placeholder="e.g.: 100% Secure Analysis">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-2 text-success"></i>
                                            {{ __('Feature 2 Title') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_feature_2_title" 
                                               value="{{ $abe->free_analysis_feature_2_title }}" 
                                               placeholder="e.g.: Performance Metrics">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><i class="fas fa-bolt text-info"></i> {{ __('Feature 2 Description') }}</label>
                                        <input type="text" class="form-control" name="free_analysis_feature_2_desc" value="{{ $abe->free_analysis_feature_2_desc }}" placeholder="e.g.: Instant Results">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label">
                                            <i class="fas fa-3 text-info"></i>
                                            {{ __('Feature 3 Title') }}
                                        </label>
                                        <input type="text" class="form-control" name="free_analysis_feature_3_title" 
                                               value="{{ $abe->free_analysis_feature_3_title }}" 
                                               placeholder="e.g.: Actionable Recommendations">
                                    </div>
                                    <div class="form-group">
                                        <label class="form-label"><i class="fas fa-chart-line text-info"></i> {{ __('Feature 3 Description') }}</label>
                                        <input type="text" class="form-control" name="free_analysis_feature_3_desc" value="{{ $abe->free_analysis_feature_3_desc }}" placeholder="e.g.: All SEO Elements">
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Feature Cards Section -->
                    <div class="card mb-4 border-primary">
                        <div class="card-header bg-primary text-white">
                            <h6 class="mb-0 text-white" style="    font-size: 18px !important;">
                                <i class="fas fa-th-large"></i>
                                {{ __('Feature Cards') }}
                            </h6>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                @for($i = 1; $i <= 6; $i++)
                                    <div class="col-md-4 mb-4">
                                        <div class="border rounded p-3 h-100">
                                            <div class="form-group">
                                                <label class="form-label"><i class="fas fa-star text-warning"></i> {{ __('Card Title') }} {{ $i }}</label>
                                                <input type="text" class="form-control" name="free_analysis_feature_card_{{ $i }}_title" value="{{ $abe->{'free_analysis_feature_card_'.$i.'_title'} }}" placeholder="e.g.: ...">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label"><i class="fas fa-align-left text-info"></i> {{ __('Card Description') }} {{ $i }}</label>
                                                <input type="text" class="form-control" name="free_analysis_feature_card_{{ $i }}_desc" value="{{ $abe->{'free_analysis_feature_card_'.$i.'_desc'} }}" placeholder="e.g.: ...">
                                            </div>
                                        </div>
                                    </div>
                                @endfor
                            </div>
                        </div>
                    </div>
                    
                    
                    <!-- Submit Button -->
                    <div class="form-group text-center">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save"></i>
                            {{ __('Update Free Analysis Page') }}
                        </button>
                        <a href="{{ route('admin.dashboard') }}" class="btn btn-secondary btn-lg ml-2">
                            <i class="fas fa-times"></i>
                            {{ __('Cancel') }}
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- File Manager Modals -->
<div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=1" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal2" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=2" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal3" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=3" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal4" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=4" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal5" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=5" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal6" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=6" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal7" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=7" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal8" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=8" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal9" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=9" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

<div class="modal fade lfm-modal" id="lfmModal10" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=10" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>

@endsection

@section('scripts')
<script>
// Character counter for meta description
function updateCounter(textarea, counterId, maxLength) {
    const counter = document.getElementById(counterId);
    const currentLength = textarea.value.length;
    counter.textContent = currentLength + '/' + maxLength;
    
    if (currentLength > maxLength) {
        counter.className = 'badge badge-danger';
    } else if (currentLength > maxLength * 0.8) {
        counter.className = 'badge badge-warning';
    } else {
        counter.className = 'badge badge-info';
    }
}

// Initialize counters on page load
document.addEventListener('DOMContentLoaded', function() {
    const descTextarea = document.querySelector('textarea[name="free_analysis_meta_description"]');
    if (descTextarea) {
        updateCounter(descTextarea, 'descCounter', 160);
    }
});

// File manager integration
document.addEventListener('DOMContentLoaded', function() {
    // Handle file selection from file manager
    window.addEventListener('message', function(e) {
        if (e.data.action === 'useFile') {
            const fileInput = document.getElementById('fileInput' + e.data.serial);
            const thumbPreview = document.getElementById('thumbPreview' + e.data.serial);
            
            if (fileInput && thumbPreview) {
                fileInput.value = e.data.url;
                thumbPreview.innerHTML = '<img src="' + e.data.url + '" alt="Selected Image" class="img-thumbnail" style="max-height: 100px;">';
            }
        }
    });
});
</script>
@endsection 