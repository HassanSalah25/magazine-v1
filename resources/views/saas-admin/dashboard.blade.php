<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SaaS Admin Dashboard</title>
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
        .stats-card {
            background: white;
            border-radius: 15px;
            padding: 2rem;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
            border-left: 5px solid;
        }
        .stats-card.primary { border-left-color: #667eea; }
        .stats-card.success { border-left-color: #28a745; }
        .stats-card.warning { border-left-color: #ffc107; }
        .stats-card.info { border-left-color: #17a2b8; }
        .table-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 15px rgba(0, 0, 0, 0.08);
        }
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            border: none;
            border-radius: 8px;
        }
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(102, 126, 234, 0.4);
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
                    <a class="nav-link active" href="{{ route('saas-admin.dashboard') }}">
                        <i class="fas fa-tachometer-alt me-2"></i>Dashboard
                    </a>
                    <a class="nav-link" href="{{ route('saas-admin.tenants.index') }}">
                        <i class="fas fa-users me-2"></i>Tenants
                    </a>
                    <a class="nav-link" href="{{ route('saas-admin.tenants.create') }}">
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
                        <h2><i class="fas fa-tachometer-alt me-2"></i>Dashboard</h2>
                        <div class="d-flex align-items-center">
                            <span class="me-3">Welcome, {{ Auth::user()->fname ?? 'Admin' }}</span>
                            <div class="dropdown">
                                <button class="btn btn-outline-secondary dropdown-toggle" type="button" data-bs-toggle="dropdown">
                                    <i class="fas fa-user"></i>
                                </button>
                                <ul class="dropdown-menu">
                                    <li><a class="dropdown-item" href="{{ route('saas-admin.logout') }}" 
                                           onclick="event.preventDefault(); document.getElementById('logout-form').submit();">
                                        <i class="fas fa-sign-out-alt me-2"></i>Logout
                                    </a></li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <!-- Stats Cards -->
                    <div class="row mb-4">
                        <div class="col-md-3 mb-3">
                            <div class="stats-card primary">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">Total Tenants</h6>
                                        <h3 class="mb-0">{{ $totalTenants }}</h3>
                                    </div>
                                    <div class="text-primary">
                                        <i class="fas fa-building fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card success">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">Total Users</h6>
                                        <h3 class="mb-0">{{ $totalUsers }}</h3>
                                    </div>
                                    <div class="text-success">
                                        <i class="fas fa-users fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card warning">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">Active Tenants</h6>
                                        <h3 class="mb-0">{{ $tenants->where('created_at', '>=', now()->subDays(30))->count() }}</h3>
                                    </div>
                                    <div class="text-warning">
                                        <i class="fas fa-chart-line fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3 mb-3">
                            <div class="stats-card info">
                                <div class="d-flex align-items-center">
                                    <div class="flex-grow-1">
                                        <h6 class="text-muted mb-1">This Month</h6>
                                        <h3 class="mb-0">{{ $tenants->where('created_at', '>=', now()->startOfMonth())->count() }}</h3>
                                    </div>
                                    <div class="text-info">
                                        <i class="fas fa-calendar fa-2x"></i>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Recent Tenants -->
                    <div class="table-card">
                        <div class="p-3 border-bottom">
                            <h5 class="mb-0"><i class="fas fa-clock me-2"></i>Recent Tenants</h5>
                        </div>
                        <div class="table-responsive">
                            <table class="table table-hover mb-0">
                                <thead class="table-light">
                                    <tr>
                                        <th>Tenant ID</th>
                                        <th>Owner</th>
                                        <th>Domain</th>
                                        <th>Created</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @forelse($tenants->take(5) as $tenant)
                                        <tr>
                                            <td>
                                                <code>{{ $tenant->id }}</code>
                                            </td>
                                            <td>
                                                <div>
                                                    <strong>{{ $tenant->owner->fname ?? 'N/A' }} {{ $tenant->owner->lname ?? '' }}</strong>
                                                    <br>
                                                    <small class="text-muted">{{ $tenant->owner->email ?? 'N/A' }}</small>
                                                </div>
                                            </td>
                                            <td>
                                                @if($tenant->domains->count() > 0)
                                                    <span class="badge bg-primary">{{ $tenant->domains->first()->domain }}</span>
                                                @else
                                                    <span class="text-muted">No domain</span>
                                                @endif
                                            </td>
                                            <td>
                                                <small>{{ $tenant->created_at->format('M d, Y') }}</small>
                                            </td>
                                            <td>
                                                <a href="{{ route('saas-admin.tenants.show', $tenant->id) }}" 
                                                   class="btn btn-sm btn-outline-primary">
                                                    <i class="fas fa-eye"></i>
                                                </a>
                                            </td>
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5" class="text-center py-4">
                                                <i class="fas fa-inbox fa-2x text-muted mb-2"></i>
                                                <p class="text-muted">No tenants found</p>
                                            </td>
                                        </tr>
                                    @endforelse
                                </tbody>
                            </table>
                        </div>
                        <div class="p-3 border-top">
                            <a href="{{ route('saas-admin.tenants.index') }}" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>View All Tenants
                            </a>
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
</body>
</html>
