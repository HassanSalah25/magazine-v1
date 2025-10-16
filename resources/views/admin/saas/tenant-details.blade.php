@extends('admin.layout')

@section('title', 'Tenant Details')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">Tenant Details: {{ $tenant->id }}</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tenants.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-left"></i> Back to Tenants
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if(session('success'))
                        <div class="alert alert-success">{{ session('success') }}</div>
                    @endif

                    @if(session('error'))
                        <div class="alert alert-danger">{{ session('error') }}</div>
                    @endif

                    <!-- Tenant Information -->
                    <div class="row">
                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tenant Information</h4>
                                </div>
                                <div class="card-body">
                                    <p><strong>Tenant ID:</strong> {{ $tenant->id }}</p>
                                    <p><strong>Database Name:</strong> {{ $tenant->tenancy_db_name }}</p>
                                    <p><strong>Created:</strong> {{ $tenant->created_at->format('M d, Y H:i') }}</p>
                                    
                                    @if($tenant->domains->count() > 0)
                                        <p><strong>Domain:</strong> 
                                            <a href="http://{{ $tenant->domains->first()->domain }}" target="_blank">
                                                {{ $tenant->domains->first()->domain }}
                                            </a>
                                        </p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Update Domain</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.tenants.update-domain', $tenant->id) }}" method="POST">
                                        @csrf
                                        @method('PUT')
                                        <div class="form-group">
                                            <label for="domain">New Domain</label>
                                            <input type="text" class="form-control @error('domain') is-invalid @enderror" 
                                                   id="domain" name="domain" value="{{ $tenant->domains->first()->domain ?? '' }}" required>
                                            @error('domain')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                        <button type="submit" class="btn btn-primary">Update Domain</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Owner Information -->
                    @if($tenant->owner)
                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="card">
                                    <div class="card-header">
                                        <h4>Tenant Owner</h4>
                                    </div>
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <p><strong>Name:</strong> {{ $tenant->owner->fname }} {{ $tenant->owner->lname }}</p>
                                                <p><strong>Email:</strong> {{ $tenant->owner->email }}</p>
                                                <p><strong>Username:</strong> {{ $tenant->owner->username }}</p>
                                            </div>
                                            <div class="col-md-6">
                                                <p><strong>Status:</strong> 
                                                    <span class="badge badge-{{ $tenant->owner->status ? 'success' : 'danger' }}">
                                                        {{ $tenant->owner->status ? 'Active' : 'Inactive' }}
                                                    </span>
                                                </p>
                                                <p><strong>Email Verified:</strong> 
                                                    <span class="badge badge-{{ $tenant->owner->email_verified === 'yes' ? 'success' : 'warning' }}">
                                                        {{ $tenant->owner->email_verified === 'yes' ? 'Verified' : 'Not Verified' }}
                                                    </span>
                                                </p>
                                                <p><strong>Joined:</strong> {{ $tenant->owner->created_at->format('M d, Y H:i') }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Add User Form -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Add User to Tenant</h4>
                                </div>
                                <div class="card-body">
                                    <form action="{{ route('admin.tenants.add-user', $tenant->id) }}" method="POST">
                                        @csrf
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fname">First Name *</label>
                                                    <input type="text" class="form-control @error('fname') is-invalid @enderror" 
                                                           id="fname" name="fname" value="{{ old('fname') }}" required>
                                                    @error('fname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="lname">Last Name *</label>
                                                    <input type="text" class="form-control @error('lname') is-invalid @enderror" 
                                                           id="lname" name="lname" value="{{ old('lname') }}" required>
                                                    @error('lname')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="email">Email *</label>
                                                    <input type="email" class="form-control @error('email') is-invalid @enderror" 
                                                           id="email" name="email" value="{{ old('email') }}" required>
                                                    @error('email')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="username">Username</label>
                                                    <input type="text" class="form-control @error('username') is-invalid @enderror" 
                                                           id="username" name="username" value="{{ old('username') }}">
                                                    @error('username')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password">Password *</label>
                                                    <input type="password" class="form-control @error('password') is-invalid @enderror" 
                                                           id="password" name="password" required>
                                                    @error('password')
                                                        <div class="invalid-feedback">{{ $message }}</div>
                                                    @enderror
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="password_confirmation">Confirm Password *</label>
                                                    <input type="password" class="form-control" 
                                                           id="password_confirmation" name="password_confirmation" required>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="form-group">
                                            <button type="submit" class="btn btn-success">Add User</button>
                                        </div>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Users List -->
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-header">
                                    <h4>Tenant Users ({{ $tenant->users->count() }})</h4>
                                </div>
                                <div class="card-body">
                                    @if($tenant->users->count() > 0)
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <thead>
                                                    <tr>
                                                        <th>Name</th>
                                                        <th>Email</th>
                                                        <th>Username</th>
                                                        <th>Role</th>
                                                        <th>Status</th>
                                                        <th>Joined</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    @foreach($tenant->users as $user)
                                                        <tr>
                                                            <td>{{ $user->fname }} {{ $user->lname }}</td>
                                                            <td>{{ $user->email }}</td>
                                                            <td>{{ $user->username }}</td>
                                                            <td>
                                                                <span class="badge badge-{{ $user->is_tenant_owner ? 'primary' : 'secondary' }}">
                                                                    {{ $user->is_tenant_owner ? 'Owner' : 'User' }}
                                                                </span>
                                                            </td>
                                                            <td>
                                                                <span class="badge badge-{{ $user->status ? 'success' : 'danger' }}">
                                                                    {{ $user->status ? 'Active' : 'Inactive' }}
                                                                </span>
                                                            </td>
                                                            <td>{{ $user->created_at->format('M d, Y') }}</td>
                                                        </tr>
                                                    @endforeach
                                                </tbody>
                                            </table>
                                        </div>
                                    @else
                                        <p class="text-muted">No users found in this tenant.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
