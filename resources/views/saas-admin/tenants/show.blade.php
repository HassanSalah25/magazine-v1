<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tenant Details - SaaS Admin</title>
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
        .info-card {
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
        .badge {
            font-size: 0.75em;
        }
        .tenant-id {
            font-family: 'Courier New', monospace;
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 6px;
            border: 1px solid #dee2e6;
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
                        <h2><i class="fas fa-building me-2"></i>Tenant Details</h2>
                        <div>
                            <a href="{{ route('saas-admin.tenants.index') }}" class="btn btn-outline-secondary me-2">
                                <i class="fas fa-arrow-left me-2"></i>Back to Tenants
                            </a>
                            <button type="button" class="btn btn-danger" onclick="deleteTenant()">
                                <i class="fas fa-trash me-2"></i>Delete Tenant
                            </button>
                        </div>
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

                    <div class="row">
                        <!-- Tenant Information -->
                        <div class="col-lg-8 mb-4">
                            <div class="info-card">
                                <div class="p-4">
                                    <h5 class="mb-4"><i class="fas fa-info-circle me-2"></i>Tenant Information</h5>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Tenant ID:</strong></div>
                                        <div class="col-sm-9">
                                            <code class="tenant-id">{{ $tenant->id }}</code>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Database:</strong></div>
                                        <div class="col-sm-9">
                                            <code class="tenant-id">{{ $tenant->tenancy_db_name ?? 'N/A' }}</code>
                                        </div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Created:</strong></div>
                                        <div class="col-sm-9">{{ $tenant->created_at->format('M d, Y H:i:s') }}</div>
                                    </div>
                                    
                                    <div class="row mb-3">
                                        <div class="col-sm-3"><strong>Updated:</strong></div>
                                        <div class="col-sm-9">{{ $tenant->updated_at->format('M d, Y H:i:s') }}</div>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <!-- Owner Information -->
                        <div class="col-lg-4 mb-4">
                            <div class="info-card">
                                <div class="p-4">
                                    <h5 class="mb-4"><i class="fas fa-user me-2"></i>Owner</h5>
                                    
                                    @if($tenant->owner)
                                        <div class="text-center mb-3">
                                            <div class="bg-primary text-white rounded-circle d-inline-flex align-items-center justify-content-center" 
                                                 style="width: 60px; height: 60px; font-size: 24px;">
                                                {{ substr($tenant->owner->fname, 0, 1) }}{{ substr($tenant->owner->lname, 0, 1) }}
                                            </div>
                                        </div>
                                        
                                        <div class="text-center">
                                            <h6 class="mb-1">{{ $tenant->owner->fname }} {{ $tenant->owner->lname }}</h6>
                                            <p class="text-muted mb-2">{{ $tenant->owner->email }}</p>
                                            @if($tenant->owner->username)
                                                <span class="badge bg-secondary">{{ $tenant->owner->username }}</span>
                                            @endif
                                        </div>
                                    @else
                                        <p class="text-muted text-center">No owner assigned</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Subdomain -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="info-card">
                                <div class="p-4">
                                    <h5 class="mb-3"><i class="fas fa-globe me-2"></i>Subdomain</h5>
                                    
                                    @if($tenant->domains->count() > 0)
                                        <div class="row">
                                            @foreach($tenant->domains as $domain)
                                                <div class="col-md-6 mb-2">
                                                    <div class="d-flex align-items-center justify-content-between p-2 bg-light rounded">
                                                        <div>
                                                            <span class="badge bg-success">{{ $domain->domain }}</span>
                                                            <small class="text-muted d-block">Auto-generated Subdomain</small>
                                                        </div>
                                                        <small class="text-muted">{{ $domain->created_at->format('M d, Y') }}</small>
                                                    </div>
                                                </div>
                                            @endforeach
                                        </div>
                                    @else
                                        <div class="alert alert-info">
                                            <i class="fas fa-info-circle me-2"></i>
                                            <strong>Subdomain:</strong> <code>{{ $tenant->id }}.{{ request()->getHost() }}</code><br>
                                            <small class="text-muted">This subdomain will be automatically created when the tenant is accessed.</small>
                                        </div>
                                    @endif
                                    
                                    <div class="mt-3">
                                        <h6>Subdomain Information</h6>
                                        <div class="row">
                                            <div class="col-md-6">
                                                <strong>Tenant ID:</strong> <code>{{ $tenant->id }}</code>
                                            </div>
                                            <div class="col-md-6">
                                                <strong>Base Domain:</strong> <code>{{ request()->getHost() }}</code>
                                            </div>
                                        </div>
                                        <div class="mt-2">
                                            <strong>Full Subdomain:</strong> <code>{{ $tenant->id }}.{{ request()->getHost() }}</code>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users -->
                    <div class="row">
                        <div class="col-12">
                            <div class="info-card">
                                <div class="p-4">
                                    <div class="d-flex justify-content-between align-items-center mb-3">
                                        <h5 class="mb-0"><i class="fas fa-users me-2"></i>Users ({{ $tenant->users->count() }})</h5>
                                        <button type="button" class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#userModal">
                                            <i class="fas fa-plus me-1"></i>Add User
                                        </button>
                                    </div>
                                    
                                    @if($tenant->users->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-hover">
                                                <thead class="table-light">
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Created</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tenant->users as $user)
                                                        <tr>
                                                            <td>
                                                                <strong>{{ $user->fname }} {{ $user->lname }}</strong>
                                                            </td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>
                                                                @if($user->username)
                                                                    <span class="badge bg-secondary">{{ $user->username }}</span>
                                                                @else
                                                                    <span class="text-muted">-</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                @if($user->is_tenant_owner)
                                                                    <span class="badge bg-primary">Owner</span>
                                                                @else
                                                                    <span class="badge bg-info">User</span>
                                                                @endif
                                                            </td>
                                                            <td>
                                                                <small>{{ $user->created_at->format('M d, Y') }}</small>
                                                            </td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted text-center">No users found</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <!-- Add User Modal -->
    <div class="modal fade" id="userModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Add User</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <form method="POST" action="{{ route('saas-admin.tenants.add-user', $tenant->id) }}">
                    @csrf
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="fname" class="form-label">First Name</label>
                                <input type="text" class="form-control" id="fname" name="fname" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="lname" class="form-label">Last Name</label>
                                <input type="text" class="form-control" id="lname" name="lname" required>
                            </div>
                        </div>
                        <div class="mb-3">
                            <label for="email" class="form-label">Email</label>
                            <input type="email" class="form-control" id="email" name="email" required>
                        </div>
                        <div class="mb-3">
                            <label for="username" class="form-label">Username</label>
                            <input type="text" class="form-control" id="username" name="username">
                        </div>
                        <div class="row">
                            <div class="col-md-6 mb-3">
                                <label for="password" class="form-label">Password</label>
                                <input type="password" class="form-control" id="password" name="password" required>
                            </div>
                            <div class="col-md-6 mb-3">
                                <label for="password_confirmation" class="form-label">Confirm Password</label>
                                <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                        <button type="submit" class="btn btn-primary">Add User</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <!-- Delete Confirmation Modal -->
    <div class="modal fade" id="deleteModal" tabindex="-1">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Confirm Delete</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>
                <div class="modal-body">
                    <p>Are you sure you want to delete this tenant? This action cannot be undone.</p>
                    <p class="text-danger"><strong>Warning:</strong> This will also delete the tenant's database and all associated data.</p>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cancel</button>
                    <form method="POST" action="{{ route('saas-admin.tenants.delete', $tenant->id) }}" style="display: inline;">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="btn btn-danger">Delete Tenant</button>
                    </form>
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
        function deleteTenant() {
            new bootstrap.Modal(document.getElementById('deleteModal')).show();
        }
    </script>
</body>
</html>
