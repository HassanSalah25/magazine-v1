@extends('admin.layout')


@if(!empty($partner->language) && $partner->language->rtl == 1)
@section('styles')
<style>
    form input,
    form textarea,
    form select {
        direction: rtl;
    }
    .nicEdit-main {
        direction: rtl;
        text-align: right;
    }
</style>
@endsection
@endif


@section('content')
  <div class="page-header">
    <h4 class="page-title">Edit Partner</h4>
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
        <a href="#">Edit Partner</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Partner</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.partner.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" class="" action="{{route('admin.partner.update')}}" method="post">
                @csrf
                <input type="hidden" name="partner_id" value="{{$partner->id}}">

                {{-- Image Part --}}
                <div class="form-group">
                    <label for="">Image ** </label>
                    <br>
                    <div class="thumb-preview" id="thumbPreview1">
                        <img src="{{asset('assets/front/img/partners/'.$partner->image)}}" alt="User Image">
                    </div>
                    <br>
                    <br>


                    <input id="fileInput1" type="hidden" name="image">
                    <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                    <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                    <p class="em text-danger mb-0" id="errimage"></p>

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
                </div>
                <div class="form-group">
                  <label for="">Partner Name **</label>
                  <input type="text" class="form-control" name="name" value="{{$partner->name}}" placeholder="Enter Partner Name">
                  <p id="errname" class="text-danger mb-0 em"></p>
                </div>
                <div class="form-group">
                  <label for="">Description</label>
                  <textarea class="form-control" name="description" rows="3" placeholder="Enter Description">{{$partner->description}}</textarea>
                  <p id="errdescription" class="text-danger mb-0 em"></p>
                </div>
                <div class="form-group">
                  <label for="">Image Alt Text</label>
                  <input type="text" class="form-control" name="image_alt" value="{{$partner->image_alt}}" placeholder="Enter Alt Text for Desktop Image">
                  <p id="errimage_alt" class="text-danger mb-0 em"></p>
                </div>
                
                {{-- Mobile Image Part --}}
                <div class="form-group">
                    <label for="">Mobile Image</label>
                    <br>
                    <div class="thumb-preview" id="thumbPreview2">
                        @if($partner->mobile_image)
                            <img src="{{asset('assets/front/img/partners/'.$partner->mobile_image)}}" alt="Mobile Image">
                        @else
                            <img src="{{asset('assets/admin/img/noimage.jpg')}}" alt="Mobile Image">
                        @endif
                    </div>
                    <br>
                    <br>
                    <input id="fileInput2" type="hidden" name="mobile_image">
                    <button id="chooseImage2" class="choose-image btn btn-info" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal2">Choose Mobile Image</button>
                    <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                    <p class="em text-danger mb-0" id="errmobile_image"></p>
                </div>
                
                <div class="form-group">
                    <label for="">Mobile Image Alt Text</label>
                    <input type="text" class="form-control" name="mobile_image_alt" value="{{$partner->mobile_image_alt}}" placeholder="Enter Alt Text for Mobile Image">
                    <p id="errmobile_image_alt" class="text-danger mb-0 em"></p>
                </div>
                <div class="form-group">
                  <label for="">URL **</label>
                  <input type="text" class="form-control ltr" name="url" value="{{$partner->url}}" placeholder="Enter URL of social media account">
                  <p id="errurl" class="text-danger mb-0 em"></p>
                </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$partner->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the partner will be shown.</small></p>
                </div>
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_active" id="is_active" {{$partner->is_active ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_active">
                      Active
                    </label>
                  </div>
                </div>
                <div class="form-group">
                  <div class="form-check">
                    <input type="checkbox" class="form-check-input" name="is_google_ads" id="is_google_ads" {{$partner->is_google_ads ? 'checked' : ''}}>
                    <label class="form-check-label" for="is_google_ads">
                      Google Ads Partner
                    </label>
                  </div>
                </div>
                <div class="form-group" id="google_ads_fields" style="display: {{$partner->is_google_ads ? 'block' : 'none'}};">
                  <label for="">Google Ads Script</label>
                  <textarea class="form-control" name="google_ads_script" rows="3" placeholder="Enter Google Ads Script">{{$partner->google_ads_script}}</textarea>
                  <p id="errgoogle_ads_script" class="text-danger mb-0 em"></p>
                </div>
                <div class="form-group" id="google_ads_placement_field" style="display: {{$partner->is_google_ads ? 'block' : 'none'}};">
                  <label for="">Google Ads Placement</label>
                  <input type="text" class="form-control" name="google_ads_placement" value="{{$partner->google_ads_placement}}" placeholder="Enter Placement (e.g., header, sidebar, footer)">
                  <p id="errgoogle_ads_placement" class="text-danger mb-0 em"></p>
                </div>
                <div class="row">
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">Start Date</label>
                      <input type="datetime-local" class="form-control" name="start_date" value="{{$partner->start_date ? $partner->start_date->format('Y-m-d\TH:i') : ''}}">
                      <p id="errstart_date" class="text-danger mb-0 em"></p>
                    </div>
                  </div>
                  <div class="col-md-6">
                    <div class="form-group">
                      <label for="">End Date</label>
                      <input type="datetime-local" class="form-control" name="end_date" value="{{$partner->end_date ? $partner->end_date->format('Y-m-d\TH:i') : ''}}">
                      <p id="errend_date" class="text-danger mb-0 em"></p>
                    </div>
                    </div>
                </div>
                
                <!-- Mobile Image LFM Modal -->
                <div class="modal fade lfm-modal" id="lfmModal2" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle2" aria-hidden="true">
                    <i class="fas fa-times-circle"></i>
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                        <div class="modal-content">
                            <div class="modal-body p-0">
                                <iframe src="{{url('laravel-filemanager')}}?serial=2" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                            </div>
                        </div>
                    </div>
                </div>
              </form>
            </div>
          </div>
        </div>
        <div class="card-footer">
          <div class="form">
            <div class="form-group from-show-notify row">
              <div class="col-12 text-center">
                <button type="submit" id="submitBtn" class="btn btn-success">Update</button>
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
    });
</script>
@endsection
