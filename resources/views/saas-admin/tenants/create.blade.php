<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Tenant - SaaS Admin</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <style>
        .sidebar {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            min-height: 100vh;
            color: white;
        }
        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.8);
            padding: 12px 20px;
            border-radius: 8px;
            margin: 5px 0;
            transition: all 0.3s;
        }
        .sidebar .nav-link:hover,
        .sidebar .nav-link.active {
            background: rgba(255, 255, 255, 0.2);
            color: white;
        }
        .main-content {
            background: #f8f9fa;
            min-height: 100vh;
        }
        .form-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .form-control {
            border-radius: 8px;
            border: 2px solid #e9ecef;
            padding: 12px 15px;
        }
        .form-control:focus {
            border-color: #667eea;
            box-shadow: 0 0 0 0.2rem rgba(102, 126, 234, 0.25);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
            padding: 12px 30px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
        }
        .form-section {
            border-bottom: 1px solid #e9ecef;
            padding-bottom: 2rem;
            margin-bottom: 2rem;
        }
        .form-section:last-child {
            border-bottom: none;
            margin-bottom: 0;
        }
    </style>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar p-0">
                <div class="p-3">
                    <h4><i class="fas fa-building me-2"></i>SaaS Admin</h4>
                </div>
                <nav class="nav flex-column px-3">
                    <a class="nav-link" href="{{ route('saas-admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('saas-admin.tenants.index') }}">
                        <i class="fas fa-users me-2"></i>Tenants
                    </a>
                    <a class="nav-link active" href="{{ route('saas-admin.tenants.create') }}">
                        <i class="fas fa-plus me-2"></i>Create Tenant
                    </a>
                    <hr class="my-3">
                    <a class="nav-link" href="{{ route('saas-admin.logout') }}" 
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                    </a>
                </nav>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
                <div class="p-4">
                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <h2><i class="fas fa-plus me-2"></i>Create New Tenant</h2>
                        <a href="{{ route('saas-admin.tenants.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-arrow-left me-2"></i>Back to Tenants
                        </a>
                    </div>

                    <!-- Alerts -->
                    @if(session('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ session('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger alert-dismissible fade show" role="alert">
                            <i class="fas fa-exclamation-circle me-2"></i>{{ session('error') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                        </div>
                    @endif

                    <!-- Create Tenant Form -->
                    <div class="form-card">
                        <div class="p-4">
                            <form method="POST" action="{{ route('saas-admin.tenants.store') }}">
                                @csrf
                                
                                <!-- Owner Information Section -->
                                <div class="form-section">
                                    <h5 class="mb-3"><i class="fas fa-user me-2"></i>Owner Information</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="fname" class="form-label">First Name *</label>
                                            <input type="text" class="form-control @error('fname') is-invalid @enderror" 
                                                   id="fname" name="fname" value="{{ old('fname') }}" required>
                                            @error('fname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="lname" class="form-label">Last Name *</label>
                                            <input type="text" class="form-control @error('lname') is-invalid @enderror" 
                                                   id="lname" name="lname" value="{{ old('lname') }}" required>
                                            @error('lname')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="email" class="form-label">Email Address *</label>
                                            <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                   id="email" name="email" value="{{ old('email') }}" required>
                                            @error('email')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="username" class="form-label">Username</label>
                                            <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                   id="username" name="username" value="{{ old('username') }}">
                                            @error('username')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Password Section -->
                                <div class="form-section">
                                    <h5 class="mb-3"><i class="fas fa-lock me-2"></i>Password</h5>
                                    <div class="row">
                                        <div class="col-md-6 mb-3">
                                            <label for="password" class="form-label">Password *</label>
                                            <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                   id="password" name="password" required>
                                            @error('password')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <div class="col-md-6 mb-3">
                                            <label for="password_confirmation" class="form-label">Confirm Password *</label>
                                            <input type="password" class="form-control" 
                                                   id="password_confirmation" name="password_confirmation" required>
                                        </div>
                                    </div>
                                </div>

                                <!-- Domain Section -->
                                <div class="form-section">
                                    <h5 class="mb-3"><i class="fas fa-globe me-2"></i>Subdomain Configuration</h5>
                                    <div class="row">
                                        <div class="col-md-12 mb-3">
                                            <label for="subdomain" class="form-label">Custom Subdomain (Optional)</label>
                                            <input type="text" class="form-control @error('subdomain') is-invalid @enderror" 
                                                   id="subdomain" name="subdomain" value="{{ old('subdomain') }}" 
                                                   placeholder="e.g., mycompany, store, shop">
                                            <div class="form-text">
                                                <strong>Subdomain will be:</strong> <code id="subdomain-preview">tenant_xxxxx.{{ request()->getHost() }}</code><br>
                                                <small class="text-muted">
                                                    Leave empty for auto-generation, or enter a custom subdomain.<br>
                                                    Based on current domain: <code>{{ request()->getHost() }}</code>
                                                </small>
                                            </div>
                                            @error('subdomain')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('saas-admin.tenants.index') }}" class="btn btn-outline-secondary me-3">
                                        Cancel
                                    </a>
                                    <button type="submit" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Create Tenant
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Logout Form -->
    <form id="logout-form" action="{{ route('saas-admin.logout') }}" method="POST" style="display: none;">
        @csrf
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Live subdomain preview
        document.getElementById('subdomain').addEventListener('input', function() {
            const subdomain = this.value;
            const preview = document.getElementById('subdomain-preview');
            const currentDomain = '{{ request()->getHost() }}';
            
            if (subdomain) {
                preview.textContent = subdomain + '.' + currentDomain;
            } else {
                preview.textContent = 'tenant_xxxxx.' + currentDomain;
            }
        });
    </script>
</body>
</html>
