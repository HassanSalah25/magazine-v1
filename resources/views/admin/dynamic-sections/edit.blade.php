@extends('admin.layout')

@section('content')
<div class="page-header">
    <h4 class="page-title">Edit Dynamic Section</h4>
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
            <a href="{{ route('admin.homepagesection.index') }}">Homepage Sections</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">Edit</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <form action="{{ route('admin.dynamic-sections.update', $dynamicSection->id) }}" method="POST">
                @csrf
                @method('PUT')
                <div class="card-header">
                    <div class="card-title">Section Information</div>
                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title</label>
                                <input type="text" class="form-control" name="name" value="{{ old('name', $dynamicSection->name) }}">
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Template Type</label>
                                <select class="form-control" name="template_type" required>
                                    <option value="">Select Template</option>
                                    <option value="template_1" {{ old('template_type', $dynamicSection->template_type) == 'template_1' ? 'selected' : '' }}>
                                        Template 1 (Opinions Style)
                                    </option>
                                    <option value="template_2" {{ old('template_type', $dynamicSection->template_type) == 'template_2' ? 'selected' : '' }}>
                                        Template 2 (World Style)
                                    </option>
                                </select>
                                @error('type')
                                    <p class="text-danger">{{ $message }}</p>
                                @enderror
                            </div>
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Status</label>
                                <div class="mt-2">
                                    <label class="status-toggle">
                                        <input type="checkbox" 
                                               name="is_active" 
                                               value="1" 
                                               {{ old('is_active', $dynamicSection->is_active) ? 'checked' : '' }}>
                                        <div class="status-toggle-track"></div>
                                        <div class="status-toggle-knob">
                                            <div class="status-toggle-face status-toggle-face--off"></div>
                                            <div class="status-toggle-face status-toggle-face--on"></div>
                                        </div>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-action">
                    <button type="submit" class="btn btn-success">Update Section</button>
                    <a href="{{ route('admin.homepagesection.index') }}" class="btn btn-danger">Cancel</a>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection
