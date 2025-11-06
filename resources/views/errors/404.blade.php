@php
    $version = $be->theme_version;

    if ($version == 'dark') {
        $version = 'default';
    }
@endphp

@extends("front.$version.layout")

@section('breadcrumb-title', $bs->error_title)
@section('breadcrumb-subtitle', $bs->error_subtitle)
@section('breadcrumb-link', __('404'))

@section('content')

<style>
/* Modern 404 Page Styles */
.modern-404-section {
    min-height: 80vh;
    display: flex;
    align-items: center;
    background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
    position: relative;
    overflow: hidden;
}

.modern-404-section::before {
    content: '';
    position: absolute;
    top: 0;
    left: 0;
    right: 0;
    bottom: 0;
    background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grid" width="10" height="10" patternUnits="userSpaceOnUse"><path d="M 10 0 L 0 0 0 10" fill="none" stroke="%23e9ecef" stroke-width="0.5"/></pattern></defs><rect width="100" height="100" fill="url(%23grid)"/></svg>');
    opacity: 0.3;
    z-index: 1;
}

.error-content {
    position: relative;
    z-index: 2;
    text-align: center;
    padding: 60px 20px;
}

.error-number {
    font-size: 8rem;
    font-weight: 900;
    background: linear-gradient(135deg, #0z0a651 0%, #007a3d 100%);
    -webkit-background-clip: text;
    -webkit-text-fill-color: transparent;
    background-clip: text;
    margin-bottom: 20px;
    animation: float 3s ease-in-out infinite;
    text-shadow: 0 0 30px rgba(0, 166, 81, 0.3);
}

.error-title {
    font-size: 2.5rem;
    font-weight: 700;
    color: #2c3e50;
    margin-bottom: 20px;
    animation: slideInUp 0.8s ease-out;
}

.error-description {
    font-size: 1.2rem;
    color: #6c757d;
    margin-bottom: 40px;
    max-width: 600px;
    margin-left: auto;
    margin-right: auto;
    line-height: 1.6;
    animation: slideInUp 0.8s ease-out 0.2s both;
}

.error-actions {
    display: flex;
    gap: 20px;
    justify-content: center;
    flex-wrap: wrap;
    margin-bottom: 50px;
    animation: slideInUp 0.8s ease-out 0.4s both;
}

.btn-modern {
    padding: 15px 30px;
    border-radius: 50px;
    font-weight: 600;
    text-decoration: none;
    transition: all 0.3s ease;
    position: relative;
    overflow: hidden;
    border: 2px solid transparent;
    display: inline-flex;
    align-items: center;
    gap: 10px;
}

.btn-primary-modern {
    background: linear-gradient(135deg, #00a651 0%, #007a3d 100%);
    color: white;
    box-shadow: 0 8px 25px rgba(0, 166, 81, 0.3);
}

.btn-primary-modern:hover {
    transform: translateY(-3px);
    box-shadow: 0 12px 35px rgba(0, 166, 81, 0.4);
    color: white;
}

.btn-secondary-modern {
    background: transparent;
    color: #00a651;
    border: 2px solid #00a651;
}

.btn-secondary-modern:hover {
    background: #00a651;
    color: white;
    transform: translateY(-3px);
    box-shadow: 0 8px 25px rgba(0, 166, 81, 0.3);
}

.search-box {
    max-width: 500px;
    margin: 0 auto 40px;
    position: relative;
    animation: slideInUp 0.8s ease-out 0.6s both;
}

.search-input {
    width: 100%;
    padding: 20px 60px 20px 20px;
    border: 2px solid #e9ecef;
    border-radius: 50px;
    font-size: 1.1rem;
    background: white;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
}

.search-input:focus {
    outline: none;
    border-color: #00a651;
    box-shadow: 0 8px 25px rgba(0, 166, 81, 0.2);
}

.search-btn {
    position: absolute;
    right: 5px;
    top: 50%;
    transform: translateY(-50%);
    background: linear-gradient(135deg, #00a651 0%, #007a3d 100%);
    border: none;
    border-radius: 50%;
    width: 50px;
    height: 50px;
    color: white;
    cursor: pointer;
    transition: all 0.3s ease;
}

.search-btn:hover {
    transform: translateY(-50%) scale(1.1);
    box-shadow: 0 5px 15px rgba(0, 166, 81, 0.4);
}

.helpful-links {
    display: grid;
    grid-template-columns: repeat(auto-fit, minmax(250px, 1fr));
    gap: 20px;
    max-width: 800px;
    margin: 0 auto;
    animation: slideInUp 0.8s ease-out 0.8s both;
}

.helpful-link {
    background: white;
    padding: 25px;
    border-radius: 15px;
    text-decoration: none;
    color: #2c3e50;
    transition: all 0.3s ease;
    box-shadow: 0 5px 15px rgba(0, 0, 0, 0.1);
    border: 1px solid #f8f9fa;
}

.helpful-link:hover {
    transform: translateY(-5px);
    box-shadow: 0 15px 35px rgba(0, 0, 0, 0.15);
    color: #00a651;
}

.helpful-link i {
    font-size: 2rem;
    margin-bottom: 15px;
    color: #00a651;
}

.helpful-link h4 {
    font-size: 1.2rem;
    font-weight: 600;
    margin-bottom: 10px;
}

.helpful-link p {
    color: #6c757d;
    font-size: 0.9rem;
    margin: 0;
}

/* Animations */
@keyframes float {
    0%, 100% { transform: translateY(0px); }
    50% { transform: translateY(-20px); }
}

@keyframes slideInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Responsive Design */
@media (max-width: 768px) {
    .error-number {
        font-size: 5rem;
    }
    
    .error-title {
        font-size: 2rem;
    }
    
    .error-description {
        font-size: 1rem;
    }
    
    .error-actions {
        flex-direction: column;
        align-items: center;
    }
    
    .btn-modern {
        width: 100%;
        max-width: 300px;
        justify-content: center;
    }
    
    .helpful-links {
        grid-template-columns: 1fr;
    }
}

@media (max-width: 480px) {
    .error-content {
        padding: 40px 15px;
    }
    
    .error-number {
        font-size: 4rem;
    }
    
    .error-title {
        font-size: 1.5rem;
    }
    
    .search-input {
        padding: 15px 50px 15px 15px;
        font-size: 1rem;
    }
    
    .search-btn {
        width: 40px;
        height: 40px;
    }
}
</style>

<!-- Modern 404 Section Start -->
<div class="modern-404-section">
    <div class="container">
        <div class="error-content">
            <!-- Error Number -->
            <div class="error-number">404</div>
            
            <!-- Error Title -->
            <h1 class="error-title">Oops! Page Not Found</h1>
            
            <!-- Error Description -->
            <p class="error-description">
                The page you're looking for seems to have wandered off into the digital void. 
                Don't worry, even the best explorers sometimes take a wrong turn!
            </p>
            
            <!-- Search Box -->
            <div class="search-box">
                <form action="{{ route('front.blogs') }}" method="GET">
                    <input type="text" name="search" class="search-input" placeholder="Search for what you're looking for...">
                    <button type="submit" class="search-btn">
                        <i class="fas fa-search"></i>
                    </button>
                </form>
            </div>
            
            <!-- Action Buttons -->
            <div class="error-actions">
                <a href="{{ route('front.index') }}" class="btn-modern btn-primary-modern">
                    <i class="fas fa-home"></i>
                    Back to Home
                </a>
                <a href="javascript:history.back()" class="btn-modern btn-secondary-modern">
                    <i class="fas fa-arrow-left"></i>
                    Go Back
                </a>
            </div>
            
            <!-- Helpful Links -->
            <div class="helpful-links">
                <a href="{{ route('front.blogs') }}" class="helpful-link">
                    <i class="fas fa-newspaper"></i>
                    <h4>Latest Articles</h4>
                    <p>Discover our latest blog posts and insights</p>
                </a>
                
                <a href="{{ route('front.services') }}" class="helpful-link">
                    <i class="fas fa-cogs"></i>
                    <h4>Our Services</h4>
                    <p>Explore what we can do for you</p>
                </a>
                
                <a href="{{ route('front.contact') }}" class="helpful-link">
                    <i class="fas fa-envelope"></i>
                    <h4>Contact Us</h4>
                    <p>Get in touch with our team</p>
                </a>
            </div>
        </div>
    </div>
</div>
<!-- Modern 404 Section End -->

@endsection
