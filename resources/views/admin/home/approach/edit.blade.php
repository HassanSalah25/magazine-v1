@extends('admin.layout')


@if(!empty($point->language) && $point->language->rtl == 1)
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
    <h4 class="page-title">Approach Section</h4>
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
        <a href="#">Approach Section</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <form id="pointForm" action="{{route('admin.approach.point.update')}}" method="post" onsubmit="update(event)">
          <div class="card-header">
            <div class="card-title d-inline-block">Edit Point</div>
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.approach.index') . '?language=' . request()->input('language')}}">
							<span class="btn-label">
								<i class="fas fa-backward" style="font-size: 12px;"></i>
							</span>
							Back
						</a>
          </div>
          <div class="card-body pt-5 pb-5">
            <div class="row">
              <div class="col-lg-6 offset-lg-3">
                @csrf
                <input type="hidden" name="pointid" value="{{$point->id}}">

              <div class="form-group">
                      <label for="">Image ** </label>
                      <br>
                      <div class="thumb-preview" id="thumbPreview1">
                          <img src="{{ asset('assets/front/img/' . $point->image) }}" alt="Image">
                      </div>
                      <br>
                      <br>


                      <input id="fileInput1" type="hidden" name="image">
                      <button id="chooseImage1" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal1">Choose Image</button>


                      <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                      <p class="text-danger mb-0 em" id="errimage"></p>

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
                  <label for="">Social Icon **</label>
                  <div class="btn-group d-block">
                      <button type="button" class="btn btn-primary iconpicker-component"><i class="{{$point->icon}}"></i></button>
                      <button type="button" class="icp icp-dd btn btn-primary dropdown-toggle"
                              data-selected="fa-car" data-toggle="dropdown">
                      </button>
                      <div class="dropdown-menu"></div>
                  </div>
                  <input id="inputIcon" type="hidden" name="icon" value="{{$point->icon}}">
                  @if ($errors->has('icon'))
                    <p class="mb-0 text-danger">{{$errors->first('icon')}}</p>
                  @endif
                  <div class="mt-2">
                    <small>NB: click on the dropdown sign to select an icon.</small>
                  </div>
                </div>

                @if ($be->theme_version == 'cleaning')
                    <div class="form-group">
                        <label for="">Color **</label>
                        <input type="text" class="form-control jscolor" name="color" value="{{$point->color}}">
                        @if ($errors->has('color'))
                          <p class="mb-0 text-danger">{{$errors->first('color')}}</p>
                        @endif
                    </div>
                @endif

                <div class="form-group">
                  <label for="">Title **</label>
                  <input type="text" class="form-control" name="title" value="{{$point->title}}" placeholder="Enter Title">
                  @if ($errors->has('title'))
                    <p class="mb-0 text-danger">{{$errors->first('title')}}</p>
                  @endif
                </div>
                <div class="form-group">
                  <label for="">Short Text **</label>
                  <input type="text" class="form-control" name="short_text" value="{{$point->short_text}}" placeholder="Enter Short Text">
                  @if ($errors->has('short_text'))
                    <p class="mb-0 text-danger">{{$errors->first('short_text')}}</p>
                  @endif
                </div>

                  <div class="form-group">
                      <label for="">Show in Page</label>
                      <select name="page_id" class="form-control">
                          <option value="" selected disabled>Home Page</option>
                          <option value="{{\App\Models\Point::CAREER}}" {{ $point->page_id == \App\Models\Point::CAREER ? 'selected' : '' }}>Career Page</option>
                      </select>
                      <p id="errpage_id" class="mb-0 text-danger em"></p>
                  </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$point->serial_number}}" placeholder="Enter Serial Number">
                  @if ($errors->has('serial_number'))
                    <p class="mb-0 text-danger">{{$errors->first('serial_number')}}</p>
                  @endif
                  <p class="text-warning"><small>The higher the serial number is, the later the point will be shown in approach section.</small></p>
                </div>
              </div>
            </div>
          </div>
          <div class="card-footer pt-3">
            <div class="form">
              <div class="form-group from-show-notify row">
                <div class="col-lg-3 col-md-3 col-sm-12">

                </div>
                <div class="col-12 text-center">
                  <button type="submit" id="displayNotif" class="btn btn-success">Update</button>
                </div>
              </div>
            </div>
          </div>
        </form>
      </div>
    </div>
  </div>

@endsection


@section('scripts')
  <script>
    $(document).ready(function() {
      $('.icp').on('iconpickerSelected', function(event){
        $("#inputIcon").val($(".iconpicker-component").find('i').attr('class'));
      });
    });
  </script>
@endsection
