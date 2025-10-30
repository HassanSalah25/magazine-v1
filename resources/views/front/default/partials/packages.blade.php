<!-- Packages section start -->
<div class="section panel py-4 lg:py-8 bg-white dark:bg-gray-900">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel text-center">
                    <div class="d-flex align-items-center justify-content-center gap-3 mb-3">
                        <span class="badge badge-primary">{{ __('Special Offers') }}</span>
                        <div class="icon">
                            <svg xmlns="http://www.w3.org/2000/svg" width="81" height="9" viewBox="0 0 81 9" fill="none">
                                <rect y="4" width="80" height="1" fill="currentColor" />
                                <path d="M77 7.96366L80.5 4.48183L77 1" stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" />
                            </svg>
                        </div>
                    </div>
                    <h2 class="h3 lg:h2 mb-0">{{ __('Exclusive Packages') }}</h2>
                </div>
                
                <div class="block-content panel">
                    @if($bex->package_banner_image)
                        <div class="package-banner mb-4">
                            <img src="{{ asset($bex->package_banner_image) }}" 
                                 alt="Package Banner" 
                                 class="img-fluid w-100 rounded" 
                                 style="border-radius: 10px;">
                        </div>
                    @endif
                    
                    <div class="vstack gap-4">
                        @foreach($homePackageCategories as $key => $category)
                            @php
                                $categoryPackages = $category->packageList()->where('feature', 1)->orderBy('serial_number', 'ASC')->get();
                            @endphp
                            @if($categoryPackages->count() > 0)
                                <div class="category-section">
                                    <div class="row g-3 lg:g-4">
                                        @foreach($categoryPackages as $packageKey => $package)
                                            <div class="col-lg-4 col-md-6">
                                                <div class="card panel h-100 {{ $packageKey == 1 ? 'border-primary' : '' }} rounded p-4 lg:p-6">
                                                    <div class="card-body panel vstack gap-3">
                                                        <!-- Package Header -->
                                                        <div class="package-header text-center">
                                                            <h4 class="h5 mb-2">{{ convertUtf8($package->title) }}</h4>
                                                            <div class="price mb-2">
                                                                <span class="h3 text-primary">
                                                                    {{ $bex->base_currency_symbol_position == 'left' ? $bex->base_currency_symbol : '' }}
                                                                    {{ (int)$package->price }}
                                                                    {{ $bex->base_currency_symbol_position == 'right' ? $bex->base_currency_symbol : '' }}
                                                                    @if ($bex->recurring_billing == 1)
                                                                        <small class="fs-6 text-gray-500">/ {{ $package->duration == 'quarterly' ? __('quarter') : __('year') }}</small>
                                                                    @endif
                                                                </span>
                                                            </div>
                                                            <p class="fs-6 text-gray-600 dark:text-gray-300 mb-0">{{ convertUtf8($package->subtitle) }}</p>
                                                        </div>
                                                        
                                                        <!-- Package Features -->
                                                        <div class="package-features">
                                                            @php
                                                                $features = [];
                                                                if (!empty($package->description)) {
                                                                    // Simple approach to extract features from description
                                                                    $description = strip_tags($package->description, '<li>');
                                                                    $lines = explode("\n", $description);
                                                                    foreach ($lines as $line) {
                                                                        $line = trim(strip_tags($line));
                                                                        if (!empty($line) && strlen($line) > 3) {
                                                                            $features[] = $line;
                                                                        }
                                                                    }
                                                                }
                                                            @endphp
                                                            <ul class="list-unstyled vstack gap-2">
                                                                @foreach($features as $feature)
                                                                    <li class="d-flex align-items-center gap-2">
                                                                        <i class="fa-solid fa-check text-primary"></i>
                                                                        <span class="fs-6">{{ trim($feature) }}</span>
                                                                    </li>
                                                                @endforeach
                                                            </ul>
                                                        </div>
                                                        
                                                        <!-- Package Button -->
                                                        <div class="package-button mt-auto">
                                                            @if ($bex->recurring_billing == 1)
                                                                @auth
                                                                    @if ($activeSub->count() > 0 && empty($activeSub->first()->next_package_id))
                                                                        @if ($activeSub->first()->current_package_id == $package->id)
                                                                            <a href="#" data-package-id="{{ $package->id }}" class="js-purchase-package btn {{ $packageKey == 1 ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                                {{ __('Extend') }}
                                                                            </a>
                                                                        @else
                                                                            <a href="#" data-package-id="{{ $package->id }}" class="js-purchase-package btn {{ $packageKey == 1 ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                                {{ __('Change') }}
                                                                            </a>
                                                                        @endif
                                                                    @elseif ($activeSub->count() == 0)
                                                                        <a href="#" data-package-id="{{ $package->id }}" class="js-purchase-package btn {{ $packageKey == 1 ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                            {{ __('Purchase') }}
                                                                        </a>
                                                                    @endif
                                                                @endauth
                                                                @guest
                                                                    <a href="#" data-package-id="{{ $package->id }}" class="js-purchase-package btn {{ $packageKey == 1 ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                        {{ __('Purchase') }}
                                                                    </a>
                                                                @endguest
                                                            @else
                                                                @if ($package->order_status != 0)
                                                                    @php
                                                                        if($package->order_status == 1) {
                                                                            $link = '#';
                                                                        } elseif ($package->order_status == 2) {
                                                                            $link = $package->link;
                                                                        }
                                                                    @endphp
                                                                    <a href="{{ $link }}" 
                                                                   @if($package->order_status == 2) target="_blank" @endif 
                                                                   class="btn {{ $packageKey == 1 ? 'btn-primary' : 'btn-outline-primary' }} w-100">
                                                                        {{ __('Place Order') }}
                                                                    </a>
                                                                @endif
                                                            @endif
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>
                            @endif
                        @endforeach
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Packages section end -->