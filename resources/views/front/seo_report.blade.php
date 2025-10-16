@extends('front.default.layout')
@section('meta-keywords', "$bex->free_analysis_meta_keywords")
@section('meta-description', "$bex->free_analysis_meta_description")

@section('content')
<div class="container my-5">
    <div class="row">
        <div class="col-12">
            <h2 class="mb-4 d-flex align-items-center page-seo" style="margin-top: 9rem;"><i class="bi bi-graph-up me-2"></i> {{ __('SEO Analysis') }}</h2>
            <!-- SEO Score Overview -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-gradient-primary text-white d-flex align-items-center">
                    <i class="bi bi-bar-chart-fill me-2"></i>
                    <h5 class="mb-0">{{ __('Overall Score') }}</h5>
                </div>
                <div class="card-body text-center">
                    <div class="score-circle mx-auto mb-2" style="background: linear-gradient(135deg, {{ $seoScore >= 80 ? '#28a745, #43e97b' : ($seoScore >= 50 ? '#ffc107, #ffecb3' : '#dc3545, #ffb3b3') }});">
                        <span class="score-value">{{ round($seoScore) }}</span>
                    </div>
                    <span class="h4">{{ round($seoScore) }}/100</span>
                </div>
            </div>
            <!-- Performance Score -->
            @if($performanceScore !== 'Unavailable')
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-success text-white d-flex align-items-center">
                    <i class="bi bi-lightning-charge me-2"></i>
                    <span>{{ __('PageSpeed Insights') }}</span>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-box bg-light shadow-sm rounded py-3">
                                <i class="bi bi-clock-history text-primary fs-3"></i>
                                <div class="fw-bold mt-2">{{ $fcp }}</div>
                                <small>{{ __('First Contentful Paint') }}</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-box bg-light shadow-sm rounded py-3">
                                <i class="bi bi-aspect-ratio text-success fs-3"></i>
                                <div class="fw-bold mt-2">{{ $lcp }}</div>
                                <small>{{ __('Largest Contentful Paint') }}</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-box bg-light shadow-sm rounded py-3">
                                <i class="bi bi-bounding-box text-warning fs-3"></i>
                                <div class="fw-bold mt-2">{{ $cls }}</div>
                                <small>{{ __('Cumulative Layout Shift') }}</small>
                            </div>
                        </div>
                        <div class="col-6 col-md-3 mb-2">
                            <div class="stat-box bg-light shadow-sm rounded py-3">
                                <i class="bi bi-slash-circle text-danger fs-3"></i>
                                <div class="fw-bold mt-2">{{ $blockingTime }}</div>
                                <small>{{ __('Total Blocking Time') }}</small>
                            </div>
                        </div>
                    </div>
                    <div class="text-center my-4">
                        <div class="score-circle mx-auto mb-2" style="background: linear-gradient(135deg, {{ $performanceScore >= 90 ? '#28a745, #43e97b' : ($performanceScore >= 50 ? '#ffc107, #ffecb3' : '#dc3545, #ffb3b3') }}); width: 120px; height: 120px; font-size: 2.5rem;">
                            <span class="score-value">{{ round($performanceScore) }}</span>
                        </div>
                        <h5 class="mt-3">{{ __('Performance Score') }}</h5>
                    </div>
                </div>
            </div>
            @endif
            <!-- SEO Elements & Content Analysis -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="bi bi-search me-2"></i>
                            <span>{{ __('SEO Elements') }}</span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>{{ __('Page Title') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $title ?? __('Not Found') }}
                                </div>
                                <small class="text-muted">{{ __('Length') }}: {{ $titleLength }} {{ __('chars') }}</small>
                                @if($titleLength < 10 || $titleLength > 70)
                                    <div class="text-warning mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ __('Ideal length is between 10-70 chars') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Meta Description') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $metaDescription ?? __('Not Found') }}
                                </div>
                                <small class="text-muted">{{ __('Length') }}: {{ $metaDescriptionLength }} {{ __('chars') }}</small>
                                @if($metaDescriptionLength < 100 || $metaDescriptionLength > 300)
                                    <div class="text-warning mt-1">
                                        <i class="bi bi-exclamation-triangle"></i> {{ __('Ideal length is between 100-300 chars') }}
                                    </div>
                                @endif
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Meta Keywords') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $metaKeywords ?? __('Not Found') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Canonical URL') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $canonical ?? __('Not Found') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Page Language') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $language ?? __('Not Specified') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Robots Meta') }}:</strong>
                                <div class="mt-1 p-2 bg-light rounded">
                                    {{ $robotsMeta ?? __('Not Found') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header bg-warning text-dark d-flex align-items-center">
                            <i class="bi bi-file-earmark-bar-graph me-2"></i>
                            <span>{{ __('Content Analysis') }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center mb-3">
                                        <span class="badge bg-primary fs-5">{{ $wordCount }}</span>
                                        <div class="small mt-1">{{ __('Word Count') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center mb-3">
                                        <span class="badge bg-primary fs-5">{{ $characterCount }}</span>
                                        <div class="small mt-1">{{ __('Character Count') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="row">
                                <div class="col-6">
                                    <div class="text-center mb-3">
                                        <span class="badge bg-info fs-5">{{ $imageCount }}</span>
                                        <div class="small mt-1">{{ __('Image Count') }}</div>
                                    </div>
                                </div>
                                <div class="col-6">
                                    <div class="text-center mb-3">
                                        <span class="badge bg-info fs-5">{{ $imagesWithAlt }}</span>
                                        <div class="small mt-1">{{ __('Images with Alt') }}</div>
                                    </div>
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>{{ __('Favicon') }}:</strong>
                                <span class="badge {{ $hasFavicon ? 'bg-success' : 'bg-danger' }}">
                                    {{ $hasFavicon ? __('Present') : __('Not Found') }}
                                </span>
                            </div>
                            @if($imagesWithAlt < $imageCount && $imageCount > 0)
                                <div class="alert alert-warning d-flex align-items-center">
                                    <i class="bi bi-exclamation-triangle-fill me-2"></i>
                                    <div>{{ __(':count images without alt text', ['count' => $imageCount - $imagesWithAlt]) }}</div>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            <!-- Headings Structure -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-secondary text-white d-flex align-items-center">
                    <i class="bi bi-list-ol me-2"></i>
                    <span>{{ __('Headings Structure') }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach([['H1', $h1Tags, 5], ['H2', $h2Tags, 5], ['H3', $h3Tags, 3], ['H4', $h4Tags, 3], ['H5', $h5Tags, 3], ['H6', $h6Tags, 3]] as [$tag, $tags, $limit])
                        <div class="col-md-2">
                            <h6>{{ $tag }} ({{ count($tags) }})</h6>
                            <ul class="list-unstyled">
                                @foreach(array_slice($tags, 0, $limit) as $t)
                                    <li class="mb-1 p-1 bg-light rounded small">{{ $t }}</li>
                                @endforeach
                                @if(count($tags) > $limit)
                                    <li class="text-muted small">{{ __('and :count more...', ['count' => count($tags) - $limit]) }}</li>
                                @endif
                            </ul>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            <!-- Link Analysis & Social -->
            <div class="row">
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header bg-success text-white d-flex align-items-center">
                            <i class="bi bi-link-45deg me-2"></i>
                            <span>{{ __('Link Analysis') }}</span>
                        </div>
                        <div class="card-body">
                            <div class="row text-center mb-3">
                                <div class="col-4">
                                    <span class="badge bg-primary fs-5">{{ count($internalLinks) }}</span>
                                    <div class="small">{{ __('Internal Links') }}</div>
                                </div>
                                <div class="col-4">
                                    <span class="badge bg-primary fs-5">{{ count($externalLinks) }}</span>
                                    <div class="small">{{ __('External Links') }}</div>
                                </div>
                                <div class="col-4">
                                    <span class="badge bg-danger fs-5">{{ count($brokenLinks) }}</span>
                                    <div class="small">{{ __('Broken Links') }}</div>
                                </div>
                            </div>
                            <div class="row text-center mb-3">
                                <div class="col-6">
                                    <span class="badge bg-success fs-6">{{ count($dofollowLinks) }}</span>
                                    <div class="small">Dofollow</div>
                                </div>
                                <div class="col-6">
                                    <span class="badge bg-warning text-dark fs-6">{{ count($nofollowLinks) }}</span>
                                    <div class="small">Nofollow</div>
                                </div>
                            </div>
                            @if(count($brokenLinks) > 0)
                                <div class="alert alert-danger mt-3">
                                    <h6>{{ __('Broken Links') }}:</h6>
                                    <ul class="list-unstyled">
                                        @foreach(array_slice($brokenLinks, 0, 5) as $link)
                                            <li class="small">{{ $link['url'] }}</li>
                                        @endforeach
                                        @if(count($brokenLinks) > 5)
                                            <li class="text-muted small">{{ __('and :count more...', ['count' => count($brokenLinks) - 5]) }}</li>
                                        @endif
                                    </ul>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-md-6">
                    <div class="card shadow-sm mb-4 border-0">
                        <div class="card-header bg-info text-white d-flex align-items-center">
                            <i class="bi bi-share me-2"></i>
                            <span>{{ __('Social Media') }}</span>
                        </div>
                        <div class="card-body">
                            <div class="mb-3">
                                <strong>Open Graph Title:</strong>
                                <div class="mt-1 p-2 bg-light rounded small">
                                    {{ $ogTitle ?? __('Not Found') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Open Graph Description:</strong>
                                <div class="mt-1 p-2 bg-light rounded small">
                                    {{ $ogDescription ?? __('Not Found') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Open Graph Image:</strong>
                                <div class="mt-1 p-2 bg-light rounded small">
                                    {{ $ogImage ?? __('Not Found') }}
                                </div>
                            </div>
                            <div class="mb-3">
                                <strong>Twitter Card:</strong>
                                <div class="mt-1 p-2 bg-light rounded small">
                                    {{ $twitterCard ?? __('Not Found') }}
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Recommendations -->
            <div class="card shadow-sm mb-4 border-0">
                <div class="card-header bg-primary text-white d-flex align-items-center">
                    <i class="bi bi-lightbulb me-2"></i>
                    <span>{{ __('Recommendations') }}</span>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="bi bi-tools me-1"></i> {{ __('Required Improvements') }}:</h6>
                            <ul class="list-unstyled">
                                @if(empty($title))
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger"></i> {{ __('Add a page title') }}</li>
                                @endif
                                @if(empty($metaDescription))
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger"></i> {{ __('Add a meta description') }}</li>
                                @endif
                                @if(count($h1Tags) == 0)
                                    <li class="mb-2"><i class="bi bi-x-circle text-danger"></i> {{ __('Add one H1 heading') }}</li>
                                @endif
                                @if(count($h1Tags) > 1)
                                    <li class="mb-2"><i class="bi bi-exclamation-triangle text-warning"></i> {{ __('There should be only one H1 heading') }}</li>
                                @endif
                                @if($imagesWithAlt < $imageCount)
                                    <li class="mb-2"><i class="bi bi-exclamation-triangle text-warning"></i> {{ __('Add alt text to all images') }}</li>
                                @endif
                                @if(!$hasFavicon)
                                    <li class="mb-2"><i class="bi bi-info-circle text-info"></i> {{ __('Add a favicon') }}</li>
                                @endif
                                @if(empty($canonical))
                                    <li class="mb-2"><i class="bi bi-info-circle text-info"></i> {{ __('Add a canonical URL') }}</li>
                                @endif
                                @if(empty($language))
                                    <li class="mb-2"><i class="bi bi-info-circle text-info"></i> {{ __('Specify the page language') }}</li>
                                @endif
                            </ul>
                        </div>
                        <div class="col-md-6">
                            <h6 class="mb-3"><i class="bi bi-hand-thumbs-up me-1"></i> {{ __('Positive Points') }}:</h6>
                            <ul class="list-unstyled">
                                @if(!empty($title))
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('Page title is present') }}</li>
                                @endif
                                @if(!empty($metaDescription))
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('Meta description is present') }}</li>
                                @endif
                                @if(count($h1Tags) == 1)
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('One H1 heading is present') }}</li>
                                @endif
                                @if($imagesWithAlt == $imageCount && $imageCount > 0)
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('All images have alt text') }}</li>
                                @endif
                                @if($wordCount >= 300)
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('Sufficient content (:count words)', ['count' => $wordCount]) }}</li>
                                @endif
                                @if($hasFavicon)
                                    <li class="mb-2"><i class="bi bi-check-circle text-success"></i> {{ __('Favicon is present') }}</li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <!-- Back to Analysis Form -->
            <div class="text-center mb-4">
                <a href="{{ route('free-analysis.index') }}" class="btn btn-primary btn-lg px-4">
                    <i class="bi bi-arrow-left"></i> {{ __('Analyze another website') }}
                </a>
            </div>
        </div>
    </div>
</div>
<style>
.score-circle {
    width: 90px;
    height: 90px;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-size: 2rem;
    color: #fff;
    font-weight: bold;
    margin-bottom: 10px;
    box-shadow: 0 0 10px #e0e0e0;
}
.stat-box {
    transition: box-shadow 0.2s;
    min-height: 100px;
}
.stat-box:hover {
    box-shadow: 0 0 10px #ddd;
}
.bg-gradient-primary {
    background: linear-gradient(135deg, #007bff, #6610f2) !important;
}
</style>
@endsection

