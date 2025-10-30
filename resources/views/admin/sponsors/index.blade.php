@extends('admin.layout')

@php
$selLang = \App\Models\Language::where('code', request()->input('language'))->first();
@endphp
@if(!empty($selLang) && $selLang->rtl == 1)
@section('styles')
<style>
    form:not(.modal-form) input,
    form:not(.modal-form) textarea,
    form:not(.modal-form) select,
    select[name='language'] {
        direction: rtl;
    }
    form:not(.modal-form) .note-editor.note-frame .note-editing-area .note-editable {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif

@section('content')
<div class="page-header">
    <h4 class="page-title">Sponsor Management</h4>
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
            <a href="#">Sponsor Management</a>
        </li>
    </ul>
</div>

<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <div class="row">
                    <div class="col-lg-4">
                        <div class="card-title d-inline-block">Sponsors</div>
                    </div>
                    <div class="col-lg-3">
                        @if (!empty($langs))
                        <select name="language" class="form-control" onchange="window.location='{{url()->current() . '?language='}}'+this.value">
                            <option value="" selected disabled>Select a Language</option>
                            @foreach ($langs as $lang)
                            <option value="{{$lang->code}}" {{$lang->code == request()->input('language') ? 'selected' : ''}}>{{$lang->name}}</option>
                            @endforeach
                        </select>
                        @endif
                    </div>
                    <div class="col-lg-4 offset-lg-1 mt-2 mt-lg-0">
                        <a href="#" class="btn btn-primary float-lg-right float-left" data-toggle="modal" data-target="#createModal">
                            <i class="fas fa-plus"></i> Add Sponsor
                        </a>
                    </div>
                </div>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-12">
                        @if (count($partners) == 0)
                        <h3 class="text-center">NO SPONSORS FOUND</h3>
                        @else
                        <div class="row">
                            @foreach ($partners as $key => $partner)
                            <div class="col-md-4 mb-4">
                                <div class="card h-100">
                                    <div class="card-body">
                                        <div class="text-center mb-3">
                                            <img src="{{asset('assets/front/img/partners/'.$partner->image)}}" 
                                                 alt="{{$partner->image_alt ?? $partner->name}}" 
                                                 style="width:100%; height: 150px; object-fit: cover; border-radius: 8px;">
                                        </div>
                                        <h6 class="card-title">{{$partner->name}}</h6>
                                        @if($partner->description)
                                            <p class="card-text text-muted small">{{Str::limit($partner->description, 100)}}</p>
                                        @endif
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <small class="text-muted">
                                                @if($partner->is_google_ads)
                                                    <span class="badge badge-info">Google Ads</span>
                                                @endif
                                                @if($partner->is_active)
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-secondary">Inactive</span>
                                                @endif
                                            </small>
                                            <small class="text-muted">#{{$partner->serial_number}}</small>
                                        </div>
                                        @if($partner->start_date || $partner->end_date)
                                            <div class="small text-muted">
                                                @if($partner->start_date)
                                                    <div>Start: {{$partner->start_date->format('M d, Y')}}</div>
                                                @endif
                                                @if($partner->end_date)
                                                    <div>End: {{$partner->end_date->format('M d, Y')}}</div>
                                                @endif
                                            </div>
                                        @endif
                                    </div>
                                    <div class="card-footer">
                                        <div class="btn-group w-100" role="group">
                                            <a class="btn btn-secondary btn-sm" href="{{route('admin.partner.edit', $partner->id) . '?language=' . request()->input('language')}}">
                                                <i class="fas fa-edit"></i> Edit
                                            </a>
                                            <button type="button" class="btn btn-{{$partner->is_active ? 'warning' : 'success'}} btn-sm toggle-status" 
                                                    data-id="{{$partner->id}}">
                                                <i class="fas fa-{{$partner->is_active ? 'pause' : 'play'}}"></i> 
                                                {{$partner->is_active ? 'Deactivate' : 'Activate'}}
                                            </button>
                                            <form class="d-inline" action="{{route('admin.partner.delete')}}" method="post">
                                                @csrf
                                                <input type="hidden" name="partner_id" value="{{$partner->id}}">
                                                <button type="submit" class="btn btn-danger btn-sm deletebtn">
                                                    <i class="fas fa-trash"></i> Delete
                                                </button>
                                            </form>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Create Sponsor Modal -->
<div class="modal fade" id="createModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalCenterTitle" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">Add Sponsor</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="ajaxForm" class="modal-form" action="{{route('admin.partner.store')}}" method="post">
                    @csrf
                    {{-- Image Part --}}
                    <div class="form-group">
                        <label for="">Image ** </label>
                        <br>
                        <div class="thumb-preview" id="thumbPreview1">
                            <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="User Image">
                        </div>
                        <br>
                        <br>
                        <input id="fileInput1" type="hidden" name="image">
                        <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>
                        <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                        <p class="em text-danger mb-0" id="errimage"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Language **</label>
                        <select name="language_id" class="form-control">
                            <option value="" selected disabled>Select a language</option>
                            @foreach ($langs as $lang)
                            <option value="{{$lang->id}}">{{$lang->name}}</option>
                            @endforeach
                        </select>
                        <p id="errlanguage_id" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Sponsor Name **</label>
                        <input type="text" class="form-control" name="name" value="" placeholder="Enter Sponsor Name">
                        <p id="errname" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Description</label>
                        <textarea class="form-control" name="description" rows="3" placeholder="Enter Description"></textarea>
                        <p id="errdescription" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Image Alt Text</label>
                        <input type="text" class="form-control" name="image_alt" value="" placeholder="Enter Alt Text for Image">
                        <p id="errimage_alt" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">URL **</label>
                        <input type="text" class="form-control ltr" name="url" value="" placeholder="Enter URL">
                        <p id="errurl" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group">
                        <label for="">Serial Number **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="" placeholder="Enter Serial Number">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning"><small>The higher the serial number is, the later the sponsor will be shown.</small></p>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_active" id="is_active" checked>
                            <label class="form-check-label" for="is_active">
                                Active
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <div class="form-check">
                            <input type="checkbox" class="form-check-input" name="is_google_ads" id="is_google_ads">
                            <label class="form-check-label" for="is_google_ads">
                                Google Ads Sponsor
                            </label>
                        </div>
                    </div>
                    
                    <div class="form-group" id="google_ads_fields" style="display: none;">
                        <label for="">Google Ads Script</label>
                        <textarea class="form-control" name="google_ads_script" rows="3" placeholder="Enter Google Ads Script"></textarea>
                        <p id="errgoogle_ads_script" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="form-group" id="google_ads_placement_field" style="display: none;">
                        <label for="">Google Ads Placement</label>
                        <input type="text" class="form-control" name="google_ads_placement" placeholder="Enter Placement (e.g., header, sidebar, footer)">
                        <p id="errgoogle_ads_placement" class="mb-0 text-danger em"></p>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">Start Date</label>
                                <input type="datetime-local" class="form-control" name="start_date">
                                <p id="errstart_date" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label for="">End Date</label>
                                <input type="datetime-local" class="form-control" name="end_date">
                                <p id="errend_date" class="mb-0 text-danger em"></p>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button id="submitBtn" type="button" class="btn btn-primary">Submit</button>
            </div>
        </div>
    </div>
</div>

<!-- Image LFM Modal -->
<div class="modal fade lfm-modal" id="lfmModal1" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle" aria-hidden="true">
    <i class="fas fa-times-circle"></i>
    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-body p-0">
                <iframe src="{{url('laravel-filemanager')}}?serial=1" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    $(document).ready(function() {
        // Toggle Google Ads fields
        $('#is_google_ads').on('change', function() {
            if ($(this).is(':checked')) {
                $('#google_ads_fields').show();
                $('#google_ads_placement_field').show();
            } else {
                $('#google_ads_fields').hide();
                $('#google_ads_placement_field').hide();
            }
        });

        // Toggle sponsor status
        $('.toggle-status').on('click', function() {
            var id = $(this).data('id');
            var button = $(this);
            
            $.ajax({
                url: '{{route("admin.sponsor.toggle-status")}}',
                method: 'POST',
                data: {
                    _token: '{{csrf_token()}}',
                    id: id
                },
                success: function(response) {
                    if (response.status === 'active') {
                        button.removeClass('btn-success').addClass('btn-warning');
                        button.html('<i class="fas fa-pause"></i> Deactivate');
                        button.closest('.card').find('.badge-secondary').removeClass('badge-secondary').addClass('badge-success').text('Active');
                    } else {
                        button.removeClass('btn-warning').addClass('btn-success');
                        button.html('<i class="fas fa-play"></i> Activate');
                        button.closest('.card').find('.badge-success').removeClass('badge-success').addClass('badge-secondary').text('Inactive');
                    }
                }
            });
        });

        // make input fields RTL
        $("select[name='language_id']").on('change', function() {
            $(".request-loader").addClass("show");
            let url = "{{url('/')}}/admin/rtlcheck/" + $(this).val();
            console.log(url);
            $.get(url, function(data) {
                $(".request-loader").removeClass("show");
                if (data == 1) {
                    $("form.modal-form input").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form select").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form textarea").each(function() {
                        if (!$(this).hasClass('ltr')) {
                            $(this).addClass('rtl');
                        }
                    });
                    $("form.modal-form .nicEdit-main").each(function() {
                        $(this).addClass('rtl text-right');
                    });

                } else {
                    $("form.modal-form input, form.modal-form select, form.modal-form textarea").removeClass('rtl');
                    $("form.modal-form .nicEdit-main").removeClass('rtl text-right');
                }
            })
        });
    });
</script>
@endsection
