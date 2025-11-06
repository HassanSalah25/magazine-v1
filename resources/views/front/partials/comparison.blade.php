@php
    $lang = App\Models\Language::where('code', request()->input('language'))->first();
    if (!$lang) {
        $lang = App\Models\Language::where('is_default', 1)->first();
    }
    $abex = $lang->basic_extra;
@endphp

@if($abex->comparison_section == 1 && (!empty($abex->comparison_title) || !empty($abex->webfx_title)))
<!-- Comparison Section Start -->
<section class="comparison-section py-5" style="background-color: #f8f9fa;">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-lg-10">
                @if(!empty($abex->comparison_title))
                <div class="text-center mb-5">
                    <h2 class="display-4 font-weight-bold text-dark mb-3">
                        {{ convertUtf8($abex->comparison_title) }}
                    </h2>
                    @if(!empty($abex->comparison_subtitle))
                    <p class="lead text-muted">{{ convertUtf8($abex->comparison_subtitle) }}</p>
                    @endif
                </div>
                @endif

                <div class="row">
                    <!-- SEO Wolves Column -->
                    <div class="col-lg-4 mb-4">
                        <div class="comparison-card h-100 position-relative" style="background: linear-gradient(135deg, #e3f2fd 0%, #bbdefb 100%); border-radius: 15px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1);">
                            <!-- Decorative element -->
                            <div style="position: absolute; top: -10px; right: -10px; width: 60px; height: 60px; background: linear-gradient(45deg, #2196f3, #21cbf3); border-radius: 50%; opacity: 0.1;"></div>
                            
                            <div class="text-center mb-4">
                                <h3 class="h4 font-weight-bold text-primary mb-2">
                                    {{ convertUtf8($abex->webfx_title ?? 'WebFX') }}
                                </h3>
                            </div>
                            
                            <div class="features-list">
                                @if(!empty($abex->webfx_features))
                                    @foreach($abex->webfx_features as $feature)
                                    <div class="feature-item d-flex align-items-start mb-3">
                                        <div class="feature-icon mr-3 mt-1">
                                            @if($feature['type'] == 'check')
                                                <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </div>
                                        <div class="feature-text">
                                            <p class="mb-0 text-dark">{{ convertUtf8($feature['text']) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Typical SEO Agency Column -->
                    <div class="col-lg-4 mb-4">
                        <div class="comparison-card h-100" style="background: #fff; border-radius: 15px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #ffc107;">
                            <div class="text-center mb-4">
                                <h3 class="h4 font-weight-bold text-warning mb-2">
                                    {{ convertUtf8($abex->typical_seo_title ?? 'Typical SEO agency') }}
                                </h3>
                            </div>
                            
                            <div class="features-list">
                                @if(!empty($abex->typical_seo_features))
                                    @foreach($abex->typical_seo_features as $feature)
                                    <div class="feature-item d-flex align-items-start mb-3">
                                        <div class="feature-icon mr-3 mt-1">
                                            @if($feature['type'] == 'check')
                                                <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </div>
                                        <div class="feature-text pl-1">
                                            <p class="mb-0 text-dark">{{ convertUtf8($feature['text']) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- In-house SEO Column -->
                    <div class="col-lg-4 mb-4">
                        <div class="comparison-card h-100" style="background: #fff; border-radius: 15px; padding: 2rem; box-shadow: 0 10px 30px rgba(0,0,0,0.1); border: 2px solid #dc3545;">
                            <div class="text-center mb-4">
                                <h3 class="h4 font-weight-bold text-danger mb-2">
                                    {{ convertUtf8($abex->inhouse_seo_title ?? 'In-house SEO') }}
                                </h3>
                            </div>
                            
                            <div class="features-list">
                                @if(!empty($abex->inhouse_seo_features))
                                    @foreach($abex->inhouse_seo_features as $feature)
                                    <div class="feature-item d-flex align-items-start mb-3">
                                        <div class="feature-icon mr-3 mt-1">
                                            @if($feature['type'] == 'check')
                                                <i class="fas fa-check-circle text-success" style="font-size: 1.2rem;"></i>
                                            @else
                                                <i class="fas fa-times-circle text-danger" style="font-size: 1.2rem;"></i>
                                            @endif
                                        </div>
                                        <div class="feature-text">
                                            <p class="mb-0 text-dark">{{ convertUtf8($feature['text']) }}</p>
                                        </div>
                                    </div>
                                    @endforeach
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<!-- Comparison Section End -->
@endif
