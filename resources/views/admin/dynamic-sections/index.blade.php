@extends('admin.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">Dynamic Sections</h4>
    <ul class="breadcrumbs">
        <li class="nav-home">
            <a href="{{route('admin.dashboard')}}">
                <i class="flaticon-home"></i>
            </a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Dynamic Sections</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-6">
                        <div class="card-title">Dynamic Sections</div>
                    </div>
                    <div class="col-lg-6">
                        <a href="{{ route('admin.dynamic-sections.create') }}" class="btn btn-primary float-right">
                            <i class="fas fa-plus"></i> Add New Section
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-striped mt-3" id="dynamic-sections-table">
                        <thead>
                            <tr>
                                <th>Name</th>
                                <th>Template Type</th>
                                <th>Posts Count</th>
                                <th>Status</th>
                                <th>Actions</th>
                            </tr>
                        </thead>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
$(document).ready(function() {
    $('#dynamic-sections-table').DataTable({
        processing: true,
        serverSide: true,
        ajax: "{{ route('admin.dynamic-sections.index') }}",
        columns: [
            {data: 'name', name: 'name'},
            {data: 'template_type', name: 'template_type'},
            {data: 'posts_count', name: 'posts_count'},
            {data: 'is_active', name: 'is_active'},
            {data: 'actions', name: 'actions', orderable: false, searchable: false}
        ]
    });
});
</script>
@endsection
