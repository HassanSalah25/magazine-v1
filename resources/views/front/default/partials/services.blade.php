<!-- Services section start -->
<div class="section panel py-4 lg:py-8 bg-primary-600 text-white">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel">
                    <span class="badge badge-white mb-2">{{ convertUtf8($bs->service_section_title) }}</span>
                    <h2 class="h3 lg:h2 mb-3">{!! convertUtf8($bs->service_section_subtitle) !!}</h2>
                    <p class="fs-5 text-white text-opacity-80">{{ convertUtf8($bs->service_section_text ?? '') }}</p>
                    @if (!empty($bs->service_section_button_url) && !empty($bs->service_section_button_text))
                        <a href="{{ $bs->service_section_button_url }}" class="btn btn-white" target="_blank">
                            {{ convertUtf8($bs->service_section_button_text) }}
                        </a>
                    @endif
                </div>
                
                <div class="block-content panel">
                    <div class="vstack gap-3">
                        @if (!serviceCategory())
                            @foreach ($services as $key => $service)
                                <div class="card panel bg-white bg-opacity-10 backdrop-blur-sm rounded p-4 lg:p-6">
                                    <div class="row align-items-center g-3">
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge badge-white fs-6 fw-bold">{{ sprintf('%02d', $service->serial_number ?? $loop->iteration) }}</span>
                                                <h4 class="h6 m-0">
                                                    <a @if($service->details_page_status == 1) href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}" @else href="#" @endif class="text-white text-decoration-none">
                                                        {{ convertUtf8($service->title) }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 text-white text-opacity-80">{{ Str::limit($service->summary, 150) }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-white" href="{{ route('front.servicedetails', [$service->slug, $service->id]) }}">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        @else
                            @foreach ($scategories as $scategory)
                                <div class="card panel bg-white bg-opacity-10 backdrop-blur-sm rounded p-4 lg:p-6">
                                    <div class="row align-items-center g-3">
                                        <div class="col-auto">
                                            <div class="d-flex align-items-center gap-3">
                                                <span class="badge badge-white fs-6 fw-bold">{{ sprintf('%02d', $loop->iteration) }}</span>
                                                <h4 class="h6 m-0">
                                                    <a href="{{ route('front.services', $scategory->slug) }}" class="text-white text-decoration-none">
                                                        {{ convertUtf8($scategory->name) }}
                                                    </a>
                                                </h4>
                                            </div>
                                        </div>
                                        <div class="col">
                                            <p class="mb-0 text-white text-opacity-80">{{ Str::limit($scategory->short_text, 150) }}</p>
                                        </div>
                                        <div class="col-auto">
                                            <a class="btn btn-sm btn-white" href="{{ route('front.services', $scategory->slug) }}">
                                                <i class="fa-solid fa-arrow-right"></i>
                                            </a>
                                        </div>
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
<!-- Services section end -->
