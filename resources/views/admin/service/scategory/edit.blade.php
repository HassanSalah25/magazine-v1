@extends('admin.layout')

@if(!empty($scategory->language) && $scategory->language->rtl == 1)
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
    <h4 class="page-title">Edit Category</h4>
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
        <a href="#">Service Page</a>
      </li>
      <li class="separator">
        <i class="flaticon-right-arrow"></i>
      </li>
      <li class="nav-item">
        <a href="#">Edit Category</a>
      </li>
    </ul>
  </div>
  <div class="row">
    <div class="col-md-12">
      <div class="card">
        <div class="card-header">
          <div class="card-title d-inline-block">Edit Category</div>
          <a class="btn btn-info btn-sm float-right d-inline-block" href="{{route('admin.scategory.index') . '?language=' . request()->input('language')}}">
            <span class="btn-label">
              <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
          </a>
        </div>
        <div class="card-body pt-5 pb-5">
          <div class="row">
            <div class="col-lg-6 offset-lg-3">

              <form id="ajaxForm" class="" action="{{route('admin.scategory.update')}}" method="post">
                @csrf
                <input type="hidden" name="scategory_id" value="{{$scategory->id}}">

                {{-- Image Part --}}
                <div class="form-group">
                    <label for="">Image ** </label>
                    <br>
                    <div class="thumb-preview" id="thumbPreview1">
                        <img src="{{asset('assets/front/img/service_category_icons/'.$scategory->image)}}" alt="User Image">
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
                {{-- Shape Image Part --}}
                <div class="form-group">
                    <label for="">Shape Image</label>
                    <br>
                    <div class="thumb-preview" id="thumbPreview4">
                        <img src="{{ $scategory->shape_image ? asset('assets/front/img/service_category_icons/' . $scategory->shape_image) : asset('assets/admin/img/noimage.jpg') }}" alt="Shape Image">
                    </div>
                    <br>
                    <br>
                    <input id="fileInput4" type="hidden" name="shape_image" value="{{ $scategory->shape_image }}">
                    <button id="chooseImage4" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal4">Choose Shape Image</button>
                    <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                    <p class="em text-danger mb-0" id="errshape_image"></p>
                    <!-- Shape Image LFM Modal -->
                    <div class="modal fade lfm-modal" id="lfmModal4" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle4" aria-hidden="true">
                        <i class="fas fa-times-circle"></i>
                        <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                            <div class="modal-content">
                                <div class="modal-body p-0">
                                    <iframe src="{{url('laravel-filemanager')}}?serial=4" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-group">
                  <label for="">Name **</label>
                  <input type="text" class="form-control" name="name" value="{{$scategory->name}}" placeholder="Enter name">
                  <p id="errname" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Sort Text **</label>
                  <input type="text" class="form-control" name="short_text" value="{{$scategory->short_text}}" placeholder="Enter short text">
                  <p id="errshort_text" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Status **</label>
                  <select class="form-control ltr" name="status">
                    <option value="" selected disabled>Select a status</option>
                    <option value="1" {{$scategory->status == 1 ? 'selected' : ''}}>Active</option>
                    <option value="0" {{$scategory->status == 0 ? 'selected' : ''}}>Deactive</option>
                  </select>
                  <p id="errstatus" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Serial Number **</label>
                  <input type="number" class="form-control ltr" name="serial_number" value="{{$scategory->serial_number}}" placeholder="Enter Serial Number">
                  <p id="errserial_number" class="mb-0 text-danger em"></p>
                  <p class="text-warning"><small>The higher the serial number is, the later the service category will be shown everywhere.</small></p>
                </div>
                  {{-- Slug --}}
                  <div class="form-group">
                      <label>Slug</label>
                      <input type="text" class="form-control" name="slug" value="{{ $scategory->slug }}">
                      <p id="errslug" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Redirect URL --}}
                  <div class="form-group">
                      <label>Redirect URL</label>
                      <input type="url" class="form-control" name="redirect_url" value="{{ $scategory->redirect_url }}">
                      <p id="errredirect_url" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Is Indexed --}}
                  <div class="form-group">
                      <label>Index Page?</label>
                      <select name="is_indexed" class="form-control">
                          <option value="" disabled {{ is_null($scategory->is_indexed) ? 'selected' : '' }}>Select indexing</option>
                          <option value="1" {{ $scategory->is_indexed == 1 ? 'selected' : '' }}>Yes - index & follow</option>
                          <option value="0" {{ $scategory->is_indexed === 0 ? 'selected' : '' }}>No - noindex</option>
                      </select>
                      <p id="erris_indexed" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Publish Date --}}
                  <div class="form-group">
                      <label>Publish Date</label>
                      <input type="datetime-local" name="publish_data" class="form-control"
                             value="{{ $scategory->publish_data ? date('Y-m-d\TH:i', strtotime($scategory->publish_data)) : '' }}">
                      <p id="errpublish_data" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Canonical URL --}}
                  <div class="form-group">
                      <label>Canonical URL</label>
                      <input type="url" class="form-control" name="canonical" value="{{ $scategory->canonical }}">
                      <p id="errcanonical" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Meta Title --}}
                  <div class="form-group">
                      <label>Meta Title</label>
                      <input type="text" class="form-control" name="meta_title" value="{{ $scategory->meta_title }}">
                      <p id="errmeta_title" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Meta Keywords --}}
                  <div class="form-group">
                      <label>Meta Keywords</label>
                      <textarea name="meta_keywords" class="form-control" rows="2">{{ $scategory->meta_keywords }}</textarea>
                      <p id="errmeta_keywords" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Meta Description --}}
                  <div class="form-group">
                      <label>Meta Description</label>
                      <textarea name="meta_description" class="form-control" rows="3">{{ $scategory->meta_description }}</textarea>
                      <p id="errmeta_description" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Parent Category --}}
                  <div class="form-group">
                      <label>Parent Category</label>
                      <select name="parent_id" class="form-control">
                          <option value="" selected>No Parent</option>
                          @foreach($categories as $cat)
                              <option value="{{ $cat->id }}" {{ $scategory->parent_id == $cat->id ? 'selected' : '' }}>
                                  {{ $cat->name }}
                              </option>
                          @endforeach
                      </select>
                      <p id="errparent_id" class="mb-0 text-danger em"></p>
                  </div>

                  {{-- Content --}}
                  <div class="form-group">
                      <label>Content</label>
                      <textarea name="content" class="form-control summernote">{{ $scategory->content }}</textarea>
                      <p id="errcontent" class="mb-0 text-danger em"></p>
                  </div>

                <div class="form-group">
                  <label for="">Second Image</label>
                  <div class="thumb-preview" id="thumbPreview2">
                    <img src="{{ $scategory->second_image ? asset('assets/front/img/service_category_icons/' . $scategory->second_image) : asset('assets/admin/img/noimage.jpg') }}" alt="Second Image">
                  </div>
                  <br>
                  <input id="fileInput2" type="hidden" name="second_image">
                  <button id="chooseImage2" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal2">Choose Image</button>
                  <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                  <p class="em text-danger mb-0" id="errsecond_image"></p>
                  <!-- Image LFM Modal -->
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
                </div>
                <div class="form-group">
                  <label for="">Third Image</label>
                  <div class="thumb-preview" id="thumbPreview3">
                    <img src="{{ $scategory->third_image ? asset('assets/front/img/service_category_icons/' . $scategory->third_image) : asset('assets/admin/img/noimage.jpg') }}" alt="Third Image">
                  </div>
                  <br>
                  <input id="fileInput3" type="hidden" name="third_image" >
                  <button id="chooseImage3" class="choose-image btn btn-primary" type="button" data-multiple="false" data-toggle="modal" data-target="#lfmModal3">Choose Image</button>
                  <p class="text-warning mb-0">JPG, PNG, JPEG, SVG images are allowed</p>
                  <p class="em text-danger mb-0" id="errthird_image"></p>
                  <!-- Image LFM Modal -->
                  <div class="modal fade lfm-modal" id="lfmModal3" tabindex="-1" role="dialog" aria-labelledby="lfmModalTitle3" aria-hidden="true">
                    <i class="fas fa-times-circle"></i>
                    <div class="modal-dialog modal-dialog-centered modal-lg" role="document">
                      <div class="modal-content">
                        <div class="modal-body p-0">
                          <iframe src="{{url('laravel-filemanager')}}?serial=3" style="width: 100%; height: 500px; overflow: hidden; border: none;"></iframe>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
                <div class="form-group">
                  <label for="">Video Link</label>
                  <input type="url" class="form-control" name="video_link" value="{{$scategory->video_link}}" placeholder="Enter video link">
                  <p id="errvideo_link" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Process List <span class="text-warning">(Separate each item with a comma)</span></label>
                  <textarea class="form-control" name="process_list" placeholder="Enter process list, separated by commas">{{$scategory->process_list}}</textarea>
                  <p id="errprocess_list" class="mb-0 text-danger em"></p>
                </div>
                <div class="form-group">
                  <label for="">Caption</label>
                  <input type="text" class="form-control" name="caption" value="{{$scategory->caption}}" placeholder="Enter caption for image">
                  <p id="errcaption" class="mb-0 text-danger em"></p>
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
