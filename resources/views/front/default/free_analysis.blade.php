@extends('front.default.layout')
@section('meta-keywords', "$be->free_analysis_meta_keywords")
@section('meta-description', "$be->free_analysis_meta_description")

@section('content')
    <!-- hero area start -->
    <div class="it-hero-area p-relative fix">
        <div class="it-hero-shape-wrap">
                        <span class="it-hero-shape-1">
                            <svg width="1920" height="130" viewBox="0 0 1920 130" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M317.674 0.916147L-15.8393 82.1342C-21.2159 83.4435 -25 88.2597 -25 93.7935V117.029C-25 123.656 -19.6275 129.029 -13 129.029H1963C1969.63 129.029 1975 123.656 1975 117.029V43.9925C1975 36.2794 1967.83 30.5693 1960.31 32.2977L1682.73 96.1228C1676.4 97.5795 1670.06 93.7274 1668.43 87.4346L1648.28 9.56974C1646.63 3.21847 1640.19 -0.635465 1633.82 0.917341L1245.76 95.4533C1239.43 96.9954 1233.02 93.2046 1231.33 86.9132L1210.33 8.88425C1208.64 2.60589 1202.26 -1.18461 1195.93 0.335915L804.696 94.4413C798.331 95.9723 791.914 92.1194 790.273 85.7819L770.671 10.0717C769.027 3.72499 762.595 -0.128182 756.224 1.418L366.694 95.9521C360.323 97.4984 353.89 93.6446 352.247 87.2973L332.13 9.5688C330.487 3.2179 324.048 -0.636036 317.674 0.916147Z" fill="#00a651" />
                            </svg>
                        </span>
            <img class="it-hero-shape-2" src="{{ $be->free_analysis_hero_shape_4 ? asset($be->free_analysis_hero_shape_4) : asset('front/assets/img/home-11/hero/hero-shape-4.png') }}" alt="">
        </div>
        <div class="container container-1630">
            <div class="row align-items-center">
                <div class="col-xl-6">
                    <div class="it-hero-content it-hero-ptb">
                        <span class="it-hero-subtitle tp_fade_anim" data-delay=".3">{{ $be->free_analysis_hero_subtitle ?? __('Free SEO Analysis') }}</span>
                        <h4 class="it-hero-title tp_fade_anim" data-delay=".5">
                            {{ $be->free_analysis_hero_title_1 ?? __('Comprehensive Analysis') }}
                            <span><img class="img-1" src="{{ $be->free_analysis_hero_shape_1 ? asset($be->free_analysis_hero_shape_1) : asset('front/assets/img/home-11/hero/hero-shape-1.png') }}" alt=""></span><br>
                            {{ $be->free_analysis_hero_title_2 ?? __('For Your Website') }} <br>
                            <span><img class="img-2" src="{{ $be->free_analysis_hero_shape_2 ? asset($be->free_analysis_hero_shape_2) : asset('front/assets/img/home-11/hero/hero-shape-2.png') }}" alt=""></span>
                            {{ $be->free_analysis_hero_title_3 ?? __('and Search Engines.') }}
                        </h4>
                        <div class="tp_fade_anim" data-delay=".7">
                            <p>{{ $be->free_analysis_hero_description ?? __('Get a comprehensive analysis of your website and discover strengths and weaknesses in SEO') }}</p>
                        </div>
                        
                        <div class="it-hero-btn-box d-flex align-items-center flex-wrap mt-4">
                            <div class="tp_fade_anim" data-delay=".5" data-fade-from="top" data-ease="bounce">
                                <a class="tp-btn-black-radius btn-blue-bg  d-inline-flex align-items-center justify-content-between mr-15" href="{{ $be->free_analysis_hero_button_1_url ?? route('front.scategories') }}">
                                                <span>
                                                    <span class="text-1">{{ $be->free_analysis_hero_button_1_text ?? __('Our Services') }}</span>
                                                    <span class="text-2">{{ $be->free_analysis_hero_button_1_text ?? __('Our Services') }}</span>
                                                </span>
                                    <i>
                                                    <span>
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#21212D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg width="12" height="12" viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M1 11L11 1M11 1H1M11 1V11" stroke="#21212D" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                    </i>
                                </a>
                            </div>
                            <div class="tp_fade_anim" data-delay=".7" data-fade-from="top" data-ease="bounce">
                                <a class="tp-btn-black-radius btn-border d-inline-flex align-items-center justify-content-between" href="{{ $be->free_analysis_hero_button_2_url ?? route('front.contact') }}">
                                                <span>
                                                    <span class="text-1">{{ $be->free_analysis_hero_button_2_text ?? __('Contact Us') }}</span>
                                                    <span class="text-2">{{ $be->free_analysis_hero_button_2_text ?? __('Contact Us') }}</span>
                                                </span>
                                    <i>
                                                    <span>
                                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 2.5C16 1.675 15.325 1 14.5 1H2.5C1.675 1 1 1.675 1 2.5M16 2.5V11.5C16 12.325 15.325 13 14.5 13H2.5C1.675 13 1 12.325 1 11.5V2.5M16 2.5L8.5 7.75L1 2.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                        <svg width="17" height="14" viewBox="0 0 17 14" fill="none" xmlns="http://www.w3.org/2000/svg">
                                                            <path d="M16 2.5C16 1.675 15.325 1 14.5 1H2.5C1.675 1 1 1.675 1 2.5M16 2.5V11.5C16 12.325 15.325 13 14.5 13H2.5C1.675 13 1 12.325 1 11.5V2.5M16 2.5L8.5 7.75L1 2.5" stroke="white" stroke-width="2" stroke-linecap="round" stroke-linejoin="round" />
                                                        </svg>
                                                    </span>
                                    </i>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-xl-6">
                    <div class="it-hero-thumb p-relative mb-35">
                        <div class="tp_fade_anim" data-delay=".5" data-fade-from="right">
                            <img data-speed=".9" src="{{ $be->free_analysis_hero_thumb ? asset($be->free_analysis_hero_thumb) : asset('front/assets/img/home-11/hero/hero-thumb.png') }}" alt="">
                        </div>
                        <img data-speed="1.1" class="inner-img tp_fade_anim" data-delay=".7" data-fade-from="top" src="{{ $be->free_analysis_hero_shape_3 ? asset($be->free_analysis_hero_shape_3) : asset('front/assets/img/home-11/hero/hero-shape-3.png') }}" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- hero area end -->

    <!-- Analysis Form Section -->
    <div class="analysis-form-section py-5" style="background: linear-gradient(135deg, #00a651 0%, #008f45 100%);">
        <div class="container">
            <div class="row justify-content-center">
                <div class="col-lg-8 col-md-10">
                    <div class="analysis-form-card">
                        <div class="form-header text-center mb-5">
                            <div class="form-icon mb-3">
                                <i class="bi bi-search-heart"></i>
                            </div>
                            <h2 class="form-title">{{ $be->free_analysis_form_title ?? __('Analyze Your Website Now') }}</h2>
                            <p class="form-subtitle">{{ $be->free_analysis_form_subtitle ?? __('Get a comprehensive and free analysis of your website') }}</p>
                        </div>

                        @if($errors->any())
                            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                <strong>Error!</strong> Please correct the following errors:
                                <ul class="mb-0 mt-2">
                                    @foreach($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                                <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                            </div>
                        @endif

                        <form action="{{ route('seo.analyze') }}" method="POST" class="analysis-form">
                            @csrf
                            <div class="form-group mb-4">
                                <label for="website" class="form-label">
                                    <i class="bi bi-globe me-2"></i>
                                    {{ $be->free_analysis_form_label ?? __('Your Website URL') }}
                                </label>
                                <div class="input-group input-group-lg">
                                    <span class="input-group-text">
                                        <i class="bi bi-link-45deg"></i>
                                    </span>
                                    <input type="url" 
                                           name="website" 
                                           id="website"
                                           class="form-control" 
                                           placeholder="{{ $be->free_analysis_form_placeholder ?? __('e.g.: https://example.com') }}" 
                                           required
                                           value="{{ old('website') }}"
                                           autocomplete="url">
                                </div>
                                <div class="form-text">
                                    <i class="bi bi-info-circle me-1"></i>
                                    {{ $be->free_analysis_form_help ?? __('Enter the full URL of the website you want to analyze') }}
                                </div>
                            </div>

                            <div class="form-actions text-center">
                                <button type="submit" class="btn btn-analyze">
                                    <i class="bi bi-graph-up me-2"></i>
                                    {{ $be->free_analysis_form_button_text ?? __('Start Analysis') }}
                                    <div class="btn-ripple"></div>
                                </button>
                            </div>
                        </form>

                        <div class="form-features mt-5">
                            <div class="row text-center">
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="bi bi-shield-check"></i>
                                        <h6>{{ $be->free_analysis_feature_1_title ?? __('Safe & Free') }}</h6>
                                        <small>{{ $be->free_analysis_feature_1_desc ?? __('100% Secure Analysis') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="bi bi-lightning-charge"></i>
                                        <h6>{{ $be->free_analysis_feature_2_title ?? __('Fast & Accurate') }}</h6>
                                        <small>{{ $be->free_analysis_feature_2_desc ?? __('Instant Results') }}</small>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="feature-item">
                                        <i class="bi bi-graph-up-arrow"></i>
                                        <h6>{{ $be->free_analysis_feature_3_title ?? __('Comprehensive Analysis') }}</h6>
                                        <small>{{ $be->free_analysis_feature_3_desc ?? __('All SEO Elements') }}</small>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Features Section -->
    <div class="it-step-area it-step-bg paste-bg-2 p-relative pt-120 pb-140">
        <div class="it-step-shape-1">
            <img data-speed="1.1" src="{{ $be->free_analysis_step_shape_3 ? asset($be->free_analysis_step_shape_3) : asset('front/assets/img/home-11/step/about-shape-3.png') }}" alt="">
        </div>
        <div class="it-step-shape-2 d-none d-xxl-block">
            <img data-speed="1.1" src="{{ $be->free_analysis_step_shape_4 ? asset($be->free_analysis_step_shape_4) : asset('front/assets/img/home-11/step/about-shape-4.png') }}" alt="">
        </div>
        <div class="container container-1230">
            <div class="row justify-content-center">
                <div class="col-xl-10">
                    <div class="it-step-title-box z-index-1 text-center mb-105">
                        <span class="tp-section-subtitle-platform mb-20 tp-split-text tp-split-right">{{ $be->free_analysis_step_subtitle ?? __('What We Analyze') }}</span>
                        <h4 class="tp-section-title-platform mb-20 tp-split-text tp-split-right">{{ $be->free_analysis_step_title ?? __('Comprehensive Analysis of All SEO Elements') }}</h4>
                        <div class="tp_text_anim">
                            <p>
                                {{ $be->free_analysis_step_description ?? __('We provide a detailed analysis of all important SEO elements for your website') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- Features Grid -->
            <div class="row g-4">
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-speedometer2"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_1_title ?? __('Website Speed') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_1_desc ?? __('Comprehensive analysis of website loading speed using Google PageSpeed Insights') }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-tags"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_2_title ?? __('Meta Tags') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_2_desc ?? __('Check titles, descriptions, keywords, and meta tags') }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-link-45deg"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_3_title ?? __('Link Analysis') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_3_desc ?? __('Check internal, external, and broken links') }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-image"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_4_title ?? __('Image Analysis') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_4_desc ?? __('Check images, alt texts, and image dimensions') }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-list-check"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_5_title ?? __('Heading Structure') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_5_desc ?? __('Analyze heading structure H1-H6 and content organization') }}</p>
                    </div>
                </div>
                
                <div class="col-md-4">
                    <div class="feature-card">
                        <div class="feature-icon">
                            <i class="bi bi-share"></i>
                        </div>
                        <h5>{{ $be->free_analysis_feature_card_6_title ?? __('Social Media') }}</h5>
                        <p>{{ $be->free_analysis_feature_card_6_desc ?? __('Check Open Graph and Twitter Cards tags') }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Features Section end -->
@endsection

<style>
/* Analysis Form Styling */
.analysis-form-section {
    position: relative;
    overflow: hidden;
}

.analysis-form-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="25" cy="25" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="75" cy="75" r="1" fill="rgba(255,255,255,0.1)"/><circle cx="50" cy="10" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="10" cy="60" r="0.5" fill="rgba(255,255,255,0.1)"/><circle cx="90" cy="40" r="0.5" fill="rgba(255,255,255,0.1)"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
    opacity: 0.3;
}

.analysis-form-card {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border-radius: 20px;
    padding: 3rem;
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(255, 255, 255, 0.2);
    position: relative;
    overflow: hidden;
}

.analysis-form-card::before {
    content: '';
    position: absolute;
    top: -50%;
    left: -50%;
    width: 200%;
    height: 200%;
    background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.1), transparent);
    transform: rotate(45deg);
    animation: shimmer 3s infinite;
}

@keyframes shimmer {
    0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
    100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
}

.form-header {
    position: relative;
    z-index: 2;
}

.form-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #00a651, #008f45);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto;
    box-shadow: 0 10px 30px rgba(0, 166, 81, 0.3);
}

.form-title {
    color: #2d3748;
    font-weight: 700;
    margin-bottom: 0.5rem;
    font-size: 2.5rem;
}

.form-subtitle {
    color: #718096;
    font-size: 1.1rem;
    margin-bottom: 0;
}

.analysis-form {
    position: relative;
    z-index: 2;
}

.form-group {
    position: relative;
}

.form-label {
    font-weight: 600;
    color: #2d3748;
    margin-bottom: 0.75rem;
    font-size: 1.1rem;
}

.input-group-text {
    background: linear-gradient(135deg, #00a651, #008f45);
    border: none;
    color: white;
    font-size: 1.2rem;
}

.form-control {
    border: 2px solid #e2e8f0;
    border-radius: 12px;
    padding: 1rem 1.5rem;
    font-size: 1.1rem;
    transition: all 0.3s ease;
    background: rgba(255, 255, 255, 0.9);
}

.form-control:focus {
    border-color: #00a651;
    box-shadow: 0 0 0 3px rgba(0, 166, 81, 0.1);
    background: white;
}

.form-text {
    color: #718096;
    font-size: 0.9rem;
    margin-top: 0.5rem;
}

.btn-analyze {
    background: linear-gradient(135deg, #00a651 0%, #008f45 100%);
    border: none;
    border-radius: 50px;
    padding: 1rem 3rem;
    font-size: 1.2rem;
    font-weight: 600;
    color: white;
    position: relative;
    overflow: hidden;
    transition: all 0.3s ease;
    box-shadow: 0 10px 30px rgba(0, 166, 81, 0.3);
}

.btn-analyze:hover {
    transform: translateY(-3px);
    box-shadow: 0 15px 40px rgba(0, 166, 81, 0.4);
    color: white;
}

.btn-analyze:active {
    transform: translateY(-1px);
}

.btn-ripple {
    position: absolute;
    top: 50%;
    left: 50%;
    width: 0;
    height: 0;
    border-radius: 50%;
    background: rgba(255, 255, 255, 0.3);
    transform: translate(-50%, -50%);
    transition: width 0.6s, height 0.6s;
}

.btn-analyze:hover .btn-ripple {
    width: 300px;
    height: 300px;
}

.form-features {
    position: relative;
    z-index: 2;
}

.feature-item {
    padding: 1.5rem;
    border-radius: 15px;
    background: rgba(255, 255, 255, 0.8);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(255, 255, 255, 0.2);
    transition: all 0.3s ease;
}

.feature-item:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
}

.tp-btn-black-radius i span{
    margin: 15px;
}


.feature-item h6 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 0.5rem;
}

.feature-item small {
    color: #718096;
}

/* Feature Cards Styling */
.feature-card {
    background: white;
    border-radius: 20px;
    padding: 2.5rem 2rem;
    text-align: center;
    box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
    border: 1px solid rgba(0, 0, 0, 0.05);
    transition: all 0.3s ease;
    height: 100%;
    position: relative;
    overflow: hidden;
}

.feature-card::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    height: 4px;
    background: linear-gradient(135deg, #00a651, #008f45);
}

.feature-card:hover {
    transform: translateY(-10px);
    box-shadow: 0 20px 40px rgba(0, 0, 0, 0.15);
}

.feature-icon {
    width: 80px;
    height: 80px;
    background: linear-gradient(135deg, #00a651, #008f45);
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    box-shadow: 0 10px 30px rgba(0, 166, 81, 0.3);
}


.feature-card h5 {
    color: #2d3748;
    font-weight: 600;
    margin-bottom: 1rem;
    font-size: 1.3rem;
}

.feature-card p {
    color: #718096;
    line-height: 1.6;
    margin-bottom: 0;
}

/* Responsive Design */
@media (max-width: 768px) {
    .analysis-form-card {
        padding: 2rem;
        margin: 1rem;
    }
    
    .form-title {
        font-size: 2rem;
    }
    
    .btn-analyze {
        padding: 0.8rem 2rem;
        font-size: 1.1rem;
    }
    
    .feature-card {
        padding: 2rem 1.5rem;
    }
}

/* Loading Animation */
.btn-analyze.loading {
    pointer-events: none;
}

.btn-analyze.loading::after {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    width: 20px;
    height: 20px;
    margin: -10px 0 0 -10px;
    border: 2px solid transparent;
    border-top: 2px solid white;
    border-radius: 50%;
    animation: spin 1s linear infinite;
}

@keyframes spin {
    0% { transform: rotate(0deg); }
    100% { transform: rotate(360deg); }
}
</style>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const form = document.querySelector('.analysis-form');
    const submitBtn = document.querySelector('.btn-analyze');
    
    form.addEventListener('submit', function() {
        submitBtn.classList.add('loading');
        submitBtn.innerHTML = '<i class="bi bi-hourglass-split me-2"></i>Analyzing...';
    });
    
    // Add ripple effect to button
    submitBtn.addEventListener('click', function(e) {
        const ripple = this.querySelector('.btn-ripple');
        const rect = this.getBoundingClientRect();
        const x = e.clientX - rect.left;
        const y = e.clientY - rect.top;
        
        ripple.style.left = x + 'px';
        ripple.style.top = y + 'px';
    });
});
</script>
