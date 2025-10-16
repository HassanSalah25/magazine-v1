@extends('admin.layout')

@if(!empty($service->language) && $service->language->rtl == 1)
@section('styles')
<style>
   form input,
   form textarea,
   form select {
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
   <h4 class="page-title">Edit Service</h4>
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
         <a href="#">Edit Service</a>
      </li>
   </ul>
</div>
<div class="row">
   <div class="col-md-12">
      <div class="card">
         <div class="card-header">
            <div class="card-title d-inline-block">Edit Service</div>
            @if ($service->language_id > 0)
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.service.index') . '?language=' . request()->input('language') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @else
            <a class="btn btn-info btn-sm float-right d-inline-block" href="{{ route('admin.service.index') }}">
            <span class="btn-label">
            <i class="fas fa-backward" style="font-size: 12px;"></i>
            </span>
            Back
            </a>
            @endif
         </div>
         <div class="card-body pt-5 pb-5">
            <div class="row">
               <div class="col-lg-6 offset-lg-3">
                  <form id="ajaxForm" class="" action="{{route('admin.service.update')}}" method="post">
                     @csrf
                     <input type="hidden" name="service_id" value="{{$service->id}}">

                     {{-- Image Part --}}
                     <div class="form-group">
                         <label for="">Image ** </label>
                         <br>
                         <div class="thumb-preview" id="thumbPreview1">
                             <img src="{{asset('assets/front/img/services/' . $service->main_image)}}" alt="User Image">
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
                        <label for="">Title **</label>
                        <input type="text" class="form-control" name="title" value="{{$service->title}}" placeholder="Enter title">
                        <p id="errtitle" class="mb-0 text-danger em"></p>
                     </div>

                     @if (serviceCategory())
                     <div class="form-group">
                        <label for="">Category **</label>
                        <select class="form-control" name="category">
                           <option value="" selected disabled>Select a category</option>
                           @foreach ($ascats as $key => $ascat)
                           <option value="{{$ascat->id}}" {{$ascat->id == $service->scategory_id ? 'selected' : ''}}>{{$ascat->name}}</option>
                           @endforeach
                        </select>
                        <p id="errcategory" class="mb-0 text-danger em"></p>
                     </div>
                     @endif

                    <div class="form-group">
                        <label for="">Summary **</label>
                        <textarea class="form-control" name="summary" placeholder="Enter summary" rows="3">{{$service->summary}}</textarea>
                        <p id="errsummary" class="mb-0 text-danger em"></p>
                    </div>


                    <div class="form-group">
                        <label>Details Page **</label>
                        <div class="selectgroup w-100">
                            <label class="selectgroup-item">
                                <input type="radio" name="details_page_status" value="1" class="selectgroup-input" {{$service->details_page_status == 1 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Enable</span>
                            </label>
                            <label class="selectgroup-item">
                                <input type="radio" name="details_page_status" value="0" class="selectgroup-input" {{$service->details_page_status == 0 ? 'checked' : ''}}>
                                <span class="selectgroup-button">Disable</span>
                            </label>
                        </div>
                        <p id="errdetails_page_status" class="mb-0 text-danger em"></p>
                    </div>

                     <div class="form-group" id="contentFg">
                        <label for="">Content **</label>
                        <textarea id="serviceContent" class="form-control summernote" name="content" data-height="300" placeholder="Enter content">{{replaceBaseUrl($service->content)}}</textarea>
                        <p id="errcontent" class="mb-0 text-danger em"></p>
                     </div>
                      <div class="form-group">
                          <label>Nav & Tab Section</label>
                          <div id="repeater">
                              @if (!empty($service->nav_tab))
                                  @foreach (json_decode($service->nav_tab, true) as $key => $point)
                                      <div class="repeater-item mb-3 d-flex flex-row align-items-start gap-2">
                                          <input type="text" name="points[{{ $key }}][title]"
                                                 class="form-control mx-2" placeholder="Title"
                                                 value="{{ $point['title'] }}">
                                          <textarea id="blogContent" class="form-control"
                                                    name="points[{{ $key }}][text]"
                                                    data-height="200"
                                                    placeholder="Enter content">{{ $point['text'] }}</textarea>
                                          <button type="button" class="btn btn-danger remove-point">X</button>
                                      </div>
                                  @endforeach
                              @else
                                  <div class="repeater-item mb-3 d-flex flex-row align-items-start gap-2">
                                      <input type="text" name="points[0][title]" class="form-control mx-2"
                                             placeholder="Title">
                                      <textarea id="blogContent" class="form-control"
                                                name="points[0][text]"
                                                data-height="200"
                                                placeholder="Enter content"></textarea>                                                <button type="button" class="btn btn-danger remove-point">X</button>
                                  </div>
                              @endif
                          </div>
                          <button type="button" class="btn btn-primary mt-2" id="add-point">+ Add Point</button>
                      </div>

                     <div class="form-group">
                        <label for="">Serial Number **</label>
                        <input type="number" class="form-control ltr" name="serial_number" value="{{$service->serial_number}}" placeholder="Enter Serial Number">
                        <p id="errserial_number" class="mb-0 text-danger em"></p>
                        <p class="text-warning"><small>The higher the serial number is, the later the service will be shown everywhere.</small></p>
                     </div>
                      <div class="form-group">
                          <label for="">Second Image</label>
                          <div class="thumb-preview" id="thumbPreview2">
                              <img src="{{ $service->second_image ? asset('assets/front/img/services/' . $service->second_image) : asset('assets/admin/img/noimage.jpg') }}" alt="Second Image">
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
                              <img src="{{ $service->third_image ? asset('assets/front/img/services/' . $service->third_image) : asset('assets/admin/img/noimage.jpg') }}" alt="Third Image">
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
                          <label for="">Process List <span class="text-warning">(Separate each item with a comma)</span></label>
                          <textarea class="form-control" name="process_list" placeholder="Enter process list, separated by commas">{{$service->process_list}}</textarea>
                          <p id="errprocess_list" class="mb-0 text-danger em"></p>
                      </div>
                     <div class="form-group">
                        <label>Meta Keywords</label>
                        <input class="form-control" name="meta_keywords" value="{{$service->meta_keywords}}" placeholder="Enter meta keywords" data-role="tagsinput">
                        @if ($errors->has('meta_keywords'))
                        <p class="mb-0 text-danger">{{$errors->first('meta_keywords')}}</p>
                        @endif
                     </div>
                     <div class="form-group">
                        <label>Meta Description</label>
                        <textarea class="form-control" name="meta_description" rows="5" placeholder="Enter meta description">{{$service->meta_description}}</textarea>
                        @if ($errors->has('meta_description'))
                        <p class="mb-0 text-danger">{{$errors->first('meta_description')}}</p>
                        @endif
                     </div>

                      {{-- Slug --}}
                      <div class="form-group">
                          <label for="">Slug</label>
                          <input type="text" class="form-control" name="slug" placeholder="Enter slug" value="{{ $service->slug }}">
                          <p id="errslug" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Tags --}}
                      <div class="form-group">
                          <label for="tags">Tags</label>
                          <select id="tags" class="form-control select2" name="tags[]" multiple>
                              @foreach ($tags as $tag)
                                  <option value="{{ $tag->id }}" {{ $service->tags ? in_array($tag->id, $service->tags->pluck('id')->toArray()) ? 'selected' : ''  : ''}}>
                                      {{ $tag->title }}
                                  </option>
                              @endforeach
                          </select>
                          <p id="errtags" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Publish Date --}}
                      <div class="form-group">
                          <label for="">Publish Date</label>
                          <input type="datetime-local" class="form-control" name="publish_data"
                                 value="{{ $service->publish_data ? date('Y-m-d\TH:i', strtotime($service->publish_data)) : '' }}">
                          <p id="errpublish_data" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Is Indexed --}}
                      <div class="form-group">
                          <label for="">Index, Follow</label>
                          <select id="is_indexed" class="form-control" name="is_indexed">
                              <option value="1" {{ $service->is_indexed == 1 ? 'selected' : '' }}>Yes</option>
                              <option value="0" {{ $service->is_indexed == 0 ? 'selected' : '' }}>No</option>
                          </select>
                          <p id="erris_indexed" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Meta Title --}}
                      <div class="form-group">
                          <label>Meta Title</label>
                          <input class="form-control" name="meta_title" value="{{ $service->meta_title }}" placeholder="Enter meta title">
                          <p id="meta_title" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Canonical --}}
                      <div class="form-group">
                          <label>Canonical</label>
                          <input class="form-control" name="canonical" value="{{ $service->canonical }}" placeholder="Enter canonical">
                          <p id="errcanonical" class="mb-0 text-danger em"></p>
                      </div>

                      {{-- Redirect URL --}}
                      <div class="form-group">
                          <label>Redirect URL</label>
                          <input class="form-control" name="redirect_url" value="{{ $service->redirect_url }}" placeholder="Enter redirect URL">
                          <p id="errredirect_url" class="mb-0 text-danger em"></p>
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
    function toggleDetails() {
        let val = $("input[name='details_page_status']:checked").val();

        // if 'details page' is 'enable', then show 'content' & hide 'summary'
        if (val == 1) {
            $("#contentFg").show();
        }
        // if 'details page' is 'disable', then show 'summary' & hide 'content'
        else if (val == 0) {
            $("#contentFg").hide();
        }
    }

    $(document).ready(function() {
        toggleDetails();

        $("input[name='details_page_status']").on('change', function() {
            toggleDetails();
        });
    });
</script>
<script>
    let pointIndex = {{ !empty($abex->nav_tab) ? count(json_decode($abex->nav_tab, true)) : 1 }};

    document.getElementById('add-point').addEventListener('click', () => {
        const repeater = document.getElementById('repeater');
        const wrapper = document.createElement('div');
        wrapper.classList.add('repeater-item', 'mb-3', 'd-flex', 'flex-row', 'align-items-start', 'gap-3'); // stack inputs vertically

        wrapper.innerHTML = `
            <input type="text" name="points[${pointIndex}][title]" class="form-control mx-2" placeholder="Title">
            <textarea class="form-control summernote" name="points[${pointIndex}][text]" placeholder="Enter content"></textarea>
            <button type="button" class="btn btn-sm btn-danger remove-point align-self-start mt-2">X</button>
        `;

        repeater.appendChild(wrapper);

        // Re-initialize Summernote on the newly added textarea
        $(wrapper).find('.summernote').summernote({
            height: 200
        });

        pointIndex++;
    });

    // Remove button logic (still good)
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('remove-point')) {
            $(e.target).closest('.repeater-item').remove();
        }
    });
</script>
@endsection
