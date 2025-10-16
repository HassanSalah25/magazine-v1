@extends('admin.layout')

@section('title', 'Manage Tenants')

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header">
                    <h3 class="card-title">All Tenants</h3>
                    <div class="card-tools">
                        <a href="{{ route('admin.tenants.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus"></i> Create New Tenant
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

                    <div class="table-responsive">
                        <table class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Owner</th>
                                    <th>Domain</th>
                                    <th>Users Count</th>
                                    <th>Created At</th>
                                    <th>Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($tenants as $tenant)
                                    <tr>
                                        <td>{{ $tenant->id }}</td>
                                        <td>
                                            @if($tenant->owner)
                                                {{ $tenant->owner->fname }} {{ $tenant->owner->lname }}
                                                <br><small class="text-muted">{{ $tenant->owner->email }}</small>
                                            @else
                                                <span class="text-muted">No owner</span>
                                            @endif
                                        </td>
                                        <td>
                                            @if($tenant->domains->count() > 0)
                                                <a href="http://{{ $tenant->domains->first()->domain }}" target="_blank">
                                                    {{ $tenant->domains->first()->domain }}
                                                </a>
                                            @else
                                                <span class="text-muted">No domain</span>
                                            @endif
                                        </td>
                                        <td>{{ $tenant->users->count() }}</td>
                                        <td>{{ $tenant->created_at->format('M d, Y H:i') }}</td>
                                        <td>
                                            <div class="btn-group">
                                                <a href="{{ route('admin.tenants.show', $tenant->id) }}" 
                                                   class="btn btn-sm btn-info">View</a>
                                                <form action="{{ route('admin.tenants.destroy', $tenant->id) }}" 
                                                      method="POST" style="display: inline;">
                                                    @csrf
                                                    @method('DELETE')
                                                    <button type="submit" class="btn btn-sm btn-danger" 
                                                            onclick="return confirm('Are you sure you want to delete this tenant?')">
                                                        Delete
                                                    </button>
                                                </form>
                                            </div>
                                        </td>
                                    </tr>
                                @empty
                                    <tr>
                                        <td colspan="6" class="text-center">No tenants found</td>
                                    </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>

                    {{ $tenants->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
