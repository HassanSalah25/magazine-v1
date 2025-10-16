@extends('admin.layout')

@if(!empty($abs->language) && $abs->language->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form)  textarea,
    form:not(.modal-form)  select {
        direction: rtl;
    }
    form:not(.modal-form)  .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
<div class="page-header">
    <h4 class="page-title">How We Do It Section</h4>
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
            <a href="#">Home</a>
        </li>
        <li class="separator">
            <i class="flaticon-right-arrow"></i>
        </li>
        <li class="nav-item">
            <a href="#">How We Do It Section</a>
        </li>
    </ul>
</div>
<div class="row">
    <div class="col-md-12">

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title">Section Title & Subtitle</div>
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
            <form class="" action="{{route('admin.howwedoit.update', $lang_id)}}" method="post" id="sectionUpdateForm">
                @csrf
                <input type="hidden" name="id" value="{{request()->input('id')}}">
                <input type="hidden" name="form_type" value="section_update">
                <div class="card-body">
                    <div class="row">
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Title **</label>
                                <input class="form-control" name="how_we_do_it_title" value="{{$howWeDoItSection->title}}" placeholder="Enter Title">
                                @if ($errors->has('how_we_do_it_title'))
                                <p class="mb-0 text-danger">{{$errors->first('how_we_do_it_title')}}</p>
                                @endif
                            </div>
                        </div>
                        <div class="col-lg-6">
                            <div class="form-group">
                                <label>Subtitle</label>
                                <input class="form-control" name="how_we_do_it_subtitle" value="{{$howWeDoItSection->subtitle}}" placeholder="Enter Subtitle">
                                @if ($errors->has('how_we_do_it_subtitle'))
                                <p class="mb-0 text-danger">{{$errors->first('how_we_do_it_subtitle')}}</p>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="form">
                        <div class="form-group from-show-notify row">
                            <div class="col-12 text-center">
                                <button type="submit" class="btn btn-success">Update</button>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>

        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-10">
                        <div class="card-title">Manage Tabs</div>
                    </div>
                    <div class="col-lg-2">
                        <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#addTabModal">
                            <i class="fas fa-plus"></i> Add Tab
                        </button>
                    </div>
                </div>
            </div>
            <div class="card-body">
                @if (count($tabs) > 0)
                <div class="table-responsive">
                    <table class="table table-striped mt-3" id="basic-datatables">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Title</th>
                            <th scope="col">Content Preview</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        <tbody>
                        @foreach ($tabs as $key => $tab)
                        <tr>
                            <td>{{$key + 1}}</td>
                            <td>{{$tab['title']}}</td>
                            <td>{{Str::limit(strip_tags($tab['content']), 100)}}</td>
                            <td>
                                <!-- <button type="button" class="btn btn-primary btn-sm" data-toggle="modal" data-target="#editTabModal{{$key}}">
                                    <i class="fas fa-edit"></i> Edit
                                </button> -->
                                <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteTabModal{{$key}}">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </td>
                        </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
                @else
                <h3 class="text-center">No tabs found</h3>
                @endif
            </div>
        </div>
    </div>
</div>

<!-- Add Tab Modal -->
<div class="modal fade" id="addTabModal" tabindex="-1" role="dialog" aria-labelledby="addTabModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="addTabModalLabel">Add New Tab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.howwedoit.tab.store')}}" method="post">
                @csrf
                <input type="hidden" name="tab_section_id" value="{{request()->input('id')}}">
                <input type="hidden" name="tab_language" value="{{request()->input('language')}}">
                <div class="modal-body">
                    <div class="form-group">
                        <label>Tab Title **</label>
                        <input class="form-control" name="title" placeholder="Enter Tab Title" required>
                    </div>
                    <div class="form-group">
                        <label>Tab Content **</label>
                        <textarea class="form-control summernote" name="content" placeholder="Enter Tab Content" required></textarea>
                    </div>
                    <div class="form-group">
                        <label>Tab Image</label>
                        <div class="thumb-preview" id="thumbPreviewAdd">
                            <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="Tab Image">
                        </div>
                        <br>
                        <input id="fileInputAdd" type="hidden" name="image">
                        <button id="chooseImageAdd" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModalAdd">Choose Image</button>
                        <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                        <!-- Image LFM Modal -->
                        <div class="modal fade lfm-modal" id="lfmModalAdd" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitleAdd" aria-hidden="true">
                            <i class="fas fa-times-circle"></i>
                            <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                <div class="modal-content">
                                    <div class="modal-body p-0">
                                        <iframe src="{{url('laravel-filemanager')}}?serial=Add" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                    <button type="submit" class="btn btn-primary">Add Tab</button>
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Edit Tab Modals -->
@foreach ($tabs as $key => $tab)
<div class="modal fade" id="editTabModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="editTabModalLabel{{$key}}" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <form action="{{route('admin.howwedoit.tab.update')}}" method="post" id="editTabForm{{$key}}">
                    @csrf
                    <input type="hidden" name="tab_section_id" value="{{request()->input('id')}}">
                    <input type="hidden" name="tab_language" value="{{request()->input('language')}}">
                    <input type="hidden" name="tab_id" value="{{$tab['id']}}">
                    <input type="hidden" name="form_type" value="tab_update">
                    <div class="modal-header">
                        <h5 class="modal-title" id="editTabModalLabel{{$key}}">Edit Tab</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        <div class="form-group">
                            <label>Tab Title **</label>
                            <input class="form-control" name="title" value="{{$tab['title']}}" placeholder="Enter Tab Title" required>
                        </div>
                        <div class="form-group">
                            <label>Tab Content **</label>
                            <textarea class="form-control summernote" name="content" placeholder="Enter Tab Content" required>{{$tab['content']}}</textarea>
                        </div>
                        <div class="form-group">
                            <label>Tab Image</label>
                            <div class="thumb-preview" id="thumbPreviewEdit{{$key}}">
                                <img src="{{isset($tab['image']) && $tab['image'] ? asset($tab['image']) : asset('assets/admin/img/noimage.jpg')}}" alt="Tab Image">
                            </div>
                            <br>
                            <input id="fileInputEdit{{$key}}" type="hidden" name="image" value="{{$tab['image'] ?? ''}}">
                            <button id="chooseImageEdit{{$key}}" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModalEdit{{$key}}">Choose Image</button>
                            <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                            <!-- Image LFM Modal -->
                            <div class="modal fade lfm-modal" id="lfmModalEdit{{$key}}" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitleEdit{{$key}}" aria-hidden="true">
                                <i class="fas fa-times-circle"></i>
                                <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                                    <div class="modal-content">
                                        <div class="modal-body p-0">
                                            <iframe src="{{url('laravel-filemanager')}}?serial=Edit{{$key}}" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" form="editTabForm{{$key}}">Update Tab</button>
                    </div>
                </form>
            </div>
        </div>
</div>

<!-- Delete Tab Modal -->
<div class="modal fade" id="deleteTabModal{{$key}}" tabindex="-1" role="dialog" aria-labelledby="deleteTabModalLabel{{$key}}" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="deleteTabModalLabel{{$key}}">Delete Tab</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{route('admin.howwedoit.tab.delete')}}" method="post">
                @csrf
                <input type="hidden" name="tab_section_id" value="{{request()->input('id')}}">
                <input type="hidden" name="tab_language" value="{{request()->input('language')}}">
                <input type="hidden" name="tab_id" value="{{$tab['id']}}">
                <div class="modal-body">
                    <p>Are you sure you want to delete this tab?</p>
                    <strong>{{$tab['title']}}</strong>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
                    <button type="submit" class="btn btn-danger">Delete</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endforeach

@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // LFM for Add Tab Modal
        $('#chooseImageAdd').on('click', function() {
            $('#lfmModalAdd').modal('show');
        });

        // LFM for Edit Tab Modals
        @foreach ($tabs as $key => $tab)
        $('#chooseImageEdit{{$key}}').on('click', function() {
            $('#lfmModalEdit{{$key}}').modal('show');
        });
        @endforeach

        // Debug form submissions
        $('form[action*="howwedoit.tab.update"]').on('submit', function(e) {
            console.log('Tab Update Form submit event triggered');
            console.log('Form ID:', $(this).attr('id'));
            console.log('Form action:', $(this).attr('action'));
            console.log('Form data:', $(this).serialize());
            
            // Check if summernote content is properly included
            var content = $(this).find('textarea.summernote').val();
            console.log('Summernote content:', content);
            
            // Check if all required fields are filled
            var title = $(this).find('input[name="title"]').val();
            var tabId = $(this).find('input[name="tab_id"]').val();
            var tabLanguage = $(this).find('input[name="tab_language"]').val();
            var formType = $(this).find('input[name="form_type"]').val();
            console.log('Title:', title);
            console.log('Tab ID:', tabId);
            console.log('Tab Language:', tabLanguage);
            console.log('Form Type:', formType);
            
            if (!title || !content || !tabId || !tabLanguage) {
                e.preventDefault();
                alert('Please fill in all required fields');
                return false;
            }
        });

        // Debug section form submissions
        $('#sectionUpdateForm').on('submit', function(e) {
            console.log('Section Update Form submit event triggered');
            console.log('Form ID:', $(this).attr('id'));
            console.log('Form action:', $(this).attr('action'));
            console.log('Form data:', $(this).serialize());
        });
    });

    // LFM callback functions - these are called by the LFM iframe
    window.lfmAddCallback = function(path, id) {
        $('#fileInputAdd').val(path);
        $('#thumbPreviewAdd img').attr('src', path);
        window.closeLfmModal('Add');
    };

    @foreach ($tabs as $key => $tab)
    window.lfmEdit{{$key}}Callback = function(path, id) {
        $('#fileInputEdit{{$key}}').val(path);
        $('#thumbPreviewEdit{{$key}} img').attr('src', path);
        window.closeLfmModal('Edit{{$key}}');
    };
    @endforeach
</script>
@endsection
