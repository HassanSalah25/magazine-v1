<!-- Testimonials section start -->
<div class="section panel py-4 lg:py-8 bg-gray-100 dark:bg-gray-800 relative overflow-hidden">
    <div class="container max-w-xl">
        <div class="section-inner panel vstack gap-4 lg:gap-6">
            <div class="block-layout vstack gap-4 lg:gap-6">
                <div class="block-header panel text-center">
                    <span class="badge badge-primary mb-2">{{ convertUtf8($bs->testimonial_title) }}</span>
                    <h2 class="h3 lg:h2 mb-0">{{ convertUtf8($bs->testimonial_subtitle) }}</h2>
                </div>
                
                <div class="block-content panel">
                    <div class="swiper" data-uc-swiper="items: 1; gap: 16; dots: .dot-nav; autoplay: 5000;">
                        <div class="swiper-wrapper">
                            @foreach ($testimonials as $testimonial)
                                <div class="swiper-slide">
                                    <div class="card panel bg-white dark:bg-gray-700 rounded p-4 lg:p-6 text-center">
                                        <div class="card-body panel vstack gap-4">
                                            <!-- Quote Icon -->
                                            <div class="quote-icon">
                                                <svg width="40" height="32" viewBox="0 0 40 32" fill="none" xmlns="http://www.w3.org/2000/svg" class="text-primary">
                                                    <path d="M15.417 2.25185V11.4963C15.417 13.6296 14.4936 16.079 12.6467 18.8444L4.33602 30.8148C3.77395 31.6049 3.01113 32 2.04757 32C0.682522 32 0 31.2099 0 29.6296V2.37037C0 0.790124 0.802967 0 2.4089 0H13.1285C14.6542 0 15.417 0.750615 15.417 2.25185Z" fill="currentColor" />
                                                    <path d="M40 2.25185V11.4963C40 13.6296 39.0766 16.079 37.2298 18.8444L28.919 30.8148C28.357 31.6049 27.5942 32 26.6306 32C25.2656 32 24.583 31.2099 24.583 29.6296V2.37037C24.583 0.790124 25.386 0 26.9919 0H37.7115C39.2372 0 40 0.750615 40 2.25185Z" fill="currentColor" />
                                                </svg>
                                            </div>
                                            
                                            <!-- Testimonial Text -->
                                            <div class="testimonial-text">
                                                <p class="fs-5 text-gray-600 dark:text-gray-300 mb-0">
                                                    "{{ convertUtf8($testimonial->comment) }}"
                                                </p>
                                            </div>
                                            
                                            <!-- Author Info -->
                                            <div class="testimonial-author d-flex align-items-center justify-content-center gap-3">
                                                <div class="author-avatar">
                                                    <img class="rounded-circle" 
                                                         src="{{ asset('assets/front/img/testimonials/' . $testimonial->image) }}" 
                                                         alt="{{ convertUtf8($testimonial->name) }}"
                                                         width="50" height="50">
                                                </div>
                                                <div class="author-info text-start">
                                                    <h5 class="h6 mb-0">{{ convertUtf8($testimonial->name) }}</h5>
                                                    <p class="fs-6 text-gray-500 dark:text-gray-400 mb-0">{{ convertUtf8($testimonial->rank) }}</p>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                        
                        <!-- Dots -->
                        <div class="dot-nav d-flex justify-content-center gap-1 mt-4"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Testimonials section end -->
