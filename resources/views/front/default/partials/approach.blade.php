<!-- Approach section start -->
<div class="section panel py-4 lg:py-8 bg-white dark:bg-gray-900">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel text-center">
                    <h2 class="h3 lg:h2 mb-2">{{ convertUtf8($bs->approach_title) }}</h2>
                    @if (!empty($bs->approach_button_url) && !empty($bs->approach_button_text))
                        <a class="btn btn-primary" href="{{ $bs->approach_button_url }}" target="_blank">
                            {{ convertUtf8($bs->approach_button_text) }}
                        </a>
                    @endif
                </div>
                
                <div class="block-content panel">
                    <div class="row child-cols g-3 lg:g-4" data-uc-grid>
                        @foreach ($points as $key => $point)
                            <div class="col-12 sm:col-6 lg:col-4">
                                <div class="card panel h-100 p-4 lg:p-6 bg-gray-25 dark:bg-gray-800 rounded">
                                    <div class="card-body panel vstack gap-3">
                                        <div class="d-flex align-items-center gap-3">
                                            <span class="badge badge-primary fs-6 fw-bold">{{ sprintf('%02d', $point->serial_number) }}</span>
                                            <h4 class="h6 m-0">{{ convertUtf8($point->title) }}</h4>
                                        </div>
                                        <p class="fs-6 text-gray-600 dark:text-gray-300">
                                            @if (strlen($point->short_text) > 150)
                                                {{ mb_substr($point->short_text, 0, 150, 'utf-8') }}
                                                <span style="display:none;">{{ mb_substr($point->short_text, 150, null, 'utf-8') }}</span>
                                                <a href="#" class="see-more text-primary">{{ __('see more') }}...</a>
                                            @else
                                                {{ $point->short_text }}
                                            @endif
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Approach section end -->
