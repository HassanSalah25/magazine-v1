@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
    @section('styles')
        <style>
            form input,
            form textarea,
            form select,
            select {
                direction: rtl;
            }
            form .note-editor.note-frame .note-editing-area .note-editable {
                direction: rtl;
                text-align: right;
            }
        </style>
    @endsection
@endif

@section('content')
    <div class="page-header">
        <h4 class="page-title">Comparison Section</h4>
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
                <a href="#">Home Page</a>
            </li>
            <li class="separator">
                <i class="flaticon-right-arrow"></i>
            </li>
            <li class="nav-item">
                <a href="#">Comparison Section</a>
            </li>
        </ul>
    </div>
    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <div class="row">
                        <div class="col-lg-10">
                            <div class="card-title">Update Comparison Section</div>
                        </div>
                        <div class="col-lg-2">
                            @if (!empty($langs))
                                <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                                    <option value="" selected disabled>Select a Language</option>
                                    @foreach ($langs as $lang)
                                        <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                                    @endforeach
                                </select>
                            @endif
                        </div>
                    </div>
                </div>
                <div class="card-body pt-5 pb-4">
                            <form id="ajaxForm" action="{{route('admin.comparison.update', $lang_id)}}" method="post">
                                @csrf
                        
                        <!-- Section Title and Subtitle -->
                        <div class="row">
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Comparison Section Title</label>
                                    <input type="text" class="form-control" name="comparison_title" value="{{ $abex->comparison_title ?? 'Unlock a 20% increase in ROI with our award-winning enterprise SEO solutions' }}" placeholder="Enter comparison title">
                                    @if ($errors->has('comparison_title'))
                                        <p class="mb-0 text-danger">{{$errors->first('comparison_title')}}</p>
                                    @endif
                                </div>
                            </div>
                            <div class="col-lg-6">
                                <div class="form-group">
                                    <label>Comparison Section Subtitle</label>
                                    <input type="text" class="form-control" name="comparison_subtitle" value="{{ $abex->comparison_subtitle ?? '' }}" placeholder="Enter comparison subtitle">
                                    @if ($errors->has('comparison_subtitle'))
                                        <p class="mb-0 text-danger">{{$errors->first('comparison_subtitle')}}</p>
                                    @endif
                                </div>
                            </div>
                        </div>

                        <hr>

                        <!-- Column 1 (SEO Wolves) -->
                        <div class="row">
                            <div class="col-lg-4">
                                <div class="card border-primary">
                                    <div class="card-header bg-primary text-white">
                                        <h5 class="mb-0">Column 1 (SEO Wolves)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Column Title</label>
                                            <input type="text" class="form-control" name="comparison_col1_title" value="{{ $abex->comparison_col1_title ?? 'SEO Wolves' }}" placeholder="Enter column title">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Features</label>
                                            <div id="col1-features">
                                                @php
                                                    $col1Features = $abex->comparison_col1_features ?? [
                                                        ['text' => 'Dedicated account manager with an in-house team to develop and implement assets', 'type' => 'check'],
                                                        ['text' => 'All-in-one platform for optimizing, measuring, and reporting SEO\'s ROI', 'type' => 'check'],
                                                        ['text' => 'Built from your business objectives, market changes, and overall marketing efforts', 'type' => 'check'],
                                                        ['text' => 'In-house project management software, 24/7 help desk, and direct client phone line', 'type' => 'check']
                                                    ];
                                                @endphp
                                                @foreach($col1Features as $index => $feature)
                                                <div class="feature-item mb-3 p-3 border rounded">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Feature {{ $index + 1 }}</label>
                                                            <input type="text" class="form-control" name="col1_feature_text_{{ $index }}" value="{{ $feature['text'] }}" placeholder="Enter feature description">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Type</label>
                                                            <select class="form-control" name="col1_feature_type_{{ $index }}">
                                                                <option value="check" {{ $feature['type'] == 'check' ? 'selected' : '' }}>✓ Check</option>
                                                                <option value="cross" {{ $feature['type'] == 'cross' ? 'selected' : '' }}>✗ Cross</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-danger btn-sm remove-feature" data-column="col1">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" onclick="addFeature('col1')">Add Feature</button>
                                            <input type="hidden" name="comparison_col1_features" id="col1-features-json">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 2 (Typical SEO Agency) -->
                            <div class="col-lg-4">
                                <div class="card border-warning">
                                    <div class="card-header bg-warning text-dark">
                                        <h5 class="mb-0">Column 2 (Typical SEO Agency)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Column Title</label>
                                            <input type="text" class="form-control" name="comparison_col2_title" value="{{ $abex->comparison_col2_title ?? 'Typical SEO agency' }}" placeholder="Enter column title">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Features</label>
                                            <div id="col2-features">
                                                @php
                                                    $col2Features = $abex->comparison_col2_features ?? [
                                                        ['text' => 'Dedicated account manager that\'ll need your time to develop and implement assets', 'type' => 'check'],
                                                        ['text' => 'Third-party toolkit for tracking SEO\'s performance with subscription costs passed to you', 'type' => 'cross'],
                                                        ['text' => 'Copy-and-paste checklist for optimizing your site and (hopefully) delivering results', 'type' => 'cross']
                                                    ];
                                                @endphp
                                                @foreach($col2Features as $index => $feature)
                                                <div class="feature-item mb-3 p-3 border rounded">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Feature {{ $index + 1 }}</label>
                                                            <input type="text" class="form-control" name="col2_feature_text_{{ $index }}" value="{{ $feature['text'] }}" placeholder="Enter feature description">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Type</label>
                                                            <select class="form-control" name="col2_feature_type_{{ $index }}">
                                                                <option value="check" {{ $feature['type'] == 'check' ? 'selected' : '' }}>✓ Check</option>
                                                                <option value="cross" {{ $feature['type'] == 'cross' ? 'selected' : '' }}>✗ Cross</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-danger btn-sm remove-feature" data-column="col2">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" onclick="addFeature('col2')">Add Feature</button>
                                            <input type="hidden" name="comparison_col2_features" id="col2-features-json">
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Column 3 (In-house SEO) -->
                            <div class="col-lg-4">
                                <div class="card border-danger">
                                    <div class="card-header bg-danger text-white">
                                        <h5 class="mb-0">Column 3 (In-house SEO)</h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label>Column Title</label>
                                            <input type="text" class="form-control" name="comparison_col3_title" value="{{ $abex->comparison_col3_title ?? 'In-house SEO' }}" placeholder="Enter column title">
                                        </div>
                                        
                                        <div class="form-group">
                                            <label>Features</label>
                                            <div id="col3-features">
                                                @php
                                                    $col3Features = $abex->comparison_col3_features ?? [
                                                        ['text' => 'One or more team members searching for the time to optimize 200+ ranking factors', 'type' => 'cross'],
                                                        ['text' => 'Free and paid tools for auditing, monitoring, and measuring rankings and traffic', 'type' => 'cross'],
                                                        ['text' => 'S.M.A.R.T. goals, but difficult to achieve with limited resources, time, and skillsets', 'type' => 'check'],
                                                        ['text' => 'Varied with documentation gaps leading to project delays and wasted budget.', 'type' => 'cross']
                                                    ];
                                                @endphp
                                                @foreach($col3Features as $index => $feature)
                                                <div class="feature-item mb-3 p-3 border rounded">
                                                    <div class="row">
                                                        <div class="col-md-8">
                                                            <label class="form-label">Feature {{ $index + 1 }}</label>
                                                            <input type="text" class="form-control" name="col3_feature_text_{{ $index }}" value="{{ $feature['text'] }}" placeholder="Enter feature description">
                                                        </div>
                                                        <div class="col-md-3">
                                                            <label class="form-label">Type</label>
                                                            <select class="form-control" name="col3_feature_type_{{ $index }}">
                                                                <option value="check" {{ $feature['type'] == 'check' ? 'selected' : '' }}>✓ Check</option>
                                                                <option value="cross" {{ $feature['type'] == 'cross' ? 'selected' : '' }}>✗ Cross</option>
                                                            </select>
                                                        </div>
                                                        <div class="col-md-1 d-flex align-items-end">
                                                            <button type="button" class="btn btn-danger btn-sm remove-feature" data-column="col3">Remove</button>
                                                        </div>
                                                    </div>
                                                </div>
                                                @endforeach
                                            </div>
                                            <button type="button" class="btn btn-success btn-sm" onclick="addFeature('col3')">Add Feature</button>
                                            <input type="hidden" name="comparison_col3_features" id="col3-features-json">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </form>
                </div>

                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="button" id="testBtn" class="btn btn-info mr-2">Test JSON Conversion</button>
                                <button type="submit" id="submitBtn" class="btn btn-success">Update Comparison Section</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

@endsection

@section('scripts')
<script>
let featureCounters = {
    col1: {{ count($col1Features ?? []) }},
    col2: {{ count($col2Features ?? []) }},
    col3: {{ count($col3Features ?? []) }}
};

function addFeature(column) {
    const container = document.getElementById(column + '-features');
    const index = featureCounters[column];
    
    const featureHtml = `
        <div class="feature-item mb-3 p-3 border rounded">
            <div class="row">
                <div class="col-md-8">
                    <label class="form-label">Feature ${index + 1}</label>
                    <input type="text" class="form-control" name="${column}_feature_text_${index}" placeholder="Enter feature description">
                </div>
                <div class="col-md-3">
                    <label class="form-label">Type</label>
                    <select class="form-control" name="${column}_feature_type_${index}">
                        <option value="check">✓ Check</option>
                        <option value="cross">✗ Cross</option>
                    </select>
                </div>
                <div class="col-md-1 d-flex align-items-end">
                    <button type="button" class="btn btn-danger btn-sm remove-feature" data-column="${column}">Remove</button>
                </div>
            </div>
        </div>
    `;
    
    container.insertAdjacentHTML('beforeend', featureHtml);
    featureCounters[column]++;
}

// Remove feature functionality
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('remove-feature')) {
        e.target.closest('.feature-item').remove();
    }
});

// Function to convert form data to JSON
function convertFeaturesToJson() {
    ['col1', 'col2', 'col3'].forEach(column => {
        const features = [];
        const featureItems = document.querySelectorAll(`#${column}-features .feature-item`);
        
        console.log(`Processing ${column} features:`, featureItems.length, 'items');
        
        featureItems.forEach((item, index) => {
            const textInput = item.querySelector(`input[name="${column}_feature_text_${index}"]`);
            const typeSelect = item.querySelector(`select[name="${column}_feature_type_${index}"]`);
            
            if (textInput && textInput.value.trim() !== '') {
                features.push({
                    text: textInput.value.trim(),
                    type: typeSelect.value
                });
                console.log(`Added ${column} feature ${index}:`, textInput.value.trim(), typeSelect.value);
            }
        });
        
        // Update the hidden input with JSON data
        const jsonData = JSON.stringify(features);
        document.getElementById(`${column}-features-json`).value = jsonData;
        console.log(`${column} features JSON:`, jsonData);
    });
}

// Convert form data to JSON before submission
document.getElementById('ajaxForm').addEventListener('submit', function(e) {
    convertFeaturesToJson(); // Convert data to JSON first
    // Let the form submit normally after conversion
});

// Also convert when submit button is clicked
document.getElementById('submitBtn').addEventListener('click', function(e) {
    convertFeaturesToJson(); // Convert data to JSON first
});

// Test button to manually trigger conversion
document.getElementById('testBtn').addEventListener('click', function(e) {
    convertFeaturesToJson(); // Convert data to JSON first
    alert('JSON conversion completed! Check console for details.');
});
</script>
@endsection