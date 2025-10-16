@extends("front.$version.layout")

@section('pagename')
    - {{__('Our Profile')}}
@endsection

@section('meta-keywords', "profile, company profile, about us")
@section('meta-description', "Learn more about our company profile and team")

@section('breadcrumb-title', 'Our Profile')
@section('breadcrumb-subtitle', 'Get to know us better')
@section('breadcrumb-link', __('Our Profile'))
@section('page_class', 'profile')

@section('content')
    <!-- rts profile area start -->
    <div class="rts-about-area rts-section-gap mt--10">
        <div class="container">
            <div class="row">
                <div class="col-lg-12">
                    <div class="about-page-main-thumbnail-big-img-wrapper rts-reveal-to-bottom-wrapper">
                        <div class="text-center">
                            <h1 class="display-4 mb-4">Our Profile</h1>
                            <p class="lead">Welcome to our company profile page. Here you can learn more about who we are and what we do.</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- rts profile area end -->

    <!-- profile content area start -->
    <div class="rts-section-gap">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="profile-content">
                        <h2 class="mb-4">About Our Company</h2>
                        <p class="mb-4">
                            This is a placeholder for your company profile content. You can customize this section 
                            to include information about your company's history, mission, values, and achievements.
                        </p>
                        
                        <h3 class="mb-3">Our Mission</h3>
                        <p class="mb-4">
                            Add your company's mission statement here. This helps visitors understand what drives 
                            your organization and what you're working towards.
                        </p>
                        
                        <h3 class="mb-3">Our Values</h3>
                        <ul class="list-unstyled">
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Quality and Excellence</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Customer Satisfaction</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Innovation and Growth</li>
                            <li class="mb-2"><i class="fas fa-check text-success me-2"></i> Team Collaboration</li>
                        </ul>
                        
                        <h3 class="mb-3">Contact Information</h3>
                        <div class="row">
                            <div class="col-md-6">
                                <p><strong>Email:</strong> info@yourcompany.com</p>
                                <p><strong>Phone:</strong> +1 (555) 123-4567</p>
                            </div>
                            <div class="col-md-6">
                                <p><strong>Address:</strong> 123 Business Street<br>City, State 12345</p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- profile content area end -->

@endsection
