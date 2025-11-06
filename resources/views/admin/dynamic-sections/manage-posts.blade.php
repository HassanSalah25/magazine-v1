@extends('admin.layout')

@section('styles')
<link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
<link href="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.css" rel="stylesheet" />
<style>
    .select2-container {
        width: 100% !important;
    }
    .select2-container .selection{
        width: 100% !important;
    }
    .select2-container--default .select2-selection--single {
        height: 38px;
        border: 1px solid #ced4da;
        border-radius: 0.25rem;
    }
    .select2-container--default .select2-selection--single .select2-selection__rendered {
        line-height: 36px;
        padding-left: 12px;
    }
    .select2-container--default .select2-selection--single .select2-selection__arrow {
        height: 36px;
    }
    
    /* Drag and Drop Styles */
    .sortable-list {
        list-style: none;
        padding: 0;
    }
    .sortable-item {
        background: #fff;
        border: 1px solid #ddd;
        border-radius: 4px;
        margin-bottom: 8px;
        padding: 12px;
        cursor: move;
        transition: all 0.3s ease;
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .sortable-item:hover {
        background: #f8f9fa;
        border-color: #007bff;
    }
    .sortable-item.sortable-ghost {
        opacity: 0.4;
        background: #e3f2fd;
    }
    .sortable-item.sortable-chosen {
        background: #e3f2fd;
        border-color: #007bff;
        box-shadow: 0 2px 8px rgba(0,123,255,0.3);
    }
    .drag-handle {
        cursor: move;
        color: #6c757d;
        margin-right: 10px;
        font-size: 16px;
    }
    .drag-handle:hover {
        color: #007bff;
    }
    .post-info {
        flex: 1;
    }
    .post-actions {
        display: flex;
        gap: 5px;
    }
    .sort-order-badge {
        background: #007bff;
        color: white;
        padding: 2px 8px;
        border-radius: 12px;
        font-size: 12px;
        font-weight: bold;
        margin-right: 10px;
    }
</style>
@endsection

@section('content')
<div class="page-header">
    <h4 class="page-title">Manage Posts - {{ $dynamicSection->name }}</h4>
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
            <a href="#">Manage Posts</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Available Posts</div>
            </div>
            <div class="card-body">
                <form id="assign-post-form">
                    @csrf
                    <div class="form-group">
                        <label>Select Posts:</label>
                        <select class="form-control select2-ajax" name="blog_ids[]" multiple required>
                        </select>
                        <small class="form-text text-muted">You can select multiple posts at once</small>
                    </div>
                    <button type="submit" class="btn btn-primary">Assign Selected Posts</button>
                </form>
            </div>
        </div>
    </div>
    <div class="col-md-6">
        <div class="card">
            <div class="card-header">
                <div class="card-title">Assigned Posts</div>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <small class="text-muted">
                        <i class="fas fa-info-circle"></i> Drag and drop posts to reorder them. The order will be saved automatically.
                    </small>
                </div>
                <ul id="assigned-posts" class="sortable-list">
                    @foreach($assignedPosts as $index => $post)
                    <li class="sortable-item" data-post-id="{{ $post->id }}" data-sort-order="{{ $post->pivot->sort_order }}">
                        <div class="drag-handle">
                            <i class="fas fa-grip-vertical"></i>
                        </div>
                        <span class="sort-order-badge">{{ $index + 1 }}</span>
                        <div class="post-info">
                            <strong>{{ $post->title }}</strong>
                            @if($post->pivot->is_featured)
                                <span class="badge badge-success ml-2">Featured</span>
                            @endif
                        </div>
                        <div class="post-actions">
                            <button class="btn btn-sm btn-danger remove-post" data-post-id="{{ $post->id }}" title="Remove post">
                                <i class="fas fa-times"></i>
                            </button>
                        </div>
                    </li>
                    @endforeach
                </ul>
                @if(count($assignedPosts) == 0)
                <div class="text-center text-muted py-4">
                    <i class="fas fa-inbox fa-2x mb-2"></i>
                    <p>No posts assigned to this section yet.</p>
                </div>
                @endif
            </div>
        </div>
    </div>
    
</div>
@endsection

@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sortablejs@1.15.0/Sortable.min.js"></script>
<script>
$(document).ready(function() {
    // Initialize Select2 with AJAX
    $('.select2-ajax').select2({
        ajax: {
            url: "{{ route('admin.dynamic-sections.search-posts', $dynamicSection->id) }}",
            type: 'GET',
            dataType: 'json',
            delay: 250,
            data: function (params) {
                return {
                    q: params.term, // search term
                    page: params.page || 1
                };
            },
            processResults: function (data, params) {
                params.page = params.page || 1;
                return {
                    results: data.data.map(function (item) {
                        return {
                            id: item.id,
                            text: item.title
                        };
                    }),
                    pagination: {
                        more: data.current_page < data.last_page
                    }
                };
            },
            cache: true
        },
        allowClear: true,
        multiple: true,
        closeOnSelect: false,
        maximumSelectionLength: 20
    });

    // Initialize SortableJS for drag and drop
    const sortable = Sortable.create(document.getElementById('assigned-posts'), {
        handle: '.drag-handle',
        animation: 150,
        ghostClass: 'sortable-ghost',
        chosenClass: 'sortable-chosen',
        onEnd: function(evt) {
            updateSortOrder();
        }
    });

    // Update sort order after drag and drop
    function updateSortOrder() {
        const posts = [];
        $('#assigned-posts .sortable-item').each(function(index) {
            const postId = $(this).data('post-id');
            posts.push({
                id: postId,
                sort_order: index
            });
        });

        $.ajax({
            url: "{{ route('admin.dynamic-sections.update-post-order', $dynamicSection->id) }}",
            method: 'POST',
            data: {
                _token: '{{ csrf_token() }}',
                posts: posts
            },
            success: function(response) {
                // Update the visual order numbers
                $('#assigned-posts .sortable-item').each(function(index) {
                    $(this).find('.sort-order-badge').text(index + 1);
                });
            }
        });
    }

    // Assign post
    $('#assign-post-form').on('submit', function(e) {
        e.preventDefault();
        
        $.ajax({
            url: "{{ route('admin.dynamic-sections.assign-post', $dynamicSection->id) }}",
            method: 'POST',
            data: $(this).serialize(),
            success: function(response) {
                location.reload();
            }
        });
    });
    
    // Remove post
    $('.remove-post').on('click', function() {
        const postId = $(this).data('post-id');
        const sectionId = {{ $dynamicSection->id }};
        
        if (confirm('Are you sure you want to remove this post from the section?')) {
            // Create a form and submit it
            const form = document.createElement('form');
            form.method = 'POST';
            form.action = `/admins/dynamic-sections/${sectionId}/remove-post/${postId}`;
            
            // Add CSRF token
            const csrfInput = document.createElement('input');
            csrfInput.type = 'hidden';
            csrfInput.name = '_token';
            csrfInput.value = '{{ csrf_token() }}';
            form.appendChild(csrfInput);
            
            // Add method override for DELETE
            const methodInput = document.createElement('input');
            methodInput.type = 'hidden';
            methodInput.name = '_method';
            methodInput.value = 'DELETE';
            form.appendChild(methodInput);
            
            document.body.appendChild(form);
            form.submit();
        }
    });
});
</script>
@endsection
